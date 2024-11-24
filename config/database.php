<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'noman');
define('DB_PASS', 'noman');
define('DB_NAME', 'dfms');

// Application URL configuration
define('BASE_URL', 'http://localhost/Dairy_Farm_Management_Project/'); // Adjust this according to your setup

// Create database connection
function getDBConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Helper function for URLs
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
} 