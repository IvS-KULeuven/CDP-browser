<?php
// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

print "Database table for the cdp files will be added.\n";

$sql = "DROP TABLE IF EXISTS cdp";
$objDatabase->execSQL($sql);

$sql = "CREATE TABLE cdp (
             filename        VARCHAR(200)            NOT NULL DEFAULT '',
             name            VARCHAR(50)             NOT NULL DEFAULT '',
             keyvalue        VARCHAR(200)            NOT NULL DEFAULT '',
             PRIMARY KEY(filename, name)
             )";
$objDatabase->execSQL($sql);


?>