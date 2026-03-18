<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us | Digital Recipe Book</title>
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
                    <li class="nav-item"><a class="nav-link fw-medium active" href="about.php">About</a></li>
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

    <!-- HERO SECTION -->
    <header class="bg-light py-5 mt-5">
        <div class="container py-5 text-center reveal active">
            <h1 class="display-3 fw-bold mb-3">Our <span class="text-success">Story</span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Driven by a passion for culinary excellence and
                digital innovation, we bring the world's flavors to your kitchen.</p>
        </div>
    </header>

    <!-- CONTENT SECTION -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 reveal active">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=1200&q=80"
                        class="img-fluid rounded-4 shadow-lg" alt="Our Story">
                </div>
                <div class="col-lg-6 reveal active">
                    <span class="badge bg-success-subtle text-success mb-3">The Mission</span>
                    <h2 class="display-5 fw-bold mb-4">Connecting Hearts Through <span class="text-success">Food</span>
                    </h2>
                    <p class="text-muted mb-4 fs-5">Digital Recipe Book was born out of a simple idea: that every great
                        meal starts with a great story. We wanted to create a space where culinary traditions could be
                        shared, celebrated, and preserved for the next generation of chefs.</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold"><i class="text-success me-2">✔</i> Global Community</h5>
                            <p class="small text-muted">A platform for food lovers worldwide to exchange their secret
                                ingredients.</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold"><i class="text-success me-2">✔</i> Premium UX</h5>
                            <p class="small text-muted">A seamless, interactive experience designed for modern kitchens.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS SECTION (NEW) -->
    <section class="py-5 bg-white shadow-sm border-top border-bottom">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-6 col-md-3 reveal active">
                    <h2 class="display-5 fw-bold text-success mb-0">500+</h2>
                    <p class="text-muted small text-uppercase fw-bold">Recipes</p>
                </div>
                <div class="col-6 col-md-3 reveal active">
                    <h2 class="display-5 fw-bold text-success mb-0">12k</h2>
                    <p class="text-muted small text-uppercase fw-bold">Members</p>
                </div>
                <div class="col-6 col-md-3 reveal active">
                    <h2 class="display-5 fw-bold text-success mb-0">85</h2>
                    <p class="text-muted small text-uppercase fw-bold">Countries</p>
                </div>
                <div class="col-6 col-md-3 reveal active">
                    <h2 class="display-5 fw-bold text-success mb-0">15</h2>
                    <p class="text-muted small text-uppercase fw-bold">Awards</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PHILOSOPHY SECTION (NEW) -->
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5 reveal active">
                <span class="badge bg-success-subtle text-success mb-2">Our Values</span>
                <h2 class="display-6 fw-bold">The <span class="text-success">Philosophy</span> Behind the Plate</h2>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4 reveal active">
                    <div class="p-4 rounded-4 bg-white shadow-sm h-100 border-bottom border-success border-4">
                        <div class="text-success fs-1 mb-3"><i class="fas fa-leaf"></i></div>
                        <h4 class="fw-bold">Uncompromising Quality</h4>
                        <p class="text-muted small">We only feature recipes that have been tested, tasted, and approved
                            by our culinary board.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal active">
                    <div class="p-4 rounded-4 bg-white shadow-sm h-100 border-bottom border-success border-4">
                        <div class="text-success fs-1 mb-3"><i class="fas fa-heart"></i></div>
                        <h4 class="fw-bold">Passionate Community</h4>
                        <p class="text-muted small">Cooking is better together. We foster a supportive environment for
                            all skill levels.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal active">
                    <div class="p-4 rounded-4 bg-white shadow-sm h-100 border-bottom border-success border-4">
                        <div class="text-success fs-1 mb-3"><i class="fas fa-lightbulb"></i></div>
                        <h4 class="fw-bold">Modern Innovation</h4>
                        <p class="text-muted small">Bringing digital tools to the traditional kitchen for a seamless
                            cooking experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM SECTION (NEW) -->
    <section class="py-5 bg-light">
        <div class="container py-5 text-center">
            <h2 class="display-6 fw-bold mb-5 reveal active">The <span class="text-success">Dream Team</span></h2>
            <div class="row g-4">
                <div class="col-md-4 reveal active">
                    <img src="https://images.unsplash.com/photo-1583394238182-6f3ad46ef1c5?auto=format&fit=crop&w=400&q=80"
                        class="rounded-circle mb-3 shadow" style="width: 150px; height: 150px; object-fit: cover;"
                        alt="Chef">
                    <h5 class="fw-bold mb-1">Chef Alessandro</h5>
                    <p class="text-success small fw-bold">Lead Culinary Director</p>
                </div>
                <div class="col-md-4 reveal active">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80"
                        class="rounded-circle mb-3 shadow" style="width: 150px; height: 150px; object-fit: cover;"
                        alt="Designer">
                    <h5 class="fw-bold mb-1">Elena Wright</h5>
                    <p class="text-success small fw-bold">Head of Experience</p>
                </div>
                <div class="col-md-4 reveal active">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80"
                        class="rounded-circle mb-3 shadow" style="width: 150px; height: 150px; object-fit: cover;"
                        alt="Developer">
                    <h5 class="fw-bold mb-1">Marcus Chen</h5>
                    <p class="text-success small fw-bold">Technical Architect</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CREDITS SECTION -->
    <section class="bg-white py-5">
        <div class="container py-5">
            <div class="text-center mb-5 reveal active">
                <h2 class="display-6 fw-bold">Project <span class="text-success">Academic Info</span></h2>
                <p class="text-muted">This project is submitted as part of the COM 2303 - Web Design module.</p>
            </div>
            <div class="row justify-content-center g-4">
                <div class="col-md-6 col-lg-4 reveal active">
                    <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100 bg-light">
                        <div class="bg-success-subtle rounded-circle d-inline-flex p-3 mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2001/svg" width="32" height="32" fill="#22c55e"
                                class="bi bi-mortarboard" viewBox="0 0 16 16">
                                <path
                                    d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z" />
                                <path
                                    d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .326.63l.005.002.005.002.006.002.01.002.013.004.027.006a3.502 3.502 0 0 0 1.258.21c.569 0 1.07-.101 1.442-.258l.03-.01.013-.005.006-.002.003-.001.002-.001.002-.001-.5-1.7a.5.5 0 0 0-.327-.326 2.502 2.502 0 0 1-1.077.19 2.502 2.502 0 0 1-1.077-.19Z" />
                            </svg>
                        </div>
                        <h4 class="fw-bold">Rajarata University</h4>
                        <p class="text-muted small">Submitted to the Faculty of Applied Sciences, Rajarata University of
                            Sri Lanka.</p>
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
    <script src="script.js"></script>
</body>

</html>
