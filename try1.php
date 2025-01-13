<?php
session_start();

// Ensure the session contains the response data
$responseData = $_SESSION['responseData'] ?? null;
function getTarifDataById($tarifid, $xmlString)
{
    // Check if XML string is valid
    if (empty($xmlString)) {
        return "Error: No XML data provided.";
    }

    // Load the XML from string
    $xml = simplexml_load_string($xmlString);
    if (!$xml) {
        return "Error: Unable to parse XML data.";
    }

    // Register namespace for XPath queries
    $namespaces = $xml->getDocNamespaces();
    foreach ($namespaces as $prefix => $namespace) {
        if (empty($prefix)) {
            $prefix = "default";
        }
        $xml->registerXPathNamespace($prefix, $namespace);
    }

    // Fetch all tarif elements
    $tarifs = $xml->xpath("//default:tarif");
    if (empty($tarifs)) {
        return "Error: No tarif elements found in the XML.";
    }

    // Iterate through all tarif elements
    foreach ($tarifs as $tarif) {
        $currentTarifId = (string)$tarif['tarifid'];
        echo "Current tarifid: $currentTarifId\n"; // Debug

        // Split the combined tarifid into individual IDs
        $tarifIds = explode('_', $currentTarifId);
        echo "Split IDs: " . implode(', ', $tarifIds) . "\n"; // Debug

        // Check if the input tarifid matches any of the individual IDs
        if (in_array($tarifid, $tarifIds)) {
            // Extract data into an associative array
            return [
                'tarifid' => $currentTarifId,
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
    }

    return "Error: Tarif ID not found.";
}



// Example usage
$tarifid = '703132578';
$result = getTarifDataById($tarifid, $responseData);

// Output the result
if (is_array($result)) {
    echo "Tarif Data:\n";
    print_r($result);
} else {
    echo $result; // Error message
}
