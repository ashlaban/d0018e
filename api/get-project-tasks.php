<?php

require_once '../db.php';

function getProjectTasks( $projectid )
{
	$query = 'SELECT 	localTaskId,
					 	taskName,
					 	description,
					 	status
				FROM projectTasks
			   WHERE projectid = :projectid
			;';

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':projectid', $projectid );
	$stmt->execute();

	return sql2json($stmt);
}

// Actual handler

if ( !isset($_POST['projectid']) ) { die('{"error":"projectid not set"}'); }

$projectid = $_POST['projectid'];

echo getProjectTasks( $projectid );