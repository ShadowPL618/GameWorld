</main>
    
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3><?php echo SITE_NAME; ?></h3>
                    <p>Your ultimate gaming destination for PC, PlayStation, and Xbox games.</p>
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
                
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="site_functions/products.php">Products</a></li>
                        <li><a href="site_functions/about.php">About Us</a></li>
                        <li><a href="site_functions/contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-categories">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="site_functions/products.php?categoryId=1">PlayStation</a></li>
                        <li><a href="site_functions/products.php?categoryId=2">Xbox</a></li>
                        <li><a href="site_functions/products.php?categoryId=3">PC</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="<?php echo isset($cssPrefix) ? $cssPrefix : ''; ?>js/main.js"></script>
</body>
</html>