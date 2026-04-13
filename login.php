<?php
/**
 * GameWorld - Login Page
 * User authentication page
 */

// Set page title
$page_title = 'Login - GameWorld';

// Include header
include '../includes/header.php';

// Process login form when submitted
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Sanitize email, never sanitize passwords
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $loginError = 'Please fill in all fields.';
    } else {
        $user = authenticateUser($pdo, $email, $password);
        if ($user) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            
            // Redirect to homepage or intended page
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../index.php';
            header("Location: $redirect");
            exit();
        } else {
            $loginError = 'Invalid email or password.';
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    logoutUser();
    header("Location: login.php");
    exit();
}
?>

<div class="container">
    <div class="login-container">
        <h2>Login to GameWorld</h2>
        
        <?php if ($loginError): ?>
            <div class="error-message"><?php echo $loginError; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php" class="login-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
        

        <div class="login-links">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            <p><a href="forgot-password.php">Forgot your password?</a></p>
        </div>
    </div>
</div>

<?php
// Include footer
include '../includes/footer.php';
?>