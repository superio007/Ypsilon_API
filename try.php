<?php
session_start();
var_dump($_SESSION['responseData']);

$bookingRequestPayload = <<<XML
<?xml version='1.0' encoding='UTF-8'?>
<bookingRequest tarifId="1079508631" allTermsAccepted="true">
    <billing businessPhone="123123123" cellPhone="123123123"
        company="Test Company" country="DE" email="tester@testcompany.net"
        fax="45674576" surname="Tester" firstname="John" gender="M"
        dob="1945-12-12" location="testcity" phone="98989898"
        street="teststreet" houseNo="6" zipcode="232323"/>
    <delivery type="NORMAL"/>
    <shared:flightIds xmlns:shared="http://ypsilon.net/shared">
        <shared:flightId>1257802989</shared:flightId>
        <shared:flightId>241071041</shared:flightId>
    </shared:flightIds>
    <paxes>
        <pax dob="1945-12-12" surname="Tester" firstname="John"
            gender="M" tci="false"/>
        <pax dob="1945-12-12" surname="Tester" firstname="Jane"
            gender="F" tci="false"/>
    </paxes>
    <payment>
        <cc ccNo="1234567890123456" ccCvcCode="123" ccOwner="John Tester"
            ccVldDate="2026-06-30" ccType="VI"/>
    </payment>
    <remarks/>
    <osiRemarks/>
    <addServices/>
    <owOptions/>
</bookingRequest>
XML;

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '', // Automatically handles gzip, deflate, etc.
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $bookingRequestPayload,
    CURLOPT_HTTPHEADER => array(
        'accept: application/xml',
        'accept-encoding: gzip, deflate', // Request server to send compressed data
        'api-version: 3.92',
        'accessmode: agency',
        'accessid: gaura gaura',
        'authmode: pwd',
        'authorization: Basic c2hlbGx0ZWNoOjRlNDllOTAxMGZhYzA1NzEzN2VjOWQ0NWZjNTFmNDdh',
        'Session: d10201f5chkjwz5f8y3axwyg0yip7y', // Replace with a valid session ID
        'Content-Length: ' . strlen($bookingRequestPayload),
        'Connection: close',
        'Content-Type: application/xml',
    ),
));


$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
} else {
    echo 'Response:' . $response;
}

curl_close($curl);
