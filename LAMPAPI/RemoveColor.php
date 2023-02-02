<?php
	$inData = getRequestInfo();

	var_dump($inData); // Print statement but for non-Strings

	$colorName = $inData["name"];
	$userID = $inData["userID"];

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		echo "Connection unsuccessful\n";
		returnWithError( $conn->connect_error );
	} 
	else
	{
		echo "Connection successful\n";

		// Molds the skeleton for the action to be taken in the database
		$stmt = $conn->prepare("DELETE FROM Colors WHERE name = ? AND userID = ?)");
		echo "Prepared\n";

		// Sets variables (s for string i for integer)
		$stmt->bind_param("si", $colorName, $userID);
		echo "Bound\n";

		// Executes SQL command
		$stmt->execute(); 
		echo "Executed\n";

		$stmt->close();
		echo "Closing stmt\n";

		$conn->close();
		echo "Closing the connection\n";
		
		returnWithError("");
		echo "Returned with error\n";
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