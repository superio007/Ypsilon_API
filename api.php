<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'revalidate') {
    $token = $_POST['token'];
    $traceId = $_POST['traceId'];
    $purchaseId = $_POST['purchaseId'];
    Revalidate($traceId, $purchaseId, $token);
}
function getToken(){ 
        $url = 'https://sandboxapi.getfares.com/connect/token'; // Replace with your actual URL

        // Data to be sent in x-www-form-urlencoded format
        $data = [
            'grant_type' => 'client_credentials',
            'scope' => 'FlightEngine',
            'client_id' => 'clientid.gauratravels',
            'client_secret' => '#$0u6@tr@v315*'
        ];

        // Convert data array to x-www-form-urlencoded format
        $postFields = http_build_query($data);

        // Initialize cURL session
        $ch = curl_init();

        // Set the URL and other options for the cURL session
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        // Execute the cURL session and fetch the response
        $response = curl_exec($ch);
        $data = json_decode($response,true);

        // Check for errors
        if ($response === false) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            curl_close($ch);
            $token = $data['access_token'];
            // $cookie_name = "token";
            // $cookie_value = $token;
            // $cookie_expiration = time() + 604800;
            // setcookie($cookie_name, $cookie_value, $cookie_expiration, "/");
            return $token;
        }
    }
     
    function Revalidate($traceId,$purchaseId,$token){
        $url = 'https://sandboxapi.getfares.com/Flights/Revalidation/v1'; 
        $data = [
            "traceId" => $traceId,
            "purchaseIds" => $purchaseId
        ];

        // Convert data array to JSON format
        $jsonData = json_encode($data);

        // Initialize cURL session
        $ch = curl_init();

        // Set the URL and other options for the cURL session
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: Bearer $token"
        ]);

        // Execute the cURL session and fetch the response
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Decode and print the response
            $responseData = json_decode($response, true);
            print_r($responseData);
        }

        // Close the cURL session
        curl_close($ch);
   }