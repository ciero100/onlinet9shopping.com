<?php
// Database configuration
$servername = "localhost"; // Typically "localhost" for local development
$username = "root";        // Default username for XAMPP
$password = "";            // Default password for XAMPP is an empty string
$dbname = "ecommerce";     // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
