$files = Get-ChildItem -Path "c:\Users\Viboothi\Downloads\rep-v\*.php"
foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    # Only add require_once if not already there
    if ($content -notmatch "includes/functions.php") {
        $content = $content -replace '<!DOCTYPE html>', "<?php require_once 'includes/functions.php'; ?>`r`n<!DOCTYPE html>"
    }
    
    $content = $content -replace 'index\.html', 'index.php'
    $content = $content -replace 'recipes\.html', 'recipes.php'
    $content = $content -replace 'submit-recipe\.html', 'submit-recipe.php'
    $content = $content -replace 'about\.html', 'about.php'
    $content = $content -replace 'profile\.html', 'dashboard.php'
    $content = $content -replace 'login\.html', 'auth/login.php'
    
    $oldNav = '(?s)<li class="nav-item ms-lg-3"><a\s+class="btn btn-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0"\s+href="auth/login.php">Get Started</a></li>'
    $newNav = "<?php if (is_logged_in()): ?>`r`n                    <li class=`"nav-item ms-lg-3`"><a class=`"btn btn-outline-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0`" href=`"dashboard.php`">Dashboard</a></li>`r`n                    <li class=`"nav-item ms-lg-2`"><a class=`"btn btn-danger btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0`" href=`"auth/logout.php`">Logout</a></li>`r`n                <?php else: ?>`r`n                    <li class=`"nav-item ms-lg-3`"><a class=`"btn btn-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0`" href=`"auth/login.php`">Get Started</a></li>`r`n                <?php endif; ?>"
    
    $content = [regex]::Replace($content, $oldNav, $newNav)
    
    Set-Content -Path $file.FullName -Value $content
}
