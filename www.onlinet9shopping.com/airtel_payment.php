<?php
function initiateAirtelPayment($phoneNumber, $amount) {
    $url = "https://api.airtel.com/v1/payments";
    $api_key = "YOUR_AIRTEL_API_KEY";
    $api_secret = "YOUR_AIRTEL_API_SECRET";
    
    $headers = array(
        "Authorization: Basic " . base64_encode("$api_key:$api_secret"),
        "Content-Type: application/json"
    );

    $data = json_encode(array(
        "phoneNumber" => $phoneNumber,
        "amount" => $amount,
        "currency" => "RWF"
    ));

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Example usage
$response = initiateAirtelPayment("+250123456789", 1000);
echo $response['status'] == 'success' ? 'Payment initiated' : 'Payment failed';
?>
