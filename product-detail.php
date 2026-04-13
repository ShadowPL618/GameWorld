<?php
/**
 * GameWorld - Product Detail Page
 * Displays single product with multiple images and full description
 */
//TODO: add publisher, release date, franchise, developer

// Set page title
$page_title = 'Product Details';

// Include header
include '../includes/header.php';

// Retrieve product ID from URL parameter or redirect to products
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit();
}

// Cast ID to integer for security
$productId = (int)$_GET['id'];

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    if (isLoggedIn()) {
        dbAddToCart($pdo, $_SESSION['user_id'], $productId, $quantity);
    } else {
        addToCart($productId, $quantity);
    }
    header("Location: product-detail.php?id=$productId&added=1");
    exit();
}

// Handle add to wishlist action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    if (isLoggedIn()) {
        dbAddToWishlist($pdo, $_SESSION['user_id'], $productId);
    } else {
        addToWishlist($productId);
    }
    header("Location: product-detail.php?id=$productId&wishlisted=1");
    exit();
}

// Get product details
$product = getProductDetail($pdo, $productId);

if (!$product) {
    header("Location: products.php");
    exit();
}

// Get additional product images
$productImages = getProductImages($pdo, $productId);

$page_title = $product['product_name'] . ' - GameWorld';

// Fetch easter egg — only queries DB if newvegas theme is active
$easterEgg = null;
if (isset($_SESSION['theme']) && $_SESSION['theme'] === 'newvegas') {
    $stmt = $pdo->prepare("
        SELECT * FROM easter_eggs 
        WHERE product_id = ? AND theme = 'newvegas'
    ");
    $stmt->execute([$productId]);
    $easterEgg = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Success messages -->
<?php if (isset($_GET['added'])): ?>
    <div class="success-message">Product added to cart!</div>
<?php endif; ?>

<?php if (isset($_GET['wishlisted'])): ?>
    <div class="success-message">Product added to wishlist!</div>
<?php endif; ?>

<section class="product-detail-page">
    <div class="container">
        
        <!-- Back button -->
        <div class="back-navigation">
            <a href="products.php?categoryId=<?php echo $product['category_id']; ?>" class="btn-back">
                ← Back to <?php echo htmlspecialchars($product['category_name']); ?> Games
            </a>
        </div>
        
        <div class="product-detail-container">
            
            <!-- Left side - Images -->
            <div class="product-images-section">
                
                <!-- Main product image -->
                <div class="main-product-image">
                    <img id="mainImage" 
                         src="<?php echo htmlspecialchars($product['main_image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                </div>
                
                <!-- Thumbnail gallery -->
                <?php if (!empty($productImages)): ?>
                    <div class="image-thumbnails">
                        <!-- Main image thumbnail -->
                        <img src="<?php echo htmlspecialchars($product['main_image']); ?>" 
                             alt="Main view"
                             class="thumbnail active"
                             data-image-index="1"
                             onclick="changeImage('<?php echo htmlspecialchars($product['main_image']); ?>', this)">
                        
                        <!-- Additional images -->
                        <?php foreach ($productImages as $image): ?>
                            <img src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                                 alt="View <?php echo $image['image_order']; ?>"
                                 class="thumbnail"
                                 data-image-index="<?php echo (int)$image['image_order'] + 1; ?>"
                                 onclick="changeImage('<?php echo htmlspecialchars($image['image_path']); ?>', this)">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
            </div>
            
            <!-- Right side - Product info -->
            <div class="product-info-section">
                
                <!-- Product name -->
                <h1 class="product-detail-name">
                    <?php echo htmlspecialchars($product['product_name']); ?>
                </h1>
                
                <!-- Category badge -->
                <div class="category-badge">
                    <span><?php echo htmlspecialchars($product['category_name']); ?></span>
                </div>
                
                <!-- Price -->
                <div class="product-detail-price">
                    <?php echo formatPrice($product['price']); ?>
                </div>
                
                <!-- Short description -->
                <div class="product-short-desc">
                    <p><?php echo htmlspecialchars($product['short_description']); ?></p>
                </div>
                
                <!-- Add to cart form -->
                <form method="POST" class="product-detail-form">
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <input type="number" 
                               id="quantity" 
                               name="quantity" 
                               value="1" 
                               min="1" 
                               max="99"
                               class="quantity-input-detail">
                    </div>
                    
                    <div class="product-actions">
                        <button type="submit" name="add_to_cart" class="btn-add-cart-detail">
                            🛒 Add to Cart
                        </button>
                        
                        <button type="submit" name="add_to_wishlist" class="btn-wishlist-detail">
                            <?php echo isInWishlist($productId) ? '❤️ In Wishlist' : '🤍 Add to Wishlist'; ?>
                        </button>
                    </div>
                </form>
                
                <!-- Stock info -->
                <div class="stock-info">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <span class="in-stock">✓ In Stock (<?php echo $product['stock_quantity']; ?> available)</span>
                    <?php else: ?>
                        <span class="out-of-stock">✗ Out of Stock</span>
                    <?php endif; ?>
                </div>
                
            </div>
            
        </div>
        
        <!-- Full description section -->
        <div class="product-full-description">
            <h2>About This Game</h2>
            <p><?php echo nl2br(htmlspecialchars($product['long_description'])); ?></p>
        </div>
        
        <!-- Related products -->
        <div class="related-products">
            <h2>More <?php echo htmlspecialchars($product['category_name']); ?> Games</h2>
            
            <div class="products-grid">
                <?php
                $relatedProducts = getProductsByCategory($pdo, $product['category_id']);
                $count = 0;
                foreach ($relatedProducts as $related):
                    if ($related['product_id'] != $productId && $count < 4):
                        $count++;
                ?>
                    <article class="product-card">
                        <div class="product-image">
                            <a href="product-detail.php?id=<?php echo $related['product_id']; ?>">
                                <img src="<?php echo htmlspecialchars($related['main_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($related['product_name']); ?>">
                            </a>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">
                                <a href="product-detail.php?id=<?php echo $related['product_id']; ?>">
                                    <?php echo htmlspecialchars($related['product_name']); ?>
                                </a>
                            </h3>
                            <p class="product-price"><?php echo formatPrice($related['price']); ?></p>
                        </div>
                    </article>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>

    </div>

    <!-- Mr. House Easter Egg Popup -->
    <!-- Only rendered if: newvegas theme active + this product has an egg in the DB -->
    <?php if ($easterEgg): ?>
    <div class="mr-house-popup" id="mrHousePopup" style="display:none;">
        <div class="mr-house-inner">
            <img src="<?php echo htmlspecialchars($easterEgg['character_image']); ?>" 
                 alt="<?php echo htmlspecialchars($easterEgg['character_name']); ?>"
                 class="mr-house-avatar">
            <div class="mr-house-speech">
                <span class="mr-house-name">
                    <?php echo htmlspecialchars($easterEgg['character_name']); ?>
                </span>
                <p class="mr-house-quote">
                    <?php echo htmlspecialchars($easterEgg['quote']); ?>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Pass trigger index to JS — only exists if PHP found an easter egg
        const easterEgg = {
            triggerIndex: <?php echo (int)$easterEgg['image_index']; ?>
        };
    </script>
    <?php endif; ?>

</section>

<!-- Full screen image overlay -->
<div class="image-overlay" id="imageOverlay">
    <button class="close-overlay" onclick="closeFullscreen()">× Close</button>
    <img class="fullscreen-image" id="fullscreenImage" src="" alt="Full screen view">
</div>

<!-- JavaScript for image gallery -->
<script>
function changeImage(imageSrc, thumbnail) {
    // Update main image
    document.getElementById('mainImage').src = imageSrc;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnail.classList.add('active');
}

function openFullscreen(imageSrc) {
    const overlay = document.getElementById('imageOverlay');
    const fullscreenImg = document.getElementById('fullscreenImage');
    
    fullscreenImg.src = imageSrc;
    overlay.classList.add('active');
    
    // Prevent body scroll when overlay is active
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    const overlay = document.getElementById('imageOverlay');
    overlay.classList.remove('active');
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Add click event to main image
document.getElementById('mainImage').addEventListener('click', function() {
    openFullscreen(this.src);
});

// Close overlay when clicking on the overlay background
document.getElementById('imageOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFullscreen();
    }
});

// Close overlay with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFullscreen();
    }
});
</script>

<?php
// Include footer
include '../includes/footer.php';
?>