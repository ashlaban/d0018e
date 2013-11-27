<?php

	function getProject( $projectid )
	{
		$conn = pg_connect( "dbname=testdb user=db-man" );
		if (!$conn) {
			echo "An error occurred.\n";
			exit;
		}

		$sql = pg_query( $conn, "SELECT * FROM ProjectDataTest WHERE projectid=$projectid;" );
		if (!$sql) {
	 		echo "An error occurred.\n";
			exit;
		}

		// Fetch project data from db
		$json = array();
		while ( $row = pg_fetch_row($sql) ) {
			$proj = array();
			$proj["name"]       = $row[1];
			$proj["short-desc"] = $row[2];
			if ( $row[2] != NULL )
			{
				$proj["long-desc"] = $row[2];
			}
			else
			{
				$proj["long-desc"] = "";
			}

			array_push($json, $proj);
		}

		// Emit project data as json
		echo json_encode( $json );

	}

	if ( isset($_POST["projectid"]) )
	{
		$projectid = $_POST["projectid"];
		getProject( $projectid );
	}

?>