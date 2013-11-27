<?php

	function addProject( $name, $shortDesc, $longDesc )
	{
		$conn = pg_connect( "dbname=testdb user=db-man" );
		if (!$conn) {
			echo "An error occurred.\n";
			exit;
		}

		$query = "INSERT INTO ProjectDataTest (projectName, description) VALUES ('$name', '$shortDesc')";

		$sql = pg_query( $conn, $query );
		if (!$sql) {
	 		echo "An error occurred.\n";
			exit;
		}

		echo "Test";
	}

	if ( isset($_POST["name"]) and isset($_POST["shortDesc"]) )
	{
		$name      = $_POST["name"];
		$shortDesc = $_POST["shortDesc"];
		addProject( $name, $shortDesc, "" );
	}

?>