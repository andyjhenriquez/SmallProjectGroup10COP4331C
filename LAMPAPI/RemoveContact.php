<?php

$inData = getRequestInfo();

$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");

if( $conn->connect_error )
{
    returnWithError( $conn->connect_error );
}
else
{
    $stmt = $conn->prepare("DELETE FROM Colors WHERE Name =? AND UserID =?");
    $stmt->bind_param("si", $inData["name"], $inData["userID"]);
    $stmt->execute();
    $result = $stmt->get_result();

    var_dump($result);

    if(!$result)
    {
        http_response_code(404);
        returnWithError("No Records Found");
    }

    $stmt->close();
    $conn->close();
}

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson( $obj )
{
    header('Content-type: application/json');
    echo $obj;
}

function returnWithError( $err )
{
    $retValue = '{"id":0,"error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
}

function returnWithInfo( $numRows )
{
    $retValue = '{"NumRows":' . $numRows . '}';
    sendResultInfoAsJson( $retValue );
}

?>