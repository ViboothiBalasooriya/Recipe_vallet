const recipesData = [];
function openRecipeDetails(index) {
    const recipe = recipesData[index];
    if (!recipe) return;

    document.getElementById("modalTitle").innerText = recipe.title;
    document.getElementById("modalImg").src = recipe.img + "?auto=format&fit=crop&w=800&q=80";
    document.getElementById("modalCategory").innerText = recipe.category;
    document.getElementById("modalDesc").innerText = recipe.desc;

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
document.addEventListener("DOMContentLoaded", function () {
    // Load saved recipes dynamically if on recipes page
    let savedRecipes = JSON.parse(localStorage.getItem('savedRecipes')) || [];
    const recipeGrid = document.getElementById("recipeGrid");

    savedRecipes.forEach((recipe) => {
        const index = recipesData.length;
        recipesData.push(recipe);

        if (recipeGrid) {
            const cardHTML = `
            <div class="col-md-6 col-lg-4 reveal">
                <div class="card recipe-card shadow-sm h-100">
                    <img src="${recipe.img}?auto=format&fit=crop&w=800&q=80"
                        class="card-img-top" alt="${recipe.title}">
                    <div class="card-body">
                        <span class="badge bg-success-subtle text-success mb-2">${recipe.category}</span>
                        <h4 class="card-title fw-bold">${recipe.title}</h4>
                        <p class="text-muted small">${recipe.desc}</p>
                        <hr class="my-3 opacity-10">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">⏱ ${recipe.prepTime} mins</span>
                            <a href="javascript:void(0)" onclick="openRecipeDetails(${index})"
                                class="btn btn-link text-success p-0 text-decoration-none fw-bold">View Details →</a>
                        </div>
                    </div>
                </div>
            </div>`;
            recipeGrid.insertAdjacentHTML("beforeend", cardHTML);
        }
    });

    // Reveal Observer
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    //  Dynamic Search & Filter Logic
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

    //  Form Validation (Feature 3)
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
            const newRecipe = {
                title: title,
                category: document.getElementById("recipeCategory").value,
                desc: document.getElementById("instructions").value.substring(0, 100) + '...',
                ingredients: document.getElementById("ingredients").value.split('\n').filter(i => i.trim() !== ""),
                steps: document.getElementById("instructions").value,
                img: "https://images.unsplash.com/photo-1546069901-ba9599a7e63c", // Default image
                prepTime: document.getElementById("prepTime").value || "30"
            };
            let savedRecipes = JSON.parse(localStorage.getItem('savedRecipes')) || [];
            savedRecipes.push(newRecipe);
            localStorage.setItem('savedRecipes', JSON.stringify(savedRecipes));

            alert("🎉 Recipe submitted successfully! Your culinary masterpiece will be reviewed shortly. 👨‍🍳");
            submitForm.reset();
            window.location.href = 'recipes.html';
        });
    }

    //  Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            target?.scrollIntoView({ behavior: 'smooth' });
        });
    });
});// ...existing code...

document.addEventListener("DOMContentLoaded", function () {
    // Reveal Observer
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Dynamic Search & Filter Logic (FIXED)
    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");


    if (searchInput && categoryFilter) {
        const filterFn = () => {
            const query = searchInput.value.toLowerCase();
            const category = categoryFilter.value;

            // Target recipe cards directly
            document.querySelectorAll(".recipe-card").forEach(card => {
                const title = card.querySelector(".card-title")?.innerText.toLowerCase() || "";
                const desc = card.querySelector(".text-muted.small")?.innerText.toLowerCase() || "";
                const badge = card.querySelector(".badge")?.innerText || "";

                const matchesSearch = title.includes(query) || desc.includes(query);
                const matchesCategory = category === "All" || badge.includes(category);

                // Show/hide the col-md-4 container
                const cardContainer = card.closest(".col-md-4");
                if (cardContainer) {
                    cardContainer.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
                }
            });
        };

        searchInput.addEventListener("input", filterFn);
        categoryFilter.addEventListener("change", filterFn);
    }


});
function reveal() {
    const reveals = document.querySelectorAll(".reveal");

    reveals.forEach((element) => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 100;

        if (elementTop < windowHeight - elementVisible) {
            element.classList.add("active");
        }
    });
}

window.addEventListener("scroll", reveal);
window.addEventListener("load", reveal);