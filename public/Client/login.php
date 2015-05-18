<?php
// Your ID and token
$blogID = '8070105920543249955';
$authToken = 'Bearer QA4J9NNLUpidejnm1OJSQENO7r2nlQsuq4Ld8xbp';

// The data to send to the API


$postData2 = array(
    'from_id' => '2',
    'username' => 'usertest3',
    'title' => 'message 1',
    'message' => 'This is a test'
);



// The data to send to the API
$postData = array(
    'username' => 'breno604',
    'name' => 'Bren4',
    'email' => 'breno604@gmail.com',
    'password' => '1234567',
    'photo' => 'none3'
);


// Setup cURL
$ch = curl_init('http://localhost/BunqChat/public/api/v1/messages');
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.$authToken,
        'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => json_encode($postData2)
));

// Send the request
$response = curl_exec($ch);

// Check for errors
if($response === FALSE){
    //die(curl_error($ch));
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
echo $response;
//echo $responseData;