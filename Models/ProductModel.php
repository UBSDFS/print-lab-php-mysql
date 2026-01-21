<?php
//function to get all products from the Db and return as an array in the view as products
function getAllProducts(): array
{
    $mysqli = require __DIR__ . '/../config/database.php';

    if (!$mysqli instanceof mysqli) {
        die('Database connection not established');
    }

    $sql = "SELECT product_id, title, description, image_filename, base_price, max_quantity
            FROM products
            ORDER BY product_id ASC";

    $result = $mysqli->query($sql);
    if (!$result) {
        die('Query failed: ' . $mysqli->error);
    }

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}


function getProductsByIds(array $ids): array
{
    $ids = array_values(array_filter(array_map('intval', $ids), fn($v) => $v > 0));
    if (empty($ids)) return [];

    $mysqli = require __DIR__ . '/../config/database.php';

    if (!$mysqli instanceof mysqli) {
        die('Database connection not established');
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT product_id, title, base_price, image_filename, max_quantity
            FROM products
            WHERE product_id IN ($placeholders)";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $types = str_repeat('i', count($ids));
    $stmt->bind_param($types, ...$ids);

    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    $byId = [];
    while ($row = $result->fetch_assoc()) {
        $byId[(int)$row['product_id']] = $row;
    }

    return $byId;
}



//Get all products from the Db and display it this way