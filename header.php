<?php
/**
 * GameWorld - Header
 * Site header with logo, navigation, and theme switcher
 */

// Include required files
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/functions/functions.php';

// Get current page filename for active navigation highlighting
$currentPage = basename($_SERVER['PHP_SELF']);

// Calculate correct CSS/JS prefix based on file location
// Root files need no prefix, site_functions files need '../' prefix
$cssPrefix = (strpos($_SERVER['PHP_SELF'], '/site_functions/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="GameWorld Team">
    <title><?php echo isset($page_title) ? $page_title : SITE_NAME; ?></title>
    
    <!-- Theme Stylesheet -->
    <link rel="stylesheet" href="<?php echo $cssPrefix; ?>css/NewVegas.css">
</head>
<body class="theme-newvegas">
    
    <header class="site-header">
        <div class="container">
            <!-- Logo -->
            <div class="logo">
                <a href="<?php echo $cssPrefix; ?>index.php">
                    <h1><?php echo SITE_NAME; ?></h1>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="main-nav">
                <ul>
                    <li><a href="<?php echo $cssPrefix; ?>index.php" class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/products.php" class="<?php echo ($currentPage == 'products.php') ? 'active' : ''; ?>">Products</a></li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/blog.php" class="<?php echo ($currentPage == 'blog.php') ? 'active' : ''; ?>">Blog</a></li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/about.php" class="<?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/contact.php" class="<?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/download.php" class="<?php echo ($currentPage == 'download.php') ? 'active' : ''; ?>">Download</a></li>
                    <li>
                        <?php if (isLoggedIn()): ?>
                            <a href="<?php echo $cssPrefix; ?>site_functions/logout.php">Logout (<?php echo htmlspecialchars($_SESSION['first_name']); ?>)</a>
                        <?php else: ?>
                            <a href="<?php echo $cssPrefix; ?>site_functions/login.php" class="<?php echo ($currentPage == 'login.php') ? 'active' : ''; ?>">Login</a>
                        <?php endif; ?>
                    </li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/checkout.php" class="cart-link">🛒 Cart (<?php echo getCartCount(); ?>)</a></li>
                    <li><a href="<?php echo $cssPrefix; ?>site_functions/wishlist.php" class="wishlist-link">❤️ Wishlist (<?php echo getWishlistCount(); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="main-content">