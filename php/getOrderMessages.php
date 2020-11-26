<?php
/**
 * This example script gets information on changed order-status from the Tradebyte REST API.
 * Then it marks the messages as processed.
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
* Get data from REST API with curl
*/
$sUrl = "https://rest.trade-server.net/" . $sMerchantId . "/messages/?channel=" . $sChannelId;

$oCurl = curl_init();
curl_setopt($oCurl, CURLOPT_URL, $sUrl);
curl_setopt($oCurl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($oCurl, CURLOPT_USERPWD, $sApiUser . ":" . $sApiPassword);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_HEADER, 0);
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($oCurl, CURLOPT_TIMEOUT, 3600);
$sResponse = curl_exec($oCurl);
if ($sResponse === false) {
    echo 'Error: ' . curl_error($oCurl) . ' ErrorNr: ' . curl_errno($oCurl);
}
curl_close($oCurl);

/**
 * Process data as you need
 */
$oXml = simplexml_load_string($sResponse);
if ($oXml) {
    foreach ($oXml->MESSAGE as $oMessage) {
        echo "Message Type: " . (string)$oMessage->MESSAGE_TYPE . PHP_EOL;
        echo " Order number in Channel : " . (string)$oMessage->CHANNEL_ORDER_ID . PHP_EOL;

	    /**
	     * Sending confirmation to Tradebyte
	     */
	    $sUrl = "https://rest.trade-server.net/" . $sMerchantId . "/messages/" . (int)$oMessage->MESSAGE_ID . "/processed?channel=" . $sChannelId;
	    $oCurl = curl_init();
	    curl_setopt($oCurl, CURLOPT_URL, $sUrl);
	    curl_setopt($oCurl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($oCurl, CURLOPT_USERPWD, $sApiUser . ":" . $sApiPassword);
	    curl_setopt($oCurl, CURLOPT_POST, true); // This is a POST request!
	    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($oCurl, CURLOPT_HEADER, 0);
	    curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($oCurl, CURLOPT_TIMEOUT, 30);
	    $sResponse = curl_exec($oCurl);
	    if ($sResponse === false) {
		    echo 'Error: ' . curl_error($oCurl) . ' ErrorNr: ' . curl_errno($oCurl);
	    }else{
		    echo "'Message received' confirmation for Message id: " . $messageId . " successfully sent." . PHP_EOL;
	    }
	    curl_close($oCurl);
    }
} else {
    print_r($sResponse);
}
