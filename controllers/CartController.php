<?php
require_once __DIR__ . '/../models/CartModel.php';

function handleCart(): void
{
    // Handle cart mutations (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

        if ($productId > 0) {
            switch ($action) {
                case 'add':
                    cart_add($productId, $qty);
                    break;

                case 'update':
                    cart_update($productId, $qty);
                    break;

                case 'remove':
                    cart_remove($productId);
                    break;
            }
        }

        // PRG pattern: prevents double submit on refresh
        header('Location: /print-lab-php-mysql/public/cart.php');
        exit;
    }

    // Render cart (GET)
    $cartView = cart_buildViewData();
    $items = $cartView['items'];
    $subtotal = $cartView['subtotal'];

    require __DIR__ . '/../views/cart.php';
}
