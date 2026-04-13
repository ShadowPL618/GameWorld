<?php
/**
 * GameWorld - Database Connection
 * Establishes PDO connection to MySQL database
 */

// Database configuration
$host = 'localhost';
$dbname = 'gameworld'; 
$username = 'root'; 
$password = '';

try {
    // Create PDO connection with UTF-8 encoding
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set error mode to exceptions for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Display connection error and stop execution
    die("Database connection failed: " . $e->getMessage());
}
?>