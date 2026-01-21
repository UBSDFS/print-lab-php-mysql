<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main class="cart-page">
    <h1>Cart</h1>
    <!-- Get cart data for view -->
    <?php if (empty($items)): ?>
        <p>Your cart is empty.</p>
        <p><a href="/print-lab-php-mysql/public/prints.php">Back to Prints</a></p>
    <?php else: ?>
        <!-- List cart items -->
        <?php foreach ($items as $item): ?>
            <div class="cart-row" style="display:flex; gap:1rem; align-items:center; margin:1rem 0; padding:1rem; background:#fff; border-radius:12px;">
                <img
                    style="width:120px; height:80px; object-fit:cover; border-radius:10px;"
                    src="<?php echo htmlspecialchars('/print-lab-php-mysql/public/assets/images/wes-andy/' . ($item['image_filename'] ?? '')); ?>"
                    alt="<?php echo htmlspecialchars($item['title'] ?? 'Print'); ?>">

                <div style="flex:1;">
                    <div style="font-weight:700;"><?php echo htmlspecialchars($item['title'] ?? ''); ?></div>
                    <div>$<?php echo number_format((float)($item['price'] ?? 0), 2); ?></div>
                    <div style="margin-top:.25rem;">
                        <strong>Line:</strong> $<?php echo number_format((float)($item['line_total'] ?? 0), 2); ?>
                    </div>
                </div>

                <!-- Update one item -->
                <form method="post" action="/print-lab-php-mysql/public/cart.php" style="display:flex; gap:.5rem; align-items:center;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="product_id" value="<?php echo (int)($item['product_id'] ?? 0); ?>">

                    <label>
                        Qty:
                        <input
                            type="number"
                            name="qty"
                            min="1"
                            max="<?php echo (int)($item['max'] ?? 5); ?>"
                            value="<?php echo (int)($item['qty'] ?? 1); ?>"
                            style="width:70px;">
                    </label>

                    <button type="submit">Update</button>
                </form>

                <!-- Remove one item -->
                <form method="post" action="/print-lab-php-mysql/public/cart.php">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="product_id" value="<?php echo (int)($item['product_id'] ?? 0); ?>">
                    <button type="submit">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div style="text-align:right; margin-top:1rem;">
            <p><strong>Subtotal:</strong> $<?php echo number_format((float)$subtotal, 2); ?></p>
        </div>

        <p style="margin-top:1rem;">
            <a href="/print-lab-php-mysql/public/prints.php">Continue Shopping</a>
            &nbsp;|&nbsp;
            <a href="/print-lab-php-mysql/public/checkout.php">Proceed to Checkout</a>
        </p>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>