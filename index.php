<?php
/**
 * GameWorld - Homepage
 * Displays welcome banner, popular games, and category links
 */

// Set page title
$page_title = 'GameWorld';

// Include header
include 'includes/header.php';

// Handle add to cart action from product cards
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = (int)$_POST['product_id'];
    if (isLoggedIn()) {
        dbAddToCart($pdo, $_SESSION['user_id'], $productId, 1);
    } else {
        addToCart($productId, 1);
    }
    header('Location: index.php?added=1');
    exit();
}

// Handle add to wishlist action from product cards
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $productId = (int)$_POST['product_id'];
    if (isLoggedIn()) {
        dbAddToWishlist($pdo, $_SESSION['user_id'], $productId);
    } else {
        addToWishlist($productId);
    }
    header('Location: index.php?wishlisted=1');
    exit();
}

// Get popular games from database
$popularGames = getPopularGames($pdo, 4);
?>

<!-- Success messages -->
<?php if (isset($_GET['added'])): ?>
    <div class="success-message">Product added to cart!</div>
<?php endif; ?>

<?php if (isset($_GET['wishlisted'])): ?>
    <div class="success-message">Product added to wishlist!</div>
<?php endif; ?>
//"ljsfs""Jfhjfadfoss"
<!-- Hero Banner Section -->
<section class="hero-banner">
    <div class="banner-overlay">
        <div class="container">
            <h1 class="banner-title">Welcome to <?php echo SITE_NAME; ?></h1>
            <p class="banner-subtitle">Discover the best games across all platforms</p>
            <a href="site_functions/products.php" class="cta-button">Browse Games</a>
        </div>
    </div>
</section>

<!-- Popular Games Section -->
<section class="popular-games">
    <div class="container">
        <h2 class="section-title">Most Popular Games</h2>
        
        <div class="products-grid">
            <?php $clickableImage = false; $clickableTitle = false; $buttonType = 'wishlist'; ?>
            <?php foreach ($popularGames as $game): ?>
                <?php $product = $game; ?>
                <?php include 'templates/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">Shop by Platform</h2>
        
        <div class="categories-grid">
            <!-- PlayStation Category -->
            <article class="category-card playstation">
                <a href="site_functions/products.php?categoryId=1">
                    <div class="category-content">
                        <h3>PlayStation</h3>
                        <p>Exclusive PS4 & PS5 Games</p>
                    </div>
                </a>
            </article>
            
            <!-- Xbox Category -->
            <article class="category-card xbox">
                <a href="site_functions/products.php?categoryId=2">
                    <div class="category-content">
                        <h3>Xbox</h3>
                        <p>Xbox One & Series X|S Games</p>
                    </div>
                </a>
            </article>
            
            <!-- PC Category -->
            <article class="category-card pc">
                <a href="site_functions/products.php?categoryId=3">
                    <div class="category-content">
                        <h3>PC</h3>
                        <p>Digital PC Game Downloads</p>
                    </div>
                </a>
            </article>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?>