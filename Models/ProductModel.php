<?php // Models/ProductModel.php for database interactions related to products
function getAllProducts()
{
    $mysqli = require __DIR__ . '/../config/database.php';
    // Prepare and execute the SQL query to fetch all products
    $sql = "SELECT product_id, title, description, image_filename, base_price, max_quantity
            FROM products
            ORDER BY product_id ASC";
    //return the result set
    $result = $mysqli->query($sql);
    if (!$result) {
        die('Query failed: ' . $mysqli->error);
    }
    // Fetch all products as an associative array
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}
