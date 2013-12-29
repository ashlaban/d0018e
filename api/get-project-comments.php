<?php

require_once '../db.php';

function getProjectComments( $projectid )
{
	// TODO: SQL-inject fix - $projectid must be number.
	$query = "SELECT 	username,
					 	comment
				FROM projectComments
			   WHERE projectid = $projectid
			;";

	$sql = dbConnectAndSQL( $query );

	return sql2json($sql);
}

// Actual handler

if ( !isset($_POST['projectid']) ) { die('{"error":"projectid not set"}'); }

$projectid = $_POST['projectid'];

echo getProjectComments( $projectid );