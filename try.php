<?php
function getAdtSellByTarifId($tarifId, $xmlData)
{
    // Load the XML data
    $xml = simplexml_load_string($xmlData);

    if (!$xml) {
        return "Failed to load XML data.";
    }

    // Search for the tarif with the specified ID
    foreach ($xml->tarifs->tarif as $tarif) {
        if ((string)$tarif['tarifId'] === $tarifId) {
            // Return the adtSell value for the matched tarif
            return (string)$tarif['adtSell'];
        }
    }

    return "Tarif ID {$tarifId} not found.";
}

// Example usage
session_start();

if (!isset($_SESSION['responseData'])) {
    die("No XML data found in session.");
}

$responseData = $_SESSION['responseData'];

// Provide the tarif ID to filter
$tarifId = '1442014270'; // Replace with the ID you want to search for
$adtSellValue = getAdtSellByTarifId($tarifId, $responseData);

// Output the result
echo "AdtSell Value for Tarif ID {$tarifId}: {$adtSellValue}";
