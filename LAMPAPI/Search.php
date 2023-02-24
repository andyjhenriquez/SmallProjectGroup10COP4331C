<?php
    ini_set('display_errors', 1);

    $inData = getRequestInfo();

    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];

	// Connect to MySQL with (localhost, username, password, database)
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
        //Gets userID from logged in user session
        session_start();
        $userID = $_SESSION['userID'];

		// Molds the skeleton for the action to be taken in the database
		$stmt = $conn->prepare("SELECT firstName, lastName, phone, email FROM Contacts WHERE userID=? AND firstName=? OR lastName=?");

		// Sets variables (s for string i for integer)
		$stmt->bind_param("iss", $userID, $firstName, $lastName);

        // Executes SQL command
		$stmt->execute();

        $result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['firstName'], $row['lastName'], $row['phone'], $row['email'] );
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
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

    function returnWithInfo( $firstName, $lastName, $phone, $email)
	{
		$retValue = '{"firstName":"' . $firstName . '","lastName":"' . $lastName . '","phone":"' . $phone . '","email":"' . $email .'"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>