<?php
/**
 * GameWorld - Product Display Functions
 * Helper functions for displaying and grouping products
 * Centralizes product display logic for consistency
 */

/**
 * Group products by category for display
 * @param array $products Array of products with category info
 * @return array Products grouped by category
 */
function groupProductsByCategory($products) {
    $grouped = [];
    foreach ($products as $product) {
        $categoryId = $product['category_id'];
        if (!isset($grouped[$categoryId])) {
            $grouped[$categoryId] = [
                'category_name' => $product['category_name'],
                'theme_color' => $product['theme_color'],
                'products' => []
            ];
        }
        $grouped[$categoryId]['products'][] = $product;
    }
    return $grouped;
}

/**
 * Display products grid with optional category grouping
 * @param array $products Array of products
 * @param bool $groupByCategory Whether to group by category
 * @param string $cssPrefix Path prefix for assets
 */
function displayProductsGrid($products, $groupByCategory = false, $cssPrefix = '') {
    if ($groupByCategory) {
        $groupedProducts = groupProductsByCategory($products);
        foreach ($groupedProducts as $category) {
            echo '<section class="category-section">';
            echo '<h2 class="category-title">' . htmlspecialchars($category['category_name']) . '</h2>';
            echo '<div class="products-grid">';
            foreach ($category['products'] as $product) {
                include 'templates/product-card.php';
            }
            echo '</div>';
            echo '</section>';
        }
    } else {
        echo '<div class="products-grid">';
        foreach ($products as $product) {
            include 'templates/product-card.php';
        }
        echo '</div>';
    }
}
?>