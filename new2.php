<?php
session_start();
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
  </style>
</head>

<body>
  <?php
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
  function getFlightsWithLegs($xmlData)
  {
    // Load the XML data
    $xml = simplexml_load_string($xmlData);
    if ($xml === false) {
      throw new Exception("Unable to load XML data: " . implode(", ", libxml_get_errors()));
    }

    // Initialize the result array
    $flightsWithLegs = [];

    // Step 1: Loop through all `tarif` elements to get fareId
    foreach ($xml->xpath("//tarif") as $tarif) {
      $fareId = (string)$tarif['tarifId'];

      // Step 2: Loop through all flights under the current fareId
      foreach ($tarif->xpath("fareXRefs/fareXRef/flights/flight") as $flight) {
        $flightId = (string)$flight['flightId'];
        $legs = [];

        // Step 3: Loop through all `legXRef` elements to get legId
        foreach ($flight->xpath("legXRefs/legXRef") as $legXRef) {
          $legId = (string)$legXRef['legId'];

          // Step 4: Retrieve the <leg> element by legId
          $legData = $xml->xpath("//leg[@legId='$legId']");
          if (!empty($legData)) {
            // Convert the <leg> element to an associative array
            $legs[] = json_decode(json_encode($legData[0]), true)['@attributes'];
          }
        }

        // Step 5: Store flightId and its associated legs in the result array
        $flightsWithLegs[$flightId] = $legs;
      }
    }

    return $flightsWithLegs;
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
  isset($_SESSION['formData']);
  if (isset($_POST['trip']) == "oneway") {
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
    // var_dump($_SESSION['responseData']);
    if ($responseData === false) {
      echo 'cURL Error: ' . curl_error($curl);
      curl_close($curl);
      exit;
    }

    libxml_use_internal_errors(true);
    $fares = getFlightsWithLegs($responseData);
    

    curl_close($curl);
  } elseif (isset($_POST['trip']) == "roundtrip") {
    $curl = curl_init();
    $depDate = $departureDate;
    $depApt = $departFrom;
    $dstApt = $flyingTo;
    $returnDate = $returnDate;

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => "<?xml version='1.0' encoding='UTF-8'?><fareRequest xmlns:shared=\"http://ypsilon.net/shared\" da=\"true\"><vcrs><vcr>SQ</vcr></vcrs><alliances/><shared:fareTypes/><tourOps/><flights><flight depDate=\"$depDate\" dstApt=\"$depApt\" depApt=\"$dstApt\"/><flight depDate=\"$returnDate\" dstApt=\"$dstApt\" depApt=\"$depApt\"/></flights><paxes><pax gender=\"M\" surname=\"Klenz\" firstname=\"Hans A ADT\" dob=\"1970-12-12\"/></paxes><paxTypes/><options><limit>1</limit><offset>0</offset><vcrSummary>false</vcrSummary><waitOnList><waitOn>ALL</waitOn></waitOnList></options><coses><cos>E</cos></coses><agentCodes><agentCode>gaura</agentCode></agentCodes><directFareConsos><directFareConso>gaura</directFareConso></directFareConsos></fareRequest>",
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

    // Error handling
    if (curl_errno($curl)) {
      echo 'cURL Error: ' . curl_error($curl);
    } else {
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      echo "HTTP Code: $httpCode\n";
      var_dump($responseData);
    }

    curl_close($curl);
    $_SESSION['responseData'] = $responseData;
    // var_dump($_SESSION['responseData']);
    if ($responseData === false) {
      echo 'cURL Error: ' . curl_error($curl);
      curl_close($curl);
      exit;
    }

    libxml_use_internal_errors(true);
    $fares = getFlightsWithLegs($responseData);
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
                <div>
                  <label for="returnSlider">Return</label>
                  <input
                    type="range"
                    class="form-control-range"
                    id="returnSlider"
                    min="0"
                    max="1440"
                    value="0" />
                  <span id="returnTime">00:00 - 23:59</span>
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
                  max="10"
                  step="0.5"
                  value="2.5" />
                <span id="durationTime">2.5 hours - 5.5 hours</span>
              </div>
            </div>

            <!-- Airlines -->
            <div class="card">
              <div
                class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Airlines</h5>
                <div>
                  <button class="btn btn-sm btn-primary" id="selectAll">
                    Select all
                  </button>
                  <button class="btn btn-sm btn-secondary" id="clearAll">
                    Clear all
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="airIndia"
                    checked />
                  <label class="form-check-label" for="airIndia">Air India
                    <small class="text-muted">from ₹10,429</small></label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="airIndiaExpress"
                    checked />
                  <label class="form-check-label" for="airIndiaExpress">Air India Express
                    <small class="text-muted">from ₹10,136</small></label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="akasaAir"
                    checked />
                  <label class="form-check-label" for="akasaAir">Akasa Air
                    <small class="text-muted">from ₹9,107</small></label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="indigo"
                    checked />
                  <label class="form-check-label" for="indigo">IndiGo
                    <small class="text-muted">from ₹9,168</small></label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="spicejet"
                    checked />
                  <label class="form-check-label" for="spicejet">SpiceJet
                    <small class="text-muted">from ₹10,559</small></label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="airlineCombinations"
                    checked />
                  <label class="form-check-label" for="airlineCombinations">Airline combinations
                    <small class="text-muted">from ₹8,865</small></label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <!-- price list -->
          <div class="row border rounded mb-2" style="background: #fff">
            <div class="priceList col-md-4 col-sm-4 border-end p-2">
              <p class="m-0">Best</p>
              <p class="m-0 fw-bold price">
                ₹9,033 <i class="fa-solid fa-circle-info"></i>
              </p>
              <p class="m-0">2h 15(average)</p>
            </div>
            <div class="priceList col-md-4 col-sm-4 border-end p-2">
              <p class="m-0">Cheapest</p>
              <p class="m-0 fw-bold price">₹8,865</p>
              <p class="m-0">2h 10(average)</p>
            </div>
            <div class="priceList col-md-4 col-sm-4 p-2">
              <p class="m-0">Fastest</p>
              <p class="m-0 fw-bold price">₹15,046</p>
              <p class="m-0">2h 03(average)</p>
            </div>
          </div>
          <?php $index = 1;
          foreach ($fares as $id): ?>
            <!-- flight div -->
            <div class="flight-div mb-2 border rounded">
              <div
                class="py-1 px-2 d-flex justify-content-between align-items-center">
                <p style="font-size: small; margin: 0; padding: 7px">
                  This flight emits
                  <span class="fw-bold">19% less CO2e</span> than a typical
                  flight on this route <span><?php echo $index; ?></span>
                </p>
                <i class="fa-solid fa-circle-info fa-xs"></i>
              </div>
              <div
                style="
                  display: flex;
                  padding: 10px 0;
                  background-color: #fff;
                  border-bottom-right-radius: 7px;
                  border-bottom-left-radius: 7px;
                ">
                <div
                  class="col-md-2 col-sm-2 gap-3" style="display: grid;">
                  <img src="newUi/images/Alsaka air.png" alt="" />
                  <img src="newUi/images/indigo.png" alt="" />
                </div>
                <div class="col-md-7 col-sm-7 border-end">
                  <div class="d-grid">
                    <?php
                    foreach ($id as $key => $legs):
                    ?>
                      <div class="d-flex align-items-center">
                        <div class="col-md-4 col-sm-4 text-center pr-2">
                          <p class="m-0"><?php echo $legs['depTime']; ?></p>
                          <p class="fw-bold m-0"><?php echo $legs['depApt']; ?></p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                          <p class="m-0 text-center"><?php echo $legs['elapsed']; ?></p>
                          <div class="d-flex">
                            <p class="m-0">
                              --------<svg
                                style="width: 12px"
                                xmlns="http://www.w3.org/2000/svg"
                                xml:space="preserve"
                                viewBox="0 0 12 12"
                                class="LegInfo_planeEnd__ZGU5M">
                                <path
                                  fill="#898294"
                                  d="M3.922 12h.499a.52.52 0 0 0 .444-.247L7.949 6.8l3.233-.019A.8.8 0 0 0 12 6a.8.8 0 0 0-.818-.781L7.949 5.2 4.866.246A.525.525 0 0 0 4.421 0h-.499a.523.523 0 0 0-.489.71L5.149 5.2H2.296l-.664-1.33a.523.523 0 0 0-.436-.288L0 3.509 1.097 6 0 8.491l1.196-.073a.523.523 0 0 0 .436-.288l.664-1.33h2.853l-1.716 4.49a.523.523 0 0 0 .489.71"></path>
                              </svg>
                            </p>
                          </div>
                          <p class="m-0 text-center" style="color: #48bddd">
                            Direct
                          </p>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center pr-2">
                          <p class="m-0"><?php echo $legs['arrTime']; ?></p>
                          <p class="fw-bold m-0"><?php echo $legs['dstApt']; ?></p>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div
                  class="col-md-3 col-sm-3 d-grid justify-content-around align-content-center gap-2">
                  <p class="m-0 fw-bold text-center">Price p.p</p>
                  <p class="m-0 fw-bolder text-center">AUD <span style="font-weight: 700;"><?php $farid = $id[0]['legId']; $tarifId =getFareIdFromLegId($farid,$responseData); echo getAdtSellByTarifId($tarifId,$responseData); ?></span></p>
                  <button
                    class="btn book-button px-3"
                    style="background-color: #05203c; color: #fff">
                    Select <i class="fa-solid fa-arrow-right"></i>
                  </button>
                </div>
              </div>
            </div>
            <?php $index++; ?>
          <?php endforeach; ?>
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
      var studentFaresRadio = document.getElementById('studentFares');
      var previouslySelected = null;

      studentFaresRadio.addEventListener('click', function(event) {
        if (previouslySelected === this) {
          this.checked = false;
          previouslySelected = null;
        } else {
          previouslySelected = this;
        }
      });
    });
  </script>
</body>

</html>