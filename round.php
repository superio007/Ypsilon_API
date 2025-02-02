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


  isset($_SESSION['formData']);
  if (isset($_POST['trip']) == "roundtrip") {
    function mergeFareIds($responseData)
    {
      // Check if the session contains the response data
      if (!$responseData) {
        die("No XML data found in the session.");
      }

      // Load the XML string
      $xml = simplexml_load_string($responseData);

      // Ensure the XML is loaded correctly
      if ($xml === false) {
        die("Error loading XML data from session.");
      }

      // Initialize an array to store fare IDs
      $fareIds = [];

      // Loop through the fares and collect fare IDs
      foreach ($xml->fares->fare as $fare) {
        $fareIds[] = (string) $fare['fareId'];
      }

      // Merge fare IDs without overlapping
      $mergedFareIds = [];
      for ($i = 0; $i < count($fareIds) - 1; $i += 2) {
        // Ensure the next index exists before merging
        if (isset($fareIds[$i + 1])) {
          $mergedFareIds[] = $fareIds[$i] . '_' . $fareIds[$i + 1];
        }
      }

      return $mergedFareIds;
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
    function getSeperatedFlights($tarif, &$fareIdsPrimary, &$fareIdsSecondary, $tarifIdsingle)
    {
      if ($tarif) {
        $fareId = $tarif['@attributes']['tarifId'] ?? 'N/A';
        $adtSell = $tarif['@attributes']['adtSell'] ?? 'N/A';
        $adtTax = $tarif['@attributes']['adtTax'] ?? 'N/A';

        // Loop through fareXRefs
        if (isset($tarif['fareXRefs']['fareXRef'])) {
          foreach ($tarif['fareXRefs']['fareXRef'] as $fareXRef) {
            $subFareId = $fareXRef['@attributes']['fareId'] ?? 'N/A';

            $flightsData = [];

            // Loop through flights
            if (isset($fareXRef['flights']['flight'])) {
              $flights = $fareXRef['flights']['flight'];

              // Handle both single and multiple flight cases
              if (isset($flights['@attributes'])) {
                $flights = [$flights]; // Wrap single flight in an array
              }

              foreach ($flights as $flight) {
                $flightId = $flight['@attributes']['flightId'] ?? 'N/A';
                // echo "<h4>Flight ID: $flightId</h4>";

                $flightDetails = [
                  'flightId' => $flightId,
                  'legs' => []
                ];

                // Handle both single and multiple legXRefs
                $legXRefs = $flight['legXRefs']['legXRef'] ?? [];
                if (isset($legXRefs['@attributes'])) {
                  $legXRefs = [$legXRefs]; // Wrap single legXRef in an array
                }

                foreach ($legXRefs as $legXRef) {
                  $legDetails = [
                    'legId' => $legXRef['@attributes']['legId'] ?? 'N/A',
                    'class' => $legXRef['@attributes']['class'] ?? 'N/A',
                    'cosDescription' => $legXRef['@attributes']['cosDescription'] ?? 'N/A',
                    'fareBaseAdt' => $legXRef['@attributes']['fareBaseAdt'] ?? 'N/A',
                    'seats' => $legXRef['@attributes']['seats'] ?? 'N/A',
                  ];
                  $flightDetails['legs'][] = $legDetails;
                }

                $flightsData[] = $flightDetails;
              }
            }

            // Corrected classification logic for primary and secondary arrays
            if ($subFareId === $tarifIdsingle) { // Explicitly classify IDs
              $fareIdsPrimary[$subFareId] = $flightsData;
            } else {
              $fareIdsSecondary[$subFareId] = $flightsData;
            }
          }
        }
      } else {
        echo "<h2>No data found for this fare ID.</h2>";
      }
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
    function getFirstFareId($fareId)
    {
      return explode("_", $fareId)[0];
    }
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '<?xml version=\'1.0\' encoding=\'UTF-8\'?><fareRequest xmlns:shared="http://ypsilon.net/shared" da="true"><vcrs/><alliances/><shared:fareTypes/><tourOps/><flights><flight depDate="2025-03-26" dstApt="DEL" depApt="MEL"/><flight depDate="2025-04-09" dstApt="MEL" depApt="DEL"/></flights><paxes><pax gender="M" surname="Klenz" firstname="Hans A ADT" dob="1970-12-12"/></paxes><paxTypes/><options><limit>20</limit><offset>0</offset><vcrSummary>false</vcrSummary><waitOnList><waitOn>ALL</waitOn></waitOnList></options><coses><cos>E</cos></coses><agentCodes><agentCode>gaura</agentCode></agentCodes><directFareConsos><directFareConso>gaura</directFareConso></directFareConsos></fareRequest>',
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
    $fares = mergeFareIds($responseData);
    curl_close($curl);
  }
  ?>
  <?php if (!isset($responseData)): ?>
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
  <?php elseif (isset($responseData)):
    var_dump($responseData); ?>

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
          <div id="flightResults" class="">
            <div class="text-center" id="loader">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
          </div>
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
      const flightResultsContainer = document.getElementById("flightResults");
      const loader = document.getElementById("loader");

      // Fetch flight data
      fetch("fetch-flights.php")
        .then((response) => response.text()) // Read the response as plain text
        .then((text) => {
          try {
            const data = JSON.parse(text); // Attempt to parse the response as JSON
            loader.style.display = "none";

            if (data.error) {
              flightResultsContainer.innerHTML = `<p>${data.error}</p>`;
              return;
            }

            // Generate flight results
            data.forEach((flight) => {
              console.log(flight);
              const flightDiv = document.createElement("div");
              flightDiv.className = "flight-div mb-2 border rounded";
              flightDiv.innerHTML = `
            <div class="py-1 px-2 d-flex justify-content-between align-items-center">
              <p style="font-size: small; margin: 0; padding: 7px">
                This flight emits <span class="fw-bold">19% less CO2e</span> than a typical flight on this route
                <span>${flight.id}</span>
              </p>
              <i class="fa-solid fa-circle-info fa-xs"></i>
            </div>
            <div style="display: flex; padding: 10px 0; background-color: #fff; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px;">
              <div class="col-md-2 col-sm-2 gap-3" style="display: grid;">
                <img src="newUi/images/Alsaka air.png" alt="Alaska Air" />
                <img src="newUi/images/indigo.png" alt="Indigo" />
              </div>
              <div class="col-md-7 col-sm-7 border-end">
                <p>Outbound</p>
                ${renderFlights(flight.primary)}
                <p>Return</p>
                ${renderFlights(flight.secondary)}
              </div>
              <div class="col-md-3 col-sm-3 d-grid justify-content-around align-content-center gap-2">
                <p class="m-0 fw-bold text-center">Price p.p</p>
                <p class="m-0 fw-bolder text-center">AUD <span style="font-weight: 700;" class="price">${flight.price}</span></p>
                <button class="btn book-button px-3" style="background-color: #05203c; color: #fff">Select <i class="fa-solid fa-arrow-right"></i></button>
              </div>
            </div>
          `;
              flightResultsContainer.appendChild(flightDiv);
            });
          } catch (error) {
            loader.style.display = "none";
            flightResultsContainer.innerHTML = `<p>Response is not valid JSON: ${error.message}</p>`;
            console.error("Response text (not JSON):", text); // Log the invalid response
          }
        })
        .catch((error) => {
          loader.style.display = "none";
          flightResultsContainer.innerHTML = `<p>Error loading flights: ${error.message}</p>`;
        });

      // Function to fetch flight leg details using Fetch API
      function fetchFlightLegDetails(legId) {
        return fetch('searchLeg.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              legId: legId
            }), // Send legId as JSON
          })
          .then((response) => response.json()) // Parse the response as JSON
          .catch((error) => {
            console.error('Error fetching leg details:', error);
            return null; // Return null if error occurs
          });
      }

      // Function to render flights
      function renderFlights(flightData) {
        return Object.entries(flightData)
          .map(([fareId, flights]) => `
      <div class="d-grid">
        ${flights.map((flight) => `
          <div class="d-flex align-items-center">
            <div class="col-md-4 col-sm-4 text-center pr-2">
              <p class="m-0">${flight.legs[0]?.depTime || "N/A"}</p>
              <p class="fw-bold m-0">${flight.legs[0]?.depApt || "N/A"}</p>
            </div>
            <div class="col-md-4 col-sm-4">
              <p class="m-0 text-center">${flight.legs[0]?.elapsed || "N/A"} hours</p>
              <p class="m-0 text-center" style="color: #48bddd">${flights.length > 1 ? "Direct" : "One-way"}</p>
            </div>
            <div class="col-md-4 col-sm-4 text-center pr-2">
              <p class="m-0">${flight.legs[1]?.arrTime || "N/A"}</p>
              <p class="fw-bold m-0">${flight.legs[1]?.dstApt || "N/A"}</p>
            </div>
          </div>
        `).join('')}
      </div>
    `)
          .join('');
      }

      // Function to process flight data and fetch leg details
      function processFlights(flightData) {
        const allPromises = [];

        // Loop through primary and secondary flight data
        Object.entries(flightData).forEach(([fareId, flights]) => {
          flights.forEach((flight) => {
            flight.legs.forEach((leg) => {
              allPromises.push(
                fetchFlightLegDetails(leg.legId) // Fetch details for each leg
              );
            });
          });
        });

        // After all the AJAX calls are done, render the flights
        Promise.all(allPromises)
          .then((responses) => {
            let i = 0;
            Object.entries(flightData).forEach(([fareId, flights]) => {
              flights.forEach((flight) => {
                flight.legs.forEach((leg) => {
                  // Fill the legs with the response data
                  leg.details = responses[i]; // Assuming the response contains the detailed leg data
                  i++;
                });
              });
            });

            // Now render the updated flight data
            document.getElementById('flightResults').innerHTML = renderFlights(flightData);
          })
          .catch((error) => {
            console.error("Error fetching flight data:", error);
            flightResultsContainer.innerHTML = `<p>Failed to process flight data</p>`;
          });
      }


      const priceElements = document.querySelectorAll('.price');

      // Initialize an array to store the prices
      const prices = [];

      // Loop through each element and extract the price
      priceElements.forEach((priceElement) => {
        const priceText = priceElement.textContent.trim(); // Get the text content
        const priceValue = parseFloat(priceText.replace(/[^\d.]/g, '')); // Remove "AUD" and convert to a number

        if (!isNaN(priceValue)) {
          prices.push(priceValue); // Add the price to the array if it's valid
        }
      });

      // Ensure there are prices to process
      if (prices.length > 0) {
        // Calculate the lowest price
        const lowestPrice = Math.min(...prices);

        // Calculate the highest price
        const highestPrice = Math.max(...prices);

        // Calculate the average price
        const averagePrice =
          prices.reduce((sum, price) => sum + price, 0) / prices.length;

        // Update the respective span elements
        document.getElementById('cheapestPrice').textContent = `₹ ${lowestPrice.toFixed(2)}`;
        document.getElementById('highestPrice').textContent = `₹ ${highestPrice.toFixed(2)}`;
        document.getElementById('averagePrice').textContent = `₹ ${averagePrice.toFixed(2)}`;

        // Output the results in the console for debugging
        console.log(`Lowest Price: ₹ ${lowestPrice.toFixed(2)}`);
        console.log(`Highest Price: ₹ ${highestPrice.toFixed(2)}`);
        console.log(`Average Price: ₹ ${averagePrice.toFixed(2)}`);
      } else {
        console.log('No prices found.');
      }
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
      const outboundSlider = document.getElementById("outboundSlider");
      const returnSlider = document.getElementById("returnSlider");
      const durationSlider = document.getElementById("durationSlider");
      const outboundTime = document.getElementById("outboundTime");
      const returnTime = document.getElementById("returnTime");
      const durationTime = document.getElementById("durationTime");
      const selectAll = document.getElementById("selectAll");
      const clearAll = document.getElementById("clearAll");
      const checkboxes = document.querySelectorAll(".form-check-input");

      function formatTime(value) {
        const hours = Math.floor(value / 60);
        const minutes = value % 60;
        return `${hours.toString().padStart(2, "0")}:${minutes
            .toString()
            .padStart(2, "0")}`;
      }

      outboundSlider.addEventListener("input", () => {
        outboundTime.textContent = `${formatTime(
            outboundSlider.value
          )} - 23:59`;
      });

      returnSlider.addEventListener("input", () => {
        returnTime.textContent = `${formatTime(returnSlider.value)} - 23:59`;
      });

      durationSlider.addEventListener("input", () => {
        durationTime.textContent = `${durationSlider.value} hours - 5.5 hours`;
      });

      selectAll.addEventListener("click", () => {
        checkboxes.forEach((checkbox) => (checkbox.checked = true));
      });

      clearAll.addEventListener("click", () => {
        checkboxes.forEach((checkbox) => (checkbox.checked = false));
      });
    });
  </script>
</body>

</html>