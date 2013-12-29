<?php

require_once '../db.php';

function login( $username, $password )
{
	$dbh = dbConnect();

	$query = 'SELECT hash, salt FROM userPassword WHERE username=:username;';
	$stmt = $dbh->prepare($query);
	$stmt->bindParam(':username', $username);

	$stmt->execute();

	// Verify log in information
	$data = $stmt->fetch(PDO::FETCH_ASSOC);

	$salt = $data['salt'];
	$hash = hash( 'sha256', $password . $salt );

	if ( $hash === $data['hash'] )
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