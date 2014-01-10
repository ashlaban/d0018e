<?php

require_once '../db.php';

function getRecentProjects( $nProjects )
{
	$query = "SELECT 	projectid,
						projectname,
						owner,
						description,
						to_char(createddate, 'DD Mon, YYYY') AS createddate,
						projectrating,
						nratings
				FROM projectdata
			ORDER BY projectid DESC
			   LIMIT :nProjects";

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':nProjects', $nProjects );
	$stmt->execute();

	echo sql2json($stmt);
}

function getProjectById( $projectid )
{
	$query = 'SELECT 	projectid,
						projectname,
						owner,
						description,
						to_char(createddate, \'DD Mon, YYYY\') AS createddate,
						projectrating,
						nratings
				FROM projectdata
			   WHERE projectid = :projectid;';

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':projectid', $projectid );
	$stmt->execute();

	echo sql2json($stmt);
}

// Actual handler

if (    !isset($_POST['nProjects'])
	 && !isset($_POST['projectid']) )
{ 
	die('{"error":"Wrong arguments. nProjects or projectid expected."}');
}

if      ( isset($_POST['nProjects']) ) { getRecentProjects( $_POST['nProjects'] ); }
else if ( isset($_POST['projectid']) ) { getProjectById(    $_POST['projectid'] ); }