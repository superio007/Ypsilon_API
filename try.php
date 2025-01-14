<?php

$curl = curl_init();
$depDate = "2025-02-24";
$depApt = "MEL";
$dstApt = "DEL";
$returnDate = "2025-02-26";

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => "<?xml version='1.0' encoding='UTF-8'?><fareRequest xmlns:shared=\"http://ypsilon.net/shared\" da=\"true\"><vcrs><vcr>SQ</vcr></vcrs><alliances/><shared:fareTypes/><tourOps/><flights><flight depDate=\"2025-01-16\" dstApt=\"MEL\" depApt=\"DEL\"/><flight depDate=\"2025-02-20\" dstApt=\"DEL\" depApt=\"MEL\"/></flights><paxes><pax gender=\"M\" surname=\"Klenz\" firstname=\"Hans A ADT\" dob=\"1970-12-12\"/></paxes><paxTypes/><options><limit>1</limit><offset>0</offset><vcrSummary>false</vcrSummary><waitOnList><waitOn>ALL</waitOn></waitOnList></options><coses><cos>E</cos></coses><agentCodes><agentCode>gaura</agentCode></agentCodes><directFareConsos><directFareConso>gaura</directFareConso></directFareConsos></fareRequest>",
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

$response = curl_exec($curl);

// Error handling
if (curl_errno($curl)) {
    echo 'cURL Error: ' . curl_error($curl);
} else {
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    echo "HTTP Code: $httpCode\n";
    var_dump($response);
}

curl_close($curl);
