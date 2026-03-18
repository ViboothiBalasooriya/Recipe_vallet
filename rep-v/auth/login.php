<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (is_logged_in()) {
    header("Location: ../dashboard.php");
    exit;
}

$error = '';
$success = '';
$active_tab = 'login'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $active_tab = 'signup';
        $username = sanitize_input($_POST['username']);
        $email = sanitize_input($_POST['email']);
        $password = $_POST['password'];

        if (empty($username) || empty($email) || empty($password)) {
            $error = "All fields are required.";
        } else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $username]);
            if ($stmt->fetch()) {
                $error = "Username or email already exists.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                if ($stmt->execute([$username, $email, $hashed_password])) {
                    $success = "Registration successful. You can now log in.";
                    $active_tab = 'login';
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        $active_tab = 'login';
        $email = sanitize_input($_POST['login_email']);
        $password = $_POST['login_password'];

        if (empty($email) || empty($password)) {
            $error = "Both fields are required.";
        } else {
            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: ../dashboard.php");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login / Sign Up | Digital Recipe Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .login-split { min-height: 100vh; }
        .login-image { background: url('https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat; }
        .login-form-container { max-width: 400px; width: 100%; }
        /* Hide forms correctly using classes */
        .auth-form { display: none; }
        .auth-form.active { display: block; }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0 login-split">
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-5 bg-white">
                <div class="login-form-container reveal active">
                    <div class="mb-5">
                        <a href="../index.php" class="text-decoration-none text-success fw-bold fs-4 mb-4 d-inline-block">ðŸ´ RecipeBook</a>
                        <h1 class="fw-bold mb-2" id="authTitle">Welcome Back</h1>
                        <p class="text-muted" id="authSub">Sign in to your account to continue your culinary journey.</p>
                    </div>

                    <div class="auth-toggle mb-4 p-1 bg-light rounded-3 d-flex">
                        <button class="btn btn-success w-50 py-2 rounded-2 shadow-sm" id="loginTab" onclick="toggleAuth('login')">Login</button>
                        <button class="btn btn-link text-muted text-decoration-none w-50 py-2" id="signupTab" onclick="toggleAuth('signup')">Sign Up</button>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form method="POST" action="login.php" id="loginForm" class="auth-form <?php echo ($active_tab === 'login') ? 'active' : ''; ?>">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Email Address</label>
                            <input type="email" name="login_email" class="form-control bg-light border-0 py-3" placeholder="chef@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Password</label>
                            <input type="password" name="login_password" class="form-control bg-light border-0 py-3" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-3 mb-4 shadow-sm">Sign In</button>
                    </form>

                    <!-- Registration Form -->
                    <form method="POST" action="login.php" id="signupForm" class="auth-form <?php echo ($active_tab === 'signup') ? 'active' : ''; ?>">
                        <input type="hidden" name="action" value="register">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Username</label>
                            <input type="text" name="username" class="form-control bg-light border-0 py-3" placeholder="chef123" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-3" placeholder="chef@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Password</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-3" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-3 mb-4 shadow-sm">Join RecipeBook</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block login-image">
                <div class="h-100 w-100 d-flex align-items-end p-5" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                    <div class="text-white">
                        <h2 class="display-6 fw-bold mb-3">"Cooking is like love. It should be entered into with abandon or not at all."</h2>
                        <p class="fs-5 opacity-75">â€” Harriet van Horne</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleAuth(type) {
            const loginTab = document.getElementById('loginTab');
            const signupTab = document.getElementById('signupTab');
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            const authTitle = document.getElementById('authTitle');
            const authSub = document.getElementById('authSub');

            if (type === 'signup') {
                loginTab.classList.remove('btn-success', 'shadow-sm');
                loginTab.classList.add('btn-link', 'text-muted');
                signupTab.classList.add('btn-success', 'shadow-sm');
                signupTab.classList.remove('btn-link', 'text-muted');
                
                loginForm.classList.remove('active');
                signupForm.classList.add('active');
                
                authTitle.innerText = 'Create Account';
                authSub.innerText = 'Join our community of food enthusiasts today.';
            } else {
                signupTab.classList.remove('btn-success', 'shadow-sm');
                signupTab.classList.add('btn-link', 'text-muted');
                loginTab.classList.add('btn-success', 'shadow-sm');
                loginTab.classList.remove('btn-link', 'text-muted');
                
                signupForm.classList.remove('active');
                loginForm.classList.add('active');
                
                authTitle.innerText = 'Welcome Back';
                authSub.innerText = 'Sign in to your account to continue your culinary journey.';
            }
        }
        
        // Quick initialization based on PHP active tab
        document.addEventListener('DOMContentLoaded', () => {
            toggleAuth('<?php echo $active_tab; ?>');
        });
    </script>
</body>
</html>
