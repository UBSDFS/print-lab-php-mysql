<?php

$mysqli = require __DIR__ . '/../config/database.php';
if (!$mysqli instanceof mysqli) {
    die('Database connection not established');
}

$cart = $_SESSION['cart'] ?? []; // [product_id => qty]

// If user clicks "Place Order"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'place_order') {
    // In a real app you’d insert an order here.
    unset($_SESSION['cart']); // clear cart
    $orderPlaced = true;
} else {
    $orderPlaced = false;
}

// If order placed, show confirmation and stop early
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';

if ($orderPlaced): ?>
    <main class="checkout-page">
        <h1>Order Confirmed</h1>
        <p>Thanks! Your order has been placed.</p>
        <p><a href="/print-lab-php-mysql/public/prints.php">Back to Prints</a></p>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <?php exit; ?>
<?php endif; ?>

<?php
// If cart is empty
if (empty($cart)) {
?>
    <main class="checkout-page">
        <h1>Checkout</h1>
        <p>Your cart is empty.</p>
        <p><a href="/print-lab-php-mysql/public/prints.php">Go to Prints</a></p>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php exit;
}

// Fetch products for checkout
$items = [];
$subtotal = 0.0;

$ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$types = str_repeat('i', count($ids));

$stmt = $mysqli->prepare("
    SELECT product_id, title, base_price
    FROM products
    WHERE product_id IN ($placeholders)
    ORDER BY product_id ASC
");
$stmt->bind_param($types, ...$ids);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $pid = (int)$row['product_id'];
    $qty = (int)($cart[$pid] ?? 0);
    $price = (float)$row['base_price'];

    $lineTotal = $qty * $price;
    $subtotal += $lineTotal;

    $items[] = [
        'product_id' => $pid,
        'title' => $row['title'],
        'qty' => $qty,
        'price' => $price,
        'line_total' => $lineTotal,
    ];
}

// Totals (keep it simple)
$taxRate = 0.06; // 6% newport news tax rate
$tax = $subtotal * $taxRate;
$total = $subtotal + $tax;
?>

<main class="checkout-page">
    <h1>Checkout</h1>

    <div style="max-width:900px; margin:0 auto; background:#fff; padding:1.25rem; border-radius:12px;">
        <h2 style="margin-top:0;">Order Summary</h2>

        <?php foreach ($items as $item): ?>
            <div style="display:flex; justify-content:space-between; padding:.75rem 0; border-bottom:1px solid #eee;">
                <div>
                    <strong><?php echo htmlspecialchars($item['title']); ?></strong><br>
                    Qty: <?php echo (int)$item['qty']; ?> @ $<?php echo number_format((float)$item['price'], 2); ?>
                </div>
                <div>
                    $<?php echo number_format((float)$item['line_total'], 2); ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="text-align:right; margin-top:1rem;">
            <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
            <p><strong>Tax (<?php echo (float)($taxRate * 100); ?>%):</strong> $<?php echo number_format($tax, 2); ?></p>
            <p style="font-size:1.2rem;"><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
        </div>

        <form method="post" action="/print-lab-php-mysql/public/checkout.php" style="text-align:right; margin-top:1rem;">
            <input type="hidden" name="action" value="place_order">
            <button type="submit">Place Order</button>
        </form>

        <p style="margin-top:1rem;">
            <a href="/print-lab-php-mysql/public/cart.php">Back to Cart</a>
        </p>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>