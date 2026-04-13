<?php
/**
 * GameWorld - Blog Detail Page
 * Displays full blog post with comments section
 * Includes comment form with client-side validation
 *
 * Security Considerations:
 * - Input sanitization using sanitizeInput()
 * - Server-side validation with detailed error messages
 * - Client-side validation for better UX
 * - XSS protection with htmlspecialchars()
 *
 * Developer Note: Comments are ordered by creation time, showing conversation flow
 */

// Set page title
$page_title = 'Blog Post - GameWorld';

// Include header
include '../includes/header.php';

// Get post ID from URL
$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($postId <= 0) {
    // Invalid post ID, redirect to blog
    redirectTo('blog.php');
}

// Get blog post
$blogPost = getBlogPost($pdo, $postId);

if (!$blogPost) {
    // Post not found, redirect to blog
    redirectTo('blog.php');
}

// Handle comment submission
$commentSuccess = false;
$commentErrors = [];
$commentText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $name = sanitizeInput($_POST['name'] ?? '');
    $commentText = sanitizeInput($_POST['comment'] ?? '');

    // Validate inputs
    $commentErrors = validateEmptyFields([
        'name' => $name,
        'comment' => $commentText
    ]);

    if (empty($commentErrors)) {
        // Add comment to database
        if (addBlogComment($pdo, $postId, $name, $commentText)) {
            $commentSuccess = true;
            // Clear form data
            $name = '';
            $commentText = '';
        } else {
            $commentErrors[] = 'Failed to add comment. Please try again.';
        }
    }
}

// Get comments for this post
$comments = getBlogComments($pdo, $postId);
?>

<!-- Blog Post Header -->
<section class="blog-post-header">
    <div class="container">
        <div class="post-meta">
            <span class="post-date"><?php echo date('F j, Y', strtotime($blogPost['post_date'])); ?></span>
            <span class="post-author">By <?php echo htmlspecialchars($blogPost['author']); ?></span>
            <span class="post-category"><?php echo htmlspecialchars($blogPost['category_name']); ?></span>
        </div>
        <h1><?php echo htmlspecialchars($blogPost['title']); ?></h1>
    </div>
</section>

<!-- Blog Post Content -->
<main class="blog-post-content">
    <div class="container">
        <article class="full-blog-post">
            <div class="post-content">
                <?php echo nl2br(htmlspecialchars($blogPost['content'])); ?>
            </div>
        </article>

        <!-- Comments Section -->
        <section class="comments-section">
            <h2>Comments (<?php echo count($comments); ?>)</h2>

            <!-- Display existing comments -->
            <div class="comments-list">
                <?php if (empty($comments)): ?>
                    <p class="no-comments">No comments yet. Be the first to comment!</p>
                <?php else: ?>
                    <?php foreach ($comments as $commentItem): ?>
                        <div class="comment">
                            <div class="comment-header">
                                <strong><?php echo htmlspecialchars($commentItem['name']); ?></strong>
                                <span class="comment-date"><?php echo date('M j, Y g:i A', strtotime($commentItem['created_at'])); ?></span>
                            </div>
                            <div class="comment-content">
                                <?php echo nl2br(htmlspecialchars($commentItem['comment_text'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Comment Form -->
            <div class="comment-form-container">
                <h3>Leave a Comment</h3>

                <?php if ($commentSuccess): ?>
                    <div class="success-message">Comment added successfully!</div>
                <?php endif; ?>

                <?php if (!empty($commentErrors)): ?>
                    <div class="error-message">
                        <ul>
                            <?php foreach ($commentErrors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" class="comment-form" id="commentForm">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comment *</label>
                        <textarea id="comment" name="comment" rows="5" required><?php echo htmlspecialchars($commentText ?? ''); ?></textarea>
                    </div>

                    <button type="submit" name="submit_comment" class="submit-btn">Submit Comment</button>
                </form>
            </div>
        </section>

        <!-- Back to Blog Link -->
        <div class="back-to-blog">
            <a href="blog.php" class="back-link">← Back to Blog</a>
        </div>
    </div>
</main>

<script>
// Client-side validation for comment form
document.getElementById('commentForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const comment = document.getElementById('comment').value.trim();

    if (!name || !comment) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
    }

    if (name.length < 2) {
        e.preventDefault();
        alert('Name must be at least 2 characters long.');
        return false;
    }

    if (comment.length < 10) {
        e.preventDefault();
        alert('Comment must be at least 10 characters long.');
        return false;
    }
});
</script>

<?php
// Include footer
include '../includes/footer.php';
?>
