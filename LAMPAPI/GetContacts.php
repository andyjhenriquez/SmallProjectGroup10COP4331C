<?php

	header('Content-type: application/json');
	header('Access-Control-Allow-Origin');

	ini_set('display_errors', 1);

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
		$stmt = $conn->prepare("SELECT firstName, lastName, phone, email, ID FROM Contacts WHERE userID = ?");

		// Sets variables (s for string i for integer)
		$stmt->bind_param("i", $userID);

		// Executes SQL command
		$stmt->execute();

		$result = $stmt->get_result();

		$rows = [];
		if( $row = $result->fetch_assoc()  )
		{
			while($row = $result->fetch_row()) {
				$rows[] = $row;
			}
			returnWithInfo($rows);
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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo($rows)
	{
		$retValue = '[';
		foreach($rows as $row)
		{
			$retValue .= '{"firstName":"' . $row[0] . '","lastName":"' . $row[1] . '","phone":"' . $row[2] . '","email":"' . $row[3] . '","ID":"'. $row[4] . '"},';	
		}
		$retValue = rtrim($retValue, ",");
		$retValue .= ']';
		sendResultInfoAsJson( $retValue );
	}
	
	
?>