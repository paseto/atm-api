<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
echo 'init';
echo '<pre>';
$client = new SoapClient('http://webserver.averba.com.br/20/index.soap?wsdl',
    array(
        "trace" => 1,
        "soap_version" => SOAP_1_1
    )
);
$params = [
    'usuario' => 'WS',
    'senha' => 'giro@2019',
    'codatm' => '11363972',
    'xmlCTe' => '??',
];
try {

    $client->__soapCall('averbaCTe', $params);
    $request = $client->__getLastRequest();
    $response = $client->__getLastResponse();

    $doc = new DOMDocument('1.0', 'utf-8');
    $doc->loadXML($response);
    $XMLresults = $doc->getElementsByTagName("Codigo");
    $output = $XMLresults->item(0)->nodeValue;
    print_r($output);

    $fg = fopen('f.xml', 'w+');
    fwrite($fg, $response);
    echo '<pre>';
//    print_r($request);
    print_r($response);
} catch (Exception $exception) {
    print_r($exception);
}

//$client->call('averbaCTe', $params);
//$request = $client->getLastRequest();
//$response = $client->getLastResponse();
?>