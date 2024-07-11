<?php
// Start the session
session_start();

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

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Close the connection at the end of the script
// This will be done after the HTML output
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - My E-Commerce Store</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Our Products</h1>
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
        <p><a href="add_product.php">Add New Product</a></p>
    <?php endif; ?>
    <div class="product-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product">
                    <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width:100px;height:100px;"><br>
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <p>$<?php echo $row['price']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
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
