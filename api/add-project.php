<?php

require_once '../db.php';

/**
 * addProject:
 *
 * Required arguments:
 *	owner - 
 *	projectname   -
 *  description   -
 *
 * Optional arguments:
 *	extendedDescription - 
 *
 */
function addProject( $owner, $projectname, $description, $extendedDescription )
{
	$query = "";
	if ( is_null($extendedDescription) )
	{
		$query = "INSERT INTO projectData ( owner,  projectname,  description)
				  VALUES                  (:owner, :projectname, :description)";

	}
	else
	{
		$query = "INSERT INTO projectData ( owner,  projectname,  description,  extendedDescription)
				  VALUES                  (:owner, :projectname, :description, :extendedDescription)";
	}

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	
	$stmt->bindParam( ':owner', $owner );
	$stmt->bindParam( ':projectname', $projectname );
	$stmt->bindParam( ':description', $description );
	if ( !is_null($extendedDescription) )
	{
		$stmt->bindParam( ':extendedDescription', $extendedDescription );
	}

	$stmt->execute();

	// TODO: Error reporting
	$json = array( 'status' => 'success' );
	echo json_encode( $json );
	exit;
}

if ( !isset($_POST["username"   ]) ) { die("{'error': 'username missing'}"   ); }
if ( !isset($_POST["projectname"]) ) { die("{'error': 'projectname missing'}"); }
if ( !isset($_POST["description"]) ) { die("{'error': 'description missing'}"); }

$owner = $_POST["username"];
$projectname   = $_POST["projectname"];
$description   = $_POST["description"];

$extendedDescription = NULL;
if ( isset($_POST["extendedDescription"]) )
{
	$extendedDescription = $_POST["extendedDescription"];
}

addProject( $owner, $projectname, $description, $extendedDescription );
