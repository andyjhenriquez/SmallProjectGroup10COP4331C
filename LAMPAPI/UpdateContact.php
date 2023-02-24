<?php

	header('Content-type: application/json');
	header('Access-Control-Allow-Origin');

    ini_set('display_errors', 1);

    $inData = getRequestInfo();

    $contactID = $inData["ID"];

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		// Molds the skeleton for the action to be taken in the database
		$stmt = $conn->prepare("UPDATE Contacts SET firstName = ?, lastName = ?, phone = ?, email = ? WHERE ID=?");

		// Sets variables (s for string i for integer)
		$stmt->bind_param("ssssi", $inData['firstName'], $inData['lastName'], $inData['phone'], $inData['email'], $contactID);

        // Executes SQL command
		$stmt->execute();

        $result = $stmt->get_result();

		$stmt->close();
		$conn->close();
	}

	// Translates the request into a json body
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>