<?php


$mysqli = require __DIR__ . '/../config/database.php';
if (!$mysqli instanceof mysqli) {
    die('Database connection not established');
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * Handle ADD action (from prints.php)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $productId = (int)($_POST['product_id'] ?? 0);
    $qty       = (int)($_POST['qty'] ?? 1);

    if ($productId > 0) {
        $qty = max(1, min($qty, 5));
        $current = (int)($_SESSION['cart'][$productId] ?? 0);
        $_SESSION['cart'][$productId] = min($current + $qty, 5);
    }

    header('Location: cart.php');
    exit;
}

$cart = $_SESSION['cart']; // [product_id => qty]
//Update action
/**
 * Handle UPDATE action (from cart.php)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    $qtyMap = $_POST['qty'] ?? []; // qty[productId] => qty

    foreach ($qtyMap as $pid => $q) {
        $pid = (int)$pid;
        $q   = (int)$q;

        if ($pid <= 0) continue;

        if ($q <= 0) {
            unset($_SESSION['cart'][$pid]);        // remove
        } else {
            $_SESSION['cart'][$pid] = max(1, min($q, 5)); // clamp 1..5
        }
    }

    header('Location: cart.php');
    exit;
}


// Fetch product rows for items in cart
$items = [];
$subtotal = 0.0;

if (!empty($cart)) {
    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    $stmt = $mysqli->prepare("
        SELECT product_id, title, image_filename, base_price
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

        $row['qty'] = $qty;
        $row['line_total'] = $qty * $price;

        $subtotal += $row['line_total'];
        $items[] = $row;
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main class="cart-page">
    <h1>Cart</h1>

    <?php if (empty($items)): ?>
        <p>Your cart is empty.</p>
        <p><a href="/print-lab-php-mysql/public/prints.php">Back to Prints</a></p>
    <?php else: ?>

        <form method="post" action="/print-lab-php-mysql/public/cart.php">
            <input type="hidden" name="action" value="update">

            <?php foreach ($items as $item): ?>
                <div class="cart-row" style="display:flex; gap:1rem; align-items:center; margin:1rem 0; padding:1rem; background:#fff; border-radius:12px;">
                    <img
                        style="width:120px; height:80px; object-fit:cover; border-radius:10px;"
                        src="<?php echo htmlspecialchars('/print-lab-php-mysql/public/assets/images/wes-andy/' . ($item['image_filename'] ?? '')); ?>"
                        alt="<?php echo htmlspecialchars($item['title'] ?? 'Print'); ?>">

                    <div style="flex:1;">
                        <div style="font-weight:700;"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div>$<?php echo number_format((float)$item['base_price'], 2); ?></div>
                    </div>

                    <div>
                        <label>
                            Qty:
                            <input
                                type="number"
                                name="qty[<?php echo (int)$item['product_id']; ?>]"
                                min="0"
                                max="5"
                                value="<?php echo (int)$item['qty']; ?>"
                                style="width:70px;">
                        </label>
                    </div>

                    <div style="min-width:120px; text-align:right;">
                        $<?php echo number_format((float)$item['line_total'], 2); ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div style="text-align:right; margin-top:1rem;">
                <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                <button type="submit">Update Cart</button>
            </div>
        </form>

        <p style="margin-top:1rem;">
            <a href="/print-lab-php-mysql/public/prints.php">Continue Shopping</a>
            &nbsp;|&nbsp;
            <a href="/print-lab-php-mysql/public/checkout.php">Proceed to Checkout</a>
        </p>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>