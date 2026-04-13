<?php
require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';
/**
 * GameWorld - Contact Page
 * Contact form (localhost-friendly - no mail errors)
 */

// Set page title
$page_title = 'GameWorld - Contact Us';

// Include header
include '../includes/header.php';

// Initialize form state variables for re-display
$showThankYou = false;
$name = '';
$email = '';
$errors = [];

// Process contact form when user submits
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get and sanitize form data
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $message = sanitizeInput($_POST['message']);
    
    // Validate form fields
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        //  Save to text file (foundational requirement / backup)
        $messageLog = "=== New Contact Form Submission ===\n";
        $messageLog .= "Date: " . date('Y-m-d H:i:s') . "\n";
        $messageLog .= "Name: " . $name . "\n";
        $messageLog .= "Email: " . $email . "\n";
        $messageLog .= "Message: " . $message . "\n";
        $messageLog .= "================================\n\n";
        file_put_contents('contact_messages.txt', $messageLog, FILE_APPEND);

        // Send the actual email using PHPMailer via Mailtrap SMTP
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Always use SMTP with Mailtrap credentials
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ecdc789f352a65';
            $mail->Password   = '1108aff74bbf2e';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            // Set the sender and recipient
            $mail->setFrom(ADMIN_EMAIL, 'GameWorld');
            $mail->addReplyTo($email, $name);
            $mail->addAddress('juliuszkrajewski2009@gmail.com', 'GameWorld Admin');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'New GameWorld Help Request from ' . $name;
            $mail->Body    = "<h2>New Message</h2>"
                           . "<p><b>From:</b> " . htmlspecialchars($name) . " (" . htmlspecialchars($email) . ")</p>"
                           . "<p><b>Message:</b><br>" . nl2br(htmlspecialchars($message)) . "</p>";

            $mail->send();

            // Mark success and clear form
            $showThankYou = true;
            $_POST = [];
        } catch (Exception $e) {
            $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<section class="contact-page">
    <div class="container">
        
        <!-- Page heading -->
        <h1 class="page-title">Contact Us</h1>
        
        <div class="contact-intro">
            <p>Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>
        
        <!-- Thank you message -->
        <?php if ($showThankYou): ?>
            <div class="success-message">
                <h2>Thank You!</h2>
                <p>Thank you <?php echo htmlspecialchars($name); ?> for contacting GameWorld.</p>
                <p>We've received your message and will get back to you soon at <?php echo htmlspecialchars($email); ?>.</p>
            </div>
        <?php endif; ?>
        
        <!-- Display errors if any -->
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Contact form -->
        <div class="contact-form-container">
            <form method="POST" action="contact.php" class="contact-form">
                
                <!-- Name field -->
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                           required>
                </div>
                
                <!-- Email field -->
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           required>
                </div>
                
                <!-- Message field -->
                <div class="form-group">
                    <label for="message">Your Question *</label>
                    <textarea id="message" 
                              name="message" 
                              rows="6" 
                              required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                
                <!-- Submit and Reset buttons -->
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">Send Message</button>
                    <button type="reset" class="btn-reset">Reset Form</button>
                </div>
                
            </form>
        </div>
        
        <!-- Contact information -->
        <div class="contact-info">
            <div class="info-card">
                <h3>📧 Email</h3>
                <p><a href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a></p>
            </div>
            
            <div class="info-card">
                <h3>🕐 Business Hours</h3>
                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                <p>Saturday - Sunday: 10:00 AM - 4:00 PM</p>
            </div>
            
            <div class="info-card">
                <h3>💬 Response Time</h3>
                <p>We typically respond within 24 to 36 hours</p>
            </div>
        </div>
        
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>