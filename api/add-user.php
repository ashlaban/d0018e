<?php

	require_once '../db.php';

	function addUser( $username, $password, $isDeveloper, $isProvider )
	{	
		$conn = dbConnect();

		// TODO: Protect from SQL inject
		$query = "SELECT username FROM userPassword WHERE username='$username';";

		$sql = dbSQL( $conn, $query );
		
		if ( pg_fetch_row($sql) )
		{
			$json = array( 'error' => 'username already exists' );
			echo json_encode( $json );
			exit;
		}
		
		$salt = bin2hex( openssl_random_pseudo_bytes(8) );
		$hash = hash( 'sha256', $password . $salt );
		
		$query = "BEGIN;";
		$query .= "INSERT INTO userData     ( username   , isDeveloper , isProvider , userRating, nRatings )
				 VALUES                   ( '$username', $isDeveloper, $isProvider, 0         , 0        );";
		$query .= "INSERT INTO userPassword (username, hash, salt) VALUES ('$username', '$hash', '$salt');";
		$query .= "COMMIT;";

		dbSQL( $conn, $query );
	}
?>

<?php
	// The actual handler

	if ( !isset($_POST['username'   ]) ) { echo "{error: 'Username not specified'}";    exit; }
	if ( !isset($_POST['password'   ]) ) { echo "{error: 'Password not specified'}";    exit; }
	if ( !isset($_POST['isDeveloper']) ) { echo "{error: 'isDeveloper not specified'}"; exit; }
	if ( !isset($_POST['isProvider' ]) ) { echo "{error: 'isProvider not specified'}";  exit; }
	
	$username    = $_POST['username'];
	$password    = $_POST['password'];
	$isDeveloper = $_POST['isDeveloper'];
	$isProvider  = $_POST['isProvider' ];

	addUser( $username, $password, $isDeveloper, $isProvider );

?>