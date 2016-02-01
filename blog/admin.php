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
		?><span class='text'><?php
		echo Database::sanitizeData( $messageCorrect );
		?></span><?php
	}
	else
	{
		?><span class='text'><?php
		echo Database::sanitizeData( $messageWrong );
		?></span><?php
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
			?><span class='text'><?php
			echo Database::sanitizeData( $notUploadStr );
			?><span class='text'><?php
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

function displayHTML()
{
?>
<!DOCTYPE html>
<html>
<head>
    <title>University of Arizona</title>
	<script src="../js/jquery-2.1.4.min.js"></script>
	<script src="../js/jquery.wysibb.js"></script>
	<link rel="stylesheet" href="../css/default/wbbtheme.css" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Control Panel</title>
	<style>
	h1{text-align: center;color: #536DFE;}
	h2{color: #536DFE;}
	footer{text-align: center;}
	body {		background-color: #233e76; }
	*.text { color: #536DFE; }
	input{margin: 5px;}
	form { border : solid gray 2px; padding : 3px;}
	a    
	{ 	  
		color: #888;
	 	text-decoration: underline;
		display: inline-block;
		width: 120px;
		background-color: #3a3a3a;
		border: solid black 1px;
		border-radius: 5px;
	}
	</style>
</head>
<body>
      <header>
         <h1 id="logo">Control Panel</h1>
      </header>
      <a id="indexLink" href="../index.html">Return to Page</a>
      <a id="blogLink" href="admin.php?blog=yes">Post Blog Entry</a>
      <a id="agendaLink" href="admin.php?agenda=yes">Upload Agenda</a>

    <div id="Submit">
<?php
}

$req = $_GET;
$uploaded = isset( $req[ 'uploaded' ] );
$correct = ( $uploaded ? $req[ 'uploaded' ] : "" );
$token = Session::token();
if ( isset( $req[ 'blog' ] ) )
{
	displayHTML();
	$str = "
	   <form action='blogUpload.php' method='post'>
	   <div>
	   <h2>Blog Post</h2>
	   <form action='index.php' method='post'>
			<input type='hidden' name='token' value='${token}'>
			<span class='text'>Author:</span><br>
			<input type='text' name='author' size='30' required><br>
			<span class='text'>Title:</span><br>
			<input type='text' name='title' size='30' required><br>
			<span class='text'>Post:</span><br>
        		<textarea id='text' name='text' rows='10'></textarea>
		<div>
		<input type='submit' value='Send'>
		</div>
	   </form>
	   </div>
	<script>
		$('#text').wysibb();
	</script>
	<script>
		$( '#blogLink' ).css( 'background' , 'black' );
	</script>
	";
	checkUploaded( $uploaded, $str , $correct , "yes" , "Blog post created" , $correct, false );
	?>

	<?php
}
else if ( isset( $req[ 'agenda' ] ) )
{
	displayHTML();
	$str = "
	   <form action='upload.php'
			enctype='multipart/form-data' method='post'>
			<h2>Agenda Upload</h2>
			<p>
			<span class='text'>Title:</span><br>
			<input type='text' name='title' size='30' required>
			<input type='hidden' name='token' value='${token}'>
			</p>
			<p>
			<span class='text'>Please specify a file:</span><br>
			<input type='file' name='file' required>
			</p>
			<div>
			<input type='submit' value='Send'>
			</div>
			</form>
		   </div>
		<script>
			$( '#agendaLink' ).css( 'background' , 'black' );
		</script>
	";
	checkUploaded( $uploaded, $str , $correct , "yes" , "Agenda uploaded" , $correct , false);
}
else if ( isset( $req[ 'roster' ] ) )
{
	checkUploaded( $uploaded, "TODO: Roster form needed" , $correct , "yes" , "Roster added to" , $correct );
}
else
{
	header( "Location: admin.php?blog=yes" );
	exit();
}
