<?php

require_once '../db.php';

/**
 * addProjectComment:
 *
 * Required arguments:
 *	commentee  - 
 *	commenter -
 *  comment   -
 *
 */
function addUserComment( $commentee, $commenter, $comment )
{
	$query = "";
	$query = "INSERT INTO usercomments (  commentee,  commenter,  comment  )
			       VALUES              ( :commentee, :commenter, :comment )";

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	
	$stmt->bindParam( ':commentee' , $commentee  );
	$stmt->bindParam( ':commenter', $commenter );
	$stmt->bindParam( ':comment'  , $comment   );

	$stmt->execute();

	// TODO: Error reporting
	$json = array( 'status' => 'success' );
	echo json_encode( $json );
	exit;
}

if ( !isset($_POST["commentee"]) ) { die("{'error': 'commentee missing'}" ); }
if ( !isset($_POST["commenter"]) ) { die("{'error': 'commenter missing'}" ); }
if ( !isset($_POST["comment"  ]) ) { die("{'error': 'comment missing'}"   ); }

$commentee  = $_POST["commentee"];
$commenter = $_POST["commenter"];
$comment   = $_POST["comment"];

addUserComment( $commentee, $commenter, $comment );
