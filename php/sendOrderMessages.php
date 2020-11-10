<?php
/**
 * This example script prepares and sends information on order status changes to the Tradebyte REST API.
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
 * Example message
 */
$sNewLine = "\n";
$sXml  = '<?xml version="1.0" encoding="utf-8"?>' . $sNewLine;
$sXml .= '<MESSAGES_LIST>' . $sNewLine;
$sXml .= '<MESSAGE>' . $sNewLine;
$sXml .= '    <MESSAGE_TYPE>SHIP</MESSAGE_TYPE>' . $sNewLine;
$sXml .= '    <TB_ORDER_ID>42</TB_ORDER_ID>' . $sNewLine;
$sXml .= '    <TB_ORDER_ITEM_ID>52</TB_ORDER_ITEM_ID>' . $sNewLine;
$sXml .= '    <SKU>1302</SKU>' . $sNewLine;
$sXml .= '    <CHANNEL_SIGN>55test</CHANNEL_SIGN>' . $sNewLine;
$sXml .= '    <CHANNEL_ORDER_ID>test858555/CHANNEL_ORDER_ID>' . $sNewLine;
$sXml .= '    <CHANNEL_ORDER_ITEM_ID>kjgded-555</CHANNEL_ORDER_ITEM_ID>' . $sNewLine;
$sXml .= '    <QUANTITY>1</QUANTITY>' . $sNewLine;
$sXml .= '    <IDCODE>DE57373542354235BR</IDCODE>' . $sNewLine;
$sXml .= '    <DATE_CREATED>2020-10-15T14:45:32</DATE_CREATED>' . $sNewLine;
$sXml .= '</MESSAGE>' . $sNewLine;
$sXml .= '</MESSAGES_LIST>' . $sNewLine;

/*
 * Send data to REST API with curl
 */
$sUrl = "https://rest.trade-server.net/" . $sMerchantId ."/messages/?";

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
