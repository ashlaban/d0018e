<?php

	function login( $username, $password )
	{
		$conn = pg_connect( "dbname=testdb user=db-man" );
		if (!$conn) {
			echo "An error occurred.\n";
			exit;
		}

		$sql = pg_query( $conn, "SELECT password FROM userDataTest WHERE username='$username';" );
		if (!$sql) {
	 		echo "An error occurred.\n";
			exit;
		}

		// Verify log in information
		$row = pg_fetch_row($sql);
		if ( $row[0] === $password )
		{
			// Logged in, pass this information to session store
			$json = array( "sessionid" => "testid" );
			echo json_encode( $json );
		}

	}

	if ( isset($_POST["username"]) and isset($_POST["password"]) )
	{
		login( $_POST["username"], $_POST["password"] );
	}

?>