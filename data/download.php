<?php
/*
	This php file acts as an intermediary for anyone to download the agenda files.
	The reason we use this is for security reasons, apache won't execute the pdf file if it isn't in the document root
	Because the agenda file is outside the document root, it cannot be accessed anywhere except through our php code
	This is why we need this php file to act as the go between in order to download the agenda file.
	It also allows us to send back a recommended filename for the pdf to the browser.
*/
require_once( "./database.php" );
if ( !isset( $_GET['id'] ) )
{
	die( "No file id provided" );
}

//get the id provided as a get parameter
$id = $_GET['id'];
$agenda = Database::getAgendaFromID( $id );
//if the result from getAgendaFromID is false then the id is invalid
if ( $agenda === FALSE )
{
	die ( "File not found" );
}

//tell browser to expect pdf file as response
header("Content-type:application/pdf");

//Set the timezone to Phoenix to stop warnings from timezone not being set...
date_default_timezone_set('America/Phoenix');

//get the date that the file was created and turn it into unix time
$phpdate = strtotime( $agenda[ 'uploadDate'] );

//turn the unix time into a date for filename
$mysqldate = date( 'm_d_Y', $phpdate );

//tell the browser that the filename to download the file as is Agenda_ followed by date the agenda was added to database
header("Content-Disposition:attachment;filename='Agenda_{$mysqldate}.pdf'");

//output the files contents to the browser, allowing user to download file
readfile("../../uploads/Agenda_{$id}.pdf");

