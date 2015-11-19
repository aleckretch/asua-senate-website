<?php
/*
	This class acts as a wrapper for PHP sessions.
	The corresponding PHP code outside of here does not need to know exactly how the session data is stored.
	This file also starts the session when it is included, so it should only be included once to prevent errors.
*/
require_once( "./database.php" );
session_start();

class Session
{
	/*
		Returns true if there is a user logged in on the current session or false otherwise.
	*/
	public static function userLoggedIn()
	{
		return ( isset( $_SESSION['user'] ) );
	}

	/*
		If no username parameter was passed then this returns the current user in the session.
		Otherwise, this sets the current user to the user provided and returns their username back
	*/
	public static function user( $username = NULL )
	{
		if ( $username === NULL )
		{
			return ( self::userLoggedIn() ? $_SESSION['user'] : NULL );
		}

		$_SESSION['user'] = $username;
		return $_SESSION['user'];
	}

	/*
		If the username and password combo is valid 
			then returns true, otherwise returns false.
		If no password was provided, 
			then return true if the username exists or false otherwise.
		Side effect: Sets the user in the session to the username provided if returning true.
	*/
	public static function loginUser( $username, $password = null )
	{
		if ( $password === NULL )
		{
			if ( Database::doesUserExist( $username ) )
			{
				self::user( $username );
				return true;
			}
			return false;
		}

		if ( Database::verifyUser( $username, $password ) )
		{
			self::user( $username );
			return true;
		}
		return false;
	}
}
