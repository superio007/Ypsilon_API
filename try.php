<?php

$curl = curl_init();

$bookingRequestXml = '<?xml version="1.0" encoding="UTF-8"?>
<bookingRequest tarifId="292352902_292352903">
    <billing businessPhone="123123123" cellPhone="123123123"
    company="Test Company" country="DE" email="tester@testcompany.net"
    fax="45674576" surname="Tester" firstname="John" gender="M"
    dob="1945-12-12" location="testcity" phone="98989898"
    street="teststreet" houseNo="6" zipcode="232323"/>
    <delivery type="NORMAL"/>
    <flightIds>
        <flightId>425669380</flightId>
        <flightId>425669382</flightId>
    </flightIds>
    <paxes>
        <pax dob="1945-12-12" surname="Tester" firstname="John"
        gender="M" tci="false"/>
        <pax dob="1945-12-12" surname="Tester" firstname="Jane"
        gender="F" tci="false"/>
    </paxes>
    <payment>
        <cc ccNo="1234567890123456" ccCvcCode="1234" ccOwner="John Tester" 
        ccVldDate="2006-06-30" ccType="VI"/>
    </payment>
    <remarks/>
    <osiRemarks/>
    <addServices/>
    <owOptions/>
</bookingRequest>';

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816', // Replace with your actual API endpoint
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $bookingRequestXml,
    CURLOPT_HTTPHEADER => array(
        'accept: application/xml',
        'accept-encoding: gzip',
        'api-version: 3.92',
        'accessmode: agency',
        'accessid: gaura gaura',
        'authmode: pwd',
        'authorization: Basic c2hlbGx0ZWNoOjRlNDllOTAxMGZhYzA1NzEzN2VjOWQ0NWZjNTFmNDdh',
        'content-Length: ' . strlen($bookingRequestXml),
        'Connection: close',
        'Content-Type: text/plain'
    ),
));

$response = curl_exec($curl);

curl_close($curl);

// Output the response from the API
echo $response;
