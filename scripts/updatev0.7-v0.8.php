<?php
// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

echo "Make the possible values of the metadata 64 character long.\n";

$sql = "ALTER TABLE metadata MODIFY value VARCHAR(64)";
$objDatabase->execSQL($sql);

echo "Make PIPELINE MODULE a MULTILIST (was a LIST before).\n";
$sql = "UPDATE metadata SET valueType=\"MULTILIST\" WHERE id=\"PIPELINE MODULE\"";
$objDatabase->execSQL($sql);

echo "Change the primary key of the CDP table.\n";
$sql = "ALTER TABLE cdp DROP PRIMARY KEY;";
$objDatabase->execSQL($sql);

$sql = "ALTER TABLE cdp ADD PRIMARY KEY (filename, name, keyvalue);";
$objDatabase->execSQL($sql);

?>
