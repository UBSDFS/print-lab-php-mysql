<?php
$mysqli = require __DIR__ . '/../config/database.php';

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

// load the view 
require_once __DIR__ . '/../public/prints.php';
?>
<?php
require __DIR__ . '/../controllers/ProductControllers.php';
showPrints();
