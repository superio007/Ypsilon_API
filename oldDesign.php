<?php
session_start();
// $responseData = $_SESSION['responseData'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Search Widget</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://kit.fontawesome.com/74e6741759.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    .offer-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 16px;
      margin: 16px 0;
      background-color: #fff;
      position: relative;
    }

    .offer-card .badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #000;
      color: #ffd207;
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 14px;
    }

    .offer-card .price {
      font-size: 24px;
      font-weight: bold;
    }

    .offer-card .details {
      font-size: 14px;
      margin-top: 8px;
    }

    .offer-card .flight-info {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 16px;
      font-size: 14px;
    }

    .offer-card .availability {
      color: green;
      margin-top: 8px;
    }

    .offer-card .price-breakdown {
      color: blue;
      cursor: pointer;
      margin-top: 8px;
    }

    .offer-card .book-btn {
      background-color: #ffd207;
      border: none;
      color: #000;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
    }

    .offer-card .book-btn:hover {
      background-color: #e5be07;
    }

    main {
      background-color: #eff3f8;
    }

    .priceList {
      p {
        color: #787d8f;
      }

      .price {
        color: #0565e4;
      }

      &:hover {
        background-color: #05203c;

        p {
          color: #fff;
        }
      }
    }

    .flight-div {
      background-color: #e0e4e9;
    }

    .search-div .card-header {
      background-color: #eff3f8;
    }

    .search-div .card {
      background-color: #eff3f8;
      border: none;
    }

    .search-div .card h5 {
      font-size: 16px;
    }

    .search-div .form-check-label small {
      margin-left: 5px;
    }

    .search-div button {
      font-size: 12px;
    }

    .active-btn {
      background-color: #05203c;
      /* Dark background */
      color: #fff;
      /* White text */
      border-radius: 5px;
      /* Rounded corners */
      font-weight: bold;
      /* Bold text */
    }
  </style>
</head>

<body>
  <?php
  $tripType = '';
  require 'api.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tripType = $_POST['trip'] ?? '';
    $fareType = $_POST['fare'] ?? '';
    $departFrom = $_POST['departFromCode'] ?? '';
    $flyingTo = $_POST['flyingToCode'] ?? '';
    $departureDate = $_POST['departureDate'] ?? '';
    $returnDate = $_POST['returnDate'] ?? '';
    $travelClass = $_POST['class'] ?? '';
    $adultsCount = $_POST['adults'] ?? 1;
    $childrenCount = $_POST['children'] ?? 0;
    $infantsCount = $_POST['infants'] ?? 0;
    $total = (int)$adultsCount + (int)$childrenCount + (int)$infantsCount;

    // Store the collected data in a session array
    $_SESSION['formData'] = [
      'tripType' => $tripType,
      'fareType' => $fareType,
      'departFrom' => $departFrom,
      'flyingTo' => $flyingTo,
      'departureDate' => $departureDate,
      'returnDate' => $returnDate,
      'travelClass' => $travelClass,
      'adultsCount' => $adultsCount,
      'childrenCount' => $childrenCount,
      'infantsCount' => $infantsCount,
      'total' => $total
    ];
  }
  // For loading all flights 
  // function getFlightsWithLegs($xmlData)
  // {
  //   // Load the XML data
  //   $xml = simplexml_load_string($xmlData);
  //   if ($xml === false) {
  //     throw new Exception("Unable to load XML data: " . implode(", ", libxml_get_errors()));
  //   }

  //   // Initialize the result array
  //   $flightsWithLegs = [];

  //   // Step 1: Loop through all `tarif` elements to get fareId
  //   foreach ($xml->xpath("//tarif") as $tarif) {
  //     $fareId = (string)$tarif['tarifId'];

  //     // Step 2: Loop through all flights under the current fareId
  //     foreach ($tarif->xpath("fareXRefs/fareXRef/flights/flight") as $flight) {
  //       $flightId = (string)$flight['flightId'];
  //       $legs = [];

  //       // Step 3: Loop through all `legXRef` elements to get legId
  //       foreach ($flight->xpath("legXRefs/legXRef") as $legXRef) {
  //         $legId = (string)$legXRef['legId'];

  //         // Step 4: Retrieve the <leg> element by legId
  //         $legData = $xml->xpath("//leg[@legId='$legId']");
  //         if (!empty($legData)) {
  //           // Convert the <leg> element to an associative array
  //           $legs[] = json_decode(json_encode($legData[0]), true)['@attributes'];
  //         }
  //       }

  //       // Step 5: Store flightId and its associated legs in the result array
  //       $flightsWithLegs[$flightId] = $legs;
  //     }
  //   }

  //   return $flightsWithLegs;
  // }
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
  // To get flight Id from legId
  function getFareIdFromLegId($legId, $response)
  {


    if (!$response) {
      return "No XML data found in session.";
    }

    // Parse the XML data
    $xmlData = simplexml_load_string($response);

    if (!$xmlData) {
      return "Failed to parse XML data.";
    }

    // Navigate the XML structure to match the legId
    foreach ($xmlData->xpath('//tarifs/tarif') as $tarif) {
      $fareId = (string)$tarif->fareXRefs->fareXRef['fareId']; // Get fare ID from attribute
      foreach ($tarif->xpath('./fareXRefs/fareXRef/flights/flight/legXRefs/legXRef') as $legXRef) {
        if ((string)$legXRef['legId'] === $legId) {
          return $fareId; // Return fareId if a match is found
        }
      }
    }

    // Return message if no matching fareId is found
    return "No Fare ID found for leg ID $legId.";
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
  // To get adtSell from tarifId
  function getAdtSellByTarifId($tarifId, $xmlData)
  {
    // Load the XML data
    $xml = simplexml_load_string($xmlData);

    if (!$xml) {
      return "Failed to load XML data.";
    }

    // Search for the tarif with the specified ID
    foreach ($xml->tarifs->tarif as $tarif) {
      if ((string)$tarif['tarifId'] === $tarifId) {
        // Return the adtSell value for the matched tarif
        return (string)$tarif['adtSell'];
      }
    }

    return "Tarif ID {$tarifId} not found.";
  }
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
  isset($_SESSION['formData']);
  if ($tripType === "oneway") {
    $curl = curl_init();
    $depDate = $departureDate;
    $depApt = $departFrom;
    $dstApt = $flyingTo;
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '<?xml version=\'1.0\' encoding=\'UTF-8\'?><fareRequest xmlns:shared="http://ypsilon.net/shared" da="true"><vcrs><vcr>QF</vcr></vcrs><alliances/><shared:fareTypes/><tourOps/><flights><flight depDate="' . $depDate . '" dstApt="' . $dstApt . '" depApt="' . $depApt . '"/></flights><paxes><pax gender="M" surname="Klenz" firstname="Hans A ADT" dob="1945-12-12"/></paxes><paxTypes/><options><limit>20</limit><offset>0</offset><vcrSummary>false</vcrSummary><waitOnList><waitOn>ALL</waitOn></waitOnList></options><coses/></fareRequest>',
      CURLOPT_HTTPHEADER => array(
        'accept: application/xml',
        'accept-encoding: gzip',
        'api-version: 3.92',
        'accessmode: agency',
        'accessid: gaura gaura',
        'authmode: pwd',
        'authorization: Basic c2hlbGx0ZWNoOjRlNDllOTAxMGZhYzA1NzEzN2VjOWQ0NWZjNTFmNDdh',
        'content-Length: 494',
        'Connection: close',
        'Content-Type: text/plain'
      ),
    ));
    $responseData = curl_exec($curl);
    $_SESSION['responseData'] = $responseData;
    if ($responseData === false) {
      echo 'cURL Error: ' . curl_error($curl);
      curl_close($curl);
      exit;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($responseData);
    if (
      $xml === false
    ) {
      echo "Failed to parse XML. Errors:\n";
      foreach (libxml_get_errors() as $error) {
        echo $error->message, "\n";
      }
      libxml_clear_errors();
      exit;
    }

    // Register namespaces for elements with prefixes
    $xml->registerXPathNamespace('shared', 'http://ypsilon.net/shared');

    $fareId = [];
    foreach ($xml->fares->fare as $fare) {
      $fareId[] = (string)$fare['fareId']; // Access fareId attribute
      $fares[] = [
        'fareId' => (string)$fare['fareId'],
        'shared:fareType' => (string)$fare->children('shared', true)->fareType,
        'depApt' => (string)$fare['depApt'],
        'dstApt' => (string)$fare['dstApt'],
        'shared:vcr' => (string)$fare->children('shared', true)->vcr,
      ];
    }

    curl_close($curl);
  }
  if ($tripType === "roundtrip") {
    $curl = curl_init();
    $depDate = $departureDate;
    $depApt = $departFrom;
    $dstApt = $flyingTo;
    $returndate = $returnDate;
    $postfields = "<?xml version='1.0' encoding='UTF-8'?><fareRequest xmlns:shared=\"http://ypsilon.net/shared\" da=\"true\"><vcrs><vcr>SQ</vcr></vcrs><alliances/><shared:fareTypes/><tourOps/><flights><flight depDate=\"$depDate\" dstApt=\"$depApt\" depApt=\"$dstApt\"/><flight depDate=\"$returndate\" dstApt=\"$dstApt\" depApt=\"$depApt\"/></flights><paxes><pax gender=\"M\" surname=\"Klenz\" firstname=\"Hans A ADT\" dob=\"1970-12-12\"/></paxes><paxTypes/><options><limit>1</limit><offset>0</offset><vcrSummary>false</vcrSummary><waitOnList><waitOn>ALL</waitOn></waitOnList></options><coses><cos>E</cos></coses><agentCodes><agentCode>gaura</agentCode></agentCodes><directFareConsos><directFareConso>gaura</directFareConso></directFareConsos></fareRequest>";
    // echo "<script>alert('$postfields');</script>";
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $postfields,
      CURLOPT_HTTPHEADER => array(
        'accept: application/xml',
        'accept-encoding: gzip',
        'api-version: 3.92',
        'accessmode: agency',
        'accessid: gaura gaura',
        'authmode: pwd',
        'authorization: Basic c2hlbGx0ZWNoOjRlNDllOTAxMGZhYzA1NzEzN2VjOWQ0NWZjNTFmNDdh',
        'Content-Type: application/xml'
      ),
    ));

    $responseData = curl_exec($curl);
    $_SESSION['responseData'] = $responseData;
    if ($responseData === false) {
      echo 'cURL Error: ' . curl_error($curl);
      curl_close($curl);
      exit;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($responseData);
    if (
      $xml === false
    ) {
      echo "Failed to parse XML. Errors:\n";
      foreach (libxml_get_errors() as $error) {
        echo $error->message, "\n";
      }
      libxml_clear_errors();
      exit;
    }

    // Register namespaces for elements with prefixes
    $xml->registerXPathNamespace('shared', 'http://ypsilon.net/shared');

    $fareId = [];
    foreach ($xml->fares->fare as $fare) {
      $fareId[] = (string)$fare['fareId']; // Access fareId attribute
      $fares[] = [
        'fareId' => (string)$fare['fareId'],
        'shared:fareType' => (string)$fare->children('shared', true)->fareType,
        'depApt' => (string)$fare['depApt'],
        'dstApt' => (string)$fare['dstApt'],
        'shared:vcr' => (string)$fare->children('shared', true)->vcr,
      ];
    }
  }
  ?>
  <div class="container my-5">
    <div class="bg-warning p-4 rounded">
      <div class="d-flex align-items-center mb-3">
        <h2 class="mb-0 mr-3"><i class="fas fa-plane"></i> Flights</h2>
      </div>
      <form action="" method="post" name="search" id="flightSearchForm">
        <div class="form-row mb-3">
          <div class="col">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="trip" id="oneWay" value="oneway">
              <label class="form-check-label" for="oneWay">One Way</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="trip" id="roundTrip" value="roundtrip">
              <label class="form-check-label" for="roundTrip">Round Trip</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="trip" id="multiCity" value="multicity">
              <label class="form-check-label" for="multiCity">Multi city/Stopovers</label>
            </div>
          </div>
        </div>
        <div class="form-row mb-3">
          <div class="col">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="fare" id="studentFares" value="student">
              <label class="form-check-label" for="studentFares">Student fares</label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="departFrom">Depart from</label>
            <input type="text" class="form-control" id="departFrom" name="departFrom" placeholder="Depart from">
            <input type="hidden" id="departFromCode" name="departFromCode">
          </div>
          <div class="form-group col-md-3">
            <label for="flyingTo">Flying to</label>
            <input type="text" class="form-control" id="flyingTo" name="flyingTo" placeholder="Flying to">
            <input type="hidden" id="flyingToCode" name="flyingToCode">
          </div>
          <div class="form-group col-md-2">
            <label for="departureDate">Departure date</label>
            <input type="date" class="form-control" id="departureDate" name="departureDate">
          </div>
          <div class="form-group col-md-2">
            <label for="returnDate">Return date</label>
            <input type="date" class="form-control" id="returnDate" name="returnDate">
          </div>
          <div class="form-group col-md-2">
            <label for="class">Class</label>
            <select id="class" name="class" class="form-control">
              <option selected>Economy</option>
              <option>Business</option>
              <option>First</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="passengers">Passengers</label>
          <div class="custom-dropdown">
            <div style="border: 1px black solid; width: 50px; padding-left: 10px; cursor: pointer;" id="passengerDropdown">
              1
            </div>
            <div class="custom-dropdown-menu" style="display: none; position: absolute; background: white; border: 1px solid #ccc; padding: 10px;">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <span>Adults</span>
                  <div class="description">ages 18 and over</div>
                </div>
                <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="adults-minus">-</button>
                  <span class="mx-2" id="adults-count">1</span>
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="adults-plus">+</button>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <span>Children</span>
                  <div class="description">ages 2 - 12</div>
                </div>
                <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="children-minus">-</button>
                  <span class="mx-2" id="children-count">0</span>
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="children-plus">+</button>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <span>Infants</span>
                  <div class="description">younger than 2</div>
                </div>
                <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="infants-minus">-</button>
                  <span class="mx-2" id="infants-count">0</span>
                  <button type="button" class="btn btn-outline-secondary btn-sm" id="infants-plus">+</button>
                </div>
              </div>
              <button style="width: 80px;" class="btn btn-primary btn-block mt-2" id="passenger-ready" type="button">Ready</button>
            </div>
          </div>
          <input type="hidden" id="adultsInput" name="adults" value="1">
          <input type="hidden" id="childrenInput" name="children" value="0">
          <input type="hidden" id="infantsInput" name="infants" value="0">
        </div>
        <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i> Search</button>
      </form>
    </div>
  </div>
  <?php if (isset($responseData)): ?>
    <div class="container-md">
      <div class="row">
        <!-- Filter -->
        <div class="col-md-3">
          <div class="search-div my-4">
            <!-- Departure Times -->
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="mb-0">Departure times</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label for="outboundSlider">Outbound</label>
                  <input
                    type="range"
                    class="form-control-range"
                    id="outboundSlider"
                    min="0"
                    max="1440"
                    value="240" />
                  <span id="outboundTime">04:00 - 23:59</span>
                </div>
              </div>
            </div>

            <!-- Journey Duration -->
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="mb-0">Journey duration</h5>
              </div>
              <div class="card-body">
                <input
                  type="range"
                  class="form-control-range"
                  id="durationSlider"
                  min="0"
                  max="24"
                  step="0.5"
                  value="2.5" />
                <span id="durationTime">2.5 hours - 5.5 hours</span>
              </div>
            </div>


          </div>
        </div>
        <div class="col-md-6 my-2">
          <!-- price list -->
          <div class="row border rounded mb-2" style="background: #fff">
            <div id="cheapest" class="priceList col-md-4 col-sm-4 border-end p-2">
              <p class="m-0">Best</p>
              <p class="m-0 fw-bold ">
                <span id="cheapestPrice"></span> <i class="fa-solid fa-circle-info"></i>
              </p>
            </div>
            <div id="average" class="priceList col-md-4 col-sm-4 border-end p-2">
              <p class="m-0">Cheapest</p>
              <p class="m-0 fw-bold "><span id="averagePrice"></span></p>
            </div>
            <div id="highest" class="priceList col-md-4 col-sm-4 p-2">
              <p class="m-0">Fastest</p>
              <p class="m-0 fw-bold "><span id="highestPrice"></span></p>
            </div>
          </div>
          <div>
            <div>
              <div id="flightResults">
                <!-- JavaScript will dynamically insert flight details here -->
              </div>
            </div>
          </div>
          <?php
          // Prepare flight data
          $flightsData = [];
          $index = 1;
          foreach ($fares as $id) {
            $fareXRef = getTarifByFareId($responseData, $id['fareId']);
            $flights = isset($fareXRef['fareXRefs']['fareXRef']['flights']['flight'][0])
              ? $fareXRef['fareXRefs']['fareXRef']['flights']['flight']
              : [$fareXRef['fareXRefs']['fareXRef']['flights']['flight']];

            $legsInfo = [];
            foreach ($flights as $flight) {
              $flightId = $flight["@attributes"]["flightId"];
              $legIds = getLegIdsByFlightId($fareXRef, $flightId);
              $legs = [];
              foreach ($legIds as $legId) {
                $legs[] = searchLegById($responseData, $legId);
              }
              $legsInfo[] = $legs;
            }

            $flightsData[] = [
              'fareId' => $id['fareId'],
              'adtSell' => $fareXRef["@attributes"]["adtSell"],
              'legs' => $legsInfo,
            ];
          }
          ?>

          <script>
            // Pass the PHP array to JavaScript as JSON
            const flightsData = <?php echo json_encode($flightsData); ?>;
          </script>

        </div>
        <div class="col-md-2 d-md-block d-none">
          <img style="width: -webkit-fill-available;" src="newUi/images/BNPLRoadblock_150x1450.jpg" alt="" />
        </div>
      </div>
    </div>
  <?php endif; ?>
  <script>
    $(document).ready(function() {
      // Select all buttons with a data-btn attribute
      const buttons = $("[data-btn]");

      // Variable to track the currently visible view
      let activeView = null;

      // Attach click event listener to each button
      buttons.on("click", function() {
        // Get the value of the data-btn attribute
        const target = $(this).attr("data-btn");

        // Find the corresponding data-view element
        const view = $(`[data-view="${target}"]`);

        // If the view element exists
        if (view.length) {
          // Hide the previously active view if it exists and is not the same as the current view
          if (activeView && activeView[0] !== view[0]) {
            activeView.addClass("d-none");
          }

          // Toggle the visibility of the current view
          view.toggleClass("d-none");

          // Update the active view (or set to null if the current view is hidden)
          activeView = view.hasClass("d-none") ? null : view;
        }
      });
      // Cities array
      var cities = [{
          label: "Mumbai",
          value: "BOM"
        },
        {
          label: "Melbourne",
          value: "MEL"
        },
        {
          label: "Adelaide",
          value: "ADL"
        },
        {
          label: "Delhi",
          value: "DEL"
        },
        {
          label: "Dubai",
          value: "DXB"
        },
        {
          label: "New York",
          value: "JFK"
        },
        {
          label: "London",
          value: "LHR"
        },
        {
          label: "Paris",
          value: "CDG"
        },
        {
          label: "Tokyo",
          value: "HND"
        },
        {
          label: "Singapore",
          value: "SIN"
        },
        {
          label: "Sydney",
          value: "SYD"
        },
        {
          label: "Hong Kong",
          value: "HKG"
        },
        {
          label: "Los Angeles",
          value: "LAX"
        },
        {
          label: "Chicago",
          value: "ORD"
        },
        {
          label: "Toronto",
          value: "YYZ"
        },
        {
          label: "San Francisco",
          value: "SFO"
        },
        {
          label: "Boston",
          value: "BOS"
        },
        {
          label: "Miami",
          value: "MIA"
        },
        {
          label: "Bangkok",
          value: "BKK"
        },
        {
          label: "Beijing",
          value: "PEK"
        },
        {
          label: "Shanghai",
          value: "PVG"
        },
        {
          label: "Seoul",
          value: "ICN"
        },
        {
          label: "Istanbul",
          value: "IST"
        },
        {
          label: "Frankfurt",
          value: "FRA"
        },
        {
          label: "Amsterdam",
          value: "AMS"
        },
        {
          label: "Zurich",
          value: "ZRH"
        },
        {
          label: "Rome",
          value: "FCO"
        }
      ];

      // Autocomplete for "Depart from"
      $("#departFrom").autocomplete({
        source: cities,
        select: function(event, ui) {
          $("#departFrom").val(ui.item.label);
          $("#departFromCode").val(ui.item.value);
          return false;
        }
      });

      // Autocomplete for "Flying to"
      $("#flyingTo").autocomplete({
        source: cities,
        select: function(event, ui) {
          $("#flyingTo").val(ui.item.label);
          $("#flyingToCode").val(ui.item.value);
          return false;
        }
      });

      $('#passengerDropdown').click(function() {
        $('.custom-dropdown-menu').toggle();
      });

      $('#adults-plus').click(function() {
        let count = parseInt($('#adults-count').text());
        $('#adults-count').text(count + 1);
        $('#adultsInput').val(count + 1);
        updatePassengerDropdown();
      });

      $('#adults-minus').click(function() {
        let count = parseInt($('#adults-count').text());
        if (count > 1) {
          $('#adults-count').text(count - 1);
          $('#adultsInput').val(count - 1);
          updatePassengerDropdown();
        }
      });

      $('#children-plus').click(function() {
        let count = parseInt($('#children-count').text());
        $('#children-count').text(count + 1);
        $('#childrenInput').val(count + 1);
        updatePassengerDropdown();
      });

      $('#children-minus').click(function() {
        let count = parseInt($('#children-count').text());
        if (count > 0) {
          $('#children-count').text(count - 1);
          $('#childrenInput').val(count - 1);
          updatePassengerDropdown();
        }
      });

      $('#infants-plus').click(function() {
        let count = parseInt($('#infants-count').text());
        $('#infants-count').text(count + 1);
        $('#infantsInput').val(count + 1);
        updatePassengerDropdown();
      });

      $('#infants-minus').click(function() {
        let count = parseInt($('#infants-count').text());
        if (count > 0) {
          $('#infants-count').text(count - 1);
          $('#infantsInput').val(count - 1);
          updatePassengerDropdown();
        }
      });

      $('#passenger-ready').click(function() {
        $('.custom-dropdown-menu').hide();
      });

      function updatePassengerDropdown() {
        let adults = parseInt($('#adults-count').text());
        let children = parseInt($('#children-count').text());
        let infants = parseInt($('#infants-count').text());
        let totalPassengers = adults + children + infants;
        $('#passengerDropdown').text(totalPassengers);
      }

      $(document).click(function(event) {
        if (!$(event.target).closest('#passengerDropdown, .custom-dropdown-menu').length) {
          $('.custom-dropdown-menu').hide();
        }
      });

      // Handle the enabling/disabling of the return date field
      $('input[name="trip"]').change(function() {
        if ($('#oneWay').is(':checked')) {
          $('#returnDate').prop('disabled', true);
        } else if ($('#roundTrip').is(':checked')) {
          $('#returnDate').prop('disabled', false);
        } else if ($('#multiCity').is(':checked')) {
          $('#returnDate').prop('disabled', true);
        }
      });

      // Initialize the return date field based on the default selected trip type
      if ($('#oneWay').is(':checked') || $('#multiCity').is(':checked')) {
        $('#returnDate').prop('disabled', true);
      } else if ($('#roundTrip').is(':checked')) {
        $('#returnDate').prop('disabled', false);
      }
    });
    $(document).ready(function() {
      $(document).on('click', '.price-breakdown', function() {
        var index = $(this).data('index');
        var content = $('#price-breakdown-' + index);
        if (content.css('display') === 'none' || content.css('display') === '') {
          content.css('display', 'block');
          $(this).text('- HIDE PRICE BREAKDOWN');
        } else {
          content.css('display', 'none');
          $(this).text('+ DISPLAY PRICE BREAKDOWN');
        }
      });
    });
    document.addEventListener('DOMContentLoaded', function() {
      const container = document.getElementById("flightResults");
      const outboundSlider = document.getElementById("outboundSlider");
      const durationSlider = document.getElementById("durationSlider");
      const outboundTime = document.getElementById("outboundTime");
      const durationTime = document.getElementById("durationTime");

      // Function to convert minutes to HH:MM format
      function formatTime(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours.toString().padStart(2, "0")}:${mins.toString().padStart(2, "0")}`;
      }

      // Function to filter flights based on sliders
      function filterFlights() {
        const outboundValue = parseInt(outboundSlider.value, 10);
        const durationValue = parseFloat(durationSlider.value);

        // Update slider labels
        outboundTime.textContent = `${formatTime(outboundValue)} - 23:59`;
        durationTime.textContent = `${durationValue} hours - 24 hours`;

        // Filter flights
        const filteredFlights = flightsData.filter((flight) => {
          const legs = flight.legs[0]; // Assuming first leg for outbound and duration
          const depTime = legs[0]?.depTime || "00:00";
          const elapsed = parseFloat(legs[0]?.elapsed) || 0;

          // Convert depTime (HH:MM) to minutes
          const [depHour, depMinute] = depTime.split(":").map(Number);
          const depTimeInMinutes = depHour * 60 + depMinute;

          return depTimeInMinutes >= outboundValue && elapsed <= durationValue;
        });

        // Render filtered flights
        renderFlights(filteredFlights);
      }

      // Function to render flights
      function renderFlights(data) {
        // Clear existing content
        container.innerHTML = "";

        // Loop through the flights data and render
        data.forEach((flight, index) => {
          const flightDiv = document.createElement("div");
          flightDiv.className = "flight-div mb-2 border rounded";

          const flightContent = `
        <div class="py-1 px-2 d-flex justify-content-between align-items-center">
          <p style="font-size: small; margin: 0; padding: 7px">
            This flight emits <span class="fw-bold">19% less CO2e</span> than a typical flight
            on this route <span>${index + 1} FareId: ${flight.fareId}</span>
          </p>
          <i class="fa-solid fa-circle-info fa-xs"></i>
        </div>
        <div style="display: flex; padding: 10px 0; background-color: #fff;">
          <div class="col-md-2 col-sm-2 gap-3" style="display: grid;">
            <img src="newUi/images/Alsaka air.png" alt="" />
            <img src="newUi/images/indigo.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-7 border-end">
            ${flight.legs
              .map(
                (legs) => `
                <div class="d-grid">
                  <div class="d-flex align-items-center">
                    <div class="col-md-4 col-sm-4 text-center pr-2">
                      <p class="m-0">${legs[0][0]?.depTime || "N/A"}</p>
                      <p class="fw-bold m-0">${legs[0][0]?.depApt || "N/A"}</p>
                    </div>
                    <div class="col-md-4 col-sm-4">
                      <p class="m-0 text-center">${legs[0][0]?.elapsed || "N/A"}</p>
                      <p class="m-0 text-center" style="color: #48bddd">Direct</p>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center pr-2">
                      <p class="m-0">${legs[legs.length - 1][0]?.arrTime || "N/A"}</p>
                      <p class="fw-bold m-0">${legs[legs.length - 1][0]?.dstApt || "N/A"}</p>
                    </div>
                  </div>
                </div>
              `
              )
              .join("")}
          </div>
          <div class="col-md-3 col-sm-3 d-grid justify-content-around align-content-center gap-2">
            <p class="m-0 fw-bold text-center">Price p.p</p>
            <p class="m-0 fw-bolder text-center">AUD <span style="font-weight: 700;" class="price">${flight.adtSell}</span></p>
            <button class="btn book-button px-3" style="background-color: #05203c; color: #fff">
              Select <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      `;
          flightDiv.innerHTML = flightContent;
          container.appendChild(flightDiv);
        });
      }

      // Initial render
      renderFlights(flightsData);

      // Add event listeners for sliders
      outboundSlider.addEventListener("input", filterFlights);
      durationSlider.addEventListener("input", filterFlights);



      // Function to handle active button styling
      function setActiveButton(buttonId) {
        // Remove active class from all buttons
        document.querySelectorAll(".priceList").forEach((btn) => btn.classList.remove("active-btn"));

        // Add active class to the clicked button
        document.getElementById(buttonId).classList.add("active-btn");
      }

      // Add click event listeners for sorting and styling
      document.getElementById("cheapest").addEventListener("click", () => {
        setActiveButton("cheapest");
        const sortedData = [...flightsData].sort((a, b) => a.adtSell - b.adtSell);
        renderFlights(sortedData);
      });

      document.getElementById("average").addEventListener("click", () => {
        setActiveButton("average");
        const average = flightsData.reduce((acc, flight) => acc + parseFloat(flight.adtSell), 0) / flightsData.length;
        const filteredData = flightsData.filter((flight) => flight.adtSell >= average);
        renderFlights(filteredData);
      });

      document.getElementById("highest").addEventListener("click", () => {
        setActiveButton("highest");
        const sortedData = [...flightsData].sort((a, b) => b.adtSell - a.adtSell);
        renderFlights(sortedData);
      });
      // Fetch all elements with the class "price"
      const prices = document.querySelectorAll(".price");

      // Extract numeric values from the text content of the elements
      const priceValues = Array.from(prices).map(priceElement => {
        const priceText = priceElement.textContent.trim();
        // Remove non-numeric characters and convert to a number
        return parseFloat(priceText.replace(/[^0-9.]/g, "")) || 0;
      });

      if (priceValues.length > 0) {
        // Calculate the lowest, highest, and average prices
        const lowestPrice = Math.min(...priceValues);
        const highestPrice = Math.max(...priceValues);
        const averagePrice = (priceValues.reduce((a, b) => a + b, 0) / priceValues.length).toFixed(2);

        // Insert values into the respective elements
        document.getElementById("cheapestPrice").textContent = `AUD ${lowestPrice}`;
        document.getElementById("averagePrice").textContent = `AUD ${averagePrice}`;
        document.getElementById("highestPrice").textContent = `AUD ${highestPrice}`;
      } else {
        console.error("No prices found.");
      }
    });
  </script>
</body>

</html>