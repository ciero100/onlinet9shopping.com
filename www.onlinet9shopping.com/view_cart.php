<!-- view_cart.php -->

<?php
session_start();

// Example array of products (you would fetch these from your database)
$products = [
    ['id' => 1, 'name' => 'Product 1', 'price' => 10.00],
    ['id' => 2, 'name' => 'Product 2', 'price' => 15.00],
    ['id' => 3, 'name' => 'Product 3', 'price' => 20.00],
];

// Initialize cart array in session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to get product details by ID (replace with your database query)
function getProductById($id) {
    global $products;
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>
<body>

<h2>Your Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $product_id): ?>
                <?php $product = getProductById($product_id); ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td>
                        <form action="cart.php?action=remove" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="products.php">Continue Shopping</a></p>

</body>
</html>
