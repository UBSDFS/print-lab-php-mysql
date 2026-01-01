<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<body>

    <!-- main section-->
    <main class="Prints-page">
        <h1>Welcome to the Prints Gallery</h1>
        <p>Prints page currently under construction.
            Collection will be displayed here in a grid format.
        </p>

        <section class="print-grid">
            <!--print card-->
            <div class="print-card">
                <div class="print-image placeholder"></div>
                <h3>Wes Andy</h3>
                <p class="price"> $1000</p>
                <button> Add to cart</button>
            </div>
        </section>
    </main>
</body>
<?php include '../includes/footer.php'; ?>

</html>

/* TODO (Week 3):
* - Implement dynamic retrieval of prints from the database using PHP and MySQL.
* - Add functionality to "Add to cart" buttons to store selected prints in user session.
* - Style print cards: borders, shadows, hover effects, and button styles.
*
*/