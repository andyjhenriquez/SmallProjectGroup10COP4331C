<?php
	$inData = getRequestInfo();

	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
	$phone = $inData["phone"];
	$email = $inData["email"];

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{

		// Starts the session to grab the userID stored upon login
		session_start();
		$userID = $_SESSION['userID'];

		echo "Session started\n";

		// Molds the skeleton for the action to be taken in the database
		$stmt = $conn->prepare("INSERT INTO DevContacts (firstName, lastName, phone, email, userID) VALUES(?,?,?,?,?)");

		echo "Prepared\n";

		// Sets variables (s for string i for integer)
		$stmt->bind_param("ssssi", $firstName, $lastName, $phone, $email, $userID);

		echo "Bound\n";

		echo "userID type = " . gettype($userID) . "\n";
		echo "phone type = " . gettype($phone) . "\n";

		// Executes SQL command
		$stmt->execute(); 

		echo "Executed\n";

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