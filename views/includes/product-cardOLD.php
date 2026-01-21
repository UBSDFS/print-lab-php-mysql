<?php
// expects: $product (assoc array from fetch_assoc)
$imgSrc = "/assets/images/wes-andy/" . ($product['image_filename'] ?? '');
?>

<div class="product-card">
    <img
        class="product-image"
        src="<?= htmlspecialchars($imgSrc) ?>"
        alt="<?= htmlspecialchars($product['title'] ?? 'Print') ?>">

    <div class="product-details">
        <h3 class="product-title"><?= htmlspecialchars($product['title'] ?? '') ?></h3>

        <p class="product-description">
            <?= htmlspecialchars($product['description'] ?? '') ?>
        </p>

        <div class="product-meta">
            <span class="product-price">
                $<?= number_format((float)($product['base_price'] ?? 0), 2) ?>
            </span>
            <span class="product-max">
                Max: <?= (int)($product['max_quantity'] ?? 5) ?>
            </span>
        </div>

        <form method="post" action="cart.php" class="product-actions">
            <input type="hidden" name="product_id" value="<?= (int)($product['product_id'] ?? 0) ?>">

            <label>
                Qty:
                <select name="qty">
                    <?php
                    $max = (int)($product['max_quantity'] ?? 5);
                    $max = min($max, 5);
                    for ($i = 1; $i <= $max; $i++):
                    ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </label>

            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>
</div>

<!-- Discard file or after code refactor -->