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

//tests creating a user with a script tag as username returns a valid error code
assert ( Database::createUser( "<script>" , "testing" ) === $validError );

//tests that the user created with a script tag as username actually exists
assert ( Database::doesUserExist( "<script>" ) );

//tests whether the sanitized script tag was actually the username
assert ( Database::doesUserExist( Database::sanitizeData( "<script>" ) ) );

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

//tests that script tags are sanitized correctly
$str = "<script>alert( 'hello' )</script>";
assert ( Database::sanitizeData( $str ) !== $str );

//tests that sanitized data is not the same as unsanitized data
assert ( Database::unsanitizeData( $str ) !== Database::sanitizeData( $str ) );

//tests that sanitizing data twice is the same as sanitizing it once
assert ( Database::sanitizeData( Database::sanitizeData( $str ) ) === Database::sanitizeData( $str ) );

//tests that unsanitizing sanitized data gets back the original data
assert ( Database::unsanitizeData( Database::sanitizeData( $str ) ) === $str );

//just checks to see that nothing went wrong when generating a random token
assert ( Database::randomToken() !== NULL );

//test that deleting all non-archived agendas returns valid error
assert( Database::removeAgendas( 0 ) === $validError );

//test that there are no longer any non-archived agendas
assert ( count( Database::getAgendas( 0 ) ) === 0 );

//test that deleting all archived agendas returns valid error
assert( Database::removeAgendas( 1 ) === $validError );

//test that there are no longer any archived agendas
assert ( count( Database::getAgendas( 1 ) ) === 0 );

//create a new agenda and get the id
$id = Database::createAgenda( "<script>" );

//test that creating an agenda gives back a valid id
assert ( $id !== NULL );

//test that there is at least one agenda that is not archived
assert ( count( Database::getAgendas( 0 ) ) !== 0 );

//test that there are no agendas that are archived
assert ( count( Database::getAgendas( 1 ) ) === 0 );

//test that archiveAgenda with valid id returns a validError code
assert ( Database::archiveAgenda( $id ) === $validError );

//test that there are no longer any non-archived agendas
assert ( count( Database::getAgendas( 0 ) ) === 0 );

//test that there are at least one archived agenda
assert ( count( Database::getAgendas( 1 ) ) !== 0 );

//create a new agenda and get the id
$newID = Database::createAgenda( "<script>More</script>" );

//test that creating another agenda returns a different id
assert ( $newID !== NULL && $newID !== $id );

//test that there are now at least one non-archived agenda
assert ( count( Database::getAgendas( 0 ) ) !== 0 );

//test that there are now at least one archived agenda
assert ( count( Database::getAgendas( 1 ) ) !== 0 );

//test that archiving all the agendas returns back a valid code
assert ( Database::archiveAllAgendas() === $validError );

//test that there are no longer any non-archived agendas
assert ( count( Database::getAgendas( 0 ) ) === 0 );

//test that there are at least one archived agenda
assert ( count( Database::getAgendas( 1 ) ) !== 0 );

//delete all former blog posts for testing purposes
assert ( Database::deleteAllPosts() === $validError );

//make sure there are no blog posts after deletion
assert ( count( Database::getPosts() ) === 0 );

//make sure creating a blog post works and returns an id
$postID = Database::createBlogPost( "Title" , "Here is some content." );
assert ( $postID !== NULL );

//make sure there is 1 post that has been created
assert ( count( Database::getPosts() ) === 1 );

//create another blog post and make sure it has valid id
$title = "<script>alert( 'hello' )</script>";
$newID = Database::createBlogPost( "<script>alert( 'hello' )</script>" , "XSS in title." );
assert ( $newID !== NULL );

//check that there are now two posts
assert ( count( Database::getPosts() ) === 2 );

//check that the title of the new post was properly sanitized
$postRow = Database::getPost( $newID );
assert ( isset( $postRow[ "title" ] ) && $postRow[ "title" ] !== $title );
assert ( isset( $postRow[ "title" ] ) && $postRow[ "title" ] === Database::sanitizeData( $title ) );

//make sure that deleting a post returns a valid error code
assert ( Database::deleteBlogPost( $newID ) === $validError );

//make sure that there is only 1 post left
assert ( count( Database::getPosts() ) === 1 );

//make sure that getPost works with a invalid id
$postRow = Database::getPost( $newID );
assert ( !isset( $postRow[ "title" ] ) );

//create the post again
$newID = Database::createBlogPost( "<script>alert( 'hello' )</script>" , "XSS in title." );
assert ( $newID !== NULL );

//make sure deleting all posts returns a valid error
assert ( Database::deleteAllPosts() === $validError );

//make sure there are no posts left
assert ( count( Database::getPosts() ) === 0 );

echo "<hr>";
