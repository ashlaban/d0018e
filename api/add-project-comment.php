<?php

require_once '../db.php';

/**
 * addProjectComment:
 *
 * Required arguments:
 *	username  - 
 *	projectid -
 *  comment   -
 *
 */
function addProjectComment( $username, $projectid, $comment )
{

	// TODO: Protect against SQL-injects
	$query = "";
	$query = "INSERT INTO projectComments (	  username,   projectid,   comment  )
			       VALUES                 ( '$username', $projectid, '$comment' )";

	// Connect to db and execute SQL
	dbConnectAndSQL( $query );
}

if ( !isset($_POST["username"   ]) ) { die("{'error': 'username missing'}"  ); }
if ( !isset($_POST["projectid"  ]) ) { die("{'error': 'projectid missing'}" ); }
if ( !isset($_POST["comment"    ]) ) { die("{'error': 'comment missing'}"   ); }

$username  = $_POST["username"];
$projectid = $_POST["projectid"];
$comment   = $_POST["comment"];

addProjectComment( $username, $projectid, $comment );
