<?php
	$inData = getRequestInfo();

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{

		session_start();

		// Starts the session to grab the userID stored upon login
		$userID = $_SESSION['userID'];
		echo "session userid type : " . gettype($_SESSION['userID']);

		// Molds the skeleton for the action to be taken in the database
		$stmt = $conn->prepare("DELETE FROM Users WHERE ID = ?");

		// Sets variables (s for string i for integer)
		$stmt->bind_param("i", $userID);

		// Executes SQL command
		$stmt->execute();

		session_unset();
		session_destroy();

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