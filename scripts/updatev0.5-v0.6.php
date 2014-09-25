<?php
// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

print "Add acceptance_type to FILETYPE.\n";

$sql = "INSERT INTO metadata ( id, valueType, inFits, value, required ) VALUES ( \"FILETYPE\", \"LIST\", '0', \"acceptance data\", '1')";
$objDatabase->execSQL($sql);

?>