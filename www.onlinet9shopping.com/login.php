<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='message'>Invalid email or password.</div>";
        }
    } else {
        echo "<div class='message'>Invalid email or password.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
