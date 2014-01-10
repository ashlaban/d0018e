<?php

require_once '../db.php';

function getRootTasks( $projectid )
{
	$query = 'SELECT 	taskid,
						localtaskid,
					 	taskname,
					 	description,
					 	status
				FROM projecttasks
			   WHERE projectid    = :projectid
			     AND parenttaskid IS NULL
			;';

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':projectid', $projectid );
	
	$stmt->execute();
	if( $stmt->errorCode() === '00000' )
	{
		echo sql2json($stmt);	
	}
	else
	{
		$json = array(  'status' => 'failure',
						'error'  => 'Operation not executed.' );
		echo json_encode( $json );
	}

}

function getSubtaskToTask( $projectid, $parenttaskid )
{
	$query = 'SELECT 	taskid,
						localtaskid,
					 	taskname,
					 	description,
					 	status
				FROM projecttasks
			   WHERE projectid    = :projectid
			     AND parenttaskid = :parenttaskid
			;';

	$dbh = dbConnect();
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':projectid'   , $projectid );
	$stmt->bindParam( ':parenttaskid', $parenttaskid );

	$stmt->execute();
	if( $stmt->errorCode() === '00000' )
	{
		echo sql2json($stmt);	
	}
	else
	{
		$json = array(  'status' => 'failure',
						'error'  => 'Operation not executed.' );
		echo json_encode( $json );
	}
}

// Actual handler

if ( !isset($_POST['projectid']) )
{
	die('{"error":"projectid not set"}');
}

if ( !isset($_POST['parenttaskid']) )
{
	$projectid = $_POST['projectid'];
	getRootTasks( $projectid );

}
else
{
	$projectid    = $_POST['projectid'];
	$parenttaskid = $_POST['parenttaskid'];
	getSubtaskToTask( $projectid, $parenttaskid );
}
