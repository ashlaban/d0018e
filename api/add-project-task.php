<?php

require_once '../db.php';

/**
 * addProjectTask:
 *
 * Required arguments:
 *   projectid
 *   parenttaskid
 *   taskname
 *   description
 *
 */
function addProjectTask( $projectid, $parenttaskid, $taskname, $description )
{
	$dbh = dbConnect();

	// Get next local taskid
	$query = 'SELECT MAX(localtaskid) FROM projectTasks WHERE projectid = :projectid;';
	$stmt = $dbh->prepare($query);
	$stmt->bindParam( ':projectid', $projectid );
	$stmt->execute();
	$row = $stmt->fetch();

	$localtaskid = $row[0] + 1;

	// Insert task
	$query = '';
	if ( is_null($localtaskid) )
	{
		$query = 'INSERT INTO projectTasks (  projectid,  localtaskid,  taskname,  description )
			           VALUES              ( :projectid, :localtaskid, :taskname, :description );';
	}
	else
	{
		$query = 'INSERT INTO projectTasks (  projectid,  parenttaskid,  localtaskid,  taskname,  description )
			           VALUES              ( :projectid, :parenttaskid, :localtaskid, :taskname, :description );';
	}

	$stmt = $dbh->prepare($query);
	
	$stmt->bindParam( ':projectid'    , $projectid    );
	$stmt->bindParam( ':localtaskid'  , $localtaskid  );
	$stmt->bindParam( ':taskname'     , $taskname     );
	$stmt->bindParam( ':description'  , $description  );

	if ( !is_null($projectid) ) { $stmt->bindParam( ':parenttaskid' , $parenttaskid ); }

	$stmt->execute();
	if( $stmt->errorCode() === '00000' )
	{
		$json = array( 'status' => 'success' );
		echo json_encode( $json );
	}
	else
	{
		$json = array(  'status' => 'failure',
						'error'  => 'Operation not executed.' );
		echo json_encode( $json );
	}	
}

if ( !isset($_POST['projectid'    ]) ) { die( "{'error': 'projectid missing'}"    ); }
if ( !isset($_POST['taskname'     ]) ) { die( "{'error': 'taskname missing'}"     ); }
if ( !isset($_POST['description'  ]) ) { die( "{'error': 'description missing'}"  ); }

$projectid    = $_POST['projectid'];
$taskname     = $_POST['taskname'];
$description  = $_POST['description'];

$parenttaskid = null;
if ( isset($_POST['parenttaskid' ]) ) { $parenttaskid = $_POST['parenttaskid']; }

addProjectTask( $projectid, $parenttaskid, $taskname, $description );
