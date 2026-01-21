<?php
require_once __DIR__ . '/ProductModel.php';
//function for cart operations and data building
function cart_init(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // product_id => qty
    }
}

function cart_add(int $productId, int $qty): void
{
    cart_init();
    $qty = max(1, min($qty, 5));

    $current = isset($_SESSION['cart'][$productId]) ? (int)$_SESSION['cart'][$productId] : 0;
    $newQty = $current + $qty;

    // cap at 5
    $_SESSION['cart'][$productId] = min($newQty, 5);
}

function cart_update(int $productId, int $qty): void
{
    cart_init();
    $qty = (int)$qty;

    if ($qty <= 0) {
        unset($_SESSION['cart'][$productId]);
        return;
    }

    $_SESSION['cart'][$productId] = max(1, min($qty, 5));
}

function cart_remove(int $productId): void
{
    cart_init();
    unset($_SESSION['cart'][$productId]);
}

function cart_getRaw(): array
{
    cart_init();
    return $_SESSION['cart'];
}

/**
 * Builds what the VIEW needs: items[] and subtotal
 */
function cart_buildViewData(): array
{
    $cart = cart_getRaw();
    $items = [];
    $subtotal = 0.0;

    if (empty($cart)) {
        return ['items' => [], 'subtotal' => 0.0];
    }

    $ids = array_map('intval', array_keys($cart));
    $productsById = getProductsByIds($ids); // from ProductModel

    foreach ($cart as $pid => $qty) {
        $pid = (int)$pid;
        $qty = (int)$qty;

        if (!isset($productsById[$pid])) {
            // product removed from DB or invalid id in session
            continue;
        }

        $p = $productsById[$pid];

        $maxQ = min((int)($p['max_quantity'] ?? 5), 5);
        $qty = max(1, min($qty, $maxQ));

        $price = (float)($p['base_price'] ?? 0);
        $lineTotal = $qty * $price;

        $subtotal += $lineTotal;

        $items[] = [
            'product_id' => $pid,
            'title' => $p['title'] ?? '',
            'price' => $price,
            'qty' => $qty,
            'max' => $maxQ,
            'image_filename' => $p['image_filename'] ?? '',
            'line_total' => $lineTotal
        ];
    }

    return ['items' => $items, 'subtotal' => $subtotal];
}
