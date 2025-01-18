<?php
session_start();
$responseData = $_SESSION['responseData'];
function searchLegById($filePath, $searchLegId)
{
    // Load the XML file
    $xml = simplexml_load_string($filePath) or die("Unable to load XML file!");

    // Convert SimpleXMLElement to JSON and decode to associative array for easier handling
    $xmlArray = json_decode(json_encode($xml), true);

    // Check if <legs> exists in the XML structure
    if (!isset($xmlArray['legs']['leg'])) {
        return "No <legs> found in the XML.";
    }

    // Iterate through the <leg> elements
    $legs = $xmlArray['legs']['leg'];
    $matchingLegs = [];

    foreach ($legs as $leg) {
        // Check if the leg matches the searchLegId
        if (
            isset($leg['@attributes']['legId']) && $leg['@attributes']['legId'] == $searchLegId
        ) {
            $matchingLegs[] = $leg['@attributes'];
        }
    }

    // Return the matching legs or a message if none found
    if (!empty($matchingLegs)) {
        return $matchingLegs;
    } else {
        return "No matching legs found for legId: $searchLegId.";
    }
}
echo "<PRE>";
var_dump(searchLegById($responseData, "28927676"));
echo "</PRE>";