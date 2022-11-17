<?php
require 'database.php';
// CREATE THE DATABASE
connectCreateTables();
function connectCreateTables(): void
{
    try {
        $dsnString = "mysql:hostname=" . DBHOST . ";";
        $con = new PDO($dsnString, DBUSER, DBPASS,);
        echo "connected to database: " . DBNAME;
    } catch (Exception $e) {
        die(var_dump($e->getMessage()));
    }

    $query = "create database if not exists " . DBNAME;
    $statement = $con->prepare($query);
    $statement->execute();
    $query = "use " . DBNAME;
    $statement = $con->prepare($query);
    $statement->execute();

    /** users table **/
    $query = "create table if not exists users(
		id int primary key auto_increment,
		firstname varchar(50) not null,
		lastname varchar(50) not null,
		username varchar(50) not null,
		email varchar(100) not null,
		password varchar(255) not null,
		avatar varchar(1024) null,
		date datetime default current_timestamp,
		is_admin tinyint(1) not null,
		key username (username),
		key email (email)
	)";

    $statement = $con->prepare($query);
    $statement->execute();

    $query = "create table if not exists categories(
    id int primary key auto_increment,
    category varchar(50) not null,
    description varchar(250) not null,
    disabled tinyint default 0)";

    $statement = $con->prepare($query);
    $statement->execute();

    $query = "create table if not exists posts(

		id int primary key auto_increment,
        userid int NOT NULL,
        FOREiGN KEY (userid) REFERENCES users(id),
        categoryid int NOT NULL,
        FOREiGN KEY (categoryid) REFERENCES categories(id),
		title varchar(255) not null,
		content text not null,
		thumbnail varchar(255) null,
		date datetime default current_timestamp,
       is_featured tinyint(1)
	)";
    $statement = $con->prepare($query);
    $statement->execute();
}
header('location: index');
