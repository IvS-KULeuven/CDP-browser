<?php
// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

print "Required keyword will be added to the metadata table.\n";

$sql = "ALTER TABLE metadata ADD COLUMN required    INT(3)  DEFAULT 0;";
$objDatabase->execSQL($sql);


// Add the PIPELINE MODULE metadata
$sql = "UPDATE metadata set required=1 where id = \"PIPELINE MODULE\";";
$objDatabase->execSQL($sql);

// Add the PIPELINE STEP metadata
$sql = "UPDATE metadata set required=1 where id = \"PIPELINE STEP\";";
$objDatabase->execSQL($sql);

// Add the FILETYPE metadata
$sql = "UPDATE metadata set required=1 where id = \"FILETYPE\";";
$objDatabase->execSQL($sql);

// Add the DELIVERY metadata
$sql = "UPDATE metadata set required=1 where id = \"DELIVERY\";";
$objDatabase->execSQL($sql);

// Add the UPLOAD DATE metadata
$sql = "UPDATE metadata set required=1 where id = \"UPLOAD DATE\";";
$objDatabase->execSQL($sql);

?>