<?php
session_start();

// Get the XML response from the session and parse it
$response = $_SESSION['responseData'];
$xmlData = simplexml_load_string($response);

if (!$xmlData) {
    die("Failed to parse XML data.");
}

// Function to retrieve fare ID based on leg ID
function getFareIdFromLegId(SimpleXMLElement $xml, $legId)
{
    // Navigate through farexrefs -> flights -> legxrefs -> legxref to match legid
    foreach ($xml->xpath('//farexrefs/farexref') as $farexref) {
        $fareId = (string)$farexref['fareid'];
        foreach ($farexref->xpath('./flights/flight/legxrefs/legxref') as $legxref) {
            if ((string)$legxref['legid'] === $legId) {
                return $fareId;
            }
        }
    }

    // Return null if no matching fareid is found
    return null;
}

// Example usage
$legIdToSearch = '362602527'; // Replace with the desired leg ID
$fareId = getFareIdFromLegId($xmlData, $legIdToSearch);

// Display results
if ($fareId) {
    echo "Fare ID for leg ID $legIdToSearch: $fareId";
} else {
    echo "No Fare ID found for leg ID $legIdToSearch";
}

// Optional: Display the entire XML as JSON
$xmlAsJson = json_encode($xmlData, JSON_PRETTY_PRINT);
echo "<pre>$xmlAsJson</pre>";
