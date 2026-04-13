<?php
/**
 * GameWorld - About Us Page
 * Displays company information from database
 */

// Set page title
$page_title = 'GameWorld - About Us';

// Include header
include '../includes/header.php';

// Get about content from database
$aboutSections = getAboutContent($pdo);
?>

<section class="about-page">
    <div class="container">
        
        <!-- Page heading -->
        <h1 class="page-title">About GameWorld</h1>
        
        <!-- About sections from database -->
        <div class="about-content">
            <?php foreach ($aboutSections as $section): ?>
                <article class="about-section">
                    
                    <!-- Section Title -->
                    <h2 class="section-heading">
                        <?php echo htmlspecialchars($section['section_title']); ?>
                    </h2>
                    
                    <div class="section-content">
                        <!-- Section Image (if exists) -->
                        <?php if (!empty($section['section_image'])): ?>
                            <div class="section-image">
                                <img src="<?php echo htmlspecialchars($section['section_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($section['section_title']); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <!-- Section Text -->
                        <div class="section-text">
                            <p><?php echo nl2br(htmlspecialchars($section['section_content'])); ?></p>
                        </div>
                    </div>
                    
                </article>
            <?php endforeach; ?>
        </div>
        
        <!-- Additional Info Section -->
        <div class="about-features">
            <div class="feature-card">
                <h3>🎮 Wide Selection</h3>
                <p>Games across PC, PlayStation, and Xbox platforms</p>
            </div>
            
            <div class="feature-card">
                <h3>💳 Secure Payment</h3>
                <p>Safe and encrypted transactions for your peace of mind</p>
            </div>
            
            <div class="feature-card">
                <h3>⚡ Instant Delivery</h3>
                <p>Digital downloads delivered immediately after purchase</p>
            </div>
            
            <div class="feature-card">
                <h3>🎁 Best Prices</h3>
                <p>Competitive pricing and regular special offers</p>
            </div>
        </div>
        
    </div>
</section>

<?php
// Include footer
include '../includes/footer.php';
?>