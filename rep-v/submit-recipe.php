<?php 
require_once 'includes/functions.php'; 
require_once 'includes/db.php';
require_login();

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['recipeTitle']);
    $category = sanitize_input($_POST['category']);
    $ingredients = sanitize_input($_POST['ingredients']);
    $instructions = sanitize_input($_POST['instructions']);
    $user_id = $_SESSION['user_id'];
    
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'img/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('recipe_') . '.' . $ext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_url = $upload_dir . $filename;
        }
    }

    if (empty($title) || empty($ingredients) || empty($instructions) || empty($category)) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO recipes (title, category, ingredients, instructions, image_url, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $category, $ingredients, $instructions, $image_url, $user_id])) {
            $success = "Recipe submitted successfully!";
        } else {
            $error = "Failed to submit recipe.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Submit Recipe | Digital Recipe Book</title>
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
                    <li class="nav-item"><a class="nav-link fw-medium active" href="submit-recipe.php">Submit
                            Recipe</a></li>
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

    <!-- SUBMIT SECTION -->
    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Left Content -->
                <div class="col-lg-5 reveal">
                    <h2 class="display-4 fw-bold mb-4">Share Your <br><span class="text-success">Culinary Magic</span>
                    </h2>
                    <p class="text-muted lead mb-5">Join our community of home chefs. Share your secret family recipes
                        and inspire thousands of food lovers around the globe.</p>

                    <div class="card bg-white border-0 shadow-sm p-4 rounded-4 mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success-subtle p-3 rounded-circle me-3">
                                <span class="text-success fw-bold">1</span>
                            </div>
                            <h5 class="mb-0 fw-bold">Fast Submission</h5>
                        </div>
                        <p class="text-muted small mb-0">Our streamlined process takes less than 5 minutes to get your
                            recipe live.</p>
                    </div>

                    <div class="card bg-primary-subtle border-0 shadow-sm p-4 rounded-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle p-3 rounded-circle me-3">
                                <span class="text-primary fw-bold">2</span>
                            </div>
                            <h5 class="mb-0 fw-bold">Reach Thousands</h5>
                        </div>
                        <p class="text-muted small mb-0">Your recipes will be featured on our discovery feed and
                            newsletter.</p>
                    </div>

                </div>

                <!-- Form Card -->
                <div class="col-lg-7 reveal">
                    <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="submit-recipe.php" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Recipe Image</label>
                                <input type="file" name="image" class="form-control bg-light border-0 shadow-none" accept="image/*">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Recipe Title</label>
                                <input type="text" name="recipeTitle" class="form-control form-control-lg bg-light border-0 shadow-none" placeholder="e.g. Grandma's Apple Pie" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Category</label>
                                <select name="category" class="form-select form-select-lg bg-light border-0 shadow-none" required>
                                    <option value="" disabled selected>Select a category...</option>
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Dinner">Dinner</option>
                                    <option value="Vegetarian">Vegetarian</option>
                                    <option value="Dessert">Dessert</option>
                                    <option value="General">General / Other</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase tracking-wider">Ingredients</label>
                                <textarea name="ingredients" class="form-control bg-light border-0 shadow-none" rows="4"
                                    placeholder="List ingredients separated by lines..." required></textarea>
                            </div>

                            <div class="mb-5">
                                <label
                                    class="form-label fw-bold small text-uppercase tracking-wider">Instructions</label>
                                <textarea name="instructions" class="form-control bg-light border-0 shadow-none" rows="6"
                                    placeholder="Describe the steps to prepare..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 py-3 shadow-sm rounded-3">Submit
                                Your Recipe</button>
                        </form>
                    </div>
                </div>
            </div>
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
    <script src="script.js?v=2"></script>
</body>

</html>
