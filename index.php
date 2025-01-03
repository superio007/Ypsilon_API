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
    </style>
</head>

<body>
    <?php
    require 'api.php';
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
    } else {
        $token = getToken();
    }
    $token = getToken();
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
    // Revadation 
    // Revalidation
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['traceId']) && isset($_GET['purchaseId'])) {
            $url = 'https://sandboxapi.getfares.com/Flights/Revalidation/v1';
            $traceId = $_GET['traceId'];
            $purchaseId = $_GET['purchaseId'];

            // Data to be sent in the body of the request
            $data = [
                "traceId" => $traceId,
                "purchaseIds" => [$purchaseId]
            ];

            // Convert data array to JSON format
            $jsonData = json_encode($data);

            // Initialize cURL session
            $ch = curl_init();

            // Set the URL and other options for the cURL session
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                "Authorization: Bearer $token"
            ]);

            // Execute the cURL session and fetch the response
            $response = curl_exec($ch);

            // Check for errors
            if ($response === false) {
                echo 'cURL Error: ' . curl_error($ch);
            } else {
                // Decode and print the response
                $responseData = json_decode($response, true);

                // Check if the responseData has the 'flights' key and 'isFareChange' key within it
                if (isset($responseData['flights'][0]['isFareChange']) && !$responseData['flights'][0]['isFareChange']) {
                    // Redirect to book.php with the required parameters
                    $_SESSION['responseData'] = [
                        'response' => $responseData,
                    ];
                    header("Location: book.php?traceId=$traceId&purchaseId=$purchaseId");
                    exit(); // Make sure to call exit after redirect
                } else {
                    // Fare has changed, show an alert and redirect to index.php
                    echo '<script type="text/javascript">';
                    echo 'alert("The fare has changed. Please check the updated fare.");';
                    echo 'window.location.href = "index.php";';
                    echo '</script>';
                    exit();
                }
            }

            // Close the cURL session
            curl_close($ch);
        } else {
        }
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
        // var_dump($fareId);
        // var_dump($fares);

        curl_close($curl);
    } elseif (isset($_POST['trip']) == "roundtrip") {
        // API endpoint
        $url = 'https://sandboxapi.getfares.com/Flights/Search/v1'; // Replace with your actual URL

        // Data to be sent in the body of the request
        $data = [
            "originDestinations" => [
                [
                    "departureDateTime" => $departureDate . "T09:10:27.482Z",
                    "origin" => (string)$departFrom,
                    "destination" => (string)$flyingTo
                ],
                [
                    "departureDateTime" => $returnDate . "10:27.482Z",
                    "origin" => (string)$flyingTo,
                    "destination" => (string)$departFrom
                ]
            ],
            "adultCount" => $adultsCount,
            "childCount" => $childrenCount,
            "infantCount" => $infantsCount,
            "cabinClass" => $travelClass,
            "cabinPreferenceType" => "Preferred",
            "stopOver" => "None",
            "airTravelType" => $tripType,
            "includeBaggage" => true,
            "includeMiniRules" => true
        ];

        // Convert data array to JSON format
        $jsonData = json_encode($data);

        // Initialize cURL session
        $ch = curl_init();

        // Set the URL and other options for the cURL session
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: Bearer $token"
        ]);

        // Execute the cURL session and fetch the response
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Decode and print the response
            $responseData = json_decode($response, true);
            print_r($responseData);
        }

        // Close the cURL session
        curl_close($ch);
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
        <?php $index = 1;
        foreach ($fares as $id): ?>
            <?php
            $fareXRef = getTarifByFareId($responseData, $id['fareId']); ?>
            <div class="container">
                <div class="offer-card">
                    <div><?php echo $index; ?></div>
                    <div class="d-flex justify-content-end align-items-end my-3" style="gap: 2rem;">
                        <div>
                            Total price : 1× Adults
                        </div>
                        <div class="text-right">
                            <div>Price p.p</div>
                            <div style="font-weight: 600;"><?php echo $fareXRef["@attributes"]["adtSell"] ?> AUD</div>
                        </div>
                        <div style="font-weight: 700;font-size: x-large;"><?php echo $fareXRef["@attributes"]["adtSell"] ?> <sup>AUD</sup></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>FareType : <?php echo "PUB"; ?></div>
                        <div>Departure : <?php echo $id['depApt']; ?></div>
                        <div>Destination : <?php echo $id['dstApt']; ?></div>
                        <div>Airline : <?php echo "Qatar Airways"; ?></div>
                    </div>
                    <?php
                    // Assuming $fareXRef is the provided array
                    $value = 1;
                    $flights = $fareXRef["fareXRefs"]["fareXRef"]["flights"]["flight"];

                    foreach ($flights as $flight): ?>
                        <div class="d-flex justify-content-between p-2 border my-2">
                            <?php if (isset($flight['@attributes'])): ?>
                                <?php
                                // Reset $legInfo at the beginning of each flight iteration
                                $legInfo = [];

                                if (isset($flight['legXRefs']['legXRef'])) {
                                    foreach ($flight['legXRefs']['legXRef'] as $legXRef) {
                                        if (isset($legXRef['@attributes']['legId'])) {
                                            // Fetch and append leg data to $legInfo
                                            $legData = searchLegById($responseData, $legXRef['@attributes']['legId']);
                                            if (!empty($legData)) {
                                                $legInfo[] = $legData;
                                            }
                                        }
                                    }
                                }

                                $lastNumber = count($legInfo) - 1;
                                ?>
                                <div>
                                    <div>
                                        <span style="font-size: x-large; font-weight: 600; margin-right: 0.5rem;"><?php echo $legInfo[0][0]["depTime"] ?? "N/A"; ?></span>
                                        <?php echo $legInfo[0][0]["depDate"] ?? "N/A"; ?>
                                    </div>
                                    <div><?php echo $legInfo[0][0]["depApt"] ?? "N/A"; ?></div>
                                </div>
                                <div>
                                    <div>
                                        <span style="font-size: x-large; font-weight: 600; margin-right: 0.5rem;"><?php echo $legInfo[$lastNumber][0]["arrTime"] ?? "N/A"; ?></span>
                                        <?php echo $legInfo[$lastNumber][0]["arrDate"] ?? "N/A"; ?>
                                    </div>
                                    <div><?php echo $legInfo[$lastNumber][0]["dstApt"] ?? "N/A"; ?></div>
                                </div>
                                <button data-btn="<?php echo "flight_" . $value; ?>" class="btn" style="background-color: #a79e8044;">
                                    <i class="fa-solid fa-angle-down fa-lg" style="color: #000000;"></i>
                                </button>
                            <?php else: ?>
                                <div><?php echo $flight["flightId"]; ?></div>
                                <div><?php echo $flight["addAdtPrice"]; ?></div>
                                <div><?php echo $flight["addChdPrice"]; ?></div>
                                <button data-btn="<?php echo "flight_" . $value; ?>" class="btn" style="background-color: #a79e8044;">
                                    <i class="fa-solid fa-angle-down fa-lg" style="color: #000000;"></i>
                                </button>
                            <?php endif ?>
                        </div>
                        <div data-view="flight_<?php echo $value; ?>" class="p-2 border my-2 d-none">
                            <?php foreach ($legInfo as $leg): ?>
                                <?php
                                // Access the first element of the $leg array
                                $legData = isset($leg[0]) ? $leg[0] : [];
                                ?>
                                <div class="card border-0">
                                    <!-- First Segment -->
                                    <div class="row align-items-center">
                                        <div class="col-1 text-center">
                                            <div class="mb-2">
                                                <div class="rounded-circle bg-warning" style="width: 10px; height: 10px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <p class="mb-0 text-muted"><?php echo $legData["depDate"] ?? "N/A"; ?></p>
                                            <h6 class="mb-0"><?php echo $legData["depApt"] ?? "N/A"; ?></h6>
                                            <p class="fw-bold fs-5 mb-0"><?php echo $legData["depTime"] ?? "N/A"; ?></p>
                                            <p class="text-muted small mb-0">
                                                Duration <?php echo $legData["elapsed"] ?? "N/A"; ?> Hours |
                                                Distance: <?php echo $legData["miles"] ?? "N/A"; ?> Miles
                                            </p>
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Qatar_Airways_logo.png" alt="Qatar Airways" style="height: 20px;">
                                                <span class="ms-2">Qatar Airways</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Segment -->
                                    <div class="row align-items-center mt-3">
                                        <div class="col-1 text-center">
                                            <div class="mb-2">
                                                <div class="rounded-circle bg-secondary" style="width: 10px; height: 10px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <p class="mb-0 text-muted"><?php echo $legData["arrDate"] ?? "N/A"; ?></p>
                                            <h6 class="mb-0"><?php echo $legData["dstApt"] ?? "N/A"; ?></h6>
                                            <p class="fw-bold fs-5 mb-0"><?php echo $legData["arrTime"] ?? "N/A"; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="d-flex justify-content-end my-3">
                                <button class="book-btn">Book Offer</button>
                            </div>
                        </div>
                    <?php $value++;
                    endforeach; ?>


                </div>
            </div>
            <?php $index++; ?>
        <?php endforeach; ?>
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
                    label:"Melbourne",
                    value:"MEL"
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