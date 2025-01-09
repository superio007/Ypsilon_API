<?php
session_start();

// Ensure the session contains the response data
$responseData = $_SESSION['responseData'] ?? null;

function getTarifDataById($tarifid, $xmlString) {
    // Check if XML string is valid
    if (empty($xmlString)) {
        return "Error: No XML data provided.";
    }

    // Load the XML from string
    $xml = simplexml_load_string($xmlString);
    if (!$xml) {
        return "Error: Unable to parse XML data.";
    }

    // Search for the tarif by ID
    foreach ($xml->xpath("//tarif[@tarifid='$tarifid']") as $tarif) {
        // Extract data into an associative array
        return [
            'tarifid' => (string)$tarif['tarifid'],
            'adtbuy' => (string)$tarif['adtbuy'],
            'adtsell' => (string)$tarif['adtsell'],
            'chdbuy' => (string)$tarif['chdbuy'],
            'chdsell' => (string)$tarif['chdsell'],
            'infbuy' => (string)$tarif['infbuy'],
            'infsell' => (string)$tarif['infsell'],
            'adttax' => (string)$tarif['adttax'],
            'chdtax' => (string)$tarif['chdtax'],
            'inftax' => (string)$tarif['inftax'],
            'origin' => (string)$tarif['origin'],
            'taxmode' => (string)$tarif['taxmode'],
            'refundable' => (string)($tarif['refundable'] ?? 'false'),
        ];
    }

    return "Error: Tarif ID not found.";
}

// Example usage
$tarifid = '1442014243';
$result = getTarifDataById($tarifid, $responseData);

// Output the result
if (is_array($result)) {
    echo "Tarif Data:\n";
    print_r($result);
} else {
    echo $result; // Error message
}

