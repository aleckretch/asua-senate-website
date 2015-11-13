<?php
/*
	TODO: Need to secure this by making sure user is logged in, and correct CSRF token was sent
	Probably should also prevent files that are too large
*/
require_once "database.php" ;

if ( !isset($_FILES['file']['error']) )
{
	die( "File not provided" );
}

if ( $_FILES['file']['error'] !== UPLOAD_ERR_OK )  
{
    die( "Upload failed with error {$_FILES['file']['error']}" );
}

//open resource to get actual mime type from the file
$finfo = finfo_open(FILEINFO_MIME_TYPE);
//get the mime type from the file information on the server( doesn't use info sent by client)
$mime = finfo_file( $finfo, $_FILES['file']['tmp_name'] );

//if the mime type is not a PDF file, then ignore the file
if ( $mime !== "application/pdf" )
{
	die( "{$mime} is not PDF" );
}

//TODO:
//Generate an agenda item in the database with the name of the file provided
//move the pdf file to a folder, make a new filename that doesn't use user input/old filename, make sure has pdf extension
//also use this after moving the file to change its permissions so it cannot execute: chmod( newFileDirectory , 0644 );



