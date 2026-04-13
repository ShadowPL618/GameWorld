<?php
/**
 * GameWorld - Site Configuration
 * Global settings and constants
 */

// Site information
define('SITE_NAME', 'GameWorld');
define('SITE_URL', 'http://localhost/gameworld');
define('ADMIN_EMAIL', 'juliuszkrajewski2009@gmail.com'); // Updated email

// SMTP configuration (leave blank to use PHP mail()).
// Set these when you have SMTP credentials (e.g., Mailtrap or Gmail SMTP).
define('SMTP_HOST', '');
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls'); // 'tls' or 'ssl' or ''

// File paths
define('CSS_PATH', 'css/');
define('JS_PATH', 'js/');
define('IMG_PATH', 'images/');
define('DOWNLOAD_PATH', 'downloads/');

// Session configuration for security
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize shopping cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Initialize wishlist if it doesn't exist
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Set default theme if not set
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'default';
}
?>