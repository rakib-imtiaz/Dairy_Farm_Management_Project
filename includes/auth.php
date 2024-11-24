<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Simplified login verification
function verifyLogin($username, $password) {
    try {
        $conn = getDBConnection();
        // Use prepared statement for security
        $stmt = $conn->prepare("SELECT admin_id, username FROM admin_users 
                              WHERE username = ? AND password_hash = ?");
        $stmt->execute([$username, $password]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['admin_id'] = $user['admin_id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        
        return false;
    } catch (PDOException $e) {
        return false;
    }
}

// Simple redirect for unauthorized access
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'index.php');
        exit();
    }
}

// Improved logout function
function logout() {
    // Clear all session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Destroy the session
    session_destroy();

    // Redirect to login page using BASE_URL
    $redirectUrl = rtrim(BASE_URL, '/') . '/index.php';
    header('Location: ' . $redirectUrl);
    exit();
} 