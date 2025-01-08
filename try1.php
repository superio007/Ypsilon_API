<?php

function getFlightIdByLegId($data, $legId)
{
  // Traverse the main array
  foreach ($data as $tarif) {
    if (isset($tarif['farexrefs'])) {
      // Traverse the farexrefs
      foreach ($tarif['farexrefs'] as $farexref) {
        if (isset($farexref['flights'])) {
          // Traverse the flights
          foreach ($farexref['flights'] as $flight) {
            if (isset($flight['legxrefs'])) {
              // Traverse the legxrefs
              foreach ($flight['legxrefs'] as $legxref) {
                // Check if the legxref matches the provided legid
                if (isset($legxref['@attributes']['legid']) && $legxref['@attributes']['legid'] == $legId) {
                  // Return the flight ID if legid matches
                  return $flight['attributes']['@attributes']['flightid'] ?? null;
                }
              }
            }
          }
        }
      }
    }
  }

  // Return null if no match is found
  return null;
}

// Sample data extracted from your array
$data = [
  [
    'attributes' => [
      '@attributes' => [
        'tarifid' => '598152908'
      ]
    ],
    'farexrefs' => [
      [
        'attributes' => [
          '@attributes' => [
            'fareid' => '598152908'
          ]
        ],
        'flights' => [
          [
            'attributes' => [
              '@attributes' => [
                'flightid' => '1672176513'
              ]
            ],
            'legxrefs' => [
              [
                '@attributes' => [
                  'legid' => '362602527',
                  'class' => 'O',
                  'cos' => 'E'
                ]
              ]
            ]
          ]
        ]
      ]
    ]
  ]
];

// Specify the legid to search for
$legIdToSearch = '362602527';

// Get the flight ID
$flightId = getFlightIdByLegId($data, $legIdToSearch);

if ($flightId) {
  echo "Flight ID for Leg ID {$legIdToSearch}: {$flightId}";
} else {
  echo "No matching Flight ID found for Leg ID {$legIdToSearch}.";
}
