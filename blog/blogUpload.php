<?php
require_once "./database.php";
require_once "./session.php";
/*
	This page handles uploading of blog posts.
	TODO: Need to secure this by making sure correct CSRF token was sent
*/

//if the user is not logged in, do not allow the upload to continue into database
if ( !Session::userLoggedIn() )
{
	header( "Location: login.php" );
	exit();
}

$req = $_POST;
$needed = array( "author" , "title" , "text", "token" );
foreach( $needed as $key=>$value )
{
	if ( !isset( $req[ $value ] ) )
	{
		die( "Missing {$value}" );
	}
}

if ( !Session::verifyToken( $req['token'] ) )
{
	$str = urlencode( "Request could not be handled, token does not match" );
	header( "Location: admin.php?blog=true&uploaded={$str}" );
	exit();
	
}

$title = Database::sanitizeData( $req[ 'title' ] );
$text = Database::sanitizeData( $req[ 'text' ] ); 
$author = Database::sanitizeData( $req['author'] );
Database::createBlogPost( $author, $title, $text );

header( "Location: admin.php?blog=true&uploaded=yes" );
exit();

