<?php

    # Contact Object
    # userId Integer example: 21
    # name String example: Jason Todd
    # email (optional) String example: jtodd@gmail.com
    # phone (optional) String example: 555-555-5555
    # dateCreated (optional) String example: 01/25/23

// Accept JSON data in the request body
$data = json_decode(file_get_contents('php://input'), true);

// Process the data and send a response
$response = processData($data);
header('Contact: application/json');
echo json_encode($response);

function processData($data) {
    // Add your own code to process the data and return a response
    return array('message' => 'Data received');
}

?>
