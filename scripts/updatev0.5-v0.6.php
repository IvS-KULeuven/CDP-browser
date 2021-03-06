<?php
// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

print "Add acceptance_type to FILETYPE.\n";

$sql = "INSERT INTO metadata ( id, valueType, inFits, value, required ) VALUES ( \"FILETYPE\", \"LIST\", '0', \"acceptance data\", '1')";
$objDatabase->execSQL($sql);

print "Add new document types to the DOCTYPE keyword.\n";
$sql = "INSERT INTO metadata ( id, valueType, inFits, value, required ) VALUES ( \"DOCTYPE\", \"LIST\", '0', \"delivery\", '0')";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value, required ) VALUES ( \"DOCTYPE\", \"LIST\", '0', \"reference\", '0')";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value, required ) VALUES ( \"DOCTYPE\", \"LIST\", '0', \"pipeline\", '0')";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value, required ) VALUES ( \"DOCTYPE\", \"LIST\", '0', \"support\", '0')";
$objDatabase->execSQL($sql);

print "Make PIPELINE MODULE and PIPELINE STEP keywords not mandatory.\n";
$sql = "UPDATE metadata set required=\"0\" where id = \"PIPELINE MODULE\";";
$objDatabase->execSQL($sql);

$sql = "UPDATE metadata set required=\"0\" where id = \"PIPELINE STEP\";";
$objDatabase->execSQL($sql);

?>