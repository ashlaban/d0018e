<?php

require_once '../db.php';

/**
 * addProjectComment:
 *
 * Required arguments:
 *	username  - 
 *	projectid -
 *  comment   -
 *
 */
function addProjectComment( $username, $projectid, $comment )
{
	$query = "";
	$query = "INSERT INTO projectComments (	 username,  projectid,  comment  )
			       VALUES                 ( :username, :projectid, :comment )";

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	
	$stmt->bindParam( ':username' , $username  );
	$stmt->bindParam( ':projectid', $projectid );
	$stmt->bindParam( ':comment'  , $comment   );

	$stmt->execute();

	// TODO: Error reporting
	$json = array( 'status' => 'success' );
	echo json_encode( $json );
	exit;
}

if ( !isset($_POST["username"   ]) ) { die("{'error': 'username missing'}"  ); }
if ( !isset($_POST["projectid"  ]) ) { die("{'error': 'projectid missing'}" ); }
if ( !isset($_POST["comment"    ]) ) { die("{'error': 'comment missing'}"   ); }

$username  = $_POST["username"];
$projectid = $_POST["projectid"];
$comment   = $_POST["comment"];

addProjectComment( $username, $projectid, $comment );
