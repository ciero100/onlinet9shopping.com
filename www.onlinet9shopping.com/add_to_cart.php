<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Assuming you have a function to get product details by ID
    // Example: $product = getProductById($product_id);
    
    // For simplicity, let's assume the product details are fetched like this
    $product = [
        'id' => $product_id,
        'name' => "Product Name", // Replace with actual product name
        'price' => 100 // Replace with actual product price
    ];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
}
?>
