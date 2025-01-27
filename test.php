<?php
/**
 * Get the details of a specific map element by legXRefId from servicemappings.
 *
 * @param string $responseData The XML data from the session.
 * @param string $legXRefId The legXRefId to search for in servicemappings.
 * @return array|null The details of the matched map element or null if not found.
 */
function getServiceMappingByLegXRefId($responseData, $legXRefId)
{
    if (empty($responseData)) {
        error_log('No XML data found in the session.');
        return ['error' => 'No XML data found in the session.'];
    }

    // Parse the XML string
    $xml = simplexml_load_string($responseData);
    if ($xml === false) {
        error_log('Invalid XML format.');
        return ['error' => 'Invalid XML format.'];
    }

    // Ensure <servicemappings> exists in the XML
    if (!isset($xml->servicemappings->map)) {
        error_log('Missing <servicemappings> or <map> in the XML.');
        return ['error' => 'Missing <servicemappings> or <map> in the XML.'];
    }

    // Traverse <servicemappings> to find the matching legXRefId
    foreach ($xml->servicemappings->map as $map) {
        error_log("Checking map with elemid: " . $map['elemid']);
        if ((string)$map['elemid'] === $legXRefId) {
            // Return the matched map's attributes as an array
            error_log("Matched map found with elemid: $legXRefId");
            return [
                'elemtype' => (string)$map['elemtype'],
                'elemid' => (string)$map['elemid'],
                'servicegroup' => (string)$map['servicegroup'],
                'serviceid' => (string)$map['serviceid'],
            ];
        }
    }

    // Return null if no match is found
    error_log("No matching map found for legXRefId: $legXRefId");
    return null;
}

// Example usage
session_start();
$responseData = $_SESSION['responseData'] ?? null;
$legXRefIdToSearch = '53301177337'; // Replace with the legXRefId you want to search for
$result = getServiceMappingByLegXRefId($responseData, $legXRefIdToSearch);

// Output the result
if (isset($result['error'])) {
    echo $result['error'];
} elseif ($result === null) {
    echo "No matching map found for legXRefId: $legXRefIdToSearch";
} else {
    echo "Matched Map:\n";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
}

