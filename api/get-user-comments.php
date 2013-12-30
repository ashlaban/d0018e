<?php

require_once '../db.php';

function getUserComments( $commentee )
{
	$query = 'SELECT 	commenter,
					 	comment
				FROM usercomments
			   WHERE commentee = :commentee
			;';

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindValue( ':commentee', $commentee );
	$stmt->execute();

	return sql2json($stmt);
}

// Actual handler

if ( !isset($_POST['commentee']) ) { die('{"error":"commentee not set"}'); }

$commentee = $_POST['commentee'];

echo getUserComments( $commentee );