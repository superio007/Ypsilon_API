<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://xmlapiv3.ypsilon.net:10816',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'<?xml version=\'1.0\' encoding=\'UTF-8\'?><fareRequest xmlns:shared="http://ypsilon.net/shared" da="true"><vcrs><vcr>QF</vcr></vcrs><alliances/><shared:fareTypes/><tourOps/><flights><flight depDate="2025-02-12" dstApt="DEL" depApt="MEL"/></flights><paxes><pax gender="M" surname="Klenz" firstname="Hans A ADT" dob="1945-12-12"/></paxes><paxTypes/><options><limit>20</limit><offset>0</offset><vcrSummary>false</vcrSummary><waitOnList><waitOn>ALL</waitOn></waitOnList></options><coses/></fareRequest>',
  CURLOPT_HTTPHEADER => array(
    'accept: application/xml',
    'accept-encoding: gzip',
    'api-version: 3.92',
    'accessmode: agency',
    'accessid: gaura gaura',
    'authmode: pwd',
    'authorization: Basic c2hlbGx0ZWNoOjRlNDllOTAxMGZhYzA1NzEzN2VjOWQ0NWZjNTFmNDdh',
    'Content-Type: application/xml',
  ),
));

$response = curl_exec($curl);

if (curl_errno($curl)) {
  echo 'Error:' . curl_error($curl);
} else {
  // Extract Session ID from response headers
  $headers = curl_getinfo($curl, CURLINFO_HEADER_OUT);
  $sessionId = extractSessionId($headers); // You need to implement this extraction logic
  echo "Session ID: $sessionId";
}

curl_close($curl);
