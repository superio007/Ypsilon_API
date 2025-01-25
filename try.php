<?php
session_start();
function getLegIdsByFlightId($fareXRefs, $flightId)
{
    $legIds = []; // Array to store legIds

    // Navigate to the flights array
    if (isset($fareXRefs['fareXRefs']['fareXRef']['flights']['flight'])) {
        $flights = $fareXRefs['fareXRefs']['fareXRef']['flights']['flight'];

        // Check if we have multiple flights or a single flight
        if (isset($flights[0])) {
            // Multiple flights
            foreach ($flights as $flight) {
                if (isset($flight['@attributes']['flightId']) && $flight['@attributes']['flightId'] == $flightId) {
                    // Collect legIds
                    if (isset($flight['legXRefs']['legXRef'])) {
                        foreach ($flight['legXRefs']['legXRef'] as $legRef) {
                            if (isset($legRef['@attributes']['legId'])) {
                                $legIds[] = $legRef['@attributes']['legId'];
                            }
                        }
                    }
                }
            }
        } else {
            // Single flight
            if (isset($flights['@attributes']['flightId']) && $flights['@attributes']['flightId'] == $flightId) {
                // Collect legIds
                if (isset($flights['legXRefs']['legXRef'])) {
                    foreach ($flights['legXRefs']['legXRef'] as $legRef) {
                        if (isset($legRef['@attributes']['legId'])) {
                            $legIds[] = $legRef['@attributes']['legId'];
                        }
                    }
                }
            }
        }
    }

    return $legIds;
}

    // Example usage
    $responseData = $_SESSION['responseData']; // Replace with your actual file path
    $result = getLegIdsByFlightId($responseData, '838218061');
    echo '<pre>';
    var_dump($result);
    echo '</pre>';