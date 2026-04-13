<?php
/**
 * GameWorld - Product Card Template
 * Reusable component for displaying product cards across the site
 * Reduces code duplication and ensures consistent styling
 *
 * Required variables:
 * - $product: Array with product data (product_id, product_name, main_image, price, short_description)
 * - $cssPrefix: Path prefix for CSS/JS (optional, defaults to '')
 * - $clickableImage: Whether to make image clickable to product detail (optional, defaults to false)
 * - $clickableTitle: Whether to make title clickable to product detail (optional, defaults to false)
 * - $buttonType: 'wishlist' for add to wishlist button, 'remove' for remove from wishlist (optional, defaults to 'wishlist')
 */

// Set default cssPrefix if not provided
if (!isset($cssPrefix)) {
    $cssPrefix = '';
}

// Set default clickableImage if not provided
if (!isset($clickableImage)) {
    $clickableImage = false;
}

// Set default clickableTitle if not provided
if (!isset($clickableTitle)) {
    $clickableTitle = false;
}

// Set default buttonType if not provided
if (!isset($buttonType)) {
    $buttonType = 'wishlist';
}
?>
<article class="product-card">
    <!-- Product Image -->
    <div class="product-image">
        <?php if ($clickableImage): ?>
            <a href="product-detail.php?id=<?php echo $product['product_id']; ?>">
                <img src="<?php echo htmlspecialchars($product['main_image']); ?>"
                     alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                     title="Click for details">
            </a>
        <?php else: ?>
            <img src="<?php echo htmlspecialchars($product['main_image']); ?>"
                 alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        <?php endif; ?>

        <!-- Action button -->
        <?php if ($buttonType === 'wishlist'): ?>
            <form method="POST" class="wishlist-form">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <button type="submit" name="add_to_wishlist" class="wishlist-btn" title="Add to Wishlist">
                    <?php echo isInWishlist($product['product_id']) ? '❤️' : '🤍'; ?>
                </button>
            </form>
        <?php elseif ($buttonType === 'remove'): ?>
            <a href="wishlist.php?remove=<?php echo $product['product_id']; ?>" 
               class="wishlist-btn wishlist-remove"
               title="Remove from Wishlist">
                ❌
            </a>
        <?php endif; ?>
    </div>

    <!-- Product Info -->
    <div class="product-info">
        <h3 class="product-name">
            <?php if ($clickableTitle): ?>
                <a href="product-detail.php?id=<?php echo $product['product_id']; ?>">
                    <?php echo htmlspecialchars($product['product_name']); ?>
                </a>
            <?php else: ?>
                <?php echo htmlspecialchars($product['product_name']); ?>
            <?php endif; ?>
        </h3>

        <p class="product-price">
            <?php echo formatPrice($product['price']); ?>
        </p>

        <p class="product-description">
            <?php echo htmlspecialchars($product['short_description']); ?>
        </p>

        <!-- Add to Cart Form -->
        <form method="POST" class="add-to-cart-form">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <button type="submit" name="add_to_cart" class="btn-add-cart">
                Add to Cart
            </button>
        </form>
    </div>
</article>