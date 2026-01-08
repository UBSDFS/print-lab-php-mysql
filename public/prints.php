<?php
include '../includes/header.php';
include '../includes/nav.php';

$mysqli = require __DIR__ . '/../config/database.php'; //path to the database connection file
//selects all products from the products table
$sql = "SELECT title, description, image_filename, base_price, max_quantity
        FROM products
        ORDER BY product_id ASC";

$result = $mysqli->query($sql);

if (!$result) {
    die('Query failed: ' . $mysqli->error);
}
?>


<main class="Prints-page">
    <h1>Welcome to the Gallery</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Preview</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Max Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img
                            src="http://localhost/print-lab-php-mysql/public/assets/images/wes-andy/
<?= htmlspecialchars($product['image_filename']); ?>"
                            alt="<?= htmlspecialchars($product['title']); ?>"
                            width="120">
                    </td>
                    <td><?= htmlspecialchars($product['title']); ?></td>
                    <td><?= htmlspecialchars($product['description']); ?></td>
                    <td>$<?= number_format((float)$product['base_price'], 2); ?></td>
                    <td><?= (int)$product['max_quantity']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include '../includes/footer.php'; ?>

<!-- TODO (Week 3):
*DONE - Implement dynamic retrieval of prints from the database using PHP and MySQL.
*IN PROGRESS - Add functionality to "Add to cart" buttons to store selected prints in user session.
* - Style print cards: borders, shadows, hover effects, and button styles.
*
-->