<?php
/**
 * GameWorld - Functions Library
 * All database queries and helper functions
 *
 * Architecture Notes:
 * - Functions are grouped by feature area for maintainability
 * - Database functions use PDO with prepared statements for security
 * - Error handling is centralized in executeQuery() wrapper
 * - Session-based cart/wishlist for guests, database persistence for logged-in users
 */

// ============================================
// PRODUCT FUNCTIONS
// ============================================

/**
 * Get popular games for homepage
 * @param PDO $pdo Database connection
 * @param int $limit Number of games to fetch
 * @return array Popular games
 */
function getPopularGames($pdo, $limit = 4) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE is_popular = 1 LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Error fetching popular games: " . $e->getMessage());
        return [];
    }
}

/**
 * Get products by category ID
 * @param PDO $pdo Database connection
 * @param int $categoryId Category ID
 * @return array Products in category
 */
function getProductsByCategory($pdo, $categoryId) {
    try {
        $stmt = $pdo->prepare("
            SELECT p.*, c.category_name, c.theme_color 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id 
            WHERE p.category_id = :categoryId
            ORDER BY p.product_name
        ");
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Error fetching products: " . $e->getMessage());
        return [];
    }
}

/**
 * Get single product details
 * @param PDO $pdo Database connection
 * @param int $productId Product ID
 * @return array|null Product details
 */
function getProductDetail($pdo, $productId) {
    try {
        $stmt = $pdo->prepare("
            SELECT p.*, c.category_name, c.theme_color 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id 
            WHERE p.product_id = :productId
        ");
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch(PDOException $e) {
        error_log("Error fetching product: " . $e->getMessage());
        return null;
    }
}

/**
 * Get additional product images
 * @param PDO $pdo Database connection
 * @param int $productId Product ID
 * @return array Product images array
 */
function getProductImages($pdo, $productId) {
    try {
        $stmt = $pdo->prepare("
            SELECT image_path, image_order 
            FROM product_images 
            WHERE product_id = :productId 
            ORDER BY image_order ASC
        ");
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Error fetching product images: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all categories
 * @param PDO $pdo Database connection
 * @return array Categories
 */
function getCategories($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Error fetching categories: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all products
 * @param PDO $pdo Database connection
 * @return array All products
 */
function getAllProducts($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT p.*, c.category_name, c.theme_color 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id 
            ORDER BY c.category_name, p.product_name
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Error fetching all products: " . $e->getMessage());
        return [];
    }
}

// ============================================
// CART FUNCTIONS
// ============================================

/**
 * Add product to shopping cart
 * @param int $productId Product ID to add
 * @param int $quantity Quantity to add
 */
function addToCart($productId, $quantity = 1) {
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

/**
 * Remove product from cart
 * @param int $productId Product ID to remove
 */
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

/**
 * Get all items in cart with details
 * @param PDO $pdo Database connection
 * @return array Cart items with product info
 */
function getCartItems($pdo) {
    if (empty($_SESSION['cart'])) {
        return [];
    }
    
    try {
        $productIds = array_keys($_SESSION['cart']);
        $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
        
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
        $stmt->execute($productIds);
        $products = $stmt->fetchAll();
        
        // Add quantity and calculate subtotal
        foreach ($products as &$product) {
            $product['quantity'] = $_SESSION['cart'][$product['product_id']];
            $product['subtotal'] = $product['price'] * $product['quantity'];
        }
        
        return $products;
    } catch(PDOException $e) {
        error_log("Error fetching cart items: " . $e->getMessage());
        return [];
    }
}

/**
 * Calculate total price of cart
 * @param PDO $pdo Database connection
 * @return float Total price
 */
function getCartTotal($pdo) {
    $items = getCartItems($pdo);
    $total = 0;
    
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    
    return $total;
}

/**
 * Get total number of items in cart
 * @return int Item count
 */
function getCartCount() {
    if (empty($_SESSION['cart'])) {
        return 0;
    }
    return array_sum($_SESSION['cart']);
}

// ============================================
// WISHLIST FUNCTIONS
// ============================================

/**
 * Add product to wishlist
 * @param int $productId Product ID to add
 */
function addToWishlist($productId) {
    if (!in_array($productId, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $productId;
    }
}

/**
 * Remove product from wishlist
 * @param int $productId Product ID to remove
 */
function removeFromWishlist($productId) {
    $key = array_search($productId, $_SESSION['wishlist']);
    if ($key !== false) {
        unset($_SESSION['wishlist'][$key]);
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']); // Reindex array
    }
}

/**
 * Check if product is in wishlist
 * @param int $productId Product ID to check
 * @return bool True if in wishlist
 */
function isInWishlist($productId) {
    return in_array($productId, $_SESSION['wishlist']);
}

/**
 * Get wishlist count
 * @return int Number of items in wishlist
 */
function getWishlistCount() {
    return count($_SESSION['wishlist']);
}

// ============================================
// ABOUT PAGE FUNCTIONS
// ============================================

/**
 * Get about us content from database
 * @param PDO $pdo Database connection
 * @return array About sections
 */
function getAboutContent($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM about_content ORDER BY section_order ASC");
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        error_log("Error fetching about content: " . $e->getMessage());
        return [];
    }
}

// ============================================
// DOWNLOAD FUNCTIONS
// ============================================

/**
 * Verify download code
 * @param PDO $pdo Database connection
 * @param string $code Code to verify
 * @return array|null Download info if valid
 */
function verifyDownloadCode($pdo, $code) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM download_codes 
            WHERE code_phrase = :code AND is_active = 1
        ");
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    } catch(PDOException $e) {
        error_log("Error verifying code: " . $e->getMessage());
        return null;
    }
}

// ============================================
// USER AUTHENTICATION FUNCTIONS
// ============================================

/**
 * Authenticate user login
 * @param PDO $pdo Database connection
 * @param string $email User email
 * @param string $password User password
 * @return array|null User data if authenticated, null otherwise
 */
function authenticateUser($pdo, $email, $password) {
    try {
        $stmt = $pdo->prepare("SELECT user_id, email, password, first_name, last_name, role FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        // Plain text password check for dev/testing
        if ($user && $password === $user['password']) {
            unset($user['password']);
            // Save role to session
            $_SESSION['role'] = $user['role'];
            return $user;
        }
        return null;
    } catch(PDOException $e) {
        error_log("Error authenticating user: " . $e->getMessage());
        return null;
    }
}

/**
 * Check if user is logged in
 * @return bool True if logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user data
 * @return array|null User data or null
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'email' => $_SESSION['email'],
            'first_name' => $_SESSION['first_name'],
            'last_name' => $_SESSION['last_name']
        ];
    }
    return null;
}

/**
 * Log out user
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = array();
    // If session uses cookies, remove the session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}
// ============================================
// PERSISTENT CART & WISHLIST (DATABASE)
// ============================================

/**
 * Add product to database cart for logged-in users
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 * @param int $productId Product ID to add
 * @param int $quantity Quantity to add
 */
function dbAddToCart($pdo, $userId, $productId, $quantity = 1) {
    $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $existing = $stmt->fetch();
    if ($existing) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $userId, $productId]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $productId, $quantity]);
    }
}

/**
 * Get all cart items for user from database
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 * @return array Cart items with product details
 */
function dbGetCartItems($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT c.product_id, c.quantity, p.* FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

/**
 * Remove product from user's database cart
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 * @param int $productId Product ID to remove
 */
function dbRemoveFromCart($pdo, $userId, $productId) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
}

/**
 * Add product to user's database wishlist
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 * @param int $productId Product ID to add
 */
function dbAddToWishlist($pdo, $userId, $productId) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO wishlist (user_id, product_id) VALUES (?, ?)");
    $stmt->execute([$userId, $productId]);
}

/**
 * Get all wishlist items for user from database
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 * @return array Wishlist items with product details
 */
function dbGetWishlistItems($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT w.product_id, p.* FROM wishlist w JOIN products p ON w.product_id = p.product_id WHERE w.user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

/**
 * Remove product from user's database wishlist
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 * @param int $productId Product ID to remove
 */
function dbRemoveFromWishlist($pdo, $userId, $productId) {
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
}

// ============================================
// USER REGISTRATION (DATABASE)
// ============================================

/**
 * Register new user with hashed password
 * @param PDO $pdo Database connection
 * @param string $email User email address
 * @param string $password User password (will be hashed)
 * @param string $firstName User's first name
 * @param string $lastName User's last name
 * @return bool True if registration successful
 */
function registerUser($pdo, $email, $password, $firstName, $lastName) {
    try {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$email, $hashed, $firstName, $lastName]);
    } catch(PDOException $e) {
        error_log("Error registering user: " . $e->getMessage());
        return false;
    }
}

// ============================================
// HELPER FUNCTIONS
// ============================================

/**
 * Sanitize user input
 * @param string|array $data Input to sanitize
 * @return string Sanitized string
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Format price with currency
 * @param float $price Price to format
 * @return string Formatted price
 */
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

// ============================================
// FORM VALIDATION FUNCTIONS
// ============================================

/**
 * Validate that required fields are not empty
 * @param array $fields Associative array of field names and values
 * @return array Array of error messages for empty fields
 */
function validateEmptyFields($fields) {
    $errors = [];
    foreach ($fields as $fieldName => $value) {
        if (empty(trim($value))) {
            $errors[] = ucfirst($fieldName) . ' is required';
        }
    }
    return $errors;
}

// ============================================
// DATABASE HELPER FUNCTIONS
// ============================================

/**
 * Execute database query with centralized error handling
 * Reduces try-catch duplication across database functions
 * @param PDO $pdo Database connection
 * @param string $query SQL query
 * @param array $params Query parameters
 * @return PDOStatement Executed statement
 * @throws Exception If query fails
 */
function executeQuery($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } catch(PDOException $e) {
        error_log("Database error in query: $query - " . $e->getMessage());
        throw new Exception("Database operation failed. Please try again later.");
    }
}

// ============================================
// REDIRECT FUNCTIONS
// ============================================

/**
 * Consistent redirect function with proper headers
 * Centralizes redirect logic to ensure consistency
 * @param string $url URL to redirect to
 */
function redirectTo($url) {
    header("Location: $url");
    exit();
}

// ============================================
// BLOG FUNCTIONS
// ============================================

/**
 * Get all blog posts with category information
 * @param PDO $pdo Database connection
 * @param int|null $categoryId Filter by category (null for all)
 * @return array Blog posts
 *
 * Developer Note: Orders by post_date first, then created_at for consistent sorting
 * when multiple posts have the same date. Consider adding pagination for large blogs.
 */
function getBlogPosts($pdo, $categoryId = null) {
    $query = "
        SELECT bp.*, bc.category_name
        FROM blog_posts bp
        JOIN categories bc ON bp.category_id = bc.category_id
    ";
    $params = [];

    if ($categoryId !== null) {
        if (is_array($categoryId) && !empty($categoryId)) {
            $placeholders = implode(', ', array_fill(0, count($categoryId), '?'));
            $query .= " WHERE bp.category_id IN ($placeholders)";
            $params = $categoryId;
        } elseif (!is_array($categoryId)) {
            $query .= " WHERE bp.category_id = ?";
            $params[] = $categoryId;
        }
    }

    $query .= " ORDER BY bp.post_date DESC, bp.created_at DESC";

    $stmt = executeQuery($pdo, $query, $params);
    return $stmt->fetchAll();
}

/**
 * Get single blog post by ID
 * @param PDO $pdo Database connection
 * @param int $postId Post ID
 * @return array|null Blog post data
 */
function getBlogPost($pdo, $postId) {
    $query = "
        SELECT bp.*, bc.category_name
        FROM blog_posts bp
        JOIN categories bc ON bp.category_id = bc.category_id
        WHERE bp.post_id = :postId
    ";
    $stmt = executeQuery($pdo, $query, ['postId' => $postId]);
    return $stmt->fetch();
}

/**
 * Get comments for a blog post
 * @param PDO $pdo Database connection
 * @param int $postId Post ID
 * @return array Comments
 */
function getBlogComments($pdo, $postId) {
    $query = "
        SELECT * FROM blog_comments
        WHERE post_id = :postId
        ORDER BY created_at ASC
    ";
    $stmt = executeQuery($pdo, $query, ['postId' => $postId]);
    return $stmt->fetchAll();
}

/**
 * Add a new blog post
 * @param PDO $pdo Database connection
 * @param string $title Post title
 * @param string $author Author name
 * @param string $date Post date
 * @param int $categoryId Category ID
 * @param string $content Post content
 * @return bool Success
 */
function addBlogPost($pdo, $title, $author, $date, $categoryId, $content) {
    $query = "
        INSERT INTO blog_posts (title, author, post_date, category_id, content)
        VALUES (:title, :author, :postDate, :categoryId, :content)
    ";
    $stmt = executeQuery($pdo, $query, [
        'title' => $title,
        'author' => $author,
        'postDate' => $date,
        'categoryId' => $categoryId,
        'content' => $content
    ]);
    return $stmt->rowCount() > 0;
}

/**
 * Add a comment to a blog post
 * @param PDO $pdo Database connection
 * @param int $postId Post ID
 * @param string $name Commenter name
 * @param string $comment Comment text
 * @return bool Success
 */
function addBlogComment($pdo, $postId, $name, $comment) {
    $query = "
        INSERT INTO blog_comments (post_id, name, comment_text)
        VALUES (:postId, :name, :comment)
    ";
    $stmt = executeQuery($pdo, $query, [
        'postId' => $postId,
        'name' => $name,
        'comment' => $comment
    ]);
    return $stmt->rowCount() > 0;
}

/**
 * Get excerpt from blog post content
 * @param string $content Full content
 * @param int $length Excerpt length
 * @return string Excerpt with "..." if truncated
 */
function getBlogExcerpt($content, $length = 150) {
    $excerpt = substr($content, 0, $length);
    if (strlen($content) > $length) {
        $excerpt .= '...';
    }
    return $excerpt;
}
?>