
<?php
require_once __DIR__ . '/../models/ProductModel.php';

function showPrints()
{
    $products = getAllProducts();
    require __DIR__ . '/../views/prints.php';
}
