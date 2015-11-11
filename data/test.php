<?php
/*
Contains test cases for the Database, should be run each time there is a change to the Database class
*/
echo "<b>This should be a blank page between the lines if nothing went wrong</b><hr><br>";

require_once "./database.php";
$validError = "00000";

//tests that the samePassword function returns true if the passwords match
assert ( Database::samePassword( "testing" , Database::hashPassword( "testing" ) ) );

//tests that the samePassword function returns false if the passwords do not match
assert ( !Database::samePassword( "badPassword" , Database::hashPassword( "testing" ) ) );

//tests creating a user returns a valid error code
assert ( Database::createUser( "test" , "testing" ) === $validError );

//tests if the user just created now exists
assert ( Database::doesUserExist( "test" ) );

//tests that the username entered is case-insensitive when seeing if a user exists
assert ( Database::doesUserExist( "tEsT" ) );

//tests that the user can login with the correct password
assert ( Database::verifyUser( "test" , "testing" ) );

//tests that the user cannot log in with an incorrect password
assert ( !Database::verifyUser( "test" , "badPassword" ) );

//tests that a user that does not exist cannot log in
assert ( !Database::verifyUser( "badUser" , "testing" ) );

//tests that doesUserExist returns false if the user provided does not exist
assert ( !Database::doesUserExist( "badUser" ) );

//tests that deleting the user created above returns a valid error code
assert ( Database::deleteUser( "test" ) === $validError );

echo "<hr>";
