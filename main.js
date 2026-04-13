/**
 * GameWorld - Main JavaScript
 * Interactive features and enhancements
 */

// Wait for DOM to fully load before running scripts
document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // PRODUCT CARD HOVER EFFECTS
    // ============================================
    // Add lift/shadow effect on mouse hover
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        // Lift card up with shadow on hover
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.3)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
        });
    });
    
    // ============================================
    // CATEGORY CARD ANIMATIONS
    // ============================================
    // Scale cards up slightly on hover
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // ============================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ============================================
    // Enable smooth scrolling for internal page links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    // ============================================
// MR. HOUSE EASTER EGG
// ============================================
// Only runs if PHP injected the easterEgg object (newvegas theme + product 8)
if (typeof easterEgg !== 'undefined') {
    const popup = document.getElementById('mrHousePopup');

    // Triggered whenever a thumbnail is clicked
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function () {
            const index = parseInt(this.getAttribute('data-image-index'));

            if (index === easterEgg.triggerIndex) {
                popup.style.display = 'flex';
                // Auto-hide after 8 seconds
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 8000);
            } else {
                popup.style.display = 'none';
            }
        });
    });
}

    // ============================================
    // AUTO-HIDE SUCCESS MESSAGES
    // ============================================
    // Fade out success/error messages after 5 seconds
    const successMessages = document.querySelectorAll('.success-message');
    
    successMessages.forEach(message => {
        // Auto-hide after 5 seconds
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 500);
        }, 5000);
    });
    
    // ============================================
    // QUANTITY INPUT VALIDATION
    // ============================================
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            
            // Ensure value is within valid range
            if (value < 0 || isNaN(value)) {
                this.value = 0;
            } else if (value > 99) {
                this.value = 99;
            }
        });
    });
    
    // ============================================
    // BULK CHECKBOX SELECTION
    // ============================================
    const selectAllCheckbox = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('input[name="selected_products[]"]');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // ============================================
    // ADD TO CART ANIMATION
    // ============================================
// Show temporary loading text when add-to-cart is clicked
        button.addEventListener('click', function(e) {
            // Add loading animation
            this.classList.add('loading');
            this.textContent = 'Adding...';
            
            // Button will submit form normally, but show visual feedback
            setTimeout(() => {
                this.classList.remove('loading');
                this.textContent = 'Add to Cart';
            }, 1000);
        });
    });
    
    // ============================================
    // WISHLIST BUTTON ANIMATION
    // ============================================
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Add pulse animation
            this.classList.add('pulse');
            setTimeout(() => {
                this.classList.remove('pulse');
            }, 600);
        });
    });
    
    // ============================================
    // FORM VALIDATION ENHANCEMENT
    // ============================================
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const messageInput = document.getElementById('message');
            
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.field-error').forEach(el => el.remove());
            
            // Validate name
            if (nameInput && nameInput.value.trim() === '') {
                showFieldError(nameInput, 'Name is required');
                isValid = false;
            }
            
            // Validate email
            if (emailInput && emailInput.value.trim() === '') {
                showFieldError(emailInput, 'Email is required');
                isValid = false;
            } else if (emailInput && !isValidEmail(emailInput.value)) {
                showFieldError(emailInput, 'Please enter a valid email');
                isValid = false;
            }
            
            // Validate message
            if (messageInput && messageInput.value.trim() === '') {
                showFieldError(messageInput, 'Message is required');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // ============================================
    // NAVIGATION ACTIVE STATE
    // ============================================
    // Highlight the current page link in the menu
    const navLinks = document.querySelectorAll('.main-nav a');
    const currentPath = window.location.pathname.split('/').pop();
    
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        if (linkPath === currentPath || (currentPath === '' && linkPath === 'index.php')) {
            link.classList.add('active');
        }
    });

// ============================================
// HELPER FUNCTIONS
// ============================================

/**
 * Show field validation error
 * @param {HTMLElement} field - input field to attach error to
 * @param {string} message - text shown to the user
 */
function showFieldError(field, message) {
    const error = document.createElement('span');
    error.className = 'field-error';
    error.textContent = message;
    error.style.color = 'red';
    error.style.fontSize = '0.875rem';
    field.parentNode.appendChild(error);
    field.style.borderColor = 'red';
}

/**
 * Validate email format
 * @param {string} email
 * @returns {boolean}
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Format number as currency
 * @param {number|string} amount
 * @returns {string}
 */
function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

// ============================================
// ADD DYNAMIC STYLES
// ============================================
const dynamicStyles = document.createElement('style');
dynamicStyles.textContent = `
    /* Button loading animation */
    .btn-add-cart.loading {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    /* Wishlist pulse animation */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    .wishlist-btn.pulse {
        animation: pulse 0.6s ease-in-out;
    }
    
    /* Success message fade */
    .success-message {
        transition: opacity 0.5s ease-out;
    }
    
    /* Product card transitions */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    /* Category card transitions */
    .category-card {
        transition: transform 0.3s ease;
    }
`;
document.head.appendChild(dynamicStyles);

// Log successful initialization
console.log('GameWorld JavaScript initialized successfully!');