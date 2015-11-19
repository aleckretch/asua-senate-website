<?php
/*
	This file handles agenda uploads securely.
	Begins by checking that user is logged in, if not then they cannot upload.
	If there was a problem with the upload then exit.
	If the uploaded file is too large then exit.
	If the uploaded file is not actually a pdf file( checked mimetype from server side) then exit.
	Otherwise generate an entry in the database, get the id from that and move the file to the uploads folder.
	The filename for the file on the server will be Agenda_ID.pdf 
		where ID is replaced by the id returned from createAgenda.
	Finally the permissions on the file are changed to not allow execution.
	
	Note: For security reasons, the uploads folder should be outside the document root on the server.

	TODO: Need to secure this by making sure correct CSRF token was sent
	TODO: Get title to put into database from query parameter
	TODO: Need to change the path to the uploads folder when we have webspace
*/
require_once "./database.php";
require_once "./session.php";

//if the user is not logged in, do not allow the upload to continue into database
if ( !Session::userLoggedIn() )
{
	die ( "Must be logged in to upload an agenda file." );
}

//if error code is not set on file upload array then do not allow upload to continue into database
if ( !isset($_FILES['file']['error']) )
{
	die( "File not provided" );
}

//if the file was not uploaded correctly then do not allow the upload to continue into database
if ( $_FILES['file']['error'] !== UPLOAD_ERR_OK )  
{
	die( "Upload failed with error {$_FILES['file']['error']}" );
}

//if the file uploaded is larger then 20mb don't allow the upload to continue into database
if ( $_FILES['file']['size'] > 20000000) 
{
	die ( "Could not upload file, file too large" );
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

//for debug purposes, was used to print out path to file
//echo $_FILES['file']['tmp_name'];

//Create a new agenda with title of Test
$id = Database::createAgenda( "Test" );

//put path to uploads folder in variable, path should be outside document root for server
$dir = "../../uploads/Agenda_{$id}.pdf";

//move the uploaded file to the uploads folder under the name of its id
move_uploaded_file( $_FILES['file']['tmp_name'] , $dir  );

//change the permissions on the uploaded file in the uploads folder to RW-R--R--
chmod( $dir, 0644 );

