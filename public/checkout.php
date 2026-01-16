<?php
session_start(); // Start session to access cart data
// Retrieve subtotal from session or default to 0
$subtotal = $_SESSION['cart_subtotal'] ?? 0;
$tax = $subtotal * 0.06;
$total = $subtotal + $tax;

require __DIR__ . '/../views/checkout.php';
