<?php
/*
Holds functions pertaining to the database
*/
class Database
{
	/*
		Creates a connection to the database if it does not already exist
		If a connection exists then return that connection
	*/
	public static function connect()
	{
		$dbName = "senate";

		//TODO: store this somewhere so that it cannot be accessed except outside the root folder
		//Do not have a empty password for the root user when deployed
		$dbUser = "root";
		$dbPass = "";

		//$conn holds the connection to the database if it has been opened already
		//otherwise, a connection is created and $conn points to that connection
		static $conn;

		//If there is already an existing connection, return that connection
		if ( $conn )
			return $conn;

		$dataSrc = "mysql:host=localhost;dbname={$dbName}";
		try 
		{
			$conn = new PDO( $dataSrc, $dbUser , $dbPass );
			$conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
		} 
		catch ( PDOException $e ) 
		{
			echo "Error establishing Connection<br>";
			echo "{$e->getMessage()}<br>";
			exit();
		}

		return $conn;
	}

	/*
		Acts as a wrapper around the built in password_hash function.
		So if we ever decide to change how we handle passwords,
			we just have to change the contents of this function.
	*/
	public static function hashPassword( $password )
	{
		return password_hash( $password,  PASSWORD_DEFAULT );
	}

	/*
		Acts as a wrapper around built in password_verify function.
		So if we ever decide to change how we handle passwords,
			we just have to change the contents of this function.
	*/
	public static function samePassword( $password, $hash )
	{
		return password_verify( $password, $hash );
	}

	/*
		Given a username and a password in plain text.
		Returns true if the password is correct for the username provided, or false otherwise.
		Returns false if the username does not exist in the database
	*/
	public static function verifyUser( $username, $password )
	{
		$conn = self::connect();
		$stmt = $conn->prepare( "SELECT password from Users where username=:username" );
		$stmt->bindParam( "username" , $username );
		$stmt->execute();
		$user = $stmt->fetch();
		return ( isset( $user[ "password" ] ) && self::samePassword( $password, $user[ "password" ] ) === TRUE  );
	}

	/*
		Creates a user with the username and password provided in plaintext.
		The password will be hashed before it goes into the database.
		Returns the error code of the query executed, returns five zeros if the query had no errors: 00000
		Does NOT check if the username entered is valid or that it is already taken
	*/
	public static function createUser( $username, $password )
	{
		$username = strtolower( $username );
		$conn = self::connect();
		$stmt = $conn->prepare( "INSERT INTO Users( username, password ) values( :username, :password )" );
		$stmt->bindParam( "username" , $username );
		$password = self::hashPassword( $password );
		$stmt->bindParam( "password" , $password );
		$stmt->execute();
		return $conn->errorCode();
	}

	/*
		Returns true if the user with the username provided exists in the Users table, or false otherwise.
	*/
	public static function doesUserExist( $username )
	{
		$username = strtolower( $username );
		$conn = self::connect();
		$stmt = $conn->prepare( "SELECT id FROM Users WHERE username=:username" );
		$stmt->bindParam( "username" , $username ); 
		$stmt->execute();
		$row = $stmt->fetch();
		return isset( $row[ "id" ] );
	}

	/*
		Attempts to delete the user from the database.
		Returns an error code that will be 00000 if nothing went wrong.
	*/
	public static function deleteUser( $username )
	{
		$username = strtolower( $username );
		$conn = self::connect();
		$stmt = $conn->prepare( "DELETE FROM Users WHERE username=:username" );
		$stmt->bindParam( "username" , $username );
		$stmt->execute();
		return $conn->errorCode();
	}
}

?>
