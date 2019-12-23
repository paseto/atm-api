<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
echo 'init';
echo '<pre>';
$client = new \Zend\Soap\Client('http://webserver.averba.com.br/20/index.soap?wsdl',
    array(
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

    $client->call('averbaCTe', $params);
    $request = $client->getLastRequest();
    $response = $client->getLastResponse();

    echo '<pre>';
    print_r($request);
    print_r($response);
} catch (Exception $exception) {
    print_r($exception);
}

//$client->call('averbaCTe', $params);
//$request = $client->getLastRequest();
//$response = $client->getLastResponse();
?>