<?php
/**
 * This example script prepares and sends information on products stocks to the Tradebyte REST API.
 *
 * @author Marcos Doellerer<marcos.doellerer@fatchip.de>
 */

$sNewLine = "\n";

// Values obtained in the shop, for example, to be sent to Tradebyte
$aStockInfo['article_number'] = "5552-55-853-6-2";      //Article Number
$aStockInfo['stock_value'] = 42;					    //updated stock


/**
 * Preparing Xml structure according to Tradebyte specs
 */
$sXml  = '<?xml version="1.0" encoding="UTF-8"?>' . $sNewLine;
$sXml .= "<TBCATALOG>" . $sNewLine;
$sXml .= "    <ARTICLEDATA>" . $sNewLine;

$sXml .=   "	<ARTICLE>" . $sNewLine;
$sXml .=   "		<A_NR>{$aStockInfo['article_number']}</A_NR>" . $sNewLine;
$sXml .=   "	    <A_STOCK>{$aStockInfo['stock_value']}</A_STOCK>" . $sNewLine;
$sXml .=   "	</ARTICLE>" . $sNewLine;

$sXml  .= "    </ARTICLEDATA>" . $sNewLine;
$sXml  .= "</TBCATALOG>" . $sNewLine;


$sApiUser = 'api-user'; // Your API username
$sApiPassword = 'api-password'; // Your API password
$sMerchantId = '1234'; // Your digit merchant ID
$sChannelId = '5678'; // Your digit channel ID

/**
 * Send data to REST API with curl
 */
$sUrl = "https://rest.trade-server.net/" . $sMerchantId ."/articles/stock";


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
    echo "Stock sent successfully";
}
