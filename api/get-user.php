<?php

require_once '../db.php';

function getUserByName( $username )
{
	$query = "SELECT 	username,
						isProvider,
						isDeveloper,
						userrating,
						nRatings
				FROM userdata
			   WHERE username = :username";

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':username', $username );
	$stmt->execute();

	echo sql2json($stmt);
}

function getUserById( $userid )
{
	// Not implemented yet..!
}

// Actual handler

if (    !isset($_POST['username'])
	 && !isset($_POST['userid']) )
{ 
	die('{"error":"Wrong arguments. username or userid expected."}');
}

if      ( isset($_POST['username']) ) { getUserByName( $_POST['username'] ); }
else if ( isset($_POST['userid']  ) ) { getUserById(   $_POST['userid']   ); }