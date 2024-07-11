<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variable to hold order details
$order = null;
$order_items = [];

// Check if order ID is set in the URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch order details
    $sql = "SELECT * FROM orders WHERE id = ? AND user_id = (SELECT id FROM users WHERE username = ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $order_id, $_SESSION['username']);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                // Fetch order details
                $order = $result->fetch_assoc();
            } else {
                // Redirect to orders page if order not found
                header("location: orders.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Fetch order items
    $sql = "SELECT oi.*, p.name, p.price, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $order_id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $order_items[] = $row;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
} else {
    // Redirect to orders page if no ID is provided
    header("location: orders.php");
    exit();
}

// Close connection at the end of the script
// This will be done after the HTML output
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - My E-Commerce Store</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="orders.php">My Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Order Details</h1>
    <?php if ($order): ?>
        <h2>Order #<?php echo htmlspecialchars($order['id']); ?></h2>
        <p>Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
        <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
        <h3>Items:</h3>
        <div class="order-items">
            <?php if (!empty($order_items)): ?>
                <?php $total = 0; ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <?php $item_total = $item['quantity'] * $item['price']; ?>
                            <?php $total += $item_total; ?>
                            <tr>
                                <td>
                                    <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width:50px;height:50px;">
                                    <br><?php echo htmlspecialchars($item['name']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                <td>$<?php echo htmlspecialchars($item_total); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h3>Total: $<?php echo htmlspecialchars($total); ?></h3>
            <?php else: ?>
                <p>No items found for this order.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Order not found.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; <?php echo date('Y'); ?> My E-Commerce Store. All rights reserved.</p>
</footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
