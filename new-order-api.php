<?php
// webhook.php

// Read the raw POST data
$rawPostData = file_get_contents("php://input");

// Decode the JSON data
$jsonData = json_decode($rawPostData, true); // Decode as an associative array

// Check for errors in decoding
if (json_last_error() !== JSON_ERROR_NONE) {
    // Handle the error
    die('Error decoding JSON');
}

// Extract necessary details from the webhook data
// Make sure to validate these data points before using them
$contact_number = $jsonData['billing_address']['phone'] ?? ''; // Phone number
$billing_name = $jsonData['billing_address']['first_name'] ?? ''; // Customer's first name
$order_total_inc = $jsonData['total_price'] ?? ''; // Total price of the order

// Check if the required data is available
if (empty($contact_number) || empty($billing_name) || empty($order_total_inc)) {
    die('Required data is missing');
}

// Define the message
$message = "{$billing_name}, comanda dvs. de {$order_total_inc} RON este acum în procesare și va fi expediată prin GLS. Vă vom anunța prin SMS de pe acest număr când comanda a fost expediată. Dacă doriți să anulați comanda, vă rugăm să scrieți ANULARE. - Echipa SSS.ro";

// Prepare data for the SMS API
$data = array(
    "key" => "APIKEY",
    "option" => "1",
    "type" => "sms",
    "useRandomDevice" => "1",
    "prioritize" => "0",
    "number" => $contact_number,
    "message" => $message
);

// Initialize cURL
$curl = curl_init();

$url = "https://smsapi.mysms.ro/services/send.php";

curl_setopt_array($curl, array(
    CURLOPT_URL => sprintf("%s?%s", $url, http_build_query($data)),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
));

// Execute the request
try {
    $response = curl_exec($curl);

    // Handle the response
    if ($response === false) {
        throw new Exception(curl_error($curl), curl_errno($curl));
    }

    // Optional: Process the response
    // print_r($response);
} catch (Exception $e) {
    // Handle exception
    // print_r($e->getMessage());
} finally {
    // Close the cURL session
    curl_close($curl);
}
?>
