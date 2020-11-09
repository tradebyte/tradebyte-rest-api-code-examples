<?php
/**
 * This example script gets information on products and on its related articles from the Tradebyte REST API.
 *
 * @author Marcos Doellerer<marcos.doellerer@fatchip.de>
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

$iDelta = time() - (3600 * 12); //Get the delta for last 12 hours (current time minus 12 hours)
$sUrl = "https://rest.trade-server.net/" . $sMerchantId ."/products/?channel=" .  $sChannelId . '&delta=' . $iDelta;

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

/*
 * Process data as you need
 */
$oXml = simplexml_load_string($sResponse);
if ($oXml && $oXml->PRODUCTDATA) {

    if ($oXml->SUPPLIER){
        echo "Supplier: " . $oXml->SUPPLIER->NAME . PHP_EOL;
    }

    foreach ($oXml->PRODUCTDATA->PRODUCT as $oProduct) {
        echo "Product n° " . (string)$oProduct->P_NR . " title: " . (string)$oProduct->P_NAME->VALUE . PHP_EOL;

        foreach ($oProduct->ARTICLEDATA->ARTICLE as $oArticle) {
            echo "Article n° " . (string)$oArticle->A_NR . " ean: " . (string)$oArticle->A_EAN . PHP_EOL;
        }
    }
} else {
    print_r($sResponse);
}