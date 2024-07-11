<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>
<body>

<h2>Shopping Cart</h2>

<?php if (!empty($_SESSION['cart'])): ?>
    <form action="update_cart.php" method="post">
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td>
                        <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $product['quantity']; ?>" min="1">
                    </td>
                    <td><?php echo htmlspecialchars($product['price'] * $product['quantity']); ?></td>
                    <td>
                        <a href="remove_from_cart.php?product_id=<?php echo $product_id; ?>">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Update Cart</button>
    </form>
    <a href="checkout.php">Proceed to Checkout</a>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

</body>
</html>
