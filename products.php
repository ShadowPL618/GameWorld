<?php
/**
 * GameWorld - Products Page
 * Displays all products or products by category with clickable images
 */
//TODO: add publisher, release date, franchise, developer

// Set page title
$page_title = 'Products';

// Include header
include '../includes/header.php';

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = (int)$_POST['product_id'];
    if (isLoggedIn()) {
        dbAddToCart($pdo, $_SESSION['user_id'], $productId, 1);
    } else {
        addToCart($productId, 1);
    }
    header("Location: products.php?added=1");
    exit();
}

// Handle add to wishlist action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $productId = (int)$_POST['product_id'];
    if (isLoggedIn()) {
        dbAddToWishlist($pdo, $_SESSION['user_id'], $productId);
    } else {
        addToWishlist($productId);
    }
    header("Location: products.php?wishlisted=1");
    exit();
}

// Retrieve category from URL parameter and validate as integer
$categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : null;

// Fetch products: filter by category if specified, else get all
if ($categoryId) {
    $products = getProductsByCategory($pdo, $categoryId);
    $categories = getCategories($pdo);
    $currentCategory = array_filter($categories, function($cat) use ($categoryId) {
        return $cat['category_id'] == $categoryId;
    });
    $currentCategory = reset($currentCategory);
    $page_title = $currentCategory ? $currentCategory['category_name'] . ' Games' : 'Products';
} else {
    $products = getAllProducts($pdo);
    $categories = getCategories($pdo);
}
?>

<!-- Success messages -->
<?php if (isset($_GET['added'])): ?>
    <div class="success-message">Product added to cart!</div>
<?php endif; ?>

<?php if (isset($_GET['wishlisted'])): ?>
    <div class="success-message">Product added to wishlist!</div>
<?php endif; ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo htmlspecialchars($page_title); ?></h1>
        <?php if (!$categoryId): ?>
            <p>Discover games across all platforms</p>
        <?php else: ?>
            <p>Browse our <?php echo htmlspecialchars($currentCategory['category_name']); ?> collection</p>
        <?php endif; ?>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <?php if ($categoryId): ?>
            <!-- Single Category Products -->
            <div class="products-grid">
                <?php $clickableImage = true; $clickableTitle = true; $buttonType = 'wishlist'; ?>
                <?php foreach ($products as $product): ?>
                    <?php include '../templates/product-card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- All Products Grouped by Category -->
            <?php
            $productsByCategory = [];
            foreach ($products as $product) {
                $productsByCategory[$product['category_name']][] = $product;
            }
            ?>
            
            <?php foreach ($productsByCategory as $categoryName => $categoryProducts): ?>
                <div class="category-section">
                    <h2 class="section-title"><?php echo htmlspecialchars($categoryName); ?> Games</h2>
                    
                    <div class="products-grid">
                        <?php $clickableImage = true; $clickableTitle = true; $buttonType = 'wishlist'; ?>
                        <?php foreach ($categoryProducts as $product): ?>
                            <?php include '../templates/product-card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php
include '../includes/footer.php';
?>