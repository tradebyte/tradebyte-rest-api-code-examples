<?php
/**
 * This example script gets stocks for all articles from the Tradebyte REST API.
 *
 * @author Hendrik Bahr <bahr@fatchip.de>
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
$sUrl = "https://rest.trade-server.net/" . $sMerchantId ."/stock/?channel=" .  $sChannelId;
$oCurl = curl_init();
curl_setopt($oCurl, CURLOPT_URL, $sUrl);
curl_setopt($oCurl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($oCurl, CURLOPT_USERPWD, $sApiUser . ":" . $sApiPassword);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_HEADER, 0);
curl_setopt($oCurl, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($oCurl, CURLOPT_TIMEOUT, 82800); // 23 hours
$sResponse = curl_exec($oCurl);
if ($sResponse === false) {
	echo 'Error: ' . curl_error($oCurl) . ' ErrorNr: ' . curl_errno($oCurl);
}
curl_close($oCurl);

/*
 * Process data as you need
 */
$oXml = simplexml_load_string($sResponse);
if ($oXml && $oXml->ARTICLE) {
	foreach ($oXml->ARTICLE as $oProduct) {
		echo (string)$oProduct->A_NR . ": " . (string)$oProduct->A_STOCK . PHP_EOL;
	}
} else {
	print_r($sResponse);
}
