<?php

// The file with all the database settings
require_once "../lib/setup/databaseInfo.php";

// The library to work with the mysql database
require_once "../lib/database.php";

$objDatabase=new Database();

print "Database table for the user will be added.\n";

$sql = "DROP TABLE IF EXISTS users";
$objDatabase->execSQL($sql);

$sql = "CREATE TABLE users (
             id              VARCHAR(200)            NOT NULL DEFAULT '',
             name            VARCHAR(200)            NOT NULL DEFAULT '',
             firstname       VARCHAR(200)            NOT NULL DEFAULT '',
		     email           VARCHAR(200)            NOT NULL DEFAULT '',
             password        VARCHAR(32)             NOT NULL default '',
             role            INT(3)                  NOT NULL default '2',
		     PRIMARY KEY(id)
             )";
$objDatabase->execSQL($sql);

// Role : Admin = 0, User = 1
// Make a user 'wim'
$sql = "INSERT INTO users ( id, name, firstname, email, password, role ) VALUES ( \"wim\", \"De Meester\", \"Wim\", \"wim.demeester@ster.kuleuven.be\", \"" . md5("test") . "\", 0)";
$objDatabase->execSQL($sql);

print "Database table for the metadata will be added.\n";

$sql = "DROP TABLE IF EXISTS metadata";
$objDatabase->execSQL($sql);

$sql = "CREATE TABLE metadata (
          id        VARCHAR(32)    NOT NULL DEFAULT '',
          valueType VARCHAR(10)    NOT NULL DEFAULT '',
          value     VARCHAR(32)    NOT NULL DEFAULT '',
          PRIMARY KEY(id, value)
    )";
$objDatabase->execSQL($sql);

// Add the TYPE metadata to the table
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"AbsFlux\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Bad\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"ColCorr\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"D2W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"D2c\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Dark\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Distort\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Droop\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"FringeFlat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Latent\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Lin\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"NThresh\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"PixFlat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"PSF\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"SRF\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"MRSRSRF\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"Sat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"SkyFlat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TYPE\", \"LIST\", \"TelEm\")";
$objDatabase->execSQL($sql);

// Add the REFTYPE metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"IPC\")";
$objDatabase->execSQL($sql);

//'IPC', 'MASK', 'SATURATION', 'DARK', 'LINEARITY', 'GAIN', 'READNOISE', 'WCS', 'FLAT', 'PHOTOM', 'AREA', 'FRINGE', 'PHOTOM'
print "Database update successful.\n";
?>