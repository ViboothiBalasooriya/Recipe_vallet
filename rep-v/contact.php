<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $message])) {
            $success = "Your message has been sent successfully. We will get back to you soon.";
        } else {
            $error = "Something went wrong. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | Digital Recipe Book</title>
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
                    <li class="nav-item"><a class="nav-link fw-medium" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium active" href="contact.php">Contact</a></li>
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item ms-lg-3"><a class="btn btn-outline-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item ms-lg-2"><a class="btn btn-danger btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <?php if (is_logged_in()): ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-outline-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn btn-danger btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-success btn-sm px-4 rounded-pill shadow-sm mt-2 mt-lg-0" href="auth/login.php">Get Started</a></li>
                <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTACT HERO SECTION -->
    <header class="bg-light py-5 mt-5">
        <div class="container py-5 text-center reveal active">
            <h1 class="display-3 fw-bold mb-3">Get in <span class="text-success">Touch</span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Have a question or want to share a recipe idea? We'd love to hear from you.</p>
        </div>
    </header>

    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg rounded-4 p-5 reveal active">
                        <h2 class="fw-bold mb-4 text-center">Contact Form</h2>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="contact.php">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Your Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0 py-3" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Email Address</label>
                                <input type="email" name="email" class="form-control bg-light border-0 py-3" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase">Message</label>
                                <textarea name="message" class="form-control bg-light border-0 py-3" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-3 mb-2 shadow-sm">Send Message</button>
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
                <a href="contact.php" class="text-decoration-none text-muted mx-2 small">Contact</a>
            </div>
            <p class="text-muted small mb-0">Â© 2026 RecipeBook. Powered by Culinary Passion & Rajarata University.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js?v=3"></script>
</body>
</html>

