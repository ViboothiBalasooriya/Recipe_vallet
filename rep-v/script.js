// ✅ Global Recipe Data (Feature 2 - Dynamic Content)
const recipesData = [];

// ✅ Function to Open Modal Dynamically (Feature 2)
function openRecipeDetails(index) {
    const recipe = recipesData[index];
    if (!recipe) return;

    document.getElementById("modalTitle").innerText = recipe.title;
    document.getElementById("modalImg").src = recipe.img.startsWith('http') ? recipe.img + "?auto=format&fit=crop&w=800&q=80" : recipe.img;
    document.getElementById("modalCategory").innerText = recipe.category;
    document.getElementById("modalDesc").innerText = recipe.desc;
    
    document.getElementById("modalChefName").innerText = recipe.chef_name || "Unknown Chef";
    document.getElementById("modalChefLink").href = "profile.php?id=" + recipe.user_id;

    // Populate Ingredients
    const ingList = document.getElementById("modalIngredients");
    ingList.innerHTML = recipe.ingredients.map(ing => `<li><i class="fas fa-check text-success me-2"></i> ${ing}</li>`).join("");

    // Populate Instructions
    document.getElementById("modalInstructions").innerText = recipe.steps;

    // Show Modal using Bootstrap instance
    const modalElement = document.getElementById('recipeModal');
    const bModal = new bootstrap.Modal(modalElement);
    bModal.show();
}

// ✅ Feature: Toggle Favorite
window.toggleFavorite = function(recipeId, btnElement) {
    const icon = btnElement.querySelector('i');
    
    fetch('api_toggle_favorite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ recipe_id: recipeId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            if (data.action === 'added') {
                icon.classList.remove('fa-regular', 'text-muted');
                icon.classList.add('fa-solid', 'text-danger');
            } else {
                icon.classList.remove('fa-solid', 'text-danger');
                icon.classList.add('fa-regular', 'text-muted');
            }
        } else if (data.message === 'Not logged in') {
            alert("Please log in to save favorites!");
            window.location.href = "auth/login.php";
        }
    })
    .catch(err => console.error("Error toggling favorite:", err));
};

document.addEventListener("DOMContentLoaded", function () {
    // Dynamically load recipes from the API for rep-v
    const recipeGrid = document.getElementById("recipeGrid");
    if (recipeGrid) {
        fetch('get_recipes.php')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    data.forEach((recipe) => {
                        const index = recipesData.length;
                        recipesData.push(recipe);
                        
                        const cardHTML = `
                        <div class="col-md-6 col-lg-4 reveal active">
                            <div class="card recipe-card shadow-sm h-100">
                                <img src="${recipe.img.startsWith('http') ? recipe.img + '?auto=format&fit=crop&w=800&q=80' : recipe.img}"
                                    class="card-img-top" alt="${recipe.title}">
                                <div class="card-body">
                                    <span class="badge bg-success-subtle text-success mb-2">${recipe.category}</span>
                                    <h4 class="card-title fw-bold">${recipe.title}</h4>
                                    <p class="text-muted small">${recipe.desc}</p>
                                    <hr class="my-3 opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">⏱ ${recipe.prepTime} mins</span>
                                        <div>
                                            <button onclick="toggleFavorite(${recipe.id}, this)" class="btn btn-light rounded-circle shadow-sm me-2">
                                                <i class="${recipe.isFavorited ? 'fa-solid text-danger' : 'fa-regular text-muted'} fa-heart"></i>
                                            </button>
                                            <a href="javascript:void(0)" onclick="openRecipeDetails(${index})"
                                                class="btn btn-link text-success p-0 text-decoration-none fw-bold">View Details →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        recipeGrid.insertAdjacentHTML("beforeend", cardHTML);
                    });
                }
            })
            .catch(err => {
                console.error("Error tracking API response:", err);
                fetch('get_recipes.php')
                    .then(r => r.text())
                    .then(t => console.error("Raw server response:", t));
            });
    }

    // Reveal Observer
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // ✅ Dynamic Search & Filter Logic
    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");

    if (searchInput || categoryFilter) {
        const filterFn = () => {
            const query = searchInput.value.toLowerCase();
            const category = categoryFilter.value;

            document.querySelectorAll(".reveal").forEach(block => {
                const title = block.querySelector(".card-title")?.innerText.toLowerCase();
                const badge = block.querySelector(".badge")?.innerText;

                if (!title) return;

                const matchesSearch = title.includes(query);
                const matchesCategory = category === "All" || badge === category;

                block.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
            });
        };

        searchInput?.addEventListener("input", filterFn);
        categoryFilter?.addEventListener("change", filterFn);
    }

    // ✅ Form Validation (Feature 3)
    const submitForm = document.getElementById("submitRecipeForm");
    if (submitForm) {
        submitForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // Get values
            const name = document.getElementById("chefName").value.trim();
            const email = document.getElementById("chefEmail").value.trim();
            const title = document.getElementById("recipeTitle").value.trim();

            // 1. Empty Input Prevention (JS)
            if (name === "" || email === "" || title === "") {
                alert("⚠️ Please fill in all required fields (Name, Email, and Recipe Title).");
                return;
            }

            // 2. Correct Email Format (JS)
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert("⚠️ Please enter a valid email address!");
                return;
            }

            // Success
            alert("🎉 Recipe submitted successfully! Your culinary masterpiece will be reviewed shortly. 👨‍🍳");
            submitForm.reset();
        });
    }

    // ✅ Auth Form Redirect to Profile
    const authForm = document.getElementById("authForm");
    if (authForm) {
        authForm.addEventListener("submit", function (e) {
            e.preventDefault();
            // In a real application, you would validate credentials here.
            // For this UI demo, we simulate a successful login/signup and redirect.
            window.location.href = "profile.html";
        });
    }

    // ✅ Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            target?.scrollIntoView({ behavior: 'smooth' });
        });
    });
});
