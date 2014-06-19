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

// Add the READPATT metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"READPATT\", \"LIST\", \"FAST\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"READPATT\", \"LIST\", \"SLOW\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"READPATT\", \"LIST\", \"ANY\")";
$objDatabase->execSQL($sql);

// Add the SUBARRAY metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"FULL\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"MASK1140\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"MASK1550\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"MASK1065\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"MASKLYOT\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"BRIGHTSKY\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"SUB256\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"SUB128\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"SUB64\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBARRAY\", \"LIST\", \"SPLITLESSPRISM\")";
$objDatabase->execSQL($sql);

// Add the FILTER metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F560W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F770W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1000W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1130W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1280W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1500W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1800W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F2100W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F2550W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F2550WR\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1065C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1140C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F1550C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"F2300C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"P750L\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"FLEND\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"FND\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILTER\", \"LIST\", \"OPAQUE\")";
$objDatabase->execSQL($sql);

// Add the CHANNEL metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"CHANNEL\", \"LIST\", \"1\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"CHANNEL\", \"LIST\", \"2\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"CHANNEL\", \"LIST\", \"3\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"CHANNEL\", \"LIST\", \"4\")";
$objDatabase->execSQL($sql);

// Add the BAND metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"BAND\", \"LIST\", \"A\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"BAND\", \"LIST\", \"B\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"BAND\", \"LIST\", \"C\")";
$objDatabase->execSQL($sql);

// Add the GRATINGA metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"GRATINGA\", \"LIST\", \"A\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"GRATINGA\", \"LIST\", \"B\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"GRATINGA\", \"LIST\", \"C\")";
$objDatabase->execSQL($sql);

// Add the GRATINGB metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"GRATINGB\", \"LIST\", \"A\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"GRATINGB\", \"LIST\", \"B\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"GRATINGB\", \"LIST\", \"C\")";
$objDatabase->execSQL($sql);

// Add the TELESCOP metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"TELESCOP\", \"LIST\", \"JWST\")";
$objDatabase->execSQL($sql);

// Add the INSTRUME metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"INSTRUME\", \"LIST\", \"MIRI\")";
$objDatabase->execSQL($sql);

// Add the FILENAME metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FILENAME\", \"STRING\", \"\")";
$objDatabase->execSQL($sql);

// Add the DESCRIP metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"DESCRIP\", \"STRING\", \"\")";
$objDatabase->execSQL($sql);

// Add the AUTHOR metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"AUTHOR\", \"STRING\", \"\")";
$objDatabase->execSQL($sql);

// Add the PEDIGREE metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"PEDIGREE\", \"LIST\", \"GROUND\")";
$objDatabase->execSQL($sql);

// Add the SUBSTRT1 metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBSTRT1\", \"INTEGER\", \"\")";
$objDatabase->execSQL($sql);

// Add the SUBSIZE1 metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBSIZE1\", \"INTEGER\", \"\")";
$objDatabase->execSQL($sql);

// Add the SUBSTRT2 metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBSTRT2\", \"INTEGER\", \"\")";
$objDatabase->execSQL($sql);

// Add the SUBSIZE2 metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SUBSIZE2\", \"INTEGER\", \"\")";
$objDatabase->execSQL($sql);

// Add the FASTAXIS metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"FASTAXIS\", \"LIST\", \"1\")";
$objDatabase->execSQL($sql);

// Add the SLOWAXIS metadata
$sql = "INSERT INTO metadata ( id, valueType, value ) VALUES ( \"SLOWAXIS\", \"LIST\", \"2\")";
$objDatabase->execSQL($sql);




/*
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