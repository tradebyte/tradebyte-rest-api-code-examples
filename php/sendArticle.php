<?php
/**
 * This example script prepares and sends information on products and on its related articles to the Tradebyte REST API.
 *
 * @author Marcos Doellerer<marcos.doellerer@fatchip.de>
 */

$sNewLine = "\n";

$sXml = '<?xml version="1.0" encoding="UTF-8"?>' . $sNewLine;
$sXml .='<TBCATALOG xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1.2" xsi:noNamespaceSchemaLocation="http://api.trade-server.net/schema/all_in_one/tb-cat_1_2_import.xsd">' . $sNewLine;
$sXml .='    <PRODUCTDATA>' . $sNewLine;
$sXml .='    <PRODUCT>' . $sNewLine;
$sXml .='    <P_NR>1777</P_NR>' . $sNewLine;
$sXml .='    <P_ACTIVEDATA>' . $sNewLine;
$sXml .='        <P_ACTIVE channel="chxx">1</P_ACTIVE>' . $sNewLine;
$sXml .='    </P_ACTIVEDATA>' . $sNewLine;
$sXml .='    <P_NAME>' . $sNewLine;
$sXml .='        <VALUE xml:lang="x-default">Product Test Name</VALUE>' . $sNewLine;
$sXml .='    </P_NAME>' . $sNewLine;
$sXml .='    <P_TEXT>' . $sNewLine;
$sXml .='       <VALUE xml:lang="x-default">Long Description of product and all details</VALUE>' . $sNewLine;
$sXml .='    </P_TEXT>' . $sNewLine;
$sXml .='    <ARTICLEDATA>' . $sNewLine;
$sXml .='        <ARTICLE>' . $sNewLine;
$sXml .='           <A_NR>1777-1</A_NR>' . $sNewLine;
$sXml .='            <A_ACTIVE>1</A_ACTIVE>' . $sNewLine;
$sXml .='            <A_EAN>2515911601760</A_EAN>' . $sNewLine;
$sXml .='            <A_PROD_NR></A_PROD_NR>' . $sNewLine;
$sXml .='           <A_NR2>058de82247787f5fd54d523f0c823e0</A_NR2>' . $sNewLine;
$sXml .='           <A_PRICEDATA>' . $sNewLine;
$sXml .='                <A_PRICE channel="chxx">' . $sNewLine;
$sXml .='                   <A_VK>79.00</A_VK>' . $sNewLine;
$sXml .='                    <A_VK_OLD>99.00</A_VK_OLD>' . $sNewLine;
$sXml .='                   <A_UVP>99.00</A_UVP>' . $sNewLine;
$sXml .='                   <A_MWST>3</A_MWST>' . $sNewLine;
$sXml .='               </A_PRICE>' . $sNewLine;
$sXml .='            </A_PRICEDATA>' . $sNewLine;
$sXml .='            <A_MEDIADATA>' . $sNewLine;
$sXml .='                <A_MEDIA type="IMAGE" sort="0">https://your.shop/pictures//product/1/picture001.jpg</A_MEDIA>' . $sNewLine;
$sXml .='            </A_MEDIADATA>' . $sNewLine;
$sXml .='            <A_STOCK>48</A_STOCK>' . $sNewLine;
$sXml .='        </ARTICLE>' . $sNewLine;
$sXml .='    </ARTICLEDATA>' . $sNewLine;
$sXml .='    </PRODUCT>' . $sNewLine;
$sXml .='    </PRODUCTDATA>' . $sNewLine;
$sXml .='    </TBCATALOG>' . $sNewLine;


$sApiUser = 'api-user'; // Your API username
$sApiPassword = 'api-password'; // Your API password
$sMerchantId = '1234'; // Your digit merchant ID
$sChannelId = '5678'; // Your digit channel ID

/**
 * Name the file according to specifications
 */
$fileName = "TBCAT_".date("YmdHis").".xml";


/*
 * Send data to REST API with curl
 */
$sUrl = "https://rest.trade-server.net/" . $sMerchantId ."/sync/in/" . $fileName;


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