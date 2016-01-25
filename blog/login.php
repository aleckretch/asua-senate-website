<?php
	require_once "session.php";
	require_once "database.php";
	if ( Session::userLoggedIn() )
	{
		$user = Session::user();
		echo "Already logged in as {$user}<br>";
		die ( "Cannot login again" );
	}

	$values = array();
	$values[] = "username";
	$values[] = "password";
	$values[] = "dropbox";
	foreach ( $values as $value )
	{
		if ( !isset( $_POST[ $value ] ) )
		{
			die ( "{$value} was not given." );
		}
	}

	$dropbox = array();
	$dropbox[ "roster" ] = 1;
	$dropbox[ "blog" ] = 1;
	$dropbox[ "agenda" ] = 1;
	if ( !isset( $dropbox[ $_POST['dropbox'] ] ) )
	{
		$value = Database::sanitizeData( $_POST['dropbox'] );
		die ( "Dropbox value {$value} not valid" );
	}

	if ( !Session::loginUser( $_POST['username'] , $_POST['password'] ) )
	{
		die ( "Username or password was incorrect" );
	}

	//TODO: show a template for the requested dropbox value
