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

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"MASK\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"SATURATION\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"DARK\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"LINEARITY\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"GAIN\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"READNOISE\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"WCS\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"FLAT\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"PHOTOM\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"AREA\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"REFTYPE\", \"LIST\", \"FRINGE\")";
$objDatabase->execSQL($sql);

// Add the VERSION metadata 
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"VERSION\", \"STRING\", \"00.11.22\")";
$objDatabase->execSQL($sql);

// Add the USEAFTER metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"USEAFTER\", \"STRING\", \"yyyy-mm-dd\")";
$objDatabase->execSQL($sql);

// Add the DETECTOR metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DETECTOR\", \"LIST\", \"MIRIMAGE\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DETECTOR\", \"LIST\", \"MIRIFUSHORT\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DETECTOR\", \"LIST\", \"MIRIFULONG\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DETECTOR\", \"LIST\", \"IM\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DETECTOR\", \"LIST\", \"LW\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DETECTOR\", \"LIST\", \"SW\")";
$objDatabase->execSQL($sql);

// Add the MODELNAM metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"MODELNAM\", \"LIST\", \"VM\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"MODELNAM\", \"LIST\", \"JPL\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"MODELNAM\", \"LIST\", \"FM\")";
$objDatabase->execSQL($sql);



/*
- READPATT         string  valid values: 'FAST', 'SLOW', or 'ANY'
- SUBARRAY   string  valid values: 'FULL', 'MASK1140', 'MASK1550', 'MASK1065', 'MASKLYOT', 'BRIGHTSKY', 'SUB256', 'SUB128', 'SUB64' or 'SLITLESSPRISM'  (defaults to 'FULL')
- FILTER   string    valid values: 'F560W','F770W','F1000W','F1130W', 'F1280W','F1500W','F1800W', 'F2100W', 'F2550W', 'F2550WR','F1065C', 'F1140C', 'F1550C','F2300C','P750L','FLENS', 'FND', or 'OPAQUE' (only required if filter specific)
- CHANNEL   string  valid values: '1', '2', '3' or '4'
- BAND      string  valid values: 'A', 'B' or 'C'
- GRATINGA  string  valid values: 'A', 'B' or 'C'
- GRATINGB  string  valid values: 'A', 'B' or 'C'

- TELESCOP   String   always 'JWST'
- INSTRUME   String   always 'MIRI'
- FILENAME   string
- DESCRIP    string   short summary of content
- AUTHOR     string
- PEDIGREE   string   always 'GROUND' for now
- SUBSTRT1   integer
- SUBSIZE1   integer
- SUBSTRT2   integer
- SUBSIZE2   integer
- FASTAXIS   integer  always 1   (only for pixel-based CDPs)
- SLOWAXIS   integer  always 2   (only for pixel-based CDPs)


Metadata that would not be in FITS files:
- PIPELINE MODULE  String  valid values: 'CALDETECTOR1', 'CALIMAGE2', 'CALSPEC2_LRS', 'CALSPEC2_MRS', 'CALIMAGE3', 'CALCORON3', 'CALSLIT3', 'CALSLITLESS3', 'CALIFU3'
- PIPELINE STEP    String  valid values: 'data_rejection', 'droop_correction', 'reset_correction', 'saturation_check', 'dark_correction', 'linearity_correction', 'jump_correction', 'latent_correction', 'absolute_flux_calibration', 'flatfield_correction', 'source extraction', 'fringe_correction', 'distortion_wavelength_calibration'
- FILETYPE         String  valid values: 'documentation', 'algorithm', 'referencefile', 'testcase file'
- DELIVERY         String  valid values: '1', '2', '2.1', '3', etc
- DOCTYPE          string  valid values: 'cdp report', 'pipeline algorithm'
- DOCVERSION       string  valid values: (can be taken from title pages, might not be standardized)
- ALGTYPE          string  valid values: 'cdp_test', 'cdp_creation'
- ALGVERSION       string  to be supplied by author
- DOCNAME          string  contains filename of 'cdp report' describing these files.
- DEPENDENCY       string  list of strings with filenames of CDPs that went into creation of this CDP.
- HISTORY      string  additional info on source of the data, from fits header if present
- UPLOAD DATE  string  (keep track of when file is uploaded to MIRI database)

*/
print "Database update successful.\n";
?>