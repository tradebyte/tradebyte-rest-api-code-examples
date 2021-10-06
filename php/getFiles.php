<?php
include "vendor/autoload.php";

/**
 * This example retrieves available order files (pdf)
 * possible files are invoice, deliverynote, shiplabel which is specified in $fileType
 * @author Norman Albusberger <norman.albusberger@fatchip.de>
 */

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/*
 * API-Credentials - modify to your personal access credentials
 *
 * @see https://tradebyte.io/how-to/generate-rest-api-credentials-in-tb-one/
 */
$sApiUser = 'API_TBMarket'; // Your API username
$sApiPassword = 'fatchip123'; // Your API password
$sMerchantId = '1566'; // Your digit merchant ID
$sChannelId = '1289'; // Your digit channel ID
$fileType = "invoice";
//$fileType = "deliverynote";
// $fileType = "shiplabel";
$options = [
    "auth_basic" => [
        $sApiUser, $sApiPassword
    ]
];

$url = "https://rest.trade-server.net/" . $sMerchantId . "/orders/" . $fileType . "/?channel=" . $sChannelId;
$client = HttpClient::create();
echo $url;

try {
    $response = $client->request('GET', $url, $options);
    print_r($response->getHeaders());
} catch (Exception $exception) {
    echo $exception->getMessage();
}

