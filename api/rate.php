<?php

require_once '../db.php';

function rateUser( $username, $rating )
{
	$dbh = dbConnect();
		
	$query = "UPDATE userdata
				 SET userrating = userrating + :rating,
				     nRatings      = nRatings + 1
			   WHERE username = :username";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':username', $username );
	$stmt->bindParam( ':rating', $rating );
	$stmt->execute();

	if( $stmt->errorCode() === '00000' )
	{
		$json = array( 'status' => 'success' );
		echo json_encode( $json );
	}
	else
	{
		$json = array(  'status' => 'failure',
						'error'  => 'Operation not executed.' );
		echo json_encode( $json );
	}
}

function rateProject( $projectid, $rating )
{
	$dbh = dbConnect();
		
	$query = "UPDATE projectdata
				 SET projectrating = projectrating + :rating,
				     nRatings      = nRatings + 1
			   WHERE projectid = :projectid";
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':projectid', $projectid );
	$stmt->bindParam( ':rating', $rating );
	$stmt->execute();

	if( $stmt->errorCode() === '00000' )
	{
		$json = array( 'status' => 'success' );
		echo json_encode( $json );
	}
	else
	{
		$json = array(  'status' => 'failure',
						'error'  => 'Operation not executed.' );
		echo json_encode( $json );
	}	
}

// Actual handler

if ( !isset($_POST['rating']) )
{
	die('{"error":"Wrong arguments. rating expected."}');
}

$rating = $_POST['rating'];
if (0 > $rating && $rating > 5)
{
	die('{"error":"Rating out of range. Must be within 0-5."}');	
}

if (    !isset($_POST['username'])
	 && !isset($_POST['projectid']) )
{ 
	die('{"error":"Wrong arguments. username or projectid expected."}');
}

if      ( isset($_POST['username' ]) ) { rateuser(    $_POST['username' ], $rating ); }
else if ( isset($_POST['projectid']) ) { rateproject( $_POST['projectid'], $rating ); }