<?php 
require_once 'includes/functions.php'; 
require_once 'includes/db.php';

$profile_id = $_GET['id'] ?? null;
if (!$profile_id) {
    die("User ID is required.");
}

// Increment view counter if it's not the user themselves
if (!is_logged_in() || $_SESSION['user_id'] != $profile_id) {
    $stmt = $pdo->prepare("UPDATE users SET profile_views = profile_views + 1 WHERE id = ?");
    $stmt->execute([$profile_id]);
}

// Fetch User Data
$stmt = $pdo->prepare("SELECT username, profile_photo, profile_views FROM users WHERE id = ?");
$stmt->execute([$profile_id]);
$user_data = $stmt->fetch();

if (!$user_data) {
    die("User not found.");
}

$profile_photo = $user_data['profile_photo'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($username) . '&background=random&color=fff&size=150';
$username = $user_data['username'];
$profile_views = $user_data['profile_views'];

// Fetch Submitted Recipes
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$profile_id]);
$recipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($username); ?> | Digital Recipe Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="index.php">ðŸ´ RecipeBook</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link fw-medium" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="recipes.php">Recipes</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="submit-recipe.php">Submit Recipe</a></li>
                    <?php if (is_logged_in()): ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-outline-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="dashboard.php">Dashboard</a></li>
                    <?php else: ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="auth/login.php">Get Started</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- USER PROFILE HEADER -->
    <header class="bg-light py-5 mt-5">
        <div class="container py-5 text-center reveal">
            <img src="<?php echo htmlspecialchars($profile_photo); ?>"
                alt="User Avatar" class="rounded-circle border border-4 border-white shadow-sm mb-3"
                style="width: 120px; height: 120px; object-fit: cover;">
            <h1 class="display-4 fw-bold mb-2"><span class="text-success"><?php echo htmlspecialchars($username); ?></span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">Check out all the culinary masterpieces shared by <?php echo htmlspecialchars($username); ?>.</p>
            <div class="d-flex justify-content-center gap-4 mt-4">
                <div>
                    <h3 class="fw-bold mb-0"><?php echo count($recipes); ?></h3>
                    <span class="text-muted small text-uppercase">Recipes</span>
                </div>
                <div>
                    <h3 class="fw-bold mb-0"><?php echo htmlspecialchars($profile_views); ?></h3>
                    <span class="text-muted small text-uppercase">Profile Views</span>
                </div>
            </div>
        </div>
    </header>

    <!-- SUBMITTED RECIPES GRID -->
    <section class="container py-5">
        <div class="row g-4">
            <?php if (count($recipes) > 0): ?>
                <?php foreach ($recipes as $recipe): ?>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="card recipe-card shadow-sm h-100 position-relative">
                        <img src="<?php echo htmlspecialchars($recipe['image_url'] ?? 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80'); ?>"
                            class="card-img-top" alt="Recipe Image">
                        <div class="card-body">
                            <h4 class="card-title fw-bold"><?php echo htmlspecialchars($recipe['title']); ?></h4>
                            <hr class="my-3 opacity-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success-subtle text-success"><?php echo htmlspecialchars($recipe['category'] ?? 'General'); ?></span>
                                <a href="recipes.php" class="btn btn-link text-success p-0 text-decoration-none fw-bold">Explore Content â†’</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">This chef hasn't published any recipes yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js?v=3"></script>
</body>

</html>
