DROP DATABASE IF EXISTS senate;
CREATE DATABASE senate;
USE senate;

DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
	id		int NOT NULL auto_increment primary key,
	username	varchar(100) NOT NULL,
	password	varchar(255) NOT NULL,
	UNIQUE( username )
);
