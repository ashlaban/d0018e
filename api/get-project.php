<?php

require_once '../db.php';

function getProjects( $nProjects )
{
	$query = "SELECT 	projectid,
						projectname,
						owner,
						description,
						to_char(createddate, 'DD Mon, YYYY') AS createddate
				FROM projectdata
			ORDER BY projectid DESC
			   LIMIT :nProjects";

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':nProjects', $nProjects );
	$stmt->execute();

	echo sql2json($stmt);
}

// Actual handler

if ( !isset($_POST['nProjects']) ) { die('{"error":"N projects not set"}'); }

$nProjects = $_POST['nProjects'];

echo getProjects( $nProjects );