<?php
error_reporting(0); // Prevent PHP warnings from breaking the JSON response
header('Content-Type: application/json');
require_once 'includes/db.php';

session_start();
$current_user_id = $_SESSION['user_id'] ?? 0;

try {
    $stmt = $pdo->query("SELECT r.*, u.username as chef_name,
        (SELECT COUNT(*) FROM favorites f WHERE f.recipe_id = r.id AND f.user_id = " . intval($current_user_id) . ") as is_favorited 
        FROM recipes r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Map database columns to the frontend JS expectations
    foreach ($recipes as &$recipe) {
        $recipe['category'] = isset($recipe['category']) ? $recipe['category'] : 'Uncategorized';
        $recipe['prepTime'] = isset($recipe['prep_time']) ? $recipe['prep_time'] : 30;
        $recipe['img'] = !empty($recipe['image_url']) ? $recipe['image_url'] : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c';
        $recipe['desc'] = substr($recipe['instructions'], 0, 100) . '...';
        $recipe['isFavorited'] = ($recipe['is_favorited'] > 0);
        
        // Frontend JS expects an array of ingredients
        if (is_string($recipe['ingredients'])) {
            $recipe['ingredients'] = array_filter(array_map('trim', explode("\n", $recipe['ingredients'])));
        }
        $recipe['steps'] = $recipe['instructions'];
    }
    
    echo json_encode($recipes);
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Failed to fetch recipes: " . $e->getMessage()]);
}
?>
