<?php
session_start(); // Start the session to access cart data

$mysqli = require __DIR__ . '/../config/database.php';

if (!isset($_SESSION['cart'])) { // Initialize cart if not set
    $_SESSION['cart'] = []; //session cart as associative array product_id => quantity
}



// Build $items and $subtotal for the view
$cart = $_SESSION['cart'];
$items = []; // Array to hold cart items with details
$subtotal = 0.0;

// Fetch product details for items in the cart
if (!empty($cart)) {
    $ids = array_keys($cart); // Get product IDs from the cart
    $placeholders = implode(',', array_fill(0, count($ids), '?')); // Prepare placeholders for SQL IN clause

    $sql = "SELECT product_id, title, base_price, image_filename, max_quantity
            FROM products
            WHERE product_id IN ($placeholders)";

    $stmt = $mysqli->prepare($sql);
    $types = str_repeat('i', count($ids));
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) { // Process each product in the cart for display
        $pid = (int)$row['product_id'];
        $qty = (int)($cart[$pid] ?? 1);

        $maxQ = min((int)($row['max_quantity'] ?? 5), 5);
        if ($qty > $maxQ) $qty = $maxQ;

        $lineTotal = $qty * (float)$row['base_price']; // Calculate line total
        $subtotal += $lineTotal;
        // Add item details to $items array
        $items[] = [
            'product_id' => $pid,
            'title' => $row['title'],
            'price' => (float)$row['base_price'],
            'qty' => $qty,
            'max' => $maxQ,
            'image_filename' => $row['image_filename'],
            'line_total' => $lineTotal
        ];
    }
}

require __DIR__ . '/../views/cart.php';
