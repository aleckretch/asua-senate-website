<?php
/*
	JSON/AJAX Handler
*/
require_once "./database.php";
require_once "./session.php";

//returns the most recent agenda if agenda=first or all archived agendas if agenda=archived
//each agenda returned has a download attribute that contains the link for downloading the pdf for that agenda
if ( isset( $_GET['agenda'] ) )
{
	if ( $_GET['agenda'] === "first" )
	{
		echo json_encode( Database::withDownloadLinks( array( Database::getMostRecentAgenda() ) ) );
	}
	else if ( $_GET['agenda'] === "archived" )
	{
		echo json_encode( Database::withDownloadLinks( Database::getAgendas( 1 ) ) );
	}
}
//returns the entire roster if roster=all or the senator with the id provided
else if ( isset( $_GET['roster'] ) )
{
	if ( $_GET['roster'] === "all" )
	{
		echo json_encode( Database::getEntireRoster() );
	}
	else
	{
		echo json_encode( Database::getRosterFromID( $_GET['roster'] ) );
	}
}
//returns the most recent blog if blog=first or 3 previous posts from id provided as blog
else if ( isset( $_GET['blog'] ) )
{
	$response = $_GET['blog'];
	if ( $response === "first" )
	{
		$data = array( Database::getMostRecentPost() );
		$data = Database::convertDateOfBlogPosts( $data );
		echo json_encode( $data );
	}
	else
	{
		echo json_encode( Database::convertDateOfBlogPosts( Database::getPostsBeforeID( $response ) ) );
	}
}
