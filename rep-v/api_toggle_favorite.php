<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $recipe_id = $data['recipe_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    if (!$recipe_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing recipe ID']);
        exit;
    }

    try {
        // Check if already favorited
        $stmt = $pdo->prepare("SELECT id FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$user_id, $recipe_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            // Un-favorite
            $stmt = $pdo->prepare("DELETE FROM favorites WHERE id = ?");
            $stmt->execute([$exists['id']]);
            echo json_encode(['status' => 'success', 'action' => 'removed']);
        } else {
            // Favorite
            $stmt = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $recipe_id]);
            echo json_encode(['status' => 'success', 'action' => 'added']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
