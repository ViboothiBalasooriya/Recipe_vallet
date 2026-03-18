<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recipes | Digital Recipe Book</title>
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
                    <li class="nav-item"><a class="nav-link fw-medium active" href="recipes.php">Recipes</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="submit-recipe.php">Submit Recipe</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="about.php">About</a></li>
                    <?php if (is_logged_in()): ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-outline-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn btn-danger btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="auth/login.php">Get Started</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <header class="bg-light py-5 mt-5">
        <div class="container py-5 text-center reveal">
            <h1 class="display-3 fw-bold mb-3">Explore Our <span class="text-success">Recipes</span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">From quick breakfast snacks to elaborate
                gourmet dinners, discover a world of flavors curated by our global community.</p>
        </div>
    </header>

    <!-- SEARCH & FILTER -->
    <section class="container py-4">
        <div class="row g-3">
            <div class="col-md-8">
                <input type="text" id="searchInput"
                    class="form-control form-control-lg bg-white border-0 shadow-sm px-4"
                    placeholder="Search for ingredients, dishes, or chefs...">
            </div>
            <div class="col-md-4">
                <select id="categoryFilter" class="form-select form-select-lg bg-white border-0 shadow-sm px-4">
                    <option value="All" selected>All Categories</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Vegetarian">Vegetarian</option>
                    <option value="Dessert">Dessert</option>
                </select>
            </div>
        </div>
    </section>

    <!-- GRID -->
    <section class="container py-5">
        <div class="row g-4" id="recipeGrid">
            <!-- Dynamically populated via script.js -->
        </div>
    </section>

    <!-- RECIPE MODAL (Feature 2) -->
    <div class="modal fade" id="recipeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-md-5 pt-0">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <img id="modalImg" src="" class="img-fluid rounded-4 shadow-sm" alt="Recipe">
                        </div>
                        <div class="col-md-7">
                            <span id="modalCategory" class="badge bg-success-subtle text-success mb-2">Category</span>
                            <h2 id="modalTitle" class="display-6 fw-bold mb-2">Recipe Title</h2>
                            <p class="mb-4 small">
                                <span class="text-muted me-1">By</span>
                                <a id="modalChefLink" href="#" class="text-success text-decoration-none fw-bold"><i class="fas fa-user-circle me-1"></i><span id="modalChefName">Chef</span></a>
                            </p>
                            <p id="modalDesc" class="text-muted mb-4">Description of the recipe goes here...</p>

                            <h5 class="fw-bold mb-3">Ingredients</h5>
                            <ul id="modalIngredients" class="list-unstyled ingredients-list mb-4">
                                <!-- JS populated -->
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-top">
                        <h5 class="fw-bold mb-3">Preparation Steps</h5>
                        <p id="modalInstructions" class="text-muted" style="line-height: 1.8;">Steps go here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script src="script.js?v=2"></script>
</body>

</html>
