<?php
session_start();
?>
    <style>
        .custom-dropdown-menu {
            min-width: 250px;
            padding: 10px;
        }
        .custom-dropdown-menu .btn {
            width: 30px;
            padding: 0;
            text-align: center;
        }
        .custom-dropdown-menu span {
            font-weight: bold;
        }
        .custom-dropdown-menu .description {
            font-size: 0.8em;
            color: #555;
        }
        .flight-result {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
        }

        .flight-info {
            font-size: 16px;
        }

        .flight-info span {
            display: block;
        }

        .book-button {
            background-color: #f0ad4e;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .book-button:hover {
            background-color: #ec971f;
            color: #fff;
        }

        .available-seats {
            color: green;
            font-weight: bold;
        }

        .price-breakdown {
            color: blue;
            cursor: pointer;
        }

        .table-responsive {
            margin-bottom: 20px;
        }

        .price-breakdown-content{
            display: none;
        }
    </style>
<?php
    require 'api.php';
    if(isset($_COOKIE['token'])){
        $token = $_COOKIE['token'];
    }else{
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
    
    isset($_SESSION ['formData']);
    if(isset($_POST['trip'])=="oneway"){
        // API endpoint
        $url = 'https://sandboxapi.getfares.com/Flights/Search/v1'; // Replace with your actual URL

        // Data to be sent in the body of the request
        $data = [
            "originDestinations" => [
                [
                    "departureDateTime" => $departureDate."T09:10:27.482Z",
                    "origin" => (string)$departFrom,
                    "destination" => (string)$flyingTo
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
            // print_r($responseData);
        }

        // Close the cURL session
        curl_close($ch);
    }elseif(isset($_POST['trip'])=="roundtrip"){
        // API endpoint
        $url = 'https://sandboxapi.getfares.com/Flights/Search/v1'; // Replace with your actual URL

        // Data to be sent in the body of the request
        $data = [
            "originDestinations" => [
                [
                    "departureDateTime" => $departureDate."T09:10:27.482Z",
                    "origin" => (string)$departFrom,
                    "destination" => (string)$flyingTo
                ],
                [
                    "departureDateTime"=> $returnDate."10:27.482Z",
                    "origin"=> (string)$flyingTo,
                    "destination"=> (string)$departFrom
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
        <div class="container">    
            <?php foreach ($responseData['flights'] as $index => $flight): ?>
                <form action="" method="get" name="book" class="bookForm">
                        <div class="my-5">
                            <div class="flight-result">
                                <div class="d-flex justify-content-between">
                                    <div class="price">
                                        <?php
                                        $baseFare = $flight['fareGroups'][0]['fares'][0]['base'];
                                        echo number_format($baseFare, 2) . " INR";
                                        ?>
                                        <input type="text" name="traceId" id="traceId" value="<?php echo  $responseData['traceId']?>" hidden>
                                    </div>
                                    <div>Price p.p.</div>
                                </div>
                                <div class="flight-info mt-3">
                                    <span>
                                        Total price: <?php echo $flight['adtNum']; ?>× Adults –
                                        <?php echo number_format($baseFare * $flight['adtNum'], 2) . " INR"; ?>
                                    </span>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Outbound</strong> <?php echo $flight['fareGroups'][0]['fareType']; ?> fare (<?php echo $flight['fareGroups'][0]['priceClass']; ?>)
                                            </div>
                                            <div><?php echo $flight['airline']; ?></div>
                                        </div>
                                        <?php foreach ($flight['segGroups'] as $segGroup): ?>
                                            <?php foreach ($segGroup['segs'] as $segment): ?>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div>
                                                        <i class="fas fa-plane"></i> <?php echo date("H:i d.m.Y", strtotime($segment['departureOn'])); ?> <?php echo $segment['origin']; ?>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-clock"></i> <?php echo floor($segment['duration'] / 60); ?>h <?php echo $segment['duration'] % 60; ?>m
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-plane-arrival"></i> <?php echo date("H:i d.m.Y", strtotime($segment['arrivalOn'])); ?> <?php echo $segment['destination']; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="available-seats">
                                                <?php
                                                $minSeats = PHP_INT_MAX;
                                                $seatInfoAvailable = false;

                                                if (isset($flight['fareGroups']) && is_array($flight['fareGroups'])) {
                                                    foreach ($flight['fareGroups'] as $fareGroup) {
                                                        if (isset($fareGroup['segInfos']) && is_array($fareGroup['segInfos'])) {
                                                            foreach ($fareGroup['segInfos'] as $segInfo) {
                                                                if (isset($segInfo['seatRemaining'])) {
                                                                    $minSeats = min($minSeats, $segInfo['seatRemaining']);
                                                                    $seatInfoAvailable = true;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($seatInfoAvailable) {
                                                    echo "At least $minSeats seats available<br>";
                                                } else {
                                                    echo "Seat information not available<br>";
                                                }
                                                ?>
                                                <input type="text" name="purchaseId" id="purchaseId" value="<?php echo  $fareGroup['purchaseId']?>" hidden>
                                            </div>
                                            <button type="submit" class="btn book-button" >Book this offer</button>
                                        </div>
                                        <div class="mt-3">
                                            <span class="price-breakdown" data-index="<?php echo $index; ?>">+ DISPLAY PRICE BREAKDOWN</span>
                                        </div>
                                        <div class="price-breakdown-content" id="price-breakdown-<?php echo $index; ?>">
                                        <?php foreach($fareGroup['fares'] as $fare):?>
                                                <p style="margin: 12px 0 6px 12px;">
                                                <?php if($fare['paxType']=="ADT"){
                                                        echo "Adult";
                                                }elseif($fare['paxType']=="CHD"){
                                                        echo "Child";
                                                }else{
                                                        echo "Infant";
                                                }?> : <?php echo number_format($fare['base'], 2)?></p>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </form>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<script>
    $(document).ready(function() {
        // Cities array
        var cities = [
            { label: "Mumbai", value: "BOM" },
            { label: "Delhi", value: "DEL" },
            { label: "Dubai", value: "DXB" },
            { label: "New York", value: "JFK" },
            { label: "London", value: "LHR" },
            { label: "Paris", value: "CDG" },
            { label: "Tokyo", value: "HND" },
            { label: "Singapore", value: "SIN" },
            { label: "Sydney", value: "SYD" },
            { label: "Hong Kong", value: "HKG" },
            { label: "Los Angeles", value: "LAX" },
            { label: "Chicago", value: "ORD" },
            { label: "Toronto", value: "YYZ" },
            { label: "San Francisco", value: "SFO" },
            { label: "Boston", value: "BOS" },
            { label: "Miami", value: "MIA" },
            { label: "Bangkok", value: "BKK" },
            { label: "Beijing", value: "PEK" },
            { label: "Shanghai", value: "PVG" },
            { label: "Seoul", value: "ICN" },
            { label: "Istanbul", value: "IST" },
            { label: "Frankfurt", value: "FRA" },
            { label: "Amsterdam", value: "AMS" },
            { label: "Zurich", value: "ZRH" },
            { label: "Rome", value: "FCO" }
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