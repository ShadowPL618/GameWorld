<?php
/**
 * GameWorld - Blog Overview Page
 * Displays all blog posts with category filtering
 * Shows newest posts first with excerpts and read more links
 *
 * Features:
 * - Category sidebar for filtering
 * - Responsive grid layout
 * - Excerpts using PHP substr() as required
 * - SEO-friendly URLs with post IDs
 *
 * Future Enhancement: Add search functionality and pagination for large blogs
 */

// Set page title
$page_title = 'Blog - GameWorld';

// Include header
include '../includes/header.php';

// Handle category filtering
$categoryIds = [];
if (!empty($_GET['category'])) {
    $categoryIds = array_map('intval', (array)$_GET['category']);
    $categoryIds = array_filter($categoryIds);
}

// Get blog posts
$blogPosts = getBlogPosts($pdo, $categoryIds ?: null);

// Get categories for sidebar
$categories = getCategories($pdo);
?>

<!-- Blog Header -->
<section class="blog-header">
    <div class="container">
        <h1>GameWorld Blog</h1>
        <p>Stay updated with the latest gaming news, reviews, and updates</p>
    </div>
</section>

<!-- Main Blog Content -->
<main class="blog-content">
    <div class="container">
        <div class="blog-layout">

            <!-- Sidebar with Categories -->
            <aside class="blog-sidebar">
                <h3>Categories</h3>
                <form method="GET" class="category-filter-form">
                    <div class="category-list">
                        <?php foreach ($categories as $category): ?>
                            <label class="category-checkbox">
                                <input type="checkbox" name="category[]" value="<?php echo $category['category_id']; ?>"
                                       <?php echo in_array($category['category_id'], $categoryIds) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="category-actions">
                        <button type="submit" class="filter-btn">Apply Filters</button>
                        <a href="blog.php" class="clear-filters">Clear Filters</a>
                    </div>
                </form>
            </aside>

            <!-- Blog Posts Grid -->
            <section class="blog-posts">
                <?php if (empty($blogPosts)): ?>
                    <div class="no-posts">
                        <h3>No blog posts found</h3>
                        <p>Check back later for new content!</p>
                    </div>
                <?php else: ?>
                    <div class="posts-grid">
                        <?php foreach ($blogPosts as $post): ?>
                            <article class="blog-post-card">
                                <div class="post-meta">
                                    <span class="post-date"><?php echo date('F j, Y', strtotime($post['post_date'])); ?></span>
                                    <span class="post-author">By <?php echo htmlspecialchars($post['author']); ?></span>
                                    <span class="post-category"><?php echo htmlspecialchars($post['category_name']); ?></span>
                                </div>

                                <h2 class="post-title">
                                    <a href="blog-detail.php?id=<?php echo $post['post_id']; ?>">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h2>

                                <div class="post-excerpt">
                                    <p><?php echo htmlspecialchars(getBlogExcerpt($post['content'])); ?></p>
                                </div>

                                <a href="blog-detail.php?id=<?php echo $post['post_id']; ?>" class="read-more-btn">
                                    Read More
                                </a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </div>
</main>

<?php
// Include footer
include '../includes/footer.php';
?>
