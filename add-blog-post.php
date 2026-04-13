<?php
/**
 * GameWorld - Add Blog Post Page
 * Form to create new blog posts with validation
 * Admin/moderator access only (for now, accessible to all for demo)
 *
 * Validation Strategy:
 * - Client-side for immediate feedback
 * - Server-side for security and data integrity
 * - Minimum length requirements prevent spam
 * - Date validation ensures proper formatting
 *
 * TODO: Add authentication check to restrict access to authorized users
 */

// Set page title
$page_title = 'Add Blog Post - GameWorld';

// Include header
include '../includes/header.php';

// Get categories for dropdown
$categories = getCategories($pdo);

// Handle form submission
$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post'])) {
    $title = sanitizeInput($_POST['title'] ?? '');
    $author = sanitizeInput($_POST['author'] ?? '');
    $date = sanitizeInput($_POST['date'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $content = sanitizeInput($_POST['content'] ?? '');

    // Validate required fields
    $errors = validateEmptyFields([
        'title' => $title,
        'author' => $author,
        'content' => $content
    ]);

    // Validate category selection
    if ($categoryId <= 0) {
        $errors[] = 'Please select a category';
    }

    // Validate date format
    if (empty($date)) {
        $errors[] = 'Date is required';
    } elseif (!strtotime($date)) {
        $errors[] = 'Invalid date format';
    }

    if (empty($errors)) {
        // Add blog post to database
        if (addBlogPost($pdo, $title, $author, $date, $categoryId, $content)) {
            $success = true;
            // Clear form data
            $title = $author = $date = $content = '';
            $categoryId = 0;
        } else {
            $errors[] = 'Failed to add blog post. Please try again.';
        }
    }
}
?>

<!-- Add Blog Post Form -->
<main class="add-blog-post">
    <div class="container">
        <div class="form-container">
            <h1>Add New Blog Post</h1>

            <?php if ($success): ?>
                <div class="success-message">Blog post added successfully!</div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="blog-post-form" id="blogPostForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="author">Author *</label>
                        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category *</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>"
                                        <?php echo ($categoryId == $category['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea id="content" name="content" rows="15" required><?php echo htmlspecialchars($content ?? ''); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit_post" class="submit-btn">Add Blog Post</button>
                    <a href="blog.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
// Client-side validation for blog post form
document.getElementById('blogPostForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const author = document.getElementById('author').value.trim();
    const date = document.getElementById('date').value;
    const category = document.getElementById('category_id').value;
    const content = document.getElementById('content').value.trim();

    if (!title || !author || !date || !category || !content) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
    }

    if (title.length < 5) {
        e.preventDefault();
        alert('Title must be at least 5 characters long.');
        return false;
    }

    if (author.length < 2) {
        e.preventDefault();
        alert('Author name must be at least 2 characters long.');
        return false;
    }

    if (content.length < 50) {
        e.preventDefault();
        alert('Content must be at least 50 characters long.');
        return false;
    }
});
</script>

<?php
// Include footer
include '../includes/footer.php';
?>