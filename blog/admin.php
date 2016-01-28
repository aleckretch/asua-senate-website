<?php
require_once "./database.php";
require_once "./session.php";
/*
	This page holds the different HTML forms for the backend.
	TODO: Need to show the corresponding form once they have been created
*/

function showMessage( $str , $correctStr, $messageCorrect, $messageWrong )
{
	if ( $str === $correctStr )
	{
		echo Database::sanitizeData( $messageCorrect );
	}
	else
	{
		echo Database::sanitizeData( $messageWrong );
	}
}

function checkUploaded( $isUpload, $notUploadStr, $str, $correctStr, $messageCorrect, $messageWrong )
{
	if ( $isUpload )
	{
		showMessage( $str, $correctStr, $messageCorrect, $messageWrong );
	}
	else
	{
		echo Database::sanitizeData( $notUploadStr );
	}
}

//if the user is not logged in, do not allow them to see this page, redirect to login.php to have them login
if ( !Session::userLoggedIn() )
{
	header( "Location: login.php" );
	exit();
}

$req = $_GET;
$uploaded = isset( $req[ 'uploaded' ] );
$correct = ( $uploaded ? $req[ 'uploaded' ] : "" );
if ( isset( $req[ 'blog' ] ) )
{
	checkUploaded( $uploaded, "TODO: Blog form needed" , $correct , "yes" , "Blog post created" , $correct );
}
else if ( isset( $req[ 'agenda' ] ) )
{
	checkUploaded( $uploaded, "TODO: Agenda Upload form needed" , $correct , "yes" , "Agenda uploaded" , $correct );
}
else if ( isset( $req[ 'roster' ] ) )
{
	checkUploaded( $uploaded, "TODO: Roster form needed" , $correct , "yes" , "Roster added to" , $correct );
}
else
{
	echo "TODO: Entrance page needed";
}
