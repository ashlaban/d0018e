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

		// TODO: Protect against SQL-injects
		$query = "";
		if ( is_null($extendedDescription) )
		{
			$query = "INSERT INTO projectData (  owner ,   projectname ,   description )
					  VALUES                  ('$owner', '$projectname', '$description')";

		}
		else
		{
			$query = "INSERT INTO projectData (  owner ,   projectname ,   description ,   extendedDescription )
					  VALUES                  ('$owner', '$projectname', '$description', '$extendedDescription')";
		}

		// Connect to db and execute SQL
		dbConnectAndSQL( $query );
	}

?>

<?php
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

?>