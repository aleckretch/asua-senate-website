<?php
require_once "./database.php";
require_once "./session.php";
/*
	This page holds the different HTML forms for the backend.
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

function checkUploaded( $isUpload, $notUploadStr, $str, $correctStr, $messageCorrect, $messageWrong, $sanitize = TRUE )
{
	if ( $isUpload )
	{
		showMessage( $str, $correctStr, $messageCorrect, $messageWrong );
	}
	else
	{
		if ( $sanitize )
		{
			echo Database::sanitizeData( $notUploadStr );
		}
		else
		{
			echo $notUploadStr;
		}
	}
}

//if the user is not logged in, do not allow them to see this page, redirect to login.php to have them login
if ( !Session::userLoggedIn() )
{
	header( "Location: login.php" );
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>University of Arizona</title>
	<script src="../js/tiny_mce.js"></script>
	<style>
	h1{text-align: center;color: #536DFE;}
	h2{color: #536DFE;}
	footer{text-align: center;}
	body {background-color:lightgrey;}
	input{margin: 5px;}
	FORM { border : solid gray 2px; padding : 3px;}
	</style>
</head>
<body>
      <header><!-- Start header -->
         <h1 id="logo">ASUA Upload Archive</h1>
      </header><!-- End header -->
      <a href="../index.html">Return to Page</a><br/>
      <a href="admin.php?blog=yes">Post Blog Entry</a><br/>
      <a href="admin.php?agenda=yes">Upload Agenda</a><br/>

    <div id="Submit"><!-- Start content -->
<?php

$req = $_GET;
$uploaded = isset( $req[ 'uploaded' ] );
$correct = ( $uploaded ? $req[ 'uploaded' ] : "" );
$token = Session::token();
if ( isset( $req[ 'blog' ] ) )
{
	$str = "
	   <form action='blogUpload.php' method='post'>
	   <div>
	   <h2>Blog Post Entry</h2>
	   <form action='index.php' method='post'>
			<input type='hidden' name='token' value='${token}'>
			Title:<br>
			<input type='text' name='title' size='30' required><br>
			Author:<br>
			<input type='text' name='author' size='30' required><br>
			Post:<br>
        <textarea id='text' name='text'></textarea>
		<div>
		<input type='submit' value='Send'>
		</div>
	   </form>
	   </div>
	<script>
		tinyMCE.init({
			selector:'textarea' , 
	    		plugins : 'bbcode'
		});
	</script>
	";
	checkUploaded( $uploaded, $str , $correct , "yes" , "Blog post created" , $correct, false );
	?>

	<?php
}
else if ( isset( $req[ 'agenda' ] ) )
{
	$str = "
	   <form action='upload.php'
			enctype='multipart/form-data' method='post'>
			<p>
			Title:<br>
			<input type='text' name='title' size='30' required>
			<input type='hidden' name='token' value='${token}'>
			</p>
			<p>
			Please specify a file:<br>
			<input type='file' name='file' required>
			</p>
			<div>
			<input type='submit' value='Send'>
			</div>
			</form>
		   </div>
	";
	checkUploaded( $uploaded, $str , $correct , "yes" , "Agenda uploaded" , $correct , false);
}
else if ( isset( $req[ 'roster' ] ) )
{
	checkUploaded( $uploaded, "TODO: Roster form needed" , $correct , "yes" , "Roster added to" , $correct );
}
else
{

}
