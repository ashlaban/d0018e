<?php

require_once '../db.php';

function getProjects( $nProjects )
{
	// TODO: SQL-inject fix - $nProjects must be number.
	$query = "SELECT projectname, owner, description, to_char(createddate, 'DD Mon, YYYY') AS createddate
				FROM projectdata
			ORDER BY projectid DESC
			   LIMIT $nProjects";

	$sql = dbConnectAndSQL( $query );

	echo sql2json($sql);
}

// Actual handler

if ( !isset($_POST['nProjects']) ) { die('{"error":"N projects not set"}'); }

$nProjects = $_POST['nProjects'];

echo getProjects( $nProjects );