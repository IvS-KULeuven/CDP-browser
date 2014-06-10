<?php

// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

print "Database table for the use will be added.\n";

$sql ="DROP TABLE IF EXISTS users";
$run = mysql_query($sql) or die(mysql_error());
$sql = "CREATE TABLE users (
             id              VARCHAR(200)            NOT NULL DEFAULT '',
             name            VARCHAR(200)            NOT NULL DEFAULT '',
             firstname       VARCHAR(200)            NOT NULL DEFAULT '',
		     email           VARCHAR(200)            NOT NULL DEFAULT '',
             password        VARCHAR(32)             NOT NULL default '',
             role            INT(3)                  NOT NULL default '2',
		     PRIMARY KEY(id)
             )";
$run = mysql_query($sql) or die(mysql_error());


// Role : Admin = 0, User = 1, Waitlist = 2
// Make a user 'wim'
$sql = "INSERT INTO users ( id, name, firstname, email, password, role ) VALUES ( \"wim\", \"De Meester\", \"Wim\", \"wim.demeester@ster.kuleuven.be\", \"" . md5("test") . "\", 0)";
$run = mysql_query($sql) or die(mysql_error());

print "Database update successful.\n";
?>