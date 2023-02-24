<?php

	header('Content-type: application/json');
	header('Access-Control-Allow-Origin');

	$inData = getRequestInfo();
	
	$ID = 0;
	$firstName = "";
	$lastName = "";

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331"); 	
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{

		// Molds the command to be done in MySQL
		$stmt = $conn->prepare("SELECT ID, firstName, lastName FROM Users WHERE user=? AND pass =?");

		// Sets the missing variables ('?') in the command (ss because it's two Strings)
		$stmt->bind_param("ss", $inData["user"], $inData["pass"]);

		$stmt->execute();

		// Gets the table data from the given command, returns FALSE if nothing found
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['firstName'], $row['lastName'], $row['ID'] );

			// Starts session and stores the logged in user ID
			session_start();
			$_SESSION['userID'] = $row['ID'];
		}
		else
		{
			returnWithError("No Records Found");
		}

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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
