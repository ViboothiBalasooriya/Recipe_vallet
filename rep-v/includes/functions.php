<?php
// includes/functions.php

session_start();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: /auth/login.php");
        exit;
    }
}

function get_current_user_id() {
    return $_SESSION['user_id'] ?? null;
}
?>
