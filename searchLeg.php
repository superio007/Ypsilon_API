<?php
header('Content-Type: application/json');
session_start();


if (isset($_POST['legId'])) {
    $legId = $_POST['legId'];
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
    // Assuming you have a valid file path for the XML data
    $filePath = $_SESSION['responseData'];// Modify with the correct file path

    // Call the searchLegById function to get the leg details
    $legDetails = searchLegById($filePath, $legId);

    // Return the response as JSON
    echo json_encode($legDetails);
} else {
    echo json_encode(['error' => 'legId not provided']);
}
