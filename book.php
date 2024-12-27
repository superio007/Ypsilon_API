<?php
session_start();
$formData = $_SESSION['formData'];
// var_dump($formData);
$responseData = $_SESSION['responseData'];
// print_r($responseData);
$bagageData = isset($_SESSION['baggage']);
// var_dump($bagageData);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        #spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: #154782;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .passenger-form {
            background-color: #f2f2f2;
            border: 1px solid #e5e5e5;
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .passenger-form h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            margin-right: 10px;
            flex: 1;
        }

        .form-row label {
            margin-bottom: 5px;
        }

        .form-row input,
        .form-row select,
        .more-options button {
            padding: 5px;
            box-sizing: border-box;
            width: 100%;
            height: 38px;
        }

        .inner-div,
        .dob-row,
        .id-number-row {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            margin-top: 15px;
        }

        .dob-row label,
        .id-number-row label {
            flex-basis: 100%;
            margin-bottom: 5px;
        }

        .dob-row select,
        .id-number-row input,
        .id-number-row select {
            flex: 1;
            height: 38px;
            margin-right: 10px;
        }

        .dob-row {
            align-items: baseline;
            margin-bottom: 1rem;
        }

        .outer-div {
            padding: 10px;
            border: 1px solid grey;
            background-color: white;
            margin-bottom: 20px;
        }

        .middle-div {
            padding: 15px;
            background-color: white;
            border: 1px solid grey;
        }

        .inner-div {
            background-color: white;
        }

        .info-div {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .info-div .info-icon {
            margin-left: 5px;
            font-size: 14px;
            color: #000;
        }

        .more-options {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .more-options button {
            padding: 5px 10px;
            height: 38px;
        }

        .notice-box {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        .id-number-row .form-row {
            flex: 0 0 20%;
            margin-right: 10px;
        }

        .id-number-row .dob-row {
            flex: 1;
            display: flex;
        }

        .id-number-row .dob-row select {
            margin-right: 10px;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            display: none;
        }

        .form-row select,
        .form-row input {
            margin-bottom: 5px;
        }

        #main {
            display: flex;
            justify-content: center;
        }

        #main #outer-div {
            border: 1px solid #00000073;
            width: 100%;
            background-color: white;
        }

        #main .form-container {
            width: 98%;
            margin: 10px auto;
            padding: 20px;
            border: 1px solid #00000073;
            background-color: #ffffff;
        }

        #main .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        #main .form-group {
            flex: 1;
            margin-right: 10px;
        }

        #main .form-group:last-child {
            margin-right: 0;
        }

        #main label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #333;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        select:focus {
            border-color: #0073e6;
            outline: none;
        }

        #main .form-note {
            text-align: right;
            margin-top: 10px;
        }

        #main .form-note p {
            font-size: 12px;
            color: #666;
        }

        #main .form-submit {
            text-align: center;
            margin-top: 20px;
        }

        #main .form-submit button {
            padding: 10px 20px;
            background-color: #0073e6;
            border: none;
            border-radius: 3px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        #main .form-submit button:hover {
            background-color: #005bb5;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php
        require 'api.php';
        // require 'managebagage.php';
        $token = getToken();
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'test';

        // Create connection
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $traceId = $_GET['traceId'];
        $purchaseId = $_GET['purchaseId'];
        function searchAdditionalServices($jsonResponse) {
            // Decode the JSON response
            // $responseArray = json_decode($jsonResponse, true);
        
            // Convert the array to a JSON string
            $jsonString = json_encode($jsonResponse);
        
            // Search for the word "additionalServices" in the JSON string
            if (strpos($jsonString, 'additionalServices') !== false) {
                return true;
            } else {
                return false;
            }
        }
        $additionalServicesCheck = searchAdditionalServices($responseData);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            // Validation functions
            function validate_required($field, $value)
            {
                global $errors;
                if (empty($value)) {
                    $errors[$field] = ucfirst(str_replace('-', ' ', $field)) . ' is required.';
                }
            }

            function validate_date($day, $month, $year, $field_name)
            {
                global $errors;
                if (!checkdate((int)$month, (int)$day, (int)$year)) {
                    $errors[$field_name] = 'Invalid date for ' . str_replace('-', ' ', $field_name) . '.';
                }
            }

            // Fetch and validate inputs
            $titles = $_POST['title'];
            $first_names = $_POST['first-name'];
            $last_names = $_POST['last-name'];
            $agentsids = $_POST['agents-id'];
            $emailaddress = $_POST['email-address'];
            $phonenumber = $_POST['phone-number'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $zipcode = $_POST['zip-code'];
            $address = $_POST['Address'];
            $street = $_POST['street'];
            $dob_days = $_POST['dob-day'];
            $dob_months = $_POST['dob-month'];
            $dob_years = $_POST['dob-year'];
            $id_methods = $_POST['id-method'];
            $genders = $_POST['gender'];
            $id_numbers = $_POST['id-number'];
            $state = $_POST['State'];
            $country_code = $_POST['country-code'];
            $id_expire_days = $_POST['id-expire-day'];
            $id_expire_months = $_POST['id-expire-month'];
            $id_expire_years = $_POST['id-expire-year'];
            $id_issue_days = $_POST['id-issue-day'];
            $id_issue_months = $_POST['id-issue-month'];
            $id_issue_years = $_POST['id-issue-year'];
            $country_issues = $_POST['country-issue'];
            $country_births = $_POST['country-birth'];
            $paxTypes = $_POST['paxType'];

            // Validate shared fields once
            validate_required('email-address', $emailaddress);
            validate_required('phone-number', $phonenumber);
            validate_required('country', $country);
            validate_required('city', $city);
            validate_required('zip-code', $zipcode);
            validate_required('Address', $address);
            validate_required('street', $street);
            validate_required('State', $state);
            validate_required('country-code', $country_code);

            // Iterate over each passenger and validate their data
            foreach ($titles as $index => $title) {
                validate_required("title[$index]", $title);
                validate_required("first-name[$index]", $first_names[$index]);
                validate_required("last-name[$index]", $last_names[$index]);
                validate_required("agents-id[$index]", $agentsids[$index]);
                validate_required("dob-day[$index]", $dob_days[$index]);
                validate_required("dob-month[$index]", $dob_months[$index]);
                validate_required("dob-year[$index]", $dob_years[$index]);
                if (!isset($errors["dob-day[$index]"]) && !isset($errors["dob-month[$index]"]) && !isset($errors["dob-year[$index]"])) {
                    validate_date($dob_days[$index], $dob_months[$index], $dob_years[$index], "date of birth[$index]");
                }
                validate_required("id-method[$index]", $id_methods[$index]);
                validate_required("gender[$index]", $genders[$index]);
                validate_required("id-number[$index]", $id_numbers[$index]);
                validate_required("id-expire-day[$index]", $id_expire_days[$index]);
                validate_required("id-expire-month[$index]", $id_expire_months[$index]);
                validate_required("id-expire-year[$index]", $id_expire_years[$index]);
                if (!isset($errors["id-expire-day[$index]"]) && !isset($errors["id-expire-month[$index]"]) && !isset($errors["id-expire-year[$index]"])) {
                    validate_date($id_expire_days[$index], $id_expire_months[$index], $id_expire_years[$index], "ID expire date[$index]");
                }
                validate_required("id-issue-day[$index]", $id_issue_days[$index]);
                validate_required("id-issue-month[$index]", $id_issue_months[$index]);
                validate_required("id-issue-year[$index]", $id_issue_years[$index]);
                if (!isset($errors["id-issue-day[$index]"]) && !isset($errors["id-issue-month[$index]"]) && !isset($errors["id-issue-year[$index]"])) {
                    validate_date($id_issue_days[$index], $id_issue_months[$index], $id_issue_years[$index], "ID issue date[$index]");
                }
                validate_required("country-issue[$index]", $country_issues[$index]);
                validate_required("country-birth[$index]", $country_births[$index]);
                validate_required("paxType[$index]", $paxTypes[$index]);
            }
            $book_status = "Processing";
            $bookingMessage = "";

            if (empty($errors)) {
                $stmt = $mysqli->prepare("INSERT INTO wpk4_backend_travel_booking_pax (traceId, purchaseid, booking_status,salutation, fname, lname, email, gender, dob, paxType, mobile_no, passportNumber, passportDOI, passportDOE, passportIssuedCountry, seatPref, addressName, street, AddresState, postalCode, countryName, countryCode, city, passengerNationality) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)");

                // Iterate over each passenger and insert their data
                foreach ($titles as $index => $title) {
                    $first_name = $first_names[$index];
                    $last_name = $last_names[$index];
                    $agentsid = $agentsids[$index];
                    $dob_day = $dob_days[$index];
                    $dob_month = $dob_months[$index];
                    $dob_year = $dob_years[$index];
                    $id_method = $id_methods[$index];
                    $gender = $genders[$index];
                    $id_number = $id_numbers[$index];
                    $id_expire_day = $id_expire_days[$index];
                    $id_expire_month = $id_expire_months[$index];
                    $id_expire_year = $id_expire_years[$index];
                    $id_issue_day = $id_issue_days[$index];
                    $id_issue_month = $id_issue_months[$index];
                    $id_issue_year = $id_issue_years[$index];
                    $country_issue = $country_issues[$index];
                    $country_birth = $country_births[$index];
                    $paxType = $paxTypes[$index];

                    $dob = $dob_year . '-' . str_pad($dob_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dob_day, 2, '0', STR_PAD_LEFT);
                    $idissueDate = $id_issue_year . '-' . str_pad($id_issue_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($id_issue_day, 2, '0', STR_PAD_LEFT);
                    $idexpireDate = $id_expire_year . '-' . str_pad($id_expire_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($id_expire_day, 2, '0', STR_PAD_LEFT);
                    $seatref = "N";

                    $stmt->bind_param(
                        "ssssssssssssssssssssssss",
                        $traceId,
                        $purchaseId,
                        $book_status,
                        $title,
                        $first_name,
                        $last_name,
                        $emailaddress,
                        $gender,
                        $dob,
                        $paxType,
                        $phonenumber,
                        $id_number,
                        $idissueDate,
                        $idexpireDate,
                        $country_issue,
                        $seatref,
                        $address,
                        $street,
                        $state,
                        $zipcode,
                        $country,
                        $country_code,
                        $city,
                        $country_birth
                    );

                    // Execute the statement
                    if (!$stmt->execute()) {
                        echo "Error: " . $stmt->error;
                    }
                }

                echo "All records created successfully";

                // Close the statement
                $stmt->close();

                // Fetch all passengers for the traceId
                $storequery = $mysqli->prepare("SELECT * FROM `wpk4_backend_travel_booking_pax` WHERE traceId = ?");
                $storequery->bind_param("s", $traceId);
                $storequery->execute();
                $result = $storequery->get_result();

                // Fetch the results into an associative array
                $results = [];
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }

                $passengers = [];
                foreach ($results as $result) {
                    $paxType = $result['paxType'];
                    if ($paxType == 'Adult') {
                        $paxType = "ADT";
                    } elseif ($paxType == 'Child') {
                        $paxType = "CHD";
                    } else {
                        $paxType = "INF";
                    }

                    $passengers[] = [
                        "title" => $result['salutation'],
                        "firstName" => $result['fname'],
                        "lastName" => $result['lname'],
                        "email" => $result['email'],
                        "dob" => $result['dob'] . "T15:43:15.677Z",
                        "genderType" => $result['gender'],
                        "areaCode" => "",
                        "ffNumber" => "",
                        "paxType" => $paxType,
                        "mobile" => (string)$result['mobile_no'],
                        "passportNumber" => $result['passportNumber'],
                        "passengerNationality" => $result['passengerNationality'],
                        "passportDOI" => $result['passportDOI'] . "T15:43:15.677Z",
                        "passportDOE" => $result['passportDOE'] . "T15:43:15.677Z",
                        "passportIssuedCountry" => $result['passportIssuedCountry'],
                        "seatPref" => $result['seatPref'],
                        "mealPref" => "",
                        "ktn" => "",
                        "redressNo" => "",
                    ];
                }

                // Fetch baggage data from the session
                session_start();
                $bagageData = $_SESSION['baggageData'] ?? [];

                $additionalServices = [];
                if (!empty($bagageData)) {
                    foreach ($bagageData as $data) {
                        $additionalServices[] = [
                            "baggageRefNo" => $data['freeTextValue'],
                            "MealsRefNo" => "",
                            "SegmentInfo" => $data['cityPairValue']
                        ];
                    }
                }

                // Prepare the API request data
                $url = 'https://sandboxapi.getfares.com/Flights/Booking/CreatePNR/v1';
                $data = [
                    "traceId" => $traceId,
                    "gstDetails" => [
                        "address1" => "",
                        "address2" => "",
                        "city" => "",
                        "state" => "",
                        "pinCode" => "",
                        "email" => "",
                        "gstNumber" => "",
                        "gstPhoneNo" => "",
                        "gstCompanyName" => ""
                    ],
                    "purchaseIds" => [$purchaseId],
                    "passengers" => $passengers,
                    "address" => [
                        "addressName" => $address,
                        "street" => $street,
                        "state" => $state,
                        "postalCode" => $zipcode,
                        "countryName" => $country,
                        "countryCode" => $country_code,
                        "city" => $city
                    ],
                    "additionalServices" => $additionalServices
                ];

                // Convert data array to JSON format
                $jsonData = json_encode($data);

                var_dump($jsonData);

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
                    var_dump($responseData);
                    if (!empty($responseData['orderId'])) {
                        $bookingMessage = "Booking successful!";
                        // SQL query
                        $update = "UPDATE `wpk4_backend_travel_booking_pax` 
                                SET `booking_status`='CONFIRMED' 
                                WHERE `traceId` = ?";

                        // Prepare statement
                        $stmt = $mysqli->prepare($update);

                        // Bind parameters
                        $stmt->bind_param('s', $traceId); // 's' denotes that traceId is a string
                        if ($stmt->execute()) {
                            // echo "updated";
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        // Close the statement
                        $stmt->close();
                    }
                }

                // Close the cURL session
                curl_close($ch);

            } else {
                // Display errors
                foreach ($errors as $field => $error) {
                    echo "<p>$error</p>";
                }
            }

            // Close the connection
            $mysqli->close();
        }
        // var_dump($formData);
        $passengerTypes = array_merge(
            array_fill(0, $formData['adultsCount'], 'Adult'),
            array_fill(0, $formData['childrenCount'], 'Child'),
            array_fill(0, $formData['infantsCount'], 'Infant')
        );
        $passengers_count = $formData['total'];
        // foreach($responseData['response']['flights'] as $flight){
        //     foreach($flight['fareGroups'] as $faregroup){
        //         foreach($faregroup['fares'] as $fares){
        //             $baseFair = $fares['base'];
        //         }
        //     }
        // }
        foreach($responseData['response']['flights'] as $flight){
            $baseFare = $flight['fareGroups'][0]['fares'][0]['base'];
            $childFare = isset($flight['fareGroups'][0]['fares'][1]['base']);   
        }
        
        $base_price = $baseFare;


        $total = "$ " .  $baseFare + isset($childFare);

        // DB connection 
    ?>

    <div id="spinner" style="display: none;">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <?php if (empty($responseData['orderId'])) : ?>
        <div id="main-div">
            <form action="" method="post" id="passenger-form">
                <div class="passenger-form mb-3">
                    <?php
                    for ($i = 0; $i < $formData['total']; $i++) :
                        $passengerType = $passengerTypes[$i];
                    ?>
                        <div class="outer-div">
                            <div class="middle-div">
                                <div class="info-div">
                                    <?php echo ($i + 1) . ". " . $passengerType; ?>
                                    <i class="fas fa-info-circle info-icon"></i>
                                    <input type="text" value="<?php echo $passengerType; ?>" hidden name="paxType[]">
                                </div>
                                <div class="inner-div">
                                    <div class="form-row">
                                        <label for="title-<?php echo $i; ?>">Title*</label>
                                        <select id="title-<?php echo $i; ?>" name="title[]" required>
                                            <option value="Mr">Mr.</option>
                                            <option value="Mrs">Mrs.</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Ms">Ms.</option>
                                        </select>
                                        <div id="title-<?php echo $i; ?>-error" class="error-message">Title is required.</div>
                                    </div>
                                    <div class="form-row">
                                        <label for="first-name-<?php echo $i; ?>">First name*</label>
                                        <input type="text" id="first-name-<?php echo $i; ?>" placeholder="Enter first name" name="first-name[]" required>
                                        <div id="first-name-<?php echo $i; ?>-error" class="error-message">First name is required.</div>
                                    </div>
                                    <div class="form-row">
                                        <label for="last-name-<?php echo $i; ?>">Last name*</label>
                                        <input type="text" id="last-name-<?php echo $i; ?>" placeholder="Enter last name" name="last-name[]" required>
                                        <div id="last-name-<?php echo $i; ?>-error" class="error-message">Last name is required.</div>
                                    </div>
                                </div>
                                    <div class="dob-row">
                                        <label for="dob-<?php echo $i; ?>">Date of birth*</label>
                                        <select id="dob-day-<?php echo $i; ?>" name="dob-day[]" class="dob-field" required>
                                            <option value="" selected disabled hidden>DD</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                        <select id="dob-month-<?php echo $i; ?>" name="dob-month[]" class="dob-field" required>
                                        <option value="" selected disabled hidden>MM</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                        </select>
                                        <select id="dob-year-<?php echo $i; ?>" name="dob-year[]" class="dob-field" required>
                                            <option value="" selected disabled hidden>YYYY</option>
                                            <!-- Year options here -->
                                        </select>
                                        <div id="dob-<?php echo $i; ?>-error" class="error-message">Complete date of birth is required.</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="id-method-<?php echo $i; ?>">Identification method</label>
                                        <select id="id-method-<?php echo $i; ?>" name="id-method[]" required>
                                            <option value="" selected disabled hidden>Select</option>
                                            <option value="Passport">Passport</option>
                                        </select>
                                        <div id="id-method-<?php echo $i; ?>-error" class="error-message">Identification method is required.</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <label style="display: flex;align-items: end;" for="gender-<?php echo $i; ?>">Gender</label>
                                                <select id="gender-<?php echo $i; ?>" name="gender[]" required>
                                                    <option value="" selected disabled hidden>Select Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                                <div id="gender-<?php echo $i; ?>-error" class="error-message">Gender is required.</div>
                                            </div>
                                            <div class="col-6">
                                                <label style="display: flex;align-items: end;" for="id-number-<?php echo $i; ?>">Identification Number</label>
                                                <input type="text" placeholder="Enter passport number" id="id-number-<?php echo $i; ?>" name="id-number[]" required>
                                                <div id="id-number-<?php echo $i; ?>-error" class="error-message">Identification number is required.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="id-issue-day-<?php echo $i; ?>" style="flex-basis: 100%; margin-bottom: 5px;">Date of Issue</label>
                                            <div class="col-4">
                                                <select id="id-issue-day-<?php echo $i; ?>" name="id-issue-day[]" class="dob-field" required>
                                                    <option value="" selected disabled hidden>DD</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select id="id-issue-month-<?php echo $i; ?>" name="id-issue-month[]" class="dob-field" required>
                                                    <option value="" selected disabled hidden>MM</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select id="id-issue-year-<?php echo $i; ?>" name="id-issue-year[]" class="dob-field" required>
                                                    <option value="">YYYY</option>
                                                    <!-- Year options here -->
                                                </select>
                                            </div>
                                            <div id="id-expire-<?php echo $i; ?>-error" class="error-message">Complete ID expiration date is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <label for="id-expire-day-<?php echo $i; ?>" style="flex-basis: 100%; margin-bottom: 5px;">Date of expire</label>
                                            <div class="col-4">
                                                <select id="id-expire-day-<?php echo $i; ?>" name="id-expire-day[]" class="dob-field" required>
                                                    <option value="" selected disabled hidden>DD</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select id="id-expire-month-<?php echo $i; ?>" name="id-expire-month[]" class="dob-field" required>
                                                    <option value="" selected disabled hidden>MM</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select id="id-expire-year-<?php echo $i; ?>" name="id-expire-year[]" class="dob-field" required>
                                                    <option value="">YYYY</option>
                                                    <!-- Year options here -->
                                                </select>
                                            </div>
                                            <div id="id-expire-<?php echo $i; ?>-error" class="error-message">Complete ID expiration date is required.</div>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <div class="form-row">
                                        <label for="country-issue-<?php echo $i; ?>">Country of issue</label>
                                        <select id="country-issue-<?php echo $i; ?>" name="country-issue[]" required>
                                            <option value="" selected disabled hidden>Select country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BR">Brazil</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="CV">Cabo Verde</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, Democratic Republic of the</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Côte d'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="SZ">Eswatini</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GR">Greece</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia (Federated States of)</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="MK">North Macedonia</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select>
                                        <div id="country-issue-<?php echo $i; ?>-error" class="error-message">Country of issue is required.</div>
                                    </div>
                                    <div class="form-row">
                                        <label for="country-birth-<?php echo $i; ?>">Country of birth</label>
                                        <select id="country-birth-<?php echo $i; ?>" name="country-birth[]" required>
                                            <option value="" selected disabled hidden>Select country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BR">Brazil</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="CV">Cabo Verde</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, Democratic Republic of the</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Côte d'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="SZ">Eswatini</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GR">Greece</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia (Federated States of)</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="MK">North Macedonia</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select>
                                        <div id="country-birth-<?php echo $i; ?>-error" class="error-message">Country of birth is required.</div>
                                    </div>
                                </div>
                                <div class="notice-box">
                                    <strong>Sharing of emergency contact details.</strong><br>
                                    Please confirm and provide your contact details (mobile number and/or email) if you wish the carriers operating your flights to be able to contact you due to operational disruption such as cancellations, delays and schedule changes etc.
                                    <div class="d-flex gap-5 row ms-3 my-3">
                                        <div style="border:1px solid #00000073" class="d-flex gap-3 col-6">
                                            <input type="radio" id="share-<?php echo $i; ?>" name="emergency_contact_<?php echo $i; ?>" value="share">
                                            <label for="share-<?php echo $i; ?>">I wish to share emergency contact details</label>
                                        </div>
                                        <div style="border:1px solid #00000073" class="d-flex gap-3 col-5">
                                            <input type="radio" id="no-share-<?php echo $i; ?>" name="emergency_contact_<?php echo $i; ?>" value="no-share" checked>
                                            <label for="no-share-<?php echo $i; ?>">I don't wish to share my details</label>
                                        </div>
                                    </div>
                                    <div id="contact-details-<?php echo $i; ?>" style="margin: 0 1rem;" class="hidden">
                                        <div class="form-row row d-flex">
                                            <div class="form-group col-6">
                                                <label for="emergency_country-<?php echo $i; ?>">Country*</label>
                                                <select id="emergency_country-<?php echo $i; ?>" name="emergency_country[]" required>
                                                    <option value="" selected disabled hidden>Select country</option>
                                                    <option value="+91">India</option>
                                                    <!-- Add more country options here -->
                                                </select>
                                                <div id="emergency_country-<?php echo $i; ?>-error" class="error-message">Country is required.</div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="emergency_phone-number-<?php echo $i; ?>">Phone number*</label>
                                                <input placeholder="Enter phone number" type="tel" id="emergency_phone-number-<?php echo $i; ?>" name="emergency_phone-number[]" required>
                                                <div id="emergency_phone-number-<?php echo $i; ?>-error" class="error-message">Phone number is required.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group" style="margin-right: 50.36666%">
                                                <label for="emergency_email-address-<?php echo $i; ?>">E-mail address*</label>
                                                <input type="email" id="emergency_email-address-<?php echo $i; ?>" name="emergency_email-address[]" placeholder="Enter email" required>
                                                <div id="emergency_email-address-<?php echo $i; ?>-error" class="error-message">Email address is required.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <h2 class="text-start ">Add ons</h2>
                    <div id="main" class="mb-3">
                        <div id="outer-div">
                            <div class="form-container">
                                <?php if ($additionalServicesCheck): ?>
                                    <div class="form-group col-6">
                                        <label for="emergency_country-<?php echo $i; ?>">Extra baggage*</label>
                                        <?php $index = 0; ?>
                                        <?php foreach ($responseData['response']['flights'] as $flight): ?>
                                            <?php foreach ($flight['segGroups'] as $segGroups): ?>
                                                <?php foreach ($segGroups['segs'] as $segs): ?>
                                                    <p class="my-2"><b><?php echo $segs['origin'] . " " . "x" . " " . $segs['destination']; ?></b></p>
                                                    <?php 
                                                        $displayedServices = []; // Track displayed services to avoid duplicates
                                                    ?>
                                                    <?php foreach ($flight['additionalServices'] as $additionalServices): ?>
                                                        <?php if ($additionalServices && !in_array($additionalServices['cityPair'] . $additionalServices['additionalServiceType'] . $additionalServices['serviceDescription'], $displayedServices)): ?>
                                                            <?php if ($additionalServices['cityPair'] == $segs['origin'] . $segs['destination']): ?>
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <input type="checkbox" name="baggage" id="baggage_<?php echo $index; ?>" data-city-pair="<?php echo $additionalServices['cityPair']; ?>" data-service-type="<?php echo $additionalServices['additionalServiceType']; ?>" data-service-description="<?php echo $additionalServices['serviceDescription']; ?>">
                                                                        <label class="m-0" for="baggage_<?php echo $index; ?>"><?php echo $additionalServices['additionalServiceType'] . "-" . $additionalServices['serviceDescription']; ?></label>
                                                                        <input type="text" id="freeText_<?php echo $index; ?>" value="<?php echo $additionalServices['freeText']; ?>" hidden>
                                                                        <input type="text" id="cityPair_<?php echo $index; ?>" value="<?php echo $additionalServices['cityPair']; ?>" hidden>
                                                                    </div>
                                                                    <div>
                                                                        <?php foreach ($additionalServices['flightFares'] as $flightFares): ?>
                                                                            <p><?php echo "$ " . $flightFares['amount']; ?></p>
                                                                            <input type="text" id="price_<?php echo $index; ?>" value="<?php echo $flightFares['amount']; ?>" hidden>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <?php 
                                                                    $displayedServices[] = $additionalServices['cityPair'] . $additionalServices['additionalServiceType'] . $additionalServices['serviceDescription'];
                                                                    $index++; 
                                                                ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-start ">Invoice Address</h2>
                        <div id="main">
                            <div id="outer-div">
                                <div class="form-container">
                                    <form id="passenger-form" action="#" method="post">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="street">Street*</label>
                                                <input type="text" id="street" name="street" placeholder="Enter Street name" required>
                                                <div id="street-error" class="error-message">Street is required.</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Address">Address.*</label>
                                                <input type="text" id="Address" name="Address" placeholder="Enter address" required>
                                                <div id="Address-error" class="error-message">Address is required.</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="zip-code">ZIP code*</label>
                                                <input type="text" id="zip-code" placeholder="Enter zip code" name="zip-code" required>
                                                <div id="zip-code-error" class="error-message">Zip code is required.</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="city">City*</label>
                                                <input type="text" id="city" placeholder="Enter city" name="city" required>
                                                <div id="city-error" class="error-message">City is required.</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="country">Country*</label>
                                                <select id="country" name="country" required>
                                                    <option value="" selected disabled hidden>Select country</option>
                                                    <option value="AF">Afghanistan</option>
                                                    <option value="AL">Albania</option>
                                                    <option value="DZ">Algeria</option>
                                                    <option value="AS">American Samoa</option>
                                                    <option value="AD">Andorra</option>
                                                    <option value="AO">Angola</option>
                                                    <option value="AI">Anguilla</option>
                                                    <option value="AQ">Antarctica</option>
                                                    <option value="AG">Antigua and Barbuda</option>
                                                    <option value="AR">Argentina</option>
                                                    <option value="AM">Armenia</option>
                                                    <option value="AW">Aruba</option>
                                                    <option value="AU">Australia</option>
                                                    <option value="AT">Austria</option>
                                                    <option value="AZ">Azerbaijan</option>
                                                    <option value="BS">Bahamas</option>
                                                    <option value="BH">Bahrain</option>
                                                    <option value="BD">Bangladesh</option>
                                                    <option value="BB">Barbados</option>
                                                    <option value="BY">Belarus</option>
                                                    <option value="BE">Belgium</option>
                                                    <option value="BZ">Belize</option>
                                                    <option value="BJ">Benin</option>
                                                    <option value="BM">Bermuda</option>
                                                    <option value="BT">Bhutan</option>
                                                    <option value="BO">Bolivia</option>
                                                    <option value="BA">Bosnia and Herzegovina</option>
                                                    <option value="BW">Botswana</option>
                                                    <option value="BR">Brazil</option>
                                                    <option value="BN">Brunei Darussalam</option>
                                                    <option value="BG">Bulgaria</option>
                                                    <option value="BF">Burkina Faso</option>
                                                    <option value="BI">Burundi</option>
                                                    <option value="CV">Cabo Verde</option>
                                                    <option value="KH">Cambodia</option>
                                                    <option value="CM">Cameroon</option>
                                                    <option value="CA">Canada</option>
                                                    <option value="KY">Cayman Islands</option>
                                                    <option value="CF">Central African Republic</option>
                                                    <option value="TD">Chad</option>
                                                    <option value="CL">Chile</option>
                                                    <option value="CN">China</option>
                                                    <option value="CO">Colombia</option>
                                                    <option value="KM">Comoros</option>
                                                    <option value="CG">Congo</option>
                                                    <option value="CD">Congo, Democratic Republic of the</option>
                                                    <option value="CR">Costa Rica</option>
                                                    <option value="CI">Côte d'Ivoire</option>
                                                    <option value="HR">Croatia</option>
                                                    <option value="CU">Cuba</option>
                                                    <option value="CY">Cyprus</option>
                                                    <option value="CZ">Czech Republic</option>
                                                    <option value="DK">Denmark</option>
                                                    <option value="DJ">Djibouti</option>
                                                    <option value="DM">Dominica</option>
                                                    <option value="DO">Dominican Republic</option>
                                                    <option value="EC">Ecuador</option>
                                                    <option value="EG">Egypt</option>
                                                    <option value="SV">El Salvador</option>
                                                    <option value="GQ">Equatorial Guinea</option>
                                                    <option value="ER">Eritrea</option>
                                                    <option value="EE">Estonia</option>
                                                    <option value="SZ">Eswatini</option>
                                                    <option value="ET">Ethiopia</option>
                                                    <option value="FJ">Fiji</option>
                                                    <option value="FI">Finland</option>
                                                    <option value="FR">France</option>
                                                    <option value="GA">Gabon</option>
                                                    <option value="GM">Gambia</option>
                                                    <option value="GE">Georgia</option>
                                                    <option value="DE">Germany</option>
                                                    <option value="GH">Ghana</option>
                                                    <option value="GR">Greece</option>
                                                    <option value="GD">Grenada</option>
                                                    <option value="GU">Guam</option>
                                                    <option value="GT">Guatemala</option>
                                                    <option value="GN">Guinea</option>
                                                    <option value="GW">Guinea-Bissau</option>
                                                    <option value="GY">Guyana</option>
                                                    <option value="HT">Haiti</option>
                                                    <option value="HN">Honduras</option>
                                                    <option value="HU">Hungary</option>
                                                    <option value="IS">Iceland</option>
                                                    <option value="IN">India</option>
                                                    <option value="ID">Indonesia</option>
                                                    <option value="IR">Iran, Islamic Republic of</option>
                                                    <option value="IQ">Iraq</option>
                                                    <option value="IE">Ireland</option>
                                                    <option value="IL">Israel</option>
                                                    <option value="IT">Italy</option>
                                                    <option value="JM">Jamaica</option>
                                                    <option value="JP">Japan</option>
                                                    <option value="JO">Jordan</option>
                                                    <option value="KZ">Kazakhstan</option>
                                                    <option value="KE">Kenya</option>
                                                    <option value="KI">Kiribati</option>
                                                    <option value="KP">Korea, Democratic People's Republic of</option>
                                                    <option value="KR">Korea, Republic of</option>
                                                    <option value="KW">Kuwait</option>
                                                    <option value="KG">Kyrgyzstan</option>
                                                    <option value="LA">Lao People's Democratic Republic</option>
                                                    <option value="LV">Latvia</option>
                                                    <option value="LB">Lebanon</option>
                                                    <option value="LS">Lesotho</option>
                                                    <option value="LR">Liberia</option>
                                                    <option value="LY">Libya</option>
                                                    <option value="LI">Liechtenstein</option>
                                                    <option value="LT">Lithuania</option>
                                                    <option value="LU">Luxembourg</option>
                                                    <option value="MG">Madagascar</option>
                                                    <option value="MW">Malawi</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="MV">Maldives</option>
                                                    <option value="ML">Mali</option>
                                                    <option value="MT">Malta</option>
                                                    <option value="MH">Marshall Islands</option>
                                                    <option value="MR">Mauritania</option>
                                                    <option value="MU">Mauritius</option>
                                                    <option value="MX">Mexico</option>
                                                    <option value="FM">Micronesia (Federated States of)</option>
                                                    <option value="MD">Moldova, Republic of</option>
                                                    <option value="MC">Monaco</option>
                                                    <option value="MN">Mongolia</option>
                                                    <option value="ME">Montenegro</option>
                                                    <option value="MA">Morocco</option>
                                                    <option value="MZ">Mozambique</option>
                                                    <option value="MM">Myanmar</option>
                                                    <option value="NA">Namibia</option>
                                                    <option value="NR">Nauru</option>
                                                    <option value="NP">Nepal</option>
                                                    <option value="NL">Netherlands</option>
                                                    <option value="NZ">New Zealand</option>
                                                    <option value="NI">Nicaragua</option>
                                                    <option value="NE">Niger</option>
                                                    <option value="NG">Nigeria</option>
                                                    <option value="MK">North Macedonia</option>
                                                    <option value="NO">Norway</option>
                                                    <option value="OM">Oman</option>
                                                    <option value="PK">Pakistan</option>
                                                    <option value="PW">Palau</option>
                                                    <option value="PA">Panama</option>
                                                    <option value="PG">Papua New Guinea</option>
                                                    <option value="PY">Paraguay</option>
                                                    <option value="PE">Peru</option>
                                                    <option value="PH">Philippines</option>
                                                    <option value="PL">Poland</option>
                                                    <option value="PT">Portugal</option>
                                                    <option value="QA">Qatar</option>
                                                    <option value="RO">Romania</option>
                                                    <option value="RU">Russian Federation</option>
                                                    <option value="RW">Rwanda</option>
                                                    <option value="KN">Saint Kitts and Nevis</option>
                                                    <option value="LC">Saint Lucia</option>
                                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                                    <option value="WS">Samoa</option>
                                                    <option value="SM">San Marino</option>
                                                    <option value="ST">Sao Tome and Principe</option>
                                                    <option value="SA">Saudi Arabia</option>
                                                    <option value="SN">Senegal</option>
                                                    <option value="RS">Serbia</option>
                                                    <option value="SC">Seychelles</option>
                                                    <option value="SL">Sierra Leone</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="SK">Slovakia</option>
                                                    <option value="SI">Slovenia</option>
                                                    <option value="SB">Solomon Islands</option>
                                                    <option value="SO">Somalia</option>
                                                    <option value="ZA">South Africa</option>
                                                    <option value="SS">South Sudan</option>
                                                    <option value="ES">Spain</option>
                                                    <option value="LK">Sri Lanka</option>
                                                    <option value="SD">Sudan</option>
                                                    <option value="SR">Suriname</option>
                                                    <option value="SE">Sweden</option>
                                                    <option value="CH">Switzerland</option>
                                                    <option value="SY">Syrian Arab Republic</option>
                                                    <option value="TW">Taiwan, Province of China</option>
                                                    <option value="TJ">Tajikistan</option>
                                                    <option value="TZ">Tanzania, United Republic of</option>
                                                    <option value="TH">Thailand</option>
                                                    <option value="TL">Timor-Leste</option>
                                                    <option value="TG">Togo</option>
                                                    <option value="TO">Tonga</option>
                                                    <option value="TT">Trinidad and Tobago</option>
                                                    <option value="TN">Tunisia</option>
                                                    <option value="TR">Turkey</option>
                                                    <option value="TM">Turkmenistan</option>
                                                    <option value="TV">Tuvalu</option>
                                                    <option value="UG">Uganda</option>
                                                    <option value="UA">Ukraine</option>
                                                    <option value="AE">United Arab Emirates</option>
                                                    <option value="GB">United Kingdom</option>
                                                    <option value="US">United States</option>
                                                    <option value="UY">Uruguay</option>
                                                    <option value="UZ">Uzbekistan</option>
                                                    <option value="VU">Vanuatu</option>
                                                    <option value="VE">Venezuela</option>
                                                    <option value="VN">Viet Nam</option>
                                                    <option value="YE">Yemen</option>
                                                    <option value="ZM">Zambia</option>
                                                    <option value="ZW">Zimbabwe</option>
                                                </select>
                                                <div id="country-error" class="error-message">Country is required.</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="country-code">Country code*</label>
                                                        <select id="country-code" name="country-code" required>
                                                            <option value="" selected disabled hidden>Select country code</option>
                                                            <option value="Afghanistan">+93 (Afghanistan)</option>
                                                            <option value="Albania">+355 (Albania)</option>
                                                            <option value="Algeria">+213 (Algeria)</option>
                                                            <option value="Andorra">+376 (Andorra)</option>
                                                            <option value="Angola">+244 (Angola)</option>
                                                            <option value="Antigua and Barbuda">+1-268 (Antigua and Barbuda)</option>
                                                            <option value="Argentina">+54 (Argentina)</option>
                                                            <option value="Armenia">+374 (Armenia)</option>
                                                            <option value="Australia">+61 (Australia)</option>
                                                            <option value="Austria">+43 (Austria)</option>
                                                            <option value="Azerbaijan">+994 (Azerbaijan)</option>
                                                            <option value="Bahamas">+1-242 (Bahamas)</option>
                                                            <option value="Bahrain">+973 (Bahrain)</option>
                                                            <option value="Bangladesh">+880 (Bangladesh)</option>
                                                            <option value="Barbados">+1-246 (Barbados)</option>
                                                            <option value="Belarus">+375 (Belarus)</option>
                                                            <option value="Belgium">+32 (Belgium)</option>
                                                            <option value="Belize">+501 (Belize)</option>
                                                            <option value="Benin">+229 (Benin)</option>
                                                            <option value="Bhutan">+975 (Bhutan)</option>
                                                            <option value="Bolivia">+591 (Bolivia)</option>
                                                            <option value="Bosnia and Herzegovina">+387 (Bosnia and Herzegovina)</option>
                                                            <option value="Botswana">+267 (Botswana)</option>
                                                            <option value="Brazil">+55 (Brazil)</option>
                                                            <option value="Brunei">+673 (Brunei)</option>
                                                            <option value="Bulgaria">+359 (Bulgaria)</option>
                                                            <option value="Burkina Faso">+226 (Burkina Faso)</option>
                                                            <option value="Burundi">+257 (Burundi)</option>
                                                            <option value="Cabo Verde">+238 (Cabo Verde)</option>
                                                            <option value="Cambodia">+855 (Cambodia)</option>
                                                            <option value="Cameroon">+237 (Cameroon)</option>
                                                            <option value="Canada">+1 (Canada)</option>
                                                            <option value="Central African Republic">+236 (Central African Republic)</option>
                                                            <option value="Chad">+235 (Chad)</option>
                                                            <option value="Chile">+56 (Chile)</option>
                                                            <option value="China">+86 (China)</option>
                                                            <option value="Colombia">+57 (Colombia)</option>
                                                            <option value="Comoros">+269 (Comoros)</option>
                                                            <option value="Congo, Democratic Republic of the">+243 (Congo, Democratic Republic of the)</option>
                                                            <option value="Congo, Republic of the">+242 (Congo, Republic of the)</option>
                                                            <option value="Costa Rica">+506 (Costa Rica)</option>
                                                            <option value="Croatia">+385 (Croatia)</option>
                                                            <option value="Cuba">+53 (Cuba)</option>
                                                            <option value="Cyprus">+357 (Cyprus)</option>
                                                            <option value="Czech Republic">+420 (Czech Republic)</option>
                                                            <option value="Denmark">+45 (Denmark)</option>
                                                            <option value="Djibouti">+253 (Djibouti)</option>
                                                            <option value="Dominica">+1-767 (Dominica)</option>
                                                            <option value="Dominican Republic">+1-809 (Dominican Republic)</option>
                                                            <option value="Ecuador">+593 (Ecuador)</option>
                                                            <option value="Egypt">+20 (Egypt)</option>
                                                            <option value="El Salvador">+503 (El Salvador)</option>
                                                            <option value="Equatorial Guinea">+240 (Equatorial Guinea)</option>
                                                            <option value="Eritrea">+291 (Eritrea)</option>
                                                            <option value="Estonia">+372 (Estonia)</option>
                                                            <option value="Eswatini">+268 (Eswatini)</option>
                                                            <option value="Ethiopia">+251 (Ethiopia)</option>
                                                            <option value="Fiji">+679 (Fiji)</option>
                                                            <option value="Finland">+358 (Finland)</option>
                                                            <option value="France">+33 (France)</option>
                                                            <option value="Gabon">+241 (Gabon)</option>
                                                            <option value="Gambia">+220 (Gambia)</option>
                                                            <option value="Georgia">+995 (Georgia)</option>
                                                            <option value="Germany">+49 (Germany)</option>
                                                            <option value="Ghana">+233 (Ghana)</option>
                                                            <option value="Greece">+30 (Greece)</option>
                                                            <option value="Grenada">+1-473 (Grenada)</option>
                                                            <option value="Guatemala">+502 (Guatemala)</option>
                                                            <option value="Guinea">+224 (Guinea)</option>
                                                            <option value="Guinea-Bissau">+245 (Guinea-Bissau)</option>
                                                            <option value="Guyana">+592 (Guyana)</option>
                                                            <option value="Haiti">+509 (Haiti)</option>
                                                            <option value="Honduras">+504 (Honduras)</option>
                                                            <option value="Hungary">+36 (Hungary)</option>
                                                            <option value="Iceland">+354 (Iceland)</option>
                                                            <option value="India">+91 (India)</option>
                                                            <option value="Indonesia">+62 (Indonesia)</option>
                                                            <option value="Iran">+98 (Iran)</option>
                                                            <option value="Iraq">+964 (Iraq)</option>
                                                            <option value="Ireland">+353 (Ireland)</option>
                                                            <option value="Israel">+972 (Israel)</option>
                                                            <option value="Italy">+39 (Italy)</option>
                                                            <option value="Jamaica">+1-876 (Jamaica)</option>
                                                            <option value="Japan">+81 (Japan)</option>
                                                            <option value="Jordan">+962 (Jordan)</option>
                                                            <option value="Kazakhstan">+7 (Kazakhstan)</option>
                                                            <option value="Kenya">+254 (Kenya)</option>
                                                            <option value="Kiribati">+686 (Kiribati)</option>
                                                            <option value="Korea, North">+850 (Korea, North)</option>
                                                            <option value="Korea, South">+82 (Korea, South)</option>
                                                            <option value="Kuwait">+965 (Kuwait)</option>
                                                            <option value="Kyrgyzstan">+996 (Kyrgyzstan)</option>
                                                            <option value="Laos">+856 (Laos)</option>
                                                            <option value="Latvia">+371 (Latvia)</option>
                                                            <option value="Lebanon">+961 (Lebanon)</option>
                                                            <option value="Lesotho">+266 (Lesotho)</option>
                                                            <option value="Liberia">+231 (Liberia)</option>
                                                            <option value="Libya">+218 (Libya)</option>
                                                            <option value="Liechtenstein">+423 (Liechtenstein)</option>
                                                            <option value="Lithuania">+370 (Lithuania)</option>
                                                            <option value="Luxembourg">+352 (Luxembourg)</option>
                                                            <option value="Madagascar">+261 (Madagascar)</option>
                                                            <option value="Malawi">+265 (Malawi)</option>
                                                            <option value="Malaysia">+60 (Malaysia)</option>
                                                            <option value="Maldives">+960 (Maldives)</option>
                                                            <option value="Mali">+223 (Mali)</option>
                                                            <option value="Malta">+356 (Malta)</option>
                                                            <option value="Marshall Islands">+692 (Marshall Islands)</option>
                                                            <option value="Mauritania">+222 (Mauritania)</option>
                                                            <option value="Mauritius">+230 (Mauritius)</option>
                                                            <option value="Mexico">+52 (Mexico)</option>
                                                            <option value="Micronesia">+691 (Micronesia)</option>
                                                            <option value="Moldova">+373 (Moldova)</option>
                                                            <option value="Monaco">+377 (Monaco)</option>
                                                            <option value="Mongolia">+976 (Mongolia)</option>
                                                            <option value="Montenegro">+382 (Montenegro)</option>
                                                            <option value="Morocco">+212 (Morocco)</option>
                                                            <option value="Mozambique">+258 (Mozambique)</option>
                                                            <option value="Myanmar">+95 (Myanmar)</option>
                                                            <option value="Namibia">+264 (Namibia)</option>
                                                            <option value="Nauru">+674 (Nauru)</option>
                                                            <option value="Nepal">+977 (Nepal)</option>
                                                            <option value="Netherlands">+31 (Netherlands)</option>
                                                            <option value="New Zealand">+64 (New Zealand)</option>
                                                            <option value="Nicaragua">+505 (Nicaragua)</option>
                                                            <option value="Niger">+227 (Niger)</option>
                                                            <option value="Nigeria">+234 (Nigeria)</option>
                                                            <option value="North Macedonia">+389 (North Macedonia)</option>
                                                            <option value="Norway">+47 (Norway)</option>
                                                            <option value="Oman">+968 (Oman)</option>
                                                            <option value="Pakistan">+92 (Pakistan)</option>
                                                            <option value="Palau">+680 (Palau)</option>
                                                            <option value="Palestine, State of">+970 (Palestine, State of)</option>
                                                            <option value="Panama">+507 (Panama)</option>
                                                            <option value="Papua New Guinea">+675 (Papua New Guinea)</option>
                                                            <option value="Paraguay">+595 (Paraguay)</option>
                                                            <option value="Peru">+51 (Peru)</option>
                                                            <option value="Philippines">+63 (Philippines)</option>
                                                            <option value="Poland">+48 (Poland)</option>
                                                            <option value="Portugal">+351 (Portugal)</option>
                                                            <option value="Qatar">+974 (Qatar)</option>
                                                            <option value="Romania">+40 (Romania)</option>
                                                            <option value="Russia">+7 (Russia)</option>
                                                            <option value="Rwanda">+250 (Rwanda)</option>
                                                            <option value="Saint Kitts and Nevis">+1-869 (Saint Kitts and Nevis)</option>
                                                            <option value="Saint Lucia">+1-758 (Saint Lucia)</option>
                                                            <option value="Saint Vincent and the Grenadines">+1-784 (Saint Vincent and the Grenadines)</option>
                                                            <option value="Samoa">+685 (Samoa)</option>
                                                            <option value="San Marino">+378 (San Marino)</option>
                                                            <option value="Sao Tome and Principe">+239 (Sao Tome and Principe)</option>
                                                            <option value="Saudi Arabia">+966 (Saudi Arabia)</option>
                                                            <option value="Senegal">+221 (Senegal)</option>
                                                            <option value="Serbia">+381 (Serbia)</option>
                                                            <option value="Seychelles">+248 (Seychelles)</option>
                                                            <option value="Sierra Leone">+232 (Sierra Leone)</option>
                                                            <option value="Singapore">+65 (Singapore)</option>
                                                            <option value="Slovakia">+421 (Slovakia)</option>
                                                            <option value="Slovenia">+386 (Slovenia)</option>
                                                            <option value="Solomon Islands">+677 (Solomon Islands)</option>
                                                            <option value="Somalia">+252 (Somalia)</option>
                                                            <option value="South Africa">+27 (South Africa)</option>
                                                            <option value="South Sudan">+211 (South Sudan)</option>
                                                            <option value="Spain">+34 (Spain)</option>
                                                            <option value="Sri Lanka">+94 (Sri Lanka)</option>
                                                            <option value="Sudan">+249 (Sudan)</option>
                                                            <option value="Suriname">+597 (Suriname)</option>
                                                            <option value="Sweden">+46 (Sweden)</option>
                                                            <option value="Switzerland">+41 (Switzerland)</option>
                                                            <option value="Syria">+963 (Syria)</option>
                                                            <option value="Taiwan">+886 (Taiwan)</option>
                                                            <option value="Tajikistan">+992 (Tajikistan)</option>
                                                            <option value="Tanzania">+255 (Tanzania)</option>
                                                            <option value="Thailand">+66 (Thailand)</option>
                                                            <option value="Timor-Leste">+670 (Timor-Leste)</option>
                                                            <option value="Togo">+228 (Togo)</option>
                                                            <option value="Tonga">+676 (Tonga)</option>
                                                            <option value="Trinidad and Tobago">+1-868 (Trinidad and Tobago)</option>
                                                            <option value="Tunisia">+216 (Tunisia)</option>
                                                            <option value="Turkey">+90 (Turkey)</option>
                                                            <option value="Turkmenistan">+993 (Turkmenistan)</option>
                                                            <option value="Tuvalu">+688 (Tuvalu)</option>
                                                            <option value="Uganda">+256 (Uganda)</option>
                                                            <option value="Ukraine">+380 (Ukraine)</option>
                                                            <option value="United Arab Emirates">+971 (United Arab Emirates)</option>
                                                            <option value="United Kingdom">+44 (United Kingdom)</option>
                                                            <option value="United States">+1 (United States)</option>
                                                            <option value="Uruguay">+598 (Uruguay)</option>
                                                            <option value="Uzbekistan">+998 (Uzbekistan)</option>
                                                            <option value="Vanuatu">+678 (Vanuatu)</option>
                                                            <option value="Vatican City">+379 (Vatican City)</option>
                                                            <option value="Venezuela">+58 (Venezuela)</option>
                                                            <option value="Vietnam">+84 (Vietnam)</option>
                                                            <option value="Yemen">+967 (Yemen)</option>
                                                            <option value="Zambia">+260 (Zambia)</option>
                                                            <option value="Zimbabwe">+263 (Zimbabwe)</option>
                                                        </select>
                                                        <div id="country-code-error" class="error-message">country code is required.</div>
                                                    </div>
                                                    <div class="col-8">
                                                        <label for="phone-number">Phone number*</label>
                                                        <input placeholder="Enter phone number" type="tel" id="phone-number" name="phone-number" required>
                                                        <div id="phone-number-error" class="error-message">Phone no is required.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="email-address">E-mail address*</label>
                                                <input type="email" id="email-address" name="email-address" placeholder="Enter email" required>
                                                <div id="email-address-error" class="error-message">Email address is required.</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="State">State*</label>
                                                <input type="text" id="State" name="State" placeholder="Enter State" required>
                                                <div id="State-error" class="error-message">State is required.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="agents-id">Agents ID</label>
                                                <select id="agents-id" name="agents-id">
                                                    <option value="" selected disabled hidden>Select Agent</option>
                                                    <option value="Kiran">Kiran Dhoke</option>
                                                    <option value="Sriharshan">Sriharshan southranjan</option>
                                                </select>
                                                <div id="agents-id-error" class="error-message">Agents ID is required.</div>
                                            </div>
                                        </div>
                                        <div class="form-note">
                                            <p>* required field</p>
                                        </div>

                                </div>
                                <!-- <div class="d-flex justify-content-end">
                                    <button id="submit_btn" style="background: #ffbb00;width: 20%;font-size: larger;color: #000;font-weight: 700;" class="btn btn-primary" type="submit">Submit -></button>
                                </div> -->
                            </div>
                        </div>

                    </div>

                </div>
                <div style="background-color: #a9a9a991;padding: 40px 0; position:sticky; bottom:0;width:100%;" class="d-flex justify-content-around align-items-center">
                    <p class="m-0"><span style="font-weight: bolder;font-size: x-large;" id="total_flight_price">Total : <span id="update_total"><?php echo $total; ?></span></span></p>
                    <input type="text" name="" id="flight_price" value="<?php echo $base_price;?>" hidden> 
                    <button id="submit_btn" style="background: #ffbb00;width: 20%;font-size: larger;color: #000;font-weight: 700;" class="btn btn-primary" type="submit">Submit -></button>
                </div>
            </form>
        </div>
    <?php else : ?>
        <div class="d-grid justify-content-center align-items-center h-100">
            <h3 class="text-center">Thanks For booking</h3>
            <p class="text-center">Your Order Id : <?php echo $responseData['orderId']; ?></p>
            <script>
                sessionStorage.removeItem('formData');
            </script>
            <?php
            unset($_SESSION['formData']);
            unset($_SESSION['responseData']);
            ?>
        </div>
    <?php endif; ?>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baggageRadios = document.querySelectorAll('input[name="baggage"]');

            // Add event listener to each radio button
            baggageRadios.forEach(function (radio) {
                radio.addEventListener('change', function (event) {
                    // Get the id of the selected radio button
                    const selectedId = event.target.id;

                    // Save the selected radio button id to sessionStorage
                    sessionStorage.setItem('selectedBaggageRadio', selectedId);

                    // Extract the index from the id (e.g., "baggage_1" -> 1)
                    const index = selectedId.split('_')[1];

                    // Construct the input ids using the index
                    const priceInputId = 'price_' + index;
                    const freeTextInputId = 'freeText_' + index;
                    const cityPairInputId = 'cityPair_' + index;
                    let flight_price = document.getElementById('flight_price').value;

                    // Get the values of the inputs
                    const priceValue = document.getElementById(priceInputId).value;
                    const freeTextValue = document.getElementById(freeTextInputId).value;
                    const cityPairValue = document.getElementById(cityPairInputId).value;
                    const final_price = parseFloat(priceValue) + parseFloat(flight_price);
                    document.getElementById("total_flight_price").innerHTML = "Total : " + "$ " + final_price.toFixed(2);

                    // Print the values to the console (for debugging purposes)
                    console.log('Selected price:', priceValue);
                    console.log('Selected freeText:', freeTextValue);  // Log freeTextValue here
                    console.log('Selected cityPair:', cityPairValue);
                    console.log(flight_price);
                    console.log(final_price);

                    var baggageData = {
                        final_price: final_price,
                        freeTextValue: freeTextValue,
                        cityPairValue: cityPairValue
                    };

                    sessionStorage.setItem('baggageData', JSON.stringify(baggageData));
                    console.log("Selected Data Array:", baggageData);

                    // Send data to PHP session using AJAX without reloading the page
                    fetch('managebagage.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ baggage: JSON.stringify(baggageData) })
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        // Optionally, you can update the UI or provide feedback to the user here
                    })
                    .catch(error => console.error('Error:', error));
                });
            });

            // Check the previously selected radio button
            const selectedBaggageRadio = sessionStorage.getItem('selectedBaggageRadio');
            if (selectedBaggageRadio) {
                const radioToCheck = document.getElementById(selectedBaggageRadio);
                if (radioToCheck) {
                    radioToCheck.checked = true;
                    // Manually trigger the change event to update the total price
                    radioToCheck.dispatchEvent(new Event('change'));
                }
            }

            // Populate year dropdowns
            function populateYearDropdowns() {
                const currentYear = new Date().getFullYear();

                for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                    const dobYear = document.getElementById('dob-year-' + i);
                    const idissueyear = document.getElementById('id-issue-year-' + i);
                    const idExpireYear = document.getElementById('id-expire-year-' + i);

                    for (let year = currentYear; year >= 1900; year--) {
                        let option = new Option(year, year);
                        dobYear.add(option);
                    }

                    for (let year = currentYear; year >= 1900; year--) {
                        let option = new Option(year, year);
                        idissueyear.add(option);
                    }

                    for (let year = currentYear; year <= currentYear + 50; year++) {
                        let option = new Option(year, year);
                        idExpireYear.add(option);
                    }
                }
            }

            populateYearDropdowns();

            // Validate fields on input
            const requiredFields = [
                'title', 'first-name', 'last-name',
                'dob-day', 'dob-month', 'dob-year',
                'id-method', 'id-number',
                'id-expire-day', 'id-expire-month', 'id-expire-year',
                'country-issue', 'country-birth', 'phone-number', 'city',
                'zip-code', 'street'
            ];

            for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                requiredFields.forEach(function(field) {
                    const input = document.getElementById(field + '-' + i);
                    if (input) {
                        input.addEventListener('input', function() {
                            validateField(input);
                        });
                    }
                });
            }

            function validateField(input) {
                const errorElement = document.getElementById(input.id + '-error');
                if (input.value === '' || input.value === null) {
                    showError(input, errorElement, 'This field is required.');
                } else if ((input.id.includes('first-name') || input.id.includes('last-name') || input.id.includes('city') || input.id.includes('street')) && /\d/.test(input.value)) {
                    showError(input, errorElement, 'This field should not contain numbers.');
                } else if ((input.id.includes('id-number') || input.id.includes('zip-code') || input.id.includes('phone-number') || input.id.includes('emergency_phone-number')) && /\D/.test(input.value)) {
                    showError(input, errorElement, 'This field should only contain numbers.');
                } else {
                    hideError(input, errorElement);
                }
            }

            function showError(input, errorElement, message) {
                input.style.border = 'red 2px solid';
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }

            function hideError(input, errorElement) {
                input.style.border = '';
                errorElement.style.display = 'none';
            }

            function toggleRequiredAttributes(index, shouldShare) {
                const emergencyFields = [
                    'emergency_country', 'emergency_phone-number', 'emergency_email-address'
                ];

                emergencyFields.forEach(function(field) {
                    const input = document.getElementById(field + '-' + index);
                    if (input) {
                        if (shouldShare) {
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                        }
                    }
                });
            }

            // Validate form on submit
            document.getElementById('passenger-form').addEventListener('submit', function(event) {
                let valid = true;

                for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                    requiredFields.forEach(function(field) {
                        const input = document.getElementById(field + '-' + i);
                        const errorElement = document.getElementById(field + '-' + i + '-error');

                        if (input && (input.value === '' || input.value === null)) {
                            showError(input, errorElement, 'This field is required.');
                            valid = false;
                        } else if (input && (input.id.includes('first-name') || input.id.includes('last-name') || input.id.includes('city') || input.id.includes('street')) && /\d/.test(input.value)) {
                            showError(input, errorElement, 'This field should not contain numbers.');
                            valid = false;
                        } else if (input && (input.id.includes('id-number') || input.id.includes('zip-code') || input.id.includes('phone-number') || input.id.includes('emergency_phone-number')) && /\D/.test(input.value)) {
                            showError(input, errorElement, 'This field should only contain numbers.');
                            valid = false;
                        } else if (input) {
                            hideError(input, errorElement);
                        }
                    });
                }

                if (!valid) {
                    event.preventDefault(); // Prevent form submission if not valid
                }
            });

            function toggleDropdown(index) {
                const shouldShare = $('#share-' + index).is(':checked');
                if (shouldShare) {
                    $('#contact-details-' + index).removeClass('hidden');
                } else {
                    $('#contact-details-' + index).addClass('hidden');
                }
                toggleRequiredAttributes(index, shouldShare);
            }

            $(document).ready(function() {
                for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                    toggleDropdown(i);
                    $('input[name="emergency_contact_' + i + '"]').on('change', function() {
                        toggleDropdown(i);
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('passenger-form');
            form.addEventListener('submit', function() {
                document.getElementById('spinner').style.display = 'flex';
            });
        });
    </script> -->
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baggageRadios = document.querySelectorAll('input[name="baggage"]');

            // Function to update baggage selection
            function updateBaggageSelection(selectedId) {
                const radio = document.getElementById(selectedId);
                const index = selectedId.split('_')[1];
                const freeTextValue = document.getElementById('freeText_' + index).value;
                const cityPairValue = document.getElementById('cityPair_' + index).value;
                const priceValue = document.getElementById('price_' + index).value;
                let flight_price = document.getElementById('flight_price').value;
                const final_price = parseFloat(priceValue) + parseFloat(flight_price);

                const baggageData = {
                    final_price: priceValue,
                    freeTextValue: freeTextValue,
                    cityPairValue: cityPairValue
                };

                // Store the selected baggage data
                let baggageDataArray = JSON.parse(sessionStorage.getItem('baggageData')) || {};
                baggageDataArray[cityPairValue] = baggageData;
                sessionStorage.setItem('baggageData', JSON.stringify(baggageDataArray));

                // Log the selected data for debugging
                console.log("Selected Data Array:", baggageDataArray);

                // Send data to PHP session using AJAX without reloading the page
                fetch('managebagage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ baggage: JSON.stringify(baggageDataArray) })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                })
                .catch(error => console.error('Error:', error));
            }

            // Add event listener to each radio button
            baggageRadios.forEach(function(radio) {
                radio.addEventListener('change', function(event) {
                    const selectedId = event.target.id;

                    // Get the selected freeText value
                    const index = selectedId.split('_')[1];
                    const selectedFreeText = document.getElementById('freeText_' + index).value;

                    // Find and check all radios with the same freeText value
                    baggageRadios.forEach(function(radio) {
                        const radioIndex = radio.id.split('_')[1];
                        const freeTextValue = document.getElementById('freeText_' + radioIndex).value;
                        if (freeTextValue === selectedFreeText) {
                            radio.checked = true;
                            updateBaggageSelection(radio.id);
                        }
                    });

                    // Save the selected radio button id to sessionStorage
                    let selectedBaggageRadios = JSON.parse(sessionStorage.getItem('selectedBaggageRadios')) || {};
                    selectedBaggageRadios[selectedFreeText] = selectedId;
                    sessionStorage.setItem('selectedBaggageRadios', JSON.stringify(selectedBaggageRadios));
                });
            });

            // Check the previously selected radio buttons
            const selectedBaggageRadios = JSON.parse(sessionStorage.getItem('selectedBaggageRadios')) || {};
            Object.keys(selectedBaggageRadios).forEach(freeText => {
                const selectedId = selectedBaggageRadios[freeText];
                const radioToCheck = document.getElementById(selectedId);
                if (radioToCheck) {
                    radioToCheck.checked = true;
                    // Manually trigger the change event to update the total price
                    radioToCheck.dispatchEvent(new Event('change'));
                }
            });

            // Populate year dropdowns
            function populateYearDropdowns() {
                const currentYear = new Date().getFullYear();

                for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                    const dobYear = document.getElementById('dob-year-' + i);
                    const idissueyear = document.getElementById('id-issue-year-' + i);
                    const idExpireYear = document.getElementById('id-expire-year-' + i);

                    for (let year = currentYear; year >= 1900; year--) {
                        let option = new Option(year, year);
                        dobYear.add(option);
                    }

                    for (let year = currentYear; year >= 1900; year--) {
                        let option = new Option(year, year);
                        idissueyear.add(option);
                    }

                    for (let year = currentYear; year <= currentYear + 50; year++) {
                        let option = new Option(year, year);
                        idExpireYear.add(option);
                    }
                }
            }

            populateYearDropdowns();

            // Validate fields on input
            const requiredFields = [
                'title', 'first-name', 'last-name',
                'dob-day', 'dob-month', 'dob-year',
                'id-method', 'id-number',
                'id-expire-day', 'id-expire-month', 'id-expire-year',
                'country-issue', 'country-birth', 'phone-number', 'city',
                'zip-code', 'street'
            ];

            for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                requiredFields.forEach(function(field) {
                    const input = document.getElementById(field + '-' + i);
                    if (input) {
                        input.addEventListener('input', function() {
                            validateField(input);
                        });
                    }
                });
            }

            function validateField(input) {
                const errorElement = document.getElementById(input.id + '-error');
                if (input.value === '' || input.value === null) {
                    showError(input, errorElement, 'This field is required.');
                } else if ((input.id.includes('first-name') || input.id.includes('last-name') || input.id.includes('city') || input.id.includes('street')) && /\d/.test(input.value)) {
                    showError(input, errorElement, 'This field should not contain numbers.');
                } else if ((input.id.includes('id-number') || input.id.includes('zip-code') || input.id.includes('phone-number') || input.id.includes('emergency_phone-number')) && /\D/.test(input.value)) {
                    showError(input, errorElement, 'This field should only contain numbers.');
                } else {
                    hideError(input, errorElement);
                }
            }

            function showError(input, errorElement, message) {
                input.style.border = 'red 2px solid';
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }

            function hideError(input, errorElement) {
                input.style.border = '';
                errorElement.style.display = 'none';
            }

            function toggleRequiredAttributes(index, shouldShare) {
                const emergencyFields = [
                    'emergency_country', 'emergency_phone-number', 'emergency_email-address'
                ];

                emergencyFields.forEach(function(field) {
                    const input = document.getElementById(field + '-' + index);
                    if (input) {
                        if (shouldShare) {
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                        }
                    }
                });
            }

            // Validate form on submit
            document.getElementById('passenger-form').addEventListener('submit', function(event) {
                let valid = true;

                for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                    requiredFields.forEach(function(field) {
                        const input = document.getElementById(field + '-' + i);
                        const errorElement = document.getElementById(field + '-' + i + '-error');

                        if (input && (input.value === '' || input.value === null)) {
                            showError(input, errorElement, 'This field is required.');
                            valid = false;
                        } else if (input && (input.id.includes('first-name') || input.id.includes('last-name') || input.id.includes('city') || input.id.includes('street')) && /\d/.test(input.value)) {
                            showError(input, errorElement, 'This field should not contain numbers.');
                            valid = false;
                        } else if (input && (input.id.includes('id-number') || input.id.includes('zip-code') || input.id.includes('phone-number') || input.id.includes('emergency_phone-number')) && /\D/.test(input.value)) {
                            showError(input, errorElement, 'This field should only contain numbers.');
                            valid = false;
                        } else if (input) {
                            hideError(input, errorElement);
                        }
                    });
                }

                if (!valid) {
                    event.preventDefault(); // Prevent form submission if not valid
                }
            });

            function toggleDropdown(index) {
                const shouldShare = $('#share-' + index).is(':checked');
                if (shouldShare) {
                    $('#contact-details-' + index).removeClass('hidden');
                } else {
                    $('#contact-details-' + index).addClass('hidden');
                }
                toggleRequiredAttributes(index, shouldShare);
            }

            $(document).ready(function() {
                for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                    toggleDropdown(i);
                    $('input[name="emergency_contact_' + i + '"]').on('change', function() {
                        toggleDropdown(i);
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('passenger-form');
            form.addEventListener('submit', function() {
                document.getElementById('spinner').style.display = 'flex';
            });
        });
    </script> -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const baggageRadios = document.querySelectorAll('input[name="baggage"]');
        
        // Function to update the total flight price
        function updateTotalFlightPrice() {
            let flight_price = parseFloat(document.getElementById('flight_price').value);
            let baggageDataArray = JSON.parse(sessionStorage.getItem('baggageData')) || {};
            let baggageTotal = 0;

            Object.values(baggageDataArray).forEach(data => {
                baggageTotal += parseFloat(data.final_price);
            });

            const total = flight_price + baggageTotal;
            document.getElementById("total_flight_price").innerHTML = "Total : " + "$ " + total.toFixed(2);
        }

        // Function to update baggage selection
        function updateBaggageSelection(selectedId) {
            const radio = document.getElementById(selectedId);
            const index = selectedId.split('_')[1];
            const freeTextValue = document.getElementById('freeText_' + index).value;
            const cityPairValue = document.getElementById('cityPair_' + index).value;
            const priceValue = document.getElementById('price_' + index).value;

            const baggageData = {
                final_price: priceValue,
                freeTextValue: freeTextValue,
                cityPairValue: cityPairValue
            };

            // Store the selected baggage data
            let baggageDataArray = JSON.parse(sessionStorage.getItem('baggageData')) || {};
            baggageDataArray[cityPairValue] = baggageData;
            sessionStorage.setItem('baggageData', JSON.stringify(baggageDataArray));

            // Log the selected data for debugging
            console.log("Selected Data Array:", baggageDataArray);

            // Send data to PHP session using AJAX without reloading the page
            fetch('managebagage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ baggage: JSON.stringify(baggageDataArray) })
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            })
            .catch(error => console.error('Error:', error));

            // Update the total flight price
            updateTotalFlightPrice();
        }

        // Add event listener to each radio button
        baggageRadios.forEach(function(radio) {
            radio.addEventListener('change', function(event) {
                const selectedId = event.target.id;

                // Get the selected freeText value
                const index = selectedId.split('_')[1];
                const selectedFreeText = document.getElementById('freeText_' + index).value;

                // Find and check all radios with the same freeText value
                baggageRadios.forEach(function(radio) {
                    const radioIndex = radio.id.split('_')[1];
                    const freeTextValue = document.getElementById('freeText_' + radioIndex).value;
                    if (freeTextValue === selectedFreeText) {
                        radio.checked = true;
                        updateBaggageSelection(radio.id);
                    }
                });

                // Save the selected radio button id to sessionStorage
                let selectedBaggageRadios = JSON.parse(sessionStorage.getItem('selectedBaggageRadios')) || {};
                selectedBaggageRadios[selectedFreeText] = selectedId;
                sessionStorage.setItem('selectedBaggageRadios', JSON.stringify(selectedBaggageRadios));
            });
        });

        // Check the previously selected radio buttons
        const selectedBaggageRadios = JSON.parse(sessionStorage.getItem('selectedBaggageRadios')) || {};
        Object.keys(selectedBaggageRadios).forEach(freeText => {
            const selectedId = selectedBaggageRadios[freeText];
            const radioToCheck = document.getElementById(selectedId);
            if (radioToCheck) {
                radioToCheck.checked = true;
                // Manually trigger the change event to update the total price
                radioToCheck.dispatchEvent(new Event('change'));
            }
        });

        // Populate year dropdowns
        function populateYearDropdowns() {
            const currentYear = new Date().getFullYear();

            for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                const dobYear = document.getElementById('dob-year-' + i);
                const idissueyear = document.getElementById('id-issue-year-' + i);
                const idExpireYear = document.getElementById('id-expire-year-' + i);

                for (let year = currentYear; year >= 1900; year--) {
                    let option = new Option(year, year);
                    dobYear.add(option);
                }

                for (let year = currentYear; year >= 1900; year--) {
                    let option = new Option(year, year);
                    idissueyear.add(option);
                }

                for (let year = currentYear; year <= currentYear + 50; year++) {
                    let option = new Option(year, year);
                    idExpireYear.add(option);
                }
            }
        }

        populateYearDropdowns();

        // Validate fields on input
        const requiredFields = [
            'title', 'first-name', 'last-name',
            'dob-day', 'dob-month', 'dob-year',
            'id-method', 'id-number',
            'id-expire-day', 'id-expire-month', 'id-expire-year',
            'country-issue', 'country-birth', 'phone-number', 'city',
            'zip-code', 'street'
        ];

        for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
            requiredFields.forEach(function(field) {
                const input = document.getElementById(field + '-' + i);
                if (input) {
                    input.addEventListener('input', function() {
                        validateField(input);
                    });
                }
            });
        }

        function validateField(input) {
            const errorElement = document.getElementById(input.id + '-error');
            if (input.value === '' || input.value === null) {
                showError(input, errorElement, 'This field is required.');
            } else if ((input.id.includes('first-name') || input.id.includes('last-name') || input.id.includes('city') || input.id.includes('street')) && /\d/.test(input.value)) {
                showError(input, errorElement, 'This field should not contain numbers.');
            } else if ((input.id.includes('id-number') || input.id.includes('zip-code') || input.id.includes('phone-number') || input.id.includes('emergency_phone-number')) && /\D/.test(input.value)) {
                showError(input, errorElement, 'This field should only contain numbers.');
            } else {
                hideError(input, errorElement);
            }
        }

        function showError(input, errorElement, message) {
            input.style.border = 'red 2px solid';
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        function hideError(input, errorElement) {
            input.style.border = '';
            errorElement.style.display = 'none';
        }

        function toggleRequiredAttributes(index, shouldShare) {
            const emergencyFields = [
                'emergency_country', 'emergency_phone-number', 'emergency_email-address'
            ];

            emergencyFields.forEach(function(field) {
                const input = document.getElementById(field + '-' + index);
                if (input) {
                    if (shouldShare) {
                        input.setAttribute('required', 'required');
                    } else {
                        input.removeAttribute('required');
                    }
                }
            });
        }

        // Validate form on submit
        document.getElementById('passenger-form').addEventListener('submit', function(event) {
            let valid = true;

            for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                requiredFields.forEach(function(field) {
                    const input = document.getElementById(field + '-' + i);
                    const errorElement = document.getElementById(field + '-' + i + '-error');

                    if (input && (input.value === '' || input.value === null)) {
                        showError(input, errorElement, 'This field is required.');
                        valid = false;
                    } else if (input && (input.id.includes('first-name') || input.id.includes('last-name') || input.id.includes('city') || input.id.includes('street')) && /\d/.test(input.value)) {
                        showError(input, errorElement, 'This field should not contain numbers.');
                        valid = false;
                    } else if (input && (input.id.includes('id-number') || input.id.includes('zip-code') || input.id.includes('phone-number') || input.id.includes('emergency_phone-number')) && /\D/.test(input.value)) {
                        showError(input, errorElement, 'This field should only contain numbers.');
                        valid = false;
                    } else if (input) {
                        hideError(input, errorElement);
                    }
                });
            }

            if (!valid) {
                event.preventDefault(); // Prevent form submission if not valid
            }
        });

        function toggleDropdown(index) {
            const shouldShare = $('#share-' + index).is(':checked');
            if (shouldShare) {
                $('#contact-details-' + index).removeClass('hidden');
            } else {
                $('#contact-details-' + index).addClass('hidden');
            }
            toggleRequiredAttributes(index, shouldShare);
        }

        $(document).ready(function() {
            for (let i = 0; i < <?php echo $passengers_count; ?>; i++) {
                toggleDropdown(i);
                $('input[name="emergency_contact_' + i + '"]').on('change', function() {
                    toggleDropdown(i);
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('passenger-form');
        form.addEventListener('submit', function() {
            document.getElementById('spinner').style.display = 'flex';
        });
    });
</script>

<!-- Update Total Flight Price on Load -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalFlightPrice();
    });
</script>
</body>
</html>