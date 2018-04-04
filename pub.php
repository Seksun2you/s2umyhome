<?php
require_once('phpMQTT.php');
$url = parse_url(getenv('m12.cloudmqtt.com'));
$topic =  '/ESP/LED';
$client_id = "phpMQTT-pubweb";
$username = "test";                   
$password = "12345"; 
$message = "ON";

$mqtt = new Bluerhinos\phpMQTT('m12.cloudmqtt.com', '19053', $client_id);
if ($mqtt->connect(true, NULL, $username, $password)) {
    $mqtt->publish($topic, $message, 0);
    echo "Published message: " . $message;
    $mqtt->close();
}else{
    $return_msg = "MQTT FAIL...";	
}	
