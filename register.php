<?php
require_once '../includes/header.php';
$registerError = '';
$registerSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $firstName = sanitizeInput($_POST['first_name']);
    $lastName = sanitizeInput($_POST['last_name']);
    if (empty($email) || empty($password) || empty($confirm) || empty($firstName) || empty($lastName)) {
        $registerError = 'Please fill in all fields.';
    } elseif ($password !== $confirm) {
        $registerError = 'Passwords do not match.';
    } else {
        if (registerUser($pdo, $email, $password, $firstName, $lastName)) {
            $registerSuccess = true;
        } else {
            $registerError = 'Registration failed. Email may already be in use.';
        }
    }
}
?>
<div class="container">
    <div class="register-container">
        <h2>Register for GameWorld</h2>
        <?php if ($registerError): ?>
            <div class="error-message"><?php echo $registerError; ?></div>
        <?php endif; ?>
        <?php if ($registerSuccess): ?>
            <div class="success-message">Registration successful! <a href="login.php">Login here</a>.</div>
        <?php else: ?>
        <form method="POST" action="register.php" class="register-form">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="register" class="register-btn">Register</button>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
