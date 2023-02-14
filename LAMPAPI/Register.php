<?php
	$inData = getRequestInfo();

	// Storing expected values from passed JSON body
	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
    $user = $inData["user"];
    $pass = $inData["pass"];

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{

		// Molds the skeleton for the action to be taken in the database
		$stmt = $conn->prepare("INSERT INTO DevUsers (firstName, lastName, user, pass) VALUES(?,?,?,?)");

		// Sets variables (s for string i for integer)
		$stmt->bind_param("ssss", $firstName, $lastName, $user, $pass);

		// Executes SQL command
		$stmt->execute(); 

		$stmt->close();
		$conn->close();
		
		returnWithError("");
	}

	// Translates the request into a json body
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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>