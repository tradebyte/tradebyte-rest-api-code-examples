<?php
/**
 * This example script gets information on orders not yet exported from the Tradebyte REST API.
 * Then marks them as exported
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
$sUrl = "https://rest.trade-server.net/" . $sMerchantId . "/orders/?channel=" . $sChannelId;
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
 * Process data as you need.
 */
$oXml = simplexml_load_string($sResponse);

if ($oXml) {

    $ordersImported = [];

    foreach ($oXml->ORDER as $oOrder) {
        echo "Order Date " . (string)$oOrder->ORDER_DATA->ORDER_DATE . PHP_EOL;

        $ordersImported[] = (string)$oOrder->ORDER_DATA->TB_ID;
        echo "Order ID in Tradebyte " . (string)$oOrder->ORDER_DATA->TB_ID . PHP_EOL;
        echo "Order Number (in channel): " . (string)$oOrder->ORDER_DATA->CHANNEL_NO . PHP_EOL;

        /**
         * Example of Shipping Information
         */
        if ($oOrder->SELL_TO){
            echo "Payment Address: " . $oXml->ORDER->SELL_TO->STREET_NO . PHP_EOL;
        }
        /**
         *  Tag SHIP_TO is mandatory so we don't need to check existence
         */
        echo "Shipping Address: " . $oXml->ORDER->SHIP_TO->STREET_NO . PHP_EOL;

        echo "Order Items: " . PHP_EOL;
        /**
         * Here we loop through Order's Items
         */
        foreach ($oOrder->ITEMS->ITEM as $oOrderItem) {
            echo "Article EAN " . (string)$oOrderItem->EAN .
                " Quantity: " . (string)$oOrderItem->QUANTITY .
                " Price: " . (string)$oOrderItem->ITEM_PRICE . PHP_EOL;

        }
    }

    /**
     * Sending confirmation to Tradebyte
     */
    sendExportedFlagToTradebyte($ordersImported, $sMerchantId, $sApiUser, $sApiPassword);

} else {
    print_r($sResponse);
}



function sendExportedFlagToTradebyte($orderId, $sMerchantId, $sApiUser, $sApiPassword){

    foreach ($arrayOfIds as $orderId){
        $sUrl = "https://rest.trade-server.net/" . $sMerchantId . "/orders/" . $orderId . "/exported?";

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
        }
        else{
            echo "Export Confirmation for Order: " . $orderId . " successfully sent." . PHP_EOL;
        }
        curl_close($oCurl);
    }
}
