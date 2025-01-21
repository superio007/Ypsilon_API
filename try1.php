<?php
session_start();

// Load the XML from the session
$responseData = $_SESSION['responseData'] ?? null;

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
        $matchedTarif = json_decode(json_encode($tarif), true);
        break;
    }

    return $matchedTarif;
}

function displayFareData($tarif, &$fareIdsPrimary, &$fareIdsSecondary , $tarifIdsingle)
{
    if ($tarif) {
        $fareId = $tarif['@attributes']['tarifId'] ?? 'N/A';
        echo "<h2>Fare ID: $fareId</h2>";
        $adtSell = $tarif['@attributes']['adtSell'] ?? 'N/A';
        $adtTax = $tarif['@attributes']['adtTax'] ?? 'N/A';
        echo "Adult Sell Price: $adtSell<br>";
        echo "Adult Tax: $adtTax<br>";

        // Loop through fareXRefs
        if (isset($tarif['fareXRefs']['fareXRef'])) {
            foreach ($tarif['fareXRefs']['fareXRef'] as $fareXRef) {
                $subFareId = $fareXRef['@attributes']['fareId'] ?? 'N/A';
                echo "<h3>Fare Sub-ID: $subFareId</h3>";

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
                        echo "<h4>Flight ID: $flightId</h4>";

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

                // Corrected classification logic for primary and secondary arrays
                if ($subFareId === $tarifIdsingle) { // Explicitly classify IDs
                    $fareIdsPrimary[$subFareId] = $flightsData;
                } else {
                    $fareIdsSecondary[$subFareId] = $flightsData;
                }
            }
        }
    } else {
        echo "<h2>No data found for this fare ID.</h2>";
    }
}

// Initialize arrays for storing fare IDs with flights
$fareIdsPrimary = [];
$fareIdsSecondary = [];
$tarifId= "382714061_382714075";
// Retrieve and display data for the fare ID
function getFirstFareId($fareId)
{
    return explode("_", $fareId)[0];
}
$tarifIdsingle = getFirstFareId($tarifId);
$tarif = getTarifByFareId($responseData, $tarifId);

displayFareData($tarif, $fareIdsPrimary, $fareIdsSecondary, $tarifIdsingle);

// Print the arrays for verification
echo "<h2>Primary Fare IDs with Flights:</h2>";
echo "<pre>";
print_r($fareIdsPrimary);
echo "</pre>";

echo "<h2>Secondary Fare IDs with Flights:</h2>";
echo "<pre>";
print_r($fareIdsSecondary);
echo "</pre>";
