<?php
/**
 * GameWorld - Checkout Page
 * Shopping cart with product details and total calculation
 */

// Set page title
$page_title = 'GameWorld - Shopping Cart';

// Include header
include '../includes/header.php';


// Use persistent database cart for authenticated users
if (isLoggedIn()) {
    $userId = $_SESSION['user_id'];

    // Delete item from cart when remove link clicked
    if (isset($_GET['remove'])) {
        dbRemoveFromCart($pdo, $userId, (int)$_GET['remove']);
        header("Location: checkout.php");
        exit();
    }

    // Update product quantities when user submits cart form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $productId => $quantity) {
            $quantity = (int)$quantity;
            if ($quantity > 0) {
                $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$quantity, $userId, $productId]);
            } else {
                dbRemoveFromCart($pdo, $userId, $productId);
            }
        }
        header("Location: checkout.php?updated=1");
        exit();
    }

    // Retrieve cart items and calculate total from database
    $cartItems = dbGetCartItems($pdo, $userId);
    $cartTotal = 0;
    foreach ($cartItems as $item) {
        $cartTotal += $item['price'] * $item['quantity'];
    }
} else {
    // Use session storage for guest shopping cart
    $cartItems = getCartItems($pdo);
    $cartTotal = getCartTotal($pdo);
}
?>

<!-- Success message -->
<?php if (isset($_GET['updated'])): ?>
    <div class="success-message">Cart updated successfully!</div>
<?php endif; ?>

<section class="checkout-page">
    <div class="container">
        
        <!-- Page heading -->
        <h1 class="page-title">Shopping Cart</h1>
        
        <?php if (empty($cartItems)): ?>
            
            <!-- Empty cart message -->
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Start shopping to add items to your cart!</p>
                <a href="products.php" class="btn-continue-shopping">Browse Products</a>
            </div>
            
        <?php else: ?>
            
            <!-- Cart items form -->
            <form method="POST" class="cart-form">
                <div class="cart-table-container">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr class="cart-item">
                                    
                                    <!-- Product name -->
                                    <td class="product-name">
                                        <?php echo htmlspecialchars($item['product_name']); ?>
                                    </td>
                                    
                                    <!-- Product image -->
                                    <td class="product-image">
                                        <img src="<?php echo htmlspecialchars($item['main_image']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                             width="80">
                                    </td>
                                    
                                    <!-- Price -->
                                    <td class="product-price">
                                        <?php echo formatPrice($item['price']); ?>
                                    </td>
                                    
                                    <!-- Quantity input -->
                                    <td class="product-quantity">
                                        <input type="number" 
                                               name="quantity[<?php echo $item['product_id']; ?>]" 
                                               value="<?php echo $item['quantity']; ?>" 
                                               min="0" 
                                               max="99"
                                               class="quantity-input">
                                    </td>
                                    
                                    <!-- Subtotal -->
                                    <td class="product-subtotal">
                                        <?php echo formatPrice($item['subtotal']); ?>
                                    </td>
                                    
                                    <!-- Remove button -->
                                    <td class="product-remove">
                                        <a href="checkout.php?remove=<?php echo $item['product_id']; ?>" 
                                           class="btn-remove"
                                           onclick="return confirm('Remove this item from cart?');">
                                            ❌
                                        </a>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Cart actions -->
                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="btn-update-cart">
                        Update Cart
                    </button>
                    <a href="products.php" class="btn-continue-shopping">
                        Continue Shopping
                    </a>
                </div>
            </form>
            
            <!-- Cart summary -->
            <div class="cart-summary">
                <h2>Order Summary</h2>
                
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span class="summary-value"><?php echo formatPrice($cartTotal); ?></span>
                </div>
                
                <div class="summary-row">
                    <span>Tax (0%):</span>
                    <span class="summary-value">$0.00</span>
                </div>
                
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span class="summary-value">FREE</span>
                </div>
                
                <hr>
                
                <div class="summary-row total">
                    <span>Total:</span>
                    <span class="summary-value"><?php echo formatPrice($cartTotal); ?></span>
                </div>
                
                <button class="btn-checkout" onclick="alert('Gangsters have been dispatched to collect the deposit, we also accept payment in human organs. We hope you enjoy your game and we hope to see you again!');">
                    Proceed to Checkout
                </button>
            </div>
            
        <?php endif; ?>
        
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>