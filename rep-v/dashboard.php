<?php 
require_once 'includes/functions.php'; 
require_once 'includes/db.php';
require_login();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$recipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile | Digital Recipe Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="index.php">🍴 RecipeBook</a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link fw-medium" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="recipes.php">Recipes</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="submit-recipe.php">Submit Recipe</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="about.php">About</a></li>
                    <li class="nav-item ms-lg-3 dropdown">
                        <a class="nav-link fw-bold text-success dropdown-toggle active" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> My Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                            <li><a class="dropdown-item fw-medium" href="dashboard.php">Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item fw-medium text-danger" href="index.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- USER PROFILE HEADER -->
    <header class="bg-light py-5 mt-5">
        <div class="container py-5 text-center reveal">
            <img src="https://images.unsplash.com/photo-1583394838336-aced97832abf?auto=format&fit=crop&w=150&h=150&q=80"
                alt="User Avatar" class="rounded-circle border border-4 border-white shadow-sm mb-3"
                style="width: 120px; height: 120px; object-fit: cover;">
            <h1 class="display-4 fw-bold mb-2">Hello, <span class="text-success"><?php echo htmlspecialchars($username); ?></span>!</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">Culinary enthusiast. Loves experimenting with
                new flavors and sharing the joy of cooking with the world.</p>
            <div class="d-flex justify-content-center gap-4 mt-4">
                <div>
                    <h3 class="fw-bold mb-0"><?php echo count($recipes); ?></h3>
                    <span class="text-muted small text-uppercase">Submitted Recipes</span>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">12</h3>
                    <span class="text-muted small text-uppercase">Saved Favorites</span>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">1.2k</h3>
                    <span class="text-muted small text-uppercase">Profile Views</span>
                </div>
            </div>
        </div>
    </header>

    <!-- SUBMITTED RECIPES GRID -->
    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h2 class="fw-bold display-6">My Submitted Recipes</h2>
                <p class="text-muted mb-0">Manage and view the culinary masterpieces you've shared.</p>
            </div>
            <div>
                <a href="submit-recipe.php" class="btn btn-success rounded-pill px-4 shadow-sm"><i
                        class="fas fa-plus me-2"></i> Submit New</a>
            </div>
        </div>

        <div class="row g-4">
            <?php if (count($recipes) > 0): ?>
                <?php foreach ($recipes as $recipe): ?>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="card recipe-card shadow-sm h-100 position-relative">
                        <span class="position-absolute top-0 end-0 m-3 badge bg-success text-white">Approved</span>
                        <img src="<?php echo htmlspecialchars($recipe['image_url'] ?? 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80'); ?>"
                            class="card-img-top" alt="Recipe Image">
                        <div class="card-body">
                            <h4 class="card-title fw-bold"><?php echo htmlspecialchars($recipe['title']); ?></h4>
                            <hr class="my-3 opacity-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Added: <?php echo date('M j, Y', strtotime($recipe['created_at'])); ?></span>
                                </div>
                                <div>
                                    <button class="btn btn-link text-primary p-0 text-decoration-none fw-bold me-3"><i
                                            class="fas fa-edit"></i> Edit</button>
                                    <button class="btn btn-link text-danger p-0 text-decoration-none fw-bold"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">You haven't submitted any recipes yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-5">
        <div class="container text-center">
            <div class="mb-3">
                <a href="index.php" class="text-decoration-none text-muted mx-2 small">Home</a>
                <a href="recipes.php" class="text-decoration-none text-muted mx-2 small">Recipes</a>
                <a href="submit-recipe.php" class="text-decoration-none text-muted mx-2 small">Submit</a>
                <a href="about.php" class="text-decoration-none text-muted mx-2 small">About</a>
            </div>
            <p class="text-muted small mb-0">© 2026 RecipeBook. Powered by Culinary Passion & Rajarata University.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
