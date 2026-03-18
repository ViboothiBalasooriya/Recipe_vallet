CREATE DATABASE IF NOT EXISTS recipe_book;
USE recipe_book;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255) DEFAULT NULL,
    profile_views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT 'Uncategorized',
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    prep_time INT DEFAULT 30,
    image_url VARCHAR(255),
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    UNIQUE KEY user_recipe (user_id, recipe_id)
);

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================
-- DUMMY DATA FOR INITIAL SETUP
-- ==============================================

-- 1. Insert a Dummy Chef User (Password is 'password123')
INSERT IGNORE INTO users (id, username, email, password, profile_views) VALUES 
(1, 'MasterChef', 'chef@recipebook.com', '$2y$10$hL0oH9fTbV3FjS3wWzE9.eT.gDqG29LZZ7Y6Z.k7bQ/rXZ3E0bA8K', 250);

-- 2. Insert the featured recipes from the index page
INSERT IGNORE INTO recipes (id, title, category, ingredients, instructions, prep_time, image_url, user_id) VALUES 
(1, 'Signature Garden Harvest Bowl', 'Vegetarian', '2 cups Organic Kale\n1 Roasted Sweet Potato\n1/2 Avocado (Sliced)\n1/4 cup Quinoa\nZesty Tahini Dressing', 'Massage the kale with a touch of olive oil until tender and bright green.\nArrange roasted sweet potatoes and cooked quinoa over the base.\nDrizzle generously with tahini dressing and top with fresh avocado.', 20, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c', 1),
(2, 'Healthy Summer Bowls', 'Vegetarian', 'Mixed Greens\nCherry Tomatoes\nCucumber\nBalsamic Vinaigrette', 'Toss all ingredients together.\nServe chilled.', 15, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd', 1),
(3, 'Authentic Italian Classics', 'Dinner', 'Spaghetti\nMarinara Sauce\nFresh Basil\nParmesan Cheese', 'Boil pasta until al dente.\nHeat the marinara sauce.\nCombine and garnish with basil and parmesan.', 45, 'https://images.unsplash.com/photo-1473093226795-af9932fe5856', 1),
(4, 'Sweet Treats Dessert', 'Dessert', 'Dark Chocolate\nHeavy Cream\nVanilla Extract\nStrawberries', 'Melt chocolate and mix with cream and vanilla.\nServe with fresh strawberries.', 60, 'https://images.unsplash.com/photo-1488477181946-6428a0291777', 1),
(5, 'Classic Honey Pancakes', 'Breakfast', 'Flour\nEggs\nMilk\nHoney\nButter', 'Mix dry and wet ingredients.\nCook on a griddle until golden.\nServe with butter and honey.', 20, 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445', 1);
