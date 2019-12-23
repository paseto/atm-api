<?php
ini_set('display_errors', 1);
require 'vendor/autoload.php';
use Paseto\ATMAverba;

echo 'init';
echo '<pre>';
try {
    $averba = new ATMAverba();
    $result = $averba->setUser('WS')
        ->setPassword('giro@2019')
        ->setCod('11363972')
        ->setXml('123')
        ->averbaCTe();

    if ($result == false) {
        echo $averba->getErrors();
    } else {
        $response = $averba->getResponse();
        print_r($response);
    }

} catch (Exception $exception) {
    print_r($exception);
}
