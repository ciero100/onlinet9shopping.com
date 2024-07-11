<?php
session_start();

$servername = "localhost"; // Your database server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "ecommerce"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $address = $conn->real_escape_string($_POST['address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    // Calculate total price
    $total_price = 0.0;
    $cart_items = $conn->query("SELECT * FROM cart_items WHERE user_id = $user_id");

    if ($cart_items) {
        while ($item = $cart_items->fetch_assoc()) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $product_result = $conn->query("SELECT price FROM products WHERE id = $product_id");

            if ($product_result) {
                $product = $product_result->fetch_assoc();
                $total_price += $product['price'] * $quantity;
            } else {
                die("Product query failed: " . $conn->error);
            }
        }
    } else {
        die("Cart items query failed: " . $conn->error);
    }

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, shipping_address, payment_method) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("idss", $user_id, $total_price, $address, $payment_method);

        if ($stmt->execute()) {
            // Clear cart items
            if ($conn->query("DELETE FROM cart_items WHERE user_id = $user_id")) {
                echo "Order placed successfully";
            } else {
                die("Failed to clear cart items: " . $conn->error);
            }
        } else {
            die("Order insertion failed: " . $stmt->error);
        }

        $stmt->close();
    } else {
        die("Statement preparation failed: " . $conn->error);
    }

    $conn->close();
}
?>
