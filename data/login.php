<?php
/*
	Prototype for logging in via NetID, never have to use/store passwords at all.
	Response from webauth gives back username from NetID, can use this with a whitelist to see if someone can login to the site for upload/blog
	See the following link for using the webauth api:
		https://netid.arizona.edu/apidocs/webauth/index.html
*/
require_once "./database.php";
session_start();

//change the address in the string when we have webspace
$service = urlencode( "http://localhost/asua-senate-website/data/login.php" );

if ( !isset( $_GET['ticket'] ) && !isset( $_SESSION['user'] ) )
{
	//redirect to login page for webauth passing along a callback url as the service
	header( "Location: https://webauth.arizona.edu/webauth/login?service={$service}" );
}
else if ( isset( $_GET['ticket'] ) && !isset( $_SESSION['user'] ) )
{
	//received a ticket parameter

	//use curl to send a get request to webauth to validate the ticket and service
	$curl = curl_init();
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => "https://webauth.arizona.edu/webauth/validate?service={$service}&ticket={$_GET['ticket']}"
	));
	$response = curl_exec( $curl );

	//if the return value from the curl was false, then something went wrong with the request and no response was received
	if ( $response === false )
	{
		echo "Bad request";
		exit();
	}
	
	/*
		response is in the format:
			Yes\nNetID\n
		or:
			No\nNot valid
	*/
	$response = explode( "\n" , $response );

	//if the first line of the request is the word yes, then the next line will be the username
	if ( $response[ 0 ] === "yes" )
	{
		//if the username received from the request is allowed to login as an admin, then save their username in the session
		//redirect to a page
		if ( Database::doesUserExist( $response[ 1 ] ) )
		{
			$_SESSION['user'] = $response[ 1 ];
			header( "Location: login.php" );
			exit();		
		}
		else
		{
			echo "Invalid user: {$response[ 1 ]}";
		}
	}
	else
	{
		echo "Not a yes";
	}
}
else if ( isset( $_SESSION['user'] ) )
{
	echo $_SESSION['user'] . " is logged in";
}
else
{
	echo "Why am i Here";
}
