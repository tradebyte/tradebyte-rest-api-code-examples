<?php
/**
 * This example script prepares and sends information on orders to the Tradebyte REST API.
 *
 * @author Marcos Doellerer <marcos.doellerer@fatchip.de>
 */

/*
 * API-Credentials - modify to your personal access credentials
 *
 * @see https://tradebyte.io/how-to/generate-rest-api-credentials-in-tb-one/
 */
$sApiUser = 'api-user'; // Your API username
$sApiPassword = 'api-password'; // Your API password
$sMerchantId = '1234'; // Your digit merchant ID
$sChannelId = '5678'; // Your digit channel ID

/*
 * Example order XML
 */
$sNewLine = "\n";
$sXml = '<?xml version="1.0" encoding="UTF-8"?>' . $sNewLine;
$sXml .='<ORDER>' . $sNewLine;
$sXml .='    <ORDER_DATA>' . $sNewLine;
$sXml .='        <ORDER_DATE>2020-10-14</ORDER_DATE>' . $sNewLine;
$sXml .='        <CHANNEL_ID>5555</CHANNEL_ID>' . $sNewLine;
$sXml .='        <APPROVED>1</APPROVED>' . $sNewLine;
$sXml .='        <ITEM_COUNT>1</ITEM_COUNT>' . $sNewLine;
$sXml .='        <TOTAL_ITEM_AMOUNT>297.00</TOTAL_ITEM_AMOUNT>' . $sNewLine;
$sXml .='        <DATE_CREATED>2020-10-14T10:47:07</DATE_CREATED>' . $sNewLine;
$sXml .='    </ORDER_DATA>' . $sNewLine;
$sXml .='    <SELL_TO>' . $sNewLine;
$sXml .='        <CHANNEL_NO>55</CHANNEL_NO>' . $sNewLine;
$sXml .='        <FIRSTNAME>Max</FIRSTNAME>' . $sNewLine;
$sXml .='        <LASTNAME>Mustermann</LASTNAME>' . $sNewLine;
$sXml .='        <NAME>Max Mustermann</NAME>' . $sNewLine;
$sXml .='        <STREET_NO>Bahnhofsplatz 8</STREET_NO>' . $sNewLine;
$sXml .='        <ZIP>91522</ZIP>' . $sNewLine;
$sXml .='        <CITY>Ansbach</CITY>' . $sNewLine;
$sXml .='        <COUNTRY>DE</COUNTRY>' . $sNewLine;
$sXml .='        <EMAIL>example@tradebyte.com</EMAIL>' . $sNewLine;
$sXml .='    </SELL_TO>' . $sNewLine;
$sXml .='    <SHIP_TO>' . $sNewLine;
$sXml .='        <CHANNEL_NO>55</CHANNEL_NO>' . $sNewLine;
$sXml .='        <FIRSTNAME>Max</FIRSTNAME>' . $sNewLine;
$sXml .='        <LASTNAME>Mustermann</LASTNAME>' . $sNewLine;
$sXml .='        <NAME>Max Mustermann</NAME>' . $sNewLine;
$sXml .='        <STREET_NO>Bahnhofsplatz 8</STREET_NO>' . $sNewLine;
$sXml .='        <ZIP>91522</ZIP>' . $sNewLine;
$sXml .='        <CITY>Ansbach</CITY>' . $sNewLine;
$sXml .='        <COUNTRY>DE</COUNTRY>' . $sNewLine;
$sXml .='        <EMAIL>example@tradebyte.com</EMAIL>' . $sNewLine;
$sXml .='    </SHIP_TO>' . $sNewLine;
$sXml .='    <ITEMS>' . $sNewLine;
$sXml .='        <ITEM>' . $sNewLine;
$sXml .='            <CHANNEL_ID>675443254657</CHANNEL_ID>' . $sNewLine;
$sXml .='            <SKU>555-85-853-6-5</SKU>' . $sNewLine;
$sXml .='            <QUANTITY>3</QUANTITY>' . $sNewLine;
$sXml .='            <BILLING_TEXT>Example Product</BILLING_TEXT>' . $sNewLine;
$sXml .='            <TRANSFER_PRICE>99.000</TRANSFER_PRICE>' . $sNewLine;
$sXml .='            <ITEM_PRICE>99.000</ITEM_PRICE>' . $sNewLine;
$sXml .='            <DATE_CREATED>2020-10-14T10:47:07</DATE_CREATED>' . $sNewLine;
$sXml .='        </ITEM>' . $sNewLine;
$sXml .='    </ITEMS>' . $sNewLine;
$sXml .='</ORDER>' . $sNewLine;

/*
 * Send data to REST API with curl
 */
$sUrl = "https://rest.trade-server.net/" . $sMerchantId ."/orders/?channel=" . $sChannelId;

$oCurl = curl_init();
curl_setopt($oCurl, CURLOPT_URL, $sUrl);
curl_setopt($oCurl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($oCurl, CURLOPT_USERPWD, $sApiUser . ":" . $sApiPassword);
curl_setopt($oCurl, CURLOPT_POST, true);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($oCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sXml);

$sResponse = curl_exec($oCurl);
if ($sResponse === false) {
    echo 'Error: ' . curl_error($oCurl) . ' ErrorNr: ' . curl_errno($oCurl);
}
else {
    print_r($sResponse);
}
curl_close($oCurl);
