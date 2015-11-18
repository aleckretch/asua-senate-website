DROP DATABASE IF EXISTS SENATE;
CREATE DATABASE SENATE   
	DEFAULT CHARACTER SET utf8
 	DEFAULT COLLATE utf8_general_ci;
USE SENATE;

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

/*
	This will hold the information associated with blog posts.
*/
DROP TABLE IF EXISTS Posts;
CREATE TABLE Posts
(
	id		int NOT NULL auto_increment primary key,
	title		varchar( 500 ) NOT NULL,
	content		text NOT NULL,
	datePosted	datetime NOT NULL
);

DROP TABLE IF EXISTS Roster;
CREATE TABLE Roster
(
	id		int NOT NULL auto_increment primary key,
	name		varchar( 100 ) NOT NULL,
	major		varchar( 100 ) NOT NULL,
	origin		varchar( 100 ) NOT NULL,
	letter		text NOT NULL
);

DROP TABLE IF EXISTS OfficeHours;
Create TABLE OfficeHours
(
	day		varchar( 20 ) NOT NULL,
	startHour	int NOT NULL,
	endHour		int NOT NULL,
	RosterID	int NOT NULL,
	primary key( RosterID , day ),
	FOREIGN KEY (RosterID)
	REFERENCES Roster(id)
	ON DELETE CASCADE
);

/*
	This is for testing purposes, the password is blank because using webauth to login using NetID, never stores password.
*/
INSERT INTO Users( username, password ) values( 'djenkins1' , '' );
