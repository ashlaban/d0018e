<?php

	require_once '../db.php';

	function login( $username, $password )
	{
		// TODO: Protect from SQL inject
		$query = "SELECT hash, salt FROM userPassword WHERE username='$username';";

		$sql = dbConnectAndSQL( $query );

		// Verify log in information
		$row = pg_fetch_row($sql);

		$salt = $row[1];
		$hash = hash( 'sha256', $password . $salt );

		if ( $hash === $row[0] )
		{
			// Logged in, pass this information to session store
			$json = array( "sessionid" => "testid" );
			echo json_encode( $json );
		}
		else
		{
			// Login fail
			$json = array( "error" => "password does not match" );
			echo json_encode( $json );
		}

	}
?>

<?php
	// The actual handler

	if ( !isset($_POST["username"]) )
	{
		echo "{error: 'Username not specified'}";
		exit;
	}
	if ( !isset($_POST["password"]) )
	{
		echo "{error: 'Password not specified'}";
		exit;
	}
	
	$username = $_POST["username"];
	$password = $_POST["password"];

	login( $username, $password );

?>