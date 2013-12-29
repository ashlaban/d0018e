<?php

require_once '../db.php';

function addUser( $username, $password, $isDeveloper, $isProvider )
{	
	$dbh = dbConnect();

	$query = 'SELECT username FROM userPassword WHERE username=:username;';
	$stmt = $dbh->prepare($query);
	
	$stmt->bindParam( ':username', $username );
	$stmt->execute();
	
	if ( $stmt->fetch() )
	{
		$json = array( 'error' => 'username already exists' );
		echo json_encode( $json );
		exit;
	}

	$salt = bin2hex( openssl_random_pseudo_bytes(8) );
	$hash = hash( 'sha256', $password . $salt );

	try
	{
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$query = 'INSERT INTO userData     (  username,  isDeveloper,  isProvider, userRating, nRatings )
				  VALUES                   ( :username, :isDeveloper, :isProvider, 0         , 0        );';
		$stmtUserData = $dbh->prepare($query);
		$stmtUserData->bindParam(':username'   , $username   );
		$stmtUserData->bindParam(':isDeveloper', $isDeveloper);
		$stmtUserData->bindParam(':isProvider' , $isProvider );
		$stmtUserData->execute();

		$query = 'INSERT INTO userPassword ( username,  hash,  salt)
					   VALUES              (:username, :hash, :salt);';
		$stmtUserPass = $dbh->prepare($query);
		$stmtUserPass->bindParam(':username', $username);
		$stmtUserPass->bindParam(':hash'    , $hash    );
		$stmtUserPass->bindParam(':salt'    , $salt    );
		$stmtUserPass->execute();

		$dbh->commit();
	}
	catch (Exception $e)
	{
		$dbh->rollBack();
		$json = array( 'status'  => 'failure' );
		$json = array( 'message' => $e->getMessage() );
		echo json_encode( $json );
		exit;
	}

	// Message success
	$json = array( 'status' => 'success' );
	echo json_encode( $json );
	exit;
}

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