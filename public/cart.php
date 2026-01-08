<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<body>

    <!-- main section-->
    <main class="Cart-page">
        <h1>Your Shopping Cart</h1>
        <p>Cart page currently under construction.
            Selected prints will be displayed here with options to modify quantities or remove items.
        </p>

        <section class="cart-items">
            <!--cart item-->
            <div class="cart-item">
                <div class="item-image placeholder"></div>
                <div class="item-details">
                    <h3>Wes Andy</h3>
                    <p class="price"> $1000</p>
                    <p class="quantity"> Quantity: 1 </p>

                </div>
            </div>
            <a class="remove-from-cart" href="#"> Remove from cart</a>
            <a class="continue-shopping" href="/print-lab-php-mysql/public/prints.php"> Continue Shopping </a>
            <a class="checkout-button" href="/print-lab-php-mysql/public/checkout.php"> Proceed to Checkout </a>
        </section>
    </main>
</body>
<?php include '../includes/footer.php'; ?>

</html>

<!-- TODO (Week 3): CRUD for Cart
* - Implement cart functionality using PHP to store selected prints.
* - Add form elements to update item quantities directly within the cart.
* - Calculate and display total price based on cart contents.
*
-->