<?php
require_once 'includes/db.php';

echo "<h2>Database Upgrade Script</h2>";

function addColumnSafe($pdo, $table, $columnDef) {
    try {
        $pdo->exec("ALTER TABLE $table ADD COLUMN $columnDef");
    } catch (PDOException $e) {
        // 1060 is "Duplicate column name" error code, we can ignore it safely
        if ($e->errorInfo[1] != 1060) {
            echo "<p style='color:red;'>Error adding column to $table: " . $e->getMessage() . "</p>";
        }
    }
}

try {
    // 1. Alter Users Table safely
    addColumnSafe($pdo, 'users', 'profile_photo VARCHAR(255) DEFAULT NULL');
    addColumnSafe($pdo, 'users', 'profile_views INT DEFAULT 0');
    echo "<p>✅ Successfully updated <strong>users</strong> table.</p>";

    // 2. Alter Recipes Table
    addColumnSafe($pdo, 'recipes', "category VARCHAR(100) DEFAULT 'Uncategorized'");
    addColumnSafe($pdo, 'recipes', 'prep_time INT DEFAULT 30');
    echo "<p>✅ Successfully updated <strong>recipes</strong> table.</p>";

    // 3. Create Favorites Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS favorites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        recipe_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
        UNIQUE KEY user_recipe (user_id, recipe_id)
    )");
    echo "<p>✅ Successfully created <strong>favorites</strong> table.</p>";

    echo "<h3 style='color: green;'>All database updates applied successfully! You may now return to the app.</h3>";
} catch (PDOException $e) {
    echo "<h3 style='color: red;'>Error applying updates: " . $e->getMessage() . "</h3>";
}
?>
