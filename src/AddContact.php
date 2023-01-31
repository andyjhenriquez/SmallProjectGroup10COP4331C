<?php

// Accept JSON data in the request body
$data = json_decode(file_get_contents('php://input'), true);

// Process the data and send a response
$response = processData($data);
header('Content-Type: application/json');
echo json_encode($response);

function processData($data) {
    // Add your own code to process the data and return a response
    echo $data["name"];
    return array('message' => 'Data received');
}

?>