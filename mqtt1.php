<?php
require_once('phpMQTT.php');
$url = parse_url(getenv('m12.cloudmqtt.com'));
$topic =  '/ESP/LED';
$client_id = "phpMQTT-publisher";
$username = "test";                   
$password = "12345"; 


$mqtt = new Bluerhinos\phpMQTT('m12.cloudmqtt.com', '19053', $client_id);
					
$access_token = 'Ic7C4amybrY/6I6lkMssHnGSK3vVz95ZMrSYPqjcRt+Sf+VxzcYDVAy8507sOMd+sP3XZPUyugknLV56oNMg3woZGXOsjUDclHB/E9r+2Og2VczR3137EvthFQjkz2fg34JJxhaX7RDMhN6C840V5gdB04t89/1O/w1cDnyilFU=';
 
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data

if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];
			// Get replyToken
            $replyToken = $event['replyToken'];
         
		 if($text == "เปิดไฟ"){
			 
			     $message = "ON";
				$return_msg = "เปิดไฟแล้วจ้าาาา";		 
			                 }
		 if($text == "ปิดไฟ"){
			 
			    $message = "OFF";
			 	$return_msg = "ปิดไฟแล้วจ้าาาา";		 
			                 }
							 
	if ($mqtt->connect(true, NULL, $username, $password)) {
    $mqtt->publish($topic, $message, 0);
    echo "Published message: " . $message;
    $mqtt->close();
}else{
    $return_msg = "MQTT FAIL...";	
}						 
							 
							 
							 
							 
							 
							 
							 
							 
							 
							 
							 
	 
            // Build message to reply back
             $messages = ['type' => 'text','text' => $return_msg];
			      
 
            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
 
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
 
            echo $result . "\r\n";
        }
    }
}

echo '<a href="test.php">test</a>';

