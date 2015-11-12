DROP DATABASE IF EXISTS senate;
CREATE DATABASE senate;
USE senate;

/*
	This holds the username and hashed password for the users.
	The username has to be unique.
*/
DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
	id		int NOT NULL auto_increment primary key,
	username	varchar(100) NOT NULL,
	password	varchar(255) NOT NULL,
	UNIQUE( username )
);

/*
	This will hold information on the agenda files that were uploaded.
	The idea being that the id of the agenda will be part of the filename on the server, never trust user input.
*/
DROP TABLE IF EXISTS Agendas;
CREATE TABLE Agendas
(
	id		int NOT NULL auto_increment primary key,
	name		varchar( 200 ) NOT NULL,
	uploadDate	datetime NOT NULL,
	archived	tinyint(1) NOT NULL
);
