<?php
header('Content-Type: application/json');
session_start();
require 'api.php';
function mergeFareIds($responseData)
{
    // Check if the session contains the response data
    if (!$responseData) {
        die("No XML data found in the session.");
    }

    // Load the XML string
    $xml = simplexml_load_string($responseData);

    // Ensure the XML is loaded correctly
    if ($xml === false) {
        die("Error loading XML data from session.");
    }

    // Initialize an array to store fare IDs
    $fareIds = [];

    // Loop through the fares and collect fare IDs
    foreach ($xml->fares->fare as $fare) {
        $fareIds[] = (string) $fare['fareId'];
    }

    // Merge fare IDs without overlapping
    $mergedFareIds = [];
    for ($i = 0; $i < count($fareIds) - 1; $i += 2) {
        // Ensure the next index exists before merging
        if (isset($fareIds[$i + 1])) {
            $mergedFareIds[] = $fareIds[$i] . '_' . $fareIds[$i + 1];
        }
    }

    return $mergedFareIds;
}
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
    return $matchedTarif;
}
function getSeperatedFlights($tarif, &$fareIdsPrimary, &$fareIdsSecondary, $tarifIdsingle)
{
    if ($tarif) {
        $fareId = $tarif['@attributes']['tarifId'] ?? 'N/A';
        $adtSell = $tarif['@attributes']['adtSell'] ?? 'N/A';
        $adtTax = $tarif['@attributes']['adtTax'] ?? 'N/A';

        // Loop through fareXRefs
        if (isset($tarif['fareXRefs']['fareXRef'])) {
            foreach ($tarif['fareXRefs']['fareXRef'] as $fareXRef) {
                $subFareId = $fareXRef['@attributes']['fareId'] ?? 'N/A';

                $flightsData = [];

                // Loop through flights
                if (isset($fareXRef['flights']['flight'])) {
                    $flights = $fareXRef['flights']['flight'];

                    // Handle both single and multiple flight cases
                    if (isset($flights['@attributes'])) {
                        $flights = [$flights]; // Wrap single flight in an array
                    }

                    foreach ($flights as $flight) {
                        $flightId = $flight['@attributes']['flightId'] ?? 'N/A';

                        $flightDetails = [
                            'flightId' => $flightId,
                            'legs' => []
                        ];

                        // Handle both single and multiple legXRefs
                        $legXRefs = $flight['legXRefs']['legXRef'] ?? [];
                        if (isset($legXRefs['@attributes'])) {
                            $legXRefs = [$legXRefs]; // Wrap single legXRef in an array
                        }

                        foreach ($legXRefs as $legXRef) {
                            $legDetails = [
                                'legId' => $legXRef['@attributes']['legId'] ?? 'N/A',
                                'class' => $legXRef['@attributes']['class'] ?? 'N/A',
                                'cosDescription' => $legXRef['@attributes']['cosDescription'] ?? 'N/A',
                                'fareBaseAdt' => $legXRef['@attributes']['fareBaseAdt'] ?? 'N/A',
                                'seats' => $legXRef['@attributes']['seats'] ?? 'N/A',
                            ];
                            $flightDetails['legs'][] = $legDetails;
                        }

                        $flightsData[] = $flightDetails;
                    }
                }

                // Correct classification logic for primary and secondary arrays
                if ($subFareId === $tarifIdsingle) {
                    $fareIdsPrimary[$subFareId] = $flightsData;
                } else {
                    $fareIdsSecondary[$subFareId] = $flightsData;
                }
            }
        }
    }
}

function searchLegById($filePath, $searchLegId)
{
    // Load the XML file
    $xml = simplexml_load_string($filePath) or die("Unable to load XML file!");

    // Convert SimpleXMLElement to JSON and decode to associative array for easier handling
    $xmlArray = json_decode(json_encode($xml), true);

    // Check if <legs> exists in the XML structure
    if (!isset($xmlArray['legs']['leg'])) {
        return [];
    }

    // Iterate through the <leg> elements
    $legs = $xmlArray['legs']['leg'];
    $matchingLegs = [];

    foreach ($legs as $leg) {
        // Check if the leg matches the searchLegId
        if (isset($leg['@attributes']['legId']) && $leg['@attributes']['legId'] == $searchLegId) {
            $matchingLegs[] = $leg['@attributes'];
        }
    }

    return $matchingLegs; // Return all matching legs or empty if none found
}

function getFirstFareId($fareId)
{
    return explode("_", $fareId)[0];
}
// Fetch flight data
$responseData = $_SESSION['responseData'] ?? null;
if (!$responseData) {
    echo json_encode(['error' => 'No flight data found']);
    exit;
}

$fares = mergeFareIds($responseData);
$flightDetails = [];

foreach ($fares as $id) {
    $tarif = getTarifByFareId($responseData, $id);
    $fareIdsPrimary = [];
    $fareIdsSecondary = [];
    $tarifIdsingle = getFirstFareId($id);
    getSeperatedFlights($tarif, $fareIdsPrimary, $fareIdsSecondary, $tarifIdsingle);

    $flightDetails[] = [
        'id' => $id,
        'primary' => $fareIdsPrimary,
        'secondary' => $fareIdsSecondary,
        'price' => $tarif['@attributes']['adtSell'] + $tarif['@attributes']['adtTax'],
    ];
}

echo json_encode($flightDetails);
