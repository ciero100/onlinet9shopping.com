<!-- process_payment.php -->

<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('your-secret-key-here'); // Replace with your Stripe secret key

// Sanitize and validate the token and other inputs
$token = $_POST['stripeToken'];

$charge = \Stripe\Charge::create([
    'amount' => 5000, // Amount in cents ($50.00)
    'currency' => 'usd',
    'description' => 'Example charge',
    'source' => $token,
]);

// Handle post-payment logic
if ($charge->status == 'succeeded') {
    // Save order to database
    // Send confirmation email
    // Redirect to success page
    header("Location: success.php");
} else {
    // Handle failure
    header("Location: failure.php");
}
?>
