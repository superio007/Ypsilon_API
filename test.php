<?php
function searchLegById($filePath, $searchLegId)
{
  // Load the XML file
  libxml_use_internal_errors(true);
  $xml = simplexml_load_string($filePath);
  if (!$xml) {
    $errors = libxml_get_errors();
    libxml_clear_errors();
    die("Unable to load XML file. Errors: " . print_r($errors, true));
  }

  // Register namespaces for shared attributes
  $namespaces = $xml->getNamespaces(true);

  // Check if <legs> exists in the XML
  if (!isset($xml->legs->leg)) {
    return "No <legs> found in the XML.";
  }

  // Iterate through the <leg> elements
  $matchingLegs = [];
  foreach ($xml->legs->leg as $leg) {
    // Access attributes
    $attributes = $leg->attributes();
    $sharedAttributes = $leg->attributes($namespaces['shared']);

    // // Check if the leg matches the searchLegId
    // if ((string)$attributes->legid === $searchLegId) {
      $matchingLegs[] = [
        'legId' => (string)$attributes->legid,
        'depapt' => (string)$attributes->depapt,
        'depdate' => (string)$attributes->depdate,
        'deptime' => (string)$attributes->deptime,
        'arrapt' => (string)$attributes->arrapt,
        'arrdate' => (string)$attributes->arrdate,
        'arrtime' => (string)$attributes->arrtime,
        'equip' => (string)$attributes->equip,
        'fno' => (string)$attributes->fno,
        'shared:cr' => (string)$sharedAttributes->cr, // Fetching shared namespace attribute
        'miles' => (string)$attributes->miles,
        'elapsed' => (string)$attributes->elapsed,
        'meals' => (string)$attributes->meals,
        'smoker' => (string)$attributes->smoker,
        'stops' => (string)$attributes->stops,
        'eticket' => (string)$attributes->eticket,
      ];
    // }
  }

  // Return the matching legs or a message if none found
  if (!empty($matchingLegs)) {
    return $matchingLegs;
  } else {
    return "No matching legs found for legId: $searchLegId.";
  }
}

// Example usage
session_start();
$responseData = $_SESSION['responseData'] ?? null; // Assuming this contains the XML string

if (!$responseData) {
  die("No XML data found in session.");
}

$result = searchLegById($responseData, "628138540");

// Output the result
if (is_array($result)) {
  echo "Matching legs found:\n";
  print_r($result);
} else {
  echo $result; // Output the error message
}
