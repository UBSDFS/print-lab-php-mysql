<?php require_once __DIR__ . '/includes/header.php'; ?> <!-- Include the header -->
<?php require_once __DIR__ . '/includes/nav.php'; ?> <!-- Include the navigation -->


<main class="prints-page">
    <h1>Prints</h1>
    <!-- Display products from the database or a message if none are found -->
    <?php if (empty($products)): ?>
        <p>No products found. (DB connected, but table has 0 rows or wrong DB.)</p>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img
                        class="product-image"
                        src="<?php echo htmlspecialchars('/print-lab-php-mysql/public/assets/images/wes-andy/' . ($p['image_filename'] ?? '')); ?>"
                        alt="<?php echo htmlspecialchars($p['title'] ?? 'Print'); ?>">
                    <h3><?php echo htmlspecialchars($p['title']); ?></h3>
                    <p><?php echo htmlspecialchars($p['description']); ?></p>
                    <p>$<?php echo number_format((float)$p['base_price'], 2); ?></p>

                    <form method="post" action="/print-lab-php-mysql/public/cart.php">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?php echo (int)$p['product_id']; ?>">

                        <input
                            type="number"
                            name="qty"
                            min="1"
                            max="<?php echo (int)($p['max_quantity'] ?? 5); ?>"
                            value="1">

                        <button type="submit">Add to Cart</button>
                    </form>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


<!-- Receives variables from the controller and displays them ($products)-->