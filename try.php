<?php
// Function to search and extract leg details
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
        if (isset($leg['@attributes']['legId']) && $leg['@attributes']['legId'] == $searchLegId
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


$responseData = '
<availResponse xmlns:shared="http://ypsilon.net/shared" cntTarifs="15" offset="0">
    <fares>
        <fare fareId="1418816033" shared:fareType="PUB" class="Q" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">QSBLAO</fareBase>
                <fareBase shared:pax="CHD">QSBLAO</fareBase>
                <fareBase shared:pax="INF">QSBLAO</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816039" shared:fareType="PUB" class="S" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">SVAAO</fareBase>
                <fareBase shared:pax="CHD">SVAAO</fareBase>
                <fareBase shared:pax="INF">SVAAO</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816034" shared:fareType="CPN" class="S" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" corporateCode="QFV11" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">SBLAOUQV</fareBase>
                <fareBase shared:pax="CHD">SBLAOUQV</fareBase>
                <fareBase shared:pax="INF">SBLAOUQV</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816043" shared:fareType="PUB" class="S" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">QIQW</fareBase>
                <fareBase shared:pax="CHD">QIQW</fareBase>
                <fareBase shared:pax="INF">QIQW</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816044" shared:fareType="PUB" class="S" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">QIQW</fareBase>
                <fareBase shared:pax="CHD">QIQW</fareBase>
                <fareBase shared:pax="INF">QIQW</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816045" shared:fareType="PUB" class="Q" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">QIQW</fareBase>
                <fareBase shared:pax="CHD">QIQW</fareBase>
                <fareBase shared:pax="INF">QIQW</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816040" shared:fareType="PUB" class="H" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">HVAAO</fareBase>
                <fareBase shared:pax="CHD">HVAAO</fareBase>
                <fareBase shared:pax="INF">HVAAO</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816035" shared:fareType="CPN" class="H" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" corporateCode="QFV11" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">HBLAOUQV</fareBase>
                <fareBase shared:pax="CHD">HBLAOUQV</fareBase>
                <fareBase shared:pax="INF">HBLAOUQV</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816036" shared:fareType="CPN" class="I" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="B" yyFare="false" ticketTimelimit="2025-01-04" date="2025-02-12" corporateCode="QFV11" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">IBLAOUQV</fareBase>
                <fareBase shared:pax="CHD">IBLAOUQV</fareBase>
                <fareBase shared:pax="INF">IBLAOUQV</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816041" shared:fareType="PUB" class="D" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="B" yyFare="false" ticketTimelimit="2025-01-13" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">DVAAO</fareBase>
                <fareBase shared:pax="CHD">DVAAO</fareBase>
                <fareBase shared:pax="INF">DVAAO</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816037" shared:fareType="CPN" class="D" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="B" yyFare="false" ticketTimelimit="2025-01-13" date="2025-02-12" corporateCode="QFV11" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">DBLAOUQV</fareBase>
                <fareBase shared:pax="CHD">DBLAOUQV</fareBase>
                <fareBase shared:pax="INF">DBLAOUQV</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816042" shared:fareType="PUB" class="C" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="B" yyFare="false" ticketTimelimit="2025-01-13" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">CVAAO</fareBase>
                <fareBase shared:pax="CHD">CVAAO</fareBase>
                <fareBase shared:pax="INF">CVAAO</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816038" shared:fareType="CPN" class="C" depApt="MEL" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="B" yyFare="false" ticketTimelimit="2025-01-13" date="2025-02-12" corporateCode="QFV11" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">CBLAOUQV</fareBase>
                <fareBase shared:pax="CHD">CBLAOUQV</fareBase>
                <fareBase shared:pax="INF">CBLAOUQV</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816046" shared:fareType="PUB" class="Y" depApt="AVV" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">YOW</fareBase>
                <fareBase shared:pax="CHD">YOW</fareBase>
                <fareBase shared:pax="INF">YOW</fareBase>
            </fareBases>
        </fare>
        <fare fareId="1418816047" shared:fareType="PUB" class="Y" depApt="AVV" dstApt="DEL" paxType="ADT" shared:vcr="QF" cos="E" yyFare="false" ticketTimelimit="2024-12-28" date="2025-02-12" dfcConso="gaura" dfcAgent="gaura">
            <fareBases>
                <fareBase shared:pax="ADT">YOW</fareBase>
                <fareBase shared:pax="CHD">YOW</fareBase>
                <fareBase shared:pax="INF">YOW</fareBase>
            </fareBases>
        </fare>
    </fares>
    <tarifs shared:currency="AUD">
        <tarif tarifId="1418816033" adtBuy="674.0" adtSell="734.0" chdBuy="674.0" chdSell="734.0" infBuy="674.0" infSell="734.0" adtTax="147.74" chdTax="147.74" infTax="147.74" refundable="false" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECSL,ECSL,ECSL">
            <fareXRefs>
                <fareXRef fareId="1418816033">
                    <flights>
                        <flight flightId="232443201" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221435" legId="1565794488" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221436" legId="1565794489" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221437" legId="1565794490" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443202" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221438" legId="1565794491" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221439" legId="1565794492" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221440" legId="1565794493" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443203" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221441" legId="1565794494" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221442" legId="1565794495" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221443" legId="1565794496" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443204" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221444" legId="1565794497" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221445" legId="1565794498" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221446" legId="1565794499" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443205" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221447" legId="1565794500" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221448" legId="1565794501" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221449" legId="1565794502" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443206" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221450" legId="1565794503" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221451" legId="1565794504" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221452" legId="1565794505" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443207" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221453" legId="1565794506" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221454" legId="1565794507" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221455" legId="1565794509" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443208" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221456" legId="1565794510" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221457" legId="1565794511" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221458" legId="1565794512" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443209" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221459" legId="1565794513" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221460" legId="1565794514" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221461" legId="1565794515" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443210" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221462" legId="1565794516" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221463" legId="1565794517" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221464" legId="1565794518" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443211" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221465" legId="1565794519" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221466" legId="1565794520" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221467" legId="1565794521" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443212" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221468" legId="1565794522" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221469" legId="1565794523" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221470" legId="1565794524" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443213" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221471" legId="1565794525" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221472" legId="1565794526" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221473" legId="1565794527" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443214" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221474" legId="1565794528" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221475" legId="1565794529" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                                <legXRef legXRefId="91561221476" legId="1565794530" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="QSBLAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816039" adtBuy="845.0" adtSell="905.0" chdBuy="845.0" chdSell="905.0" infBuy="845.0" infSell="905.0" adtTax="115.39" chdTax="115.39" infTax="115.39" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECSV,ECSV">
            <fareXRefs>
                <fareXRef fareId="1418816039">
                    <flights>
                        <flight flightId="232443287" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221687" legId="1565794784" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221688" legId="1565794785" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443288" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221689" legId="1565794786" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221690" legId="1565794787" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816034" adtBuy="875.0" adtSell="935.0" chdBuy="875.0" chdSell="935.0" infBuy="875.0" infSell="935.0" adtTax="147.74" chdTax="147.74" infTax="147.74" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECSV,ECSV,ECSV">
            <fareXRefs>
                <fareXRef fareId="1418816034">
                    <flights>
                        <flight flightId="232443215" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221477" legId="1565794531" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221478" legId="1565794532" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221479" legId="1565794533" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443216" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221480" legId="1565794534" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221481" legId="1565794536" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221482" legId="1565794537" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443217" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221483" legId="1565794538" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221484" legId="1565794539" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221485" legId="1565794540" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443218" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221486" legId="1565794541" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221487" legId="1565794542" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221488" legId="1565794543" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443219" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221489" legId="1565794544" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221490" legId="1565794545" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221491" legId="1565794546" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443220" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221492" legId="1565794547" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221493" legId="1565794548" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221494" legId="1565794549" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443221" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221495" legId="1565794550" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221496" legId="1565794551" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221497" legId="1565794553" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443222" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221498" legId="1565794554" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221499" legId="1565794555" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221500" legId="1565794556" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443223" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221501" legId="1565794557" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221502" legId="1565794558" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221503" legId="1565794559" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443224" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221504" legId="1565794560" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221505" legId="1565794561" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221506" legId="1565794562" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443225" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221507" legId="1565794563" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221508" legId="1565794564" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221509" legId="1565794565" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443226" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221510" legId="1565794566" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221511" legId="1565794567" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221512" legId="1565794568" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443227" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221513" legId="1565794569" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221514" legId="1565794570" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221515" legId="1565794571" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443228" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221516" legId="1565794572" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221517" legId="1565794573" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221518" legId="1565794574" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="SBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816043" adtBuy="1039.0" adtSell="1099.0" chdBuy="1039.0" chdSell="1099.0" infBuy="1039.0" infSell="1099.0" adtTax="158.44" chdTax="158.44" infTax="158.44" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="EDEAL,ECSV,ECSV">
            <fareXRefs>
                <fareXRef fareId="1418816043">
                    <flights>
                        <flight flightId="232443295" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221703" legId="1565794800" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221704" legId="1565794801" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221705" legId="1565794802" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443296" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221706" legId="1565794803" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221707" legId="1565794804" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221708" legId="1565794805" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443297" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221709" legId="1565794806" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221710" legId="1565794807" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221711" legId="1565794808" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443298" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221712" legId="1565794809" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221713" legId="1565794810" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221714" legId="1565794811" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443299" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221715" legId="1565794812" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221716" legId="1565794813" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221717" legId="1565794814" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816044" adtBuy="1069.0" adtSell="1129.0" chdBuy="1069.0" chdSell="1129.0" infBuy="1069.0" infSell="1129.0" adtTax="149.88" chdTax="149.88" infTax="149.88" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="EDEAL,ECSV,ECSV">
            <fareXRefs>
                <fareXRef fareId="1418816044">
                    <flights>
                        <flight flightId="232443300" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221718" legId="1565794815" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221719" legId="1565794816" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221720" legId="1565794817" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816045" adtBuy="1216.0" adtSell="1276.0" chdBuy="1216.0" chdSell="1276.0" infBuy="1216.0" infSell="1276.0" adtTax="132.44" chdTax="132.44" infTax="132.44" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="EDEAL,ECSV,ECSV">
            <fareXRefs>
                <fareXRef fareId="1418816045">
                    <flights>
                        <flight flightId="232443301" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221721" legId="1565794818" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="QIQW" seats="9"/>
                                <legXRef legXRefId="91561221722" legId="1565794819" class="S" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                                <legXRef legXRefId="91561221723" legId="1565794820" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="SVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816040" adtBuy="1755.0" adtSell="1815.0" chdBuy="1755.0" chdSell="1815.0" infBuy="1755.0" infSell="1815.0" adtTax="115.39" chdTax="115.39" infTax="115.39" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECFL,ECFL">
            <fareXRefs>
                <fareXRef fareId="1418816040">
                    <flights>
                        <flight flightId="232443289" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221691" legId="1565794788" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HVAAO" seats="9"/>
                                <legXRef legXRefId="91561221692" legId="1565794789" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="HVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443290" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221693" legId="1565794790" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HVAAO" seats="9"/>
                                <legXRef legXRefId="91561221694" legId="1565794791" class="Q" cos="E" cosDescription="ECONOMY" fareBaseAdt="HVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816035" adtBuy="1787.0" adtSell="1847.0" chdBuy="1787.0" chdSell="1847.0" infBuy="1787.0" infSell="1847.0" adtTax="147.74" chdTax="147.74" infTax="147.74" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECFL,ECFL,ECFL">
            <fareXRefs>
                <fareXRef fareId="1418816035">
                    <flights>
                        <flight flightId="232443229" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221519" legId="1565794575" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221520" legId="1565794576" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221521" legId="1565794577" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443230" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221522" legId="1565794578" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221523" legId="1565794579" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221524" legId="1565794580" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443231" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221525" legId="1565794581" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221526" legId="1565794582" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221527" legId="1565794583" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443232" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221528" legId="1565794584" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221529" legId="1565794585" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221530" legId="1565794586" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443233" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221531" legId="1565794587" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221532" legId="1565794588" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221533" legId="1565794589" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443234" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221534" legId="1565794591" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221535" legId="1565794624" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221536" legId="1565794625" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443236" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221537" legId="1565794626" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221538" legId="1565794627" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221539" legId="1565794628" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443237" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221540" legId="1565794629" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221541" legId="1565794630" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221542" legId="1565794631" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443238" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221543" legId="1565794632" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221544" legId="1565794633" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221545" legId="1565794634" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443239" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221546" legId="1565794635" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221547" legId="1565794636" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221548" legId="1565794637" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443240" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221549" legId="1565794639" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221550" legId="1565794640" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221551" legId="1565794641" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443241" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221552" legId="1565794642" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221553" legId="1565794643" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221554" legId="1565794644" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443242" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221555" legId="1565794645" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221556" legId="1565794646" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221557" legId="1565794647" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443243" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221558" legId="1565794648" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221559" legId="1565794649" class="H" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221560" legId="1565794650" class="O" cos="E" cosDescription="ECONOMY" fareBaseAdt="HBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816036" adtBuy="4066.0" adtSell="4126.0" chdBuy="4066.0" chdSell="4126.0" infBuy="4066.0" infSell="4126.0" adtTax="147.74" chdTax="147.74" infTax="147.74" refundable="false" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="BUSL,BUSL,BUSL">
            <fareXRefs>
                <fareXRef fareId="1418816036">
                    <flights>
                        <flight flightId="232443244" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221561" legId="1565794651" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221562" legId="1565794652" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221563" legId="1565794653" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443245" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221564" legId="1565794654" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221565" legId="1565794655" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221566" legId="1565794656" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443246" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221567" legId="1565794657" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221568" legId="1565794658" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221569" legId="1565794659" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443247" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221570" legId="1565794660" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221571" legId="1565794661" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221572" legId="1565794662" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443248" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221573" legId="1565794663" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221574" legId="1565794664" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221575" legId="1565794665" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443249" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221576" legId="1565794666" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221577" legId="1565794667" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221578" legId="1565794668" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443250" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221579" legId="1565794669" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221580" legId="1565794670" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221581" legId="1565794671" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443251" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221582" legId="1565794672" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221583" legId="1565794673" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221584" legId="1565794674" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443252" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221585" legId="1565794675" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221586" legId="1565794676" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221587" legId="1565794677" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443253" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221588" legId="1565794678" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221589" legId="1565794679" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221590" legId="1565794680" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443254" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221591" legId="1565794681" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221592" legId="1565794682" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221593" legId="1565794683" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443255" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221594" legId="1565794684" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221595" legId="1565794685" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221596" legId="1565794686" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443256" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221597" legId="1565794687" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221598" legId="1565794688" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221599" legId="1565794689" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443257" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221600" legId="1565794690" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221601" legId="1565794691" class="I" cos="B" cosDescription="BUSINESS" fareBaseAdt="IBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221602" legId="1565794692" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="IBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816041" adtBuy="4550.0" adtSell="4610.0" chdBuy="4550.0" chdSell="4610.0" infBuy="4550.0" infSell="4610.0" adtTax="115.39" chdTax="115.39" infTax="115.39" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="BUSV,BUSV">
            <fareXRefs>
                <fareXRef fareId="1418816041">
                    <flights>
                        <flight flightId="232443291" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221695" legId="1565794792" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DVAAO" seats="3"/>
                                <legXRef legXRefId="91561221696" legId="1565794793" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443292" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221697" legId="1565794794" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DVAAO" seats="7"/>
                                <legXRef legXRefId="91561221698" legId="1565794795" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816037" adtBuy="4887.0" adtSell="4947.0" chdBuy="4887.0" chdSell="4947.0" infBuy="4887.0" infSell="4947.0" adtTax="147.74" chdTax="147.74" infTax="147.74" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="BUSV,BUSV,BUSV">
            <fareXRefs>
                <fareXRef fareId="1418816037">
                    <flights>
                        <flight flightId="232443258" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221603" legId="1565794693" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221604" legId="1565794694" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221605" legId="1565794695" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443259" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221606" legId="1565794696" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221607" legId="1565794697" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221608" legId="1565794698" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443260" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221609" legId="1565794699" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221610" legId="1565794700" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221611" legId="1565794701" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443261" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221612" legId="1565794702" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221613" legId="1565794703" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221614" legId="1565794704" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443262" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221615" legId="1565794705" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221616" legId="1565794706" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221617" legId="1565794707" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443263" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221618" legId="1565794708" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221619" legId="1565794709" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221620" legId="1565794710" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443264" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221621" legId="1565794711" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221622" legId="1565794712" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221623" legId="1565794713" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443265" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221624" legId="1565794714" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221625" legId="1565794715" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221626" legId="1565794716" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443266" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221627" legId="1565794717" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221628" legId="1565794718" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221629" legId="1565794719" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443267" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221630" legId="1565794720" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221631" legId="1565794721" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221632" legId="1565794722" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443268" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221633" legId="1565794723" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221634" legId="1565794724" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221635" legId="1565794732" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443269" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221636" legId="1565794733" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221637" legId="1565794734" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221638" legId="1565794735" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443270" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221639" legId="1565794736" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221640" legId="1565794737" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221641" legId="1565794738" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443271" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221642" legId="1565794739" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221643" legId="1565794740" class="D" cos="B" cosDescription="BUSINESS" fareBaseAdt="DBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221644" legId="1565794741" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="DBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816042" adtBuy="5525.0" adtSell="5585.0" chdBuy="5525.0" chdSell="5585.0" infBuy="5525.0" infSell="5585.0" adtTax="115.39" chdTax="115.39" infTax="115.39" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="BUFL,BUFL">
            <fareXRefs>
                <fareXRef fareId="1418816042">
                    <flights>
                        <flight flightId="232443293" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221699" legId="1565794796" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CVAAO" seats="5"/>
                                <legXRef legXRefId="91561221700" legId="1565794797" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443294" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221701" legId="1565794798" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CVAAO" seats="9"/>
                                <legXRef legXRefId="91561221702" legId="1565794799" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CVAAO" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816038" adtBuy="6110.0" adtSell="6170.0" chdBuy="6110.0" chdSell="6170.0" infBuy="6110.0" infSell="6170.0" adtTax="147.74" chdTax="147.74" infTax="147.74" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="BUFL,BUFL,BUFL">
            <fareXRefs>
                <fareXRef fareId="1418816038">
                    <flights>
                        <flight flightId="232443272" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221645" legId="1565794742" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221646" legId="1565794743" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221647" legId="1565794744" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443273" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221648" legId="1565794745" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221649" legId="1565794746" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221650" legId="1565794747" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443274" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221651" legId="1565794748" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221652" legId="1565794749" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221653" legId="1565794750" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443275" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221654" legId="1565794751" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221655" legId="1565794752" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221656" legId="1565794753" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443276" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221657" legId="1565794754" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221658" legId="1565794755" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221659" legId="1565794756" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443277" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221660" legId="1565794757" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221661" legId="1565794758" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221662" legId="1565794759" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443278" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221663" legId="1565794760" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221664" legId="1565794761" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221665" legId="1565794762" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443279" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221666" legId="1565794763" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221667" legId="1565794764" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221668" legId="1565794765" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443280" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221669" legId="1565794766" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221670" legId="1565794767" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221671" legId="1565794768" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443281" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221672" legId="1565794769" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221673" legId="1565794770" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221674" legId="1565794771" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443282" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221675" legId="1565794772" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221676" legId="1565794773" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221677" legId="1565794774" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443283" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221678" legId="1565794775" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221679" legId="1565794776" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221680" legId="1565794777" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443284" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221681" legId="1565794778" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221682" legId="1565794779" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221683" legId="1565794780" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443286" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221684" legId="1565794781" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221685" legId="1565794782" class="C" cos="B" cosDescription="BUSINESS" fareBaseAdt="CBLAOUQV" seats="9"/>
                                <legXRef legXRefId="91561221686" legId="1565794783" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="CBLAOUQV" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816046" adtBuy="6203.0" adtSell="6263.0" chdBuy="6203.0" chdSell="6263.0" infBuy="6203.0" infSell="6263.0" adtTax="122.31" chdTax="122.31" infTax="122.31" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECFL,ECFL,ECFL">
            <fareXRefs>
                <fareXRef fareId="1418816046">
                    <flights>
                        <flight flightId="232443302" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221724" legId="1565794821" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221725" legId="1565794822" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221726" legId="1565794823" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443305" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221727" legId="1565794824" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221728" legId="1565794825" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221729" legId="1565794826" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
        <tarif tarifId="1418816047" adtBuy="6203.0" adtSell="6263.0" chdBuy="6203.0" chdSell="6263.0" infBuy="6203.0" infSell="6263.0" adtTax="124.12" chdTax="124.12" infTax="124.12" refundable="true" origin="BARGAINFINDERMAX" taxMode="EXCL" topCar="false" topHotel="false" powerPricerDisplay="sell" fareFamilies="ECFL,ECFL,ECFL">
            <fareXRefs>
                <fareXRef fareId="1418816047">
                    <flights>
                        <flight flightId="232443306" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221730" legId="1565794827" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221731" legId="1565794828" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221732" legId="1565794829" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                            </legXRefs>
                        </flight>
                        <flight flightId="232443307" addAdtPrice="0.0" addChdPrice="0.0" addInfPrice="0.0">
                            <legXRefs>
                                <legXRef legXRefId="91561221733" legId="1565794830" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221734" legId="1565794831" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                                <legXRef legXRefId="91561221735" legId="1565794832" class="Y" cos="E" cosDescription="ECONOMY" fareBaseAdt="YOW" seats="9"/>
                            </legXRefs>
                        </flight>
                    </flights>
                </fareXRef>
            </fareXRefs>
        </tarif>
    </tarifs>
    <legs>
        <leg legId="1565794488" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794489" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794490" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794491" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794492" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794493" depApt="BLR" depDate="2025-02-13" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-14" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794494" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794495" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794496" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794497" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794498" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794499" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794500" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794501" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794502" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794503" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794504" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794505" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794506" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794507" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794509" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794510" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794511" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794512" depApt="BLR" depDate="2025-02-12" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794513" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794514" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794515" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794516" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794517" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794518" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794519" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794520" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794521" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794522" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794523" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794524" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794525" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794526" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794527" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794528" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794529" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794530" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794531" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794532" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794533" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794534" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794536" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794537" depApt="BLR" depDate="2025-02-13" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-14" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794538" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794539" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794540" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794541" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794542" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794543" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794544" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794545" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794546" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794547" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794548" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794549" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794550" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794551" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794553" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794554" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794555" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794556" depApt="BLR" depDate="2025-02-12" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794557" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794558" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794559" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794560" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794561" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794562" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794563" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794564" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794565" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794566" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794567" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794568" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794569" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794570" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794571" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794572" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794573" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794574" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794575" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794576" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794577" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794578" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794579" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794580" depApt="BLR" depDate="2025-02-13" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-14" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794581" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794582" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794583" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794584" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794585" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794586" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794587" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794588" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794589" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794591" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794624" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794625" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794626" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794627" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794628" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794629" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794630" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794631" depApt="BLR" depDate="2025-02-12" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794632" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794633" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794634" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794635" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794636" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794637" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794639" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794640" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794641" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794642" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794643" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794644" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794645" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794646" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794647" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794648" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794649" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794650" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794651" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794652" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794653" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794654" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794655" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794656" depApt="BLR" depDate="2025-02-13" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-14" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794657" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794658" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794659" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794660" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794661" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794662" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794663" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794664" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794665" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794666" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794667" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794668" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794669" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794670" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794671" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794672" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794673" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794674" depApt="BLR" depDate="2025-02-12" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794675" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794676" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794677" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794678" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794679" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794680" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794681" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794682" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794683" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794684" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794685" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794686" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794687" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794688" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794689" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794690" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794691" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794692" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794693" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794694" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794695" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794696" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794697" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794698" depApt="BLR" depDate="2025-02-13" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-14" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794699" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794700" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794701" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794702" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794703" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794704" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794705" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794706" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794707" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794708" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794709" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794710" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794711" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794712" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794713" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794714" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794715" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794716" depApt="BLR" depDate="2025-02-12" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794717" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794718" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794719" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794720" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794721" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794722" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794723" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794724" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794732" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794733" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794734" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794735" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794736" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794737" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794738" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794739" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794740" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794741" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794742" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794743" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794744" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794745" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794746" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794747" depApt="BLR" depDate="2025-02-13" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-14" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794748" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794749" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794750" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794751" depApt="MEL" depDate="2025-02-12" depTime="21:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="22:25" equip="73H" fNo="498" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794752" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794753" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794754" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794755" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794756" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794757" depApt="MEL" depDate="2025-02-12" depTime="20:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="21:55" equip="73H" fNo="496" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794758" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794759" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794760" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794761" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794762" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794763" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794764" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794765" depApt="BLR" depDate="2025-02-12" depTime="21:50" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="00:45" equip="321" fNo="5282" shared:cr="QF" miles="1081" elapsed="2.92" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794766" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794767" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794768" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794769" depApt="MEL" depDate="2025-02-12" depTime="06:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:55" equip="73H" fNo="406" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794770" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794771" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794772" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794773" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794774" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794775" depApt="MEL" depDate="2025-02-12" depTime="06:20" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:45" equip="73H" fNo="404" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794776" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794777" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794778" depApt="MEL" depDate="2025-02-12" depTime="06:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="07:25" equip="73H" fNo="402" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794779" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794780" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794781" depApt="MEL" depDate="2025-02-12" depTime="19:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="20:55" equip="73H" fNo="490" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794782" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794783" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794784" depApt="MEL" depDate="2025-02-12" depTime="12:05" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="17:05" equip="332" fNo="35" shared:cr="QF" miles="3755" elapsed="8.0" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794785" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794786" depApt="MEL" depDate="2025-02-12" depTime="16:55" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="22:05" equip="332" fNo="37" shared:cr="QF" miles="3755" elapsed="8.17" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794787" depApt="SIN" depDate="2025-02-13" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-13" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794788" depApt="MEL" depDate="2025-02-12" depTime="12:05" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="17:05" equip="332" fNo="35" shared:cr="QF" miles="3755" elapsed="8.0" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794789" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794790" depApt="MEL" depDate="2025-02-12" depTime="16:55" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="22:05" equip="332" fNo="37" shared:cr="QF" miles="3755" elapsed="8.17" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794791" depApt="SIN" depDate="2025-02-13" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-13" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794792" depApt="MEL" depDate="2025-02-12" depTime="12:05" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="17:05" equip="332" fNo="35" shared:cr="QF" miles="3755" elapsed="8.0" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794793" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794794" depApt="MEL" depDate="2025-02-12" depTime="16:55" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="22:05" equip="332" fNo="37" shared:cr="QF" miles="3755" elapsed="8.17" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794795" depApt="SIN" depDate="2025-02-13" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-13" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794796" depApt="MEL" depDate="2025-02-12" depTime="12:05" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="17:05" equip="332" fNo="35" shared:cr="QF" miles="3755" elapsed="8.0" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794797" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794798" depApt="MEL" depDate="2025-02-12" depTime="16:55" dstApt="SIN" depTerm="2" arrTerm="1" arrDate="2025-02-12" arrTime="22:05" equip="332" fNo="37" shared:cr="QF" miles="3755" elapsed="8.17" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794799" depApt="SIN" depDate="2025-02-13" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-13" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794800" depApt="MEL" depDate="2025-02-12" depTime="07:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="08:25" equip="73H" fNo="410" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794801" depApt="SYD" depDate="2025-02-12" depTime="11:00" dstApt="SIN" depTerm="1" arrTerm="1" arrDate="2025-02-12" arrTime="16:30" equip="333" fNo="291" shared:cr="QF" miles="3915" elapsed="8.5" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794802" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794803" depApt="MEL" depDate="2025-02-12" depTime="08:00" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="09:25" equip="73H" fNo="418" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794804" depApt="SYD" depDate="2025-02-12" depTime="11:00" dstApt="SIN" depTerm="1" arrTerm="1" arrDate="2025-02-12" arrTime="16:30" equip="333" fNo="291" shared:cr="QF" miles="3915" elapsed="8.5" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794805" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794806" depApt="MEL" depDate="2025-02-12" depTime="07:45" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="09:10" equip="73H" fNo="416" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794807" depApt="SYD" depDate="2025-02-12" depTime="11:00" dstApt="SIN" depTerm="1" arrTerm="1" arrDate="2025-02-12" arrTime="16:30" equip="333" fNo="291" shared:cr="QF" miles="3915" elapsed="8.5" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794808" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794809" depApt="MEL" depDate="2025-02-12" depTime="07:30" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="08:55" equip="73H" fNo="414" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794810" depApt="SYD" depDate="2025-02-12" depTime="11:00" dstApt="SIN" depTerm="1" arrTerm="1" arrDate="2025-02-12" arrTime="16:30" equip="333" fNo="291" shared:cr="QF" miles="3915" elapsed="8.5" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794811" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794812" depApt="MEL" depDate="2025-02-12" depTime="06:45" dstApt="SYD" depTerm="1" arrTerm="3" arrDate="2025-02-12" arrTime="08:10" equip="73H" fNo="408" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794813" depApt="SYD" depDate="2025-02-12" depTime="11:00" dstApt="SIN" depTerm="1" arrTerm="1" arrDate="2025-02-12" arrTime="16:30" equip="333" fNo="291" shared:cr="QF" miles="3915" elapsed="8.5" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794814" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794815" depApt="MEL" depDate="2025-02-12" depTime="06:45" dstApt="BNE" depTerm="1" arrTerm="D" arrDate="2025-02-12" arrTime="08:00" equip="73H" fNo="604" shared:cr="QF" miles="859" elapsed="2.25" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794816" depApt="BNE" depDate="2025-02-12" depTime="10:35" dstApt="SIN" depTerm="I" arrTerm="1" arrDate="2025-02-12" arrTime="17:00" equip="332" fNo="51" shared:cr="QF" miles="3823" elapsed="8.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794817" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794818" depApt="MEL" depDate="2025-02-12" depTime="08:20" dstApt="PER" depTerm="1" arrTerm="4" arrDate="2025-02-12" arrTime="09:25" equip="332" fNo="769" shared:cr="QF" miles="1681" elapsed="4.08" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794819" depApt="PER" depDate="2025-02-12" depTime="12:25" dstApt="SIN" depTerm="4" arrTerm="1" arrDate="2025-02-12" arrTime="17:55" equip="332" fNo="71" shared:cr="QF" miles="2434" elapsed="5.5" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794820" depApt="SIN" depDate="2025-02-12" depTime="19:40" dstApt="DEL" depTerm="2" arrTerm="3" arrDate="2025-02-12" arrTime="23:20" equip="321" fNo="8764" shared:cr="QF" miles="2586" elapsed="6.67" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794821" depApt="AVV" depDate="2025-02-12" depTime="06:00" dstApt="SYD" arrTerm="2" arrDate="2025-02-12" arrTime="07:25" equip="320" fNo="5602" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="JQ"/>
        <leg legId="1565794822" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794823" depApt="BLR" depDate="2025-02-12" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794824" depApt="AVV" depDate="2025-02-12" depTime="06:00" dstApt="SYD" arrTerm="2" arrDate="2025-02-12" arrTime="07:25" equip="320" fNo="5602" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="JQ"/>
        <leg legId="1565794825" depApt="SYD" depDate="2025-02-12" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-12" arrTime="15:55" equip="333" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794826" depApt="BLR" depDate="2025-02-12" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-12" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794827" depApt="AVV" depDate="2025-02-12" depTime="20:55" dstApt="SYD" arrTerm="2" arrDate="2025-02-12" arrTime="22:20" equip="320" fNo="5612" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="JQ"/>
        <leg legId="1565794828" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794829" depApt="BLR" depDate="2025-02-13" depTime="20:30" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="23:30" equip="321" fNo="5040" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
        <leg legId="1565794830" depApt="AVV" depDate="2025-02-12" depTime="20:55" dstApt="SYD" arrTerm="2" arrDate="2025-02-12" arrTime="22:20" equip="320" fNo="5612" shared:cr="QF" miles="439" elapsed="1.42" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="JQ"/>
        <leg legId="1565794831" depApt="SYD" depDate="2025-02-13" depTime="09:30" dstApt="BLR" depTerm="1" arrTerm="2" arrDate="2025-02-13" arrTime="15:55" equip="332" fNo="67" shared:cr="QF" miles="5810" elapsed="12.42" meals="0" smoker="false" stops="0" eticket="true"/>
        <leg legId="1565794832" depApt="BLR" depDate="2025-02-13" depTime="19:00" dstApt="DEL" depTerm="1" arrTerm="1D" arrDate="2025-02-13" arrTime="22:00" equip="321" fNo="5042" shared:cr="QF" miles="1081" elapsed="3.0" meals="0" smoker="false" stops="0" eticket="true" shared:ocr="6E"/>
    </legs>
    <taxes shared:currency="AUD">
        <tax shared:vcr="QF" shared:fareType="PUB">104.69</tax>
        <tax shared:vcr="QF" shared:fareType="CPN">104.69</tax>
    </taxes>
    <advTaxes shared:currency="AUD">
        <advTax shared:vcr="QF" routing="QF_MELSYD0:QF_SYDBLR0:QF_BLRDEL0" adtPrice="147.74"/>
        <advTax shared:vcr="QF" routing="QF_MELSIN0:QF_SINDEL0" adtPrice="115.39"/>
        <advTax shared:vcr="QF" routing="QF_MELSYD0:QF_SYDSIN0:QF_SINDEL0" adtPrice="158.44"/>
        <advTax shared:vcr="QF" routing="QF_MELBNE0:QF_BNESIN0:QF_SINDEL0" adtPrice="149.88"/>
        <advTax shared:vcr="QF" routing="QF_MELPER0:QF_PERSIN0:QF_SINDEL0" adtPrice="132.44"/>
        <advTax shared:vcr="QF" routing="QF_AVVSYD0:QF_SYDBLR0:QF_BLRDEL0" adtPrice="122.31" adtExceptions="YOW:YOW:YOW=124.12"/>
    </advTaxes>
    <shared:specialServices>
        <serviceGroup identifier="baggage">
            <service identifier="fba" description="Free Baggage Allowance" applicablePaxTypes="ADT">
                <selectionGroup>
                    <item id="FBA_1" unit="kg" totalAllowance="40"></item>
                    <item id="FBA_2" unit="kg" totalAllowance="50"></item>
                </selectionGroup>
            </service>
        </serviceGroup>
        <serviceGroup identifier="farefamily">
            <service identifier="bf" description="Benefits">
                <selectionGroup selectionType="check">
                    <item id="BF_1" fareFamily="ECSL" fareFamilyDescription="ECONOMY SALE" description="QFINTERNATIONAL 02" programId="155527"></item>
                    <item id="BF_2" fareFamily="ECSV" fareFamilyDescription="ECONOMY SAVER" description="QFINTERNATIONAL 02" programId="155527"></item>
                    <item id="BF_3" fareFamily="ECFL" fareFamilyDescription="ECONOMY FLEX" description="QFINTERNATIONAL 02" programId="155527"></item>
                    <item id="BF_4" fareFamily="BUSL" fareFamilyDescription="BUSINESS SALE" description="QFINTERNATIONAL 02" programId="155527"></item>
                    <item id="BF_5" fareFamily="BUSV" fareFamilyDescription="BUSINESS SAVER" description="QFINTERNATIONAL 02" programId="155527"></item>
                    <item id="BF_6" fareFamily="BUFL" fareFamilyDescription="BUSINESS FLEX" description="QFINTERNATIONAL 02" programId="155527"></item>
                    <item id="BF_7" fareFamily="EDEAL" fareFamilyDescription="RED EDEAL" description="QFAUDOM 02" programId="158250"></item>
                </selectionGroup>
            </service>
        </serviceGroup>
    </shared:specialServices>
    <serviceMappings>
        <map elemType="legXRef" elemID="91561221435" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221436" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221437" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221438" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221439" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221440" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221441" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221442" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221443" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221444" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221445" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221446" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221447" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221448" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221449" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221450" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221451" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221452" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221453" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221454" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221455" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221456" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221457" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221458" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221459" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221460" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221461" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221462" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221463" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221464" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221465" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221466" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221467" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221468" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221469" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221470" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221471" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221472" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221473" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221474" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221475" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221476" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221477" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221478" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221479" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221480" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221481" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221482" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221483" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221484" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221485" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221486" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221487" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221488" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221489" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221490" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221491" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221492" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221493" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221494" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221495" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221496" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221497" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221498" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221499" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221500" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221501" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221502" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221503" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221504" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221505" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221506" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221507" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221508" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221509" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221510" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221511" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221512" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221513" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221514" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221515" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221516" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221517" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221518" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221519" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221520" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221521" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221522" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221523" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221524" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221525" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221526" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221527" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221528" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221529" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221530" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221531" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221532" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221533" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221534" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221535" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221536" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221537" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221538" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221539" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221540" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221541" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221542" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221543" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221544" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221545" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221546" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221547" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221548" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221549" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221550" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221551" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221552" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221553" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221554" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221555" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221556" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221557" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221558" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221559" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221560" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221687" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221688" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221689" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221690" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221691" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221692" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221693" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221694" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221703" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221704" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221705" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221706" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221707" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221708" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221709" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221710" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221711" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221712" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221713" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221714" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221715" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221716" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221717" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221718" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221719" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221720" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221721" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221722" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221723" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221724" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221725" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221726" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221727" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221728" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221729" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221730" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221731" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221732" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221733" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221734" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221735" serviceGroup="baggage" serviceID="FBA_1"></map>
        <map elemType="legXRef" elemID="91561221561" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221562" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221563" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221564" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221565" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221566" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221567" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221568" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221569" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221570" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221571" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221572" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221573" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221574" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221575" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221576" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221577" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221578" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221579" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221580" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221581" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221582" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221583" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221584" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221585" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221586" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221587" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221588" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221589" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221590" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221591" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221592" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221593" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221594" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221595" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221596" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221597" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221598" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221599" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221600" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221601" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221602" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221603" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221604" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221605" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221606" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221607" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221608" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221609" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221610" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221611" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221612" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221613" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221614" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221615" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221616" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221617" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221618" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221619" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221620" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221621" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221622" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221623" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221624" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221625" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221626" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221627" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221628" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221629" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221630" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221631" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221632" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221633" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221634" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221635" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221636" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221637" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221638" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221639" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221640" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221641" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221642" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221643" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221644" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221645" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221646" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221647" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221648" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221649" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221650" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221651" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221652" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221653" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221654" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221655" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221656" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221657" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221658" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221659" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221660" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221661" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221662" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221663" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221664" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221665" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221666" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221667" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221668" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221669" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221670" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221671" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221672" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221673" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221674" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221675" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221676" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221677" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221678" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221679" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221680" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221681" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221682" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221683" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221684" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221685" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221686" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221695" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221696" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221697" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221698" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221699" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221700" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221701" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221702" serviceGroup="baggage" serviceID="FBA_2"></map>
        <map elemType="legXRef" elemID="91561221435" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221436" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221437" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221438" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221439" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221440" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221441" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221442" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221443" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221444" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221445" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221446" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221447" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221448" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221449" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221450" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221451" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221452" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221453" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221454" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221455" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221456" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221457" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221458" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221459" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221460" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221461" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221462" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221463" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221464" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221465" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221466" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221467" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221468" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221469" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221470" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221471" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221472" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221473" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221474" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221475" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221476" serviceGroup="farefamily" serviceID="BF_1"></map>
        <map elemType="legXRef" elemID="91561221477" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221478" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221479" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221480" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221481" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221482" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221483" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221484" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221485" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221486" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221487" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221488" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221489" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221490" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221491" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221492" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221493" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221494" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221495" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221496" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221497" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221498" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221499" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221500" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221501" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221502" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221503" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221504" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221505" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221506" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221507" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221508" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221509" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221510" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221511" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221512" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221513" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221514" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221515" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221516" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221517" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221518" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221687" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221688" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221689" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221690" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221704" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221705" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221707" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221708" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221710" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221711" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221713" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221714" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221716" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221717" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221719" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221720" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221722" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221723" serviceGroup="farefamily" serviceID="BF_2"></map>
        <map elemType="legXRef" elemID="91561221519" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221520" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221521" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221522" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221523" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221524" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221525" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221526" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221527" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221528" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221529" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221530" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221531" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221532" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221533" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221534" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221535" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221536" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221537" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221538" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221539" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221540" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221541" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221542" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221543" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221544" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221545" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221546" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221547" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221548" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221549" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221550" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221551" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221552" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221553" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221554" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221555" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221556" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221557" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221558" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221559" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221560" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221691" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221692" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221693" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221694" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221724" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221725" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221726" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221727" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221728" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221729" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221730" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221731" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221732" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221733" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221734" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221735" serviceGroup="farefamily" serviceID="BF_3"></map>
        <map elemType="legXRef" elemID="91561221561" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221562" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221563" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221564" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221565" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221566" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221567" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221568" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221569" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221570" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221571" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221572" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221573" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221574" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221575" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221576" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221577" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221578" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221579" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221580" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221581" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221582" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221583" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221584" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221585" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221586" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221587" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221588" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221589" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221590" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221591" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221592" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221593" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221594" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221595" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221596" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221597" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221598" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221599" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221600" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221601" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221602" serviceGroup="farefamily" serviceID="BF_4"></map>
        <map elemType="legXRef" elemID="91561221603" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221604" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221605" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221606" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221607" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221608" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221609" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221610" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221611" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221612" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221613" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221614" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221615" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221616" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221617" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221618" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221619" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221620" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221621" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221622" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221623" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221624" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221625" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221626" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221627" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221628" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221629" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221630" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221631" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221632" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221633" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221634" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221635" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221636" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221637" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221638" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221639" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221640" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221641" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221642" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221643" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221644" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221695" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221696" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221697" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221698" serviceGroup="farefamily" serviceID="BF_5"></map>
        <map elemType="legXRef" elemID="91561221645" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221646" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221647" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221648" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221649" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221650" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221651" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221652" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221653" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221654" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221655" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221656" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221657" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221658" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221659" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221660" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221661" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221662" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221663" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221664" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221665" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221666" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221667" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221668" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221669" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221670" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221671" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221672" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221673" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221674" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221675" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221676" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221677" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221678" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221679" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221680" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221681" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221682" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221683" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221684" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221685" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221686" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221699" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221700" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221701" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221702" serviceGroup="farefamily" serviceID="BF_6"></map>
        <map elemType="legXRef" elemID="91561221703" serviceGroup="farefamily" serviceID="BF_7"></map>
        <map elemType="legXRef" elemID="91561221706" serviceGroup="farefamily" serviceID="BF_7"></map>
        <map elemType="legXRef" elemID="91561221709" serviceGroup="farefamily" serviceID="BF_7"></map>
        <map elemType="legXRef" elemID="91561221712" serviceGroup="farefamily" serviceID="BF_7"></map>
        <map elemType="legXRef" elemID="91561221715" serviceGroup="farefamily" serviceID="BF_7"></map>
        <map elemType="legXRef" elemID="91561221718" serviceGroup="farefamily" serviceID="BF_7"></map>
        <map elemType="legXRef" elemID="91561221721" serviceGroup="farefamily" serviceID="BF_7"></map>
    </serviceMappings>
</availResponse>
';
$legId = "1565794488";
var_dump(searchLegById($responseData, $legId));