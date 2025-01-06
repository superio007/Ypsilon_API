<?php
session_start();
$responseData = $_SESSION['responseData'];
function getTarifByFareId($responseData, $fareIdToMatch)
{
    // Load XML from string
    $xml = simplexml_load_string($responseData);
    if ($xml === false) {
        die("Failed to load XML: " . implode(", ", libxml_get_errors()));
    }

    // Initialize the result variable
    $matchedTarif = null;

    // Loop through all <tarif> elements
    foreach ($xml->xpath("//tarif[@tarifId='$fareIdToMatch']") as $tarif) {
        // Convert the matched <tarif> element to an array
        $matchedTarif = json_decode(json_encode($tarif), true);
        break; // Stop after finding the first match
    }

    // Return the matched tarif array or null if not found
    return $matchedTarif['@attributes']['adtSell'];
}

$result = getTarifByFareId($responseData, "1229133828");

// Display the filtered results
header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
