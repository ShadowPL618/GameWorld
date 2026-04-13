<?php
/**
 * GameWorld - Wishlist Page
 * Displays user's wishlist items
 */

// Set page title
$page_title = 'GameWorld - My Wishlist';

// Include header
include '../includes/header.php';


// Use persistent database wishlist for authenticated users
if (isLoggedIn()) {
    $userId = $_SESSION['user_id'];

    // Delete item from wishlist when remove link clicked
    if (isset($_GET['remove'])) {
        dbRemoveFromWishlist($pdo, $userId, (int)$_GET['remove']);
        header("Location: wishlist.php");
        exit();
    }

    // Move single product from wishlist to cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        $productId = (int)$_POST['product_id'];
        dbAddToCart($pdo, $userId, $productId, 1);
        header("Location: wishlist.php?added=1");
        exit();
    }

    // Move all wishlist products to cart in one action
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_all_to_cart'])) {
        $wishlistItems = dbGetWishlistItems($pdo, $userId);
        foreach ($wishlistItems as $item) {
            dbAddToCart($pdo, $userId, $item['product_id'], 1);
        }
        header("Location: wishlist.php?added=" . count($wishlistItems));
        exit();
    }

    // Get wishlist items from DB
    $wishlistItems = dbGetWishlistItems($pdo, $userId);
} else {
    // Fallback to session-based wishlist for guests
    $wishlistItems = [];
    if (!empty($_SESSION['wishlist'])) {
        $productIds = $_SESSION['wishlist'];
        $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
        $stmt->execute($productIds);
        $wishlistItems = $stmt->fetchAll();
    }
}
?>

<!-- Success message -->
<?php if (isset($_GET['added'])): ?>
    <div class="success-message">
        <?php echo (int)$_GET['added'] > 1 ? $_GET['added'] . ' products' : 'Product'; ?> added to cart!
    </div>
<?php endif; ?>

<section class="wishlist-page">
    <div class="container">
        
        <!-- Page heading -->
        <h1 class="page-title">❤️ My Wishlist</h1>
        
        <?php if (empty($wishlistItems)): ?>
            
            <!-- Empty wishlist message -->
            <div class="empty-wishlist">
                <h2>Your wishlist is empty</h2>
                <p>Start adding games you love to your wishlist!</p>
                <a href="products.php" class="btn-continue-shopping">Browse Products</a>
            </div>
            
        <?php else: ?>
            
            <!-- Wishlist actions -->
            <form method="POST" class="wishlist-actions">
                <button type="submit" name="add_all_to_cart" class="btn-add-all">
                    Add All to Cart
                </button>
            </form>
            
            <div class="products-grid">
                <?php $clickableImage = false; $clickableTitle = false; $buttonType = 'remove'; ?>
                <?php foreach ($wishlistItems as $item): ?>
                    <?php $product = $item; ?>
                    <?php include '../templates/product-card.php'; ?>
                <?php endforeach; ?>
            </div>
            </div>
            
            <!-- Wishlist summary -->
            <div class="wishlist-summary">
                <p>You have <strong><?php echo count($wishlistItems); ?></strong> items in your wishlist</p>
            </div>
            
        <?php endif; ?>
        
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>