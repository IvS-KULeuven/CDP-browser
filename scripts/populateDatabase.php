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
// Make a user 'wim' and a user 'vincent'
$sql = "INSERT INTO users ( id, name, firstname, email, password, role ) VALUES ( \"wim\", \"De Meester\", \"Wim\", \"wim.demeester@ster.kuleuven.be\", \"" . md5("2MilG0q8ADBYg93S") . "\", 0)";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO users ( id, name, firstname, email, password, role ) VALUES ( \"vincent\", \"Geers\", \"Vincent\", \"vgeers@cp.dias.ie\", \"" . md5("qo6YCHKUy91NriO9") . "\", 0)";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO users ( id, name, firstname, email, password, role ) VALUES ( \"miri\", \"User\", \"Miri\", \"miri@miricle.org\", \"" . md5("p=314+MIRI") . "\", 1)";
$objDatabase->execSQL($sql);

print "Database table for the metadata will be added.\n";

$sql = "DROP TABLE IF EXISTS metadata";
$objDatabase->execSQL($sql);

$sql = "CREATE TABLE metadata (
          id        VARCHAR(32)    NOT NULL DEFAULT '',
          valueType VARCHAR(10)    NOT NULL DEFAULT '',
          inFits    INT(3)         NOT NULL DEFAULT '1',
          value     VARCHAR(64)    NOT NULL DEFAULT '',
          PRIMARY KEY(id, value)
    )";
$objDatabase->execSQL($sql);

// Add the TYPE metadata to the table
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"AbsFlux\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Bad\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"ColCorr\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"D2W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"D2c\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Dark\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Distort\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Droop\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"FringeFlat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Latent\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Lin\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"NThresh\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"PixFlat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"PSF\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"SRF\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"MRSRSRF\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"Sat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"SkyFlat\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TYPE\", \"LIST\", '1', \"TelEm\")";
$objDatabase->execSQL($sql);

// Add the REFTYPE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"IPC\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"MASK\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"SATURATION\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"DARK\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"LINEARITY\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"GAIN\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"READNOISE\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"WCS\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"FLAT\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"PHOTOM\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"AREA\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"REFTYPE\", \"MULTILIST\", '1', \"FRINGE\")";
$objDatabase->execSQL($sql);

// Add the VERSION metadata 
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"VERSION\", \"STRING\", '1', \"00.11.22\")";
$objDatabase->execSQL($sql);

// Add the USEAFTER metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"USEAFTER\", \"STRING\", '1', \"yyyy-mm-dd\")";
$objDatabase->execSQL($sql);

// Add the DETECTOR metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DETECTOR\", \"LIST\", '1', \"MIRIMAGE\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DETECTOR\", \"LIST\", '1', \"MIRIFUSHORT\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DETECTOR\", \"LIST\", '1', \"MIRIFULONG\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DETECTOR\", \"LIST\", '1', \"IM\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DETECTOR\", \"LIST\", '1', \"LW\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DETECTOR\", \"LIST\", '1', \"SW\")";
$objDatabase->execSQL($sql);

// Add the MODELNAM metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"MODELNAM\", \"LIST\", '1', \"VM\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"MODELNAM\", \"LIST\", '1', \"JPL\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"MODELNAM\", \"LIST\", '1', \"FM\")";
$objDatabase->execSQL($sql);

// Add the READPATT metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"READPATT\", \"LIST\", '1', \"FAST\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"READPATT\", \"LIST\", '1', \"SLOW\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"READPATT\", \"LIST\", '1', \"ANY\")";
$objDatabase->execSQL($sql);

// Add the SUBARRAY metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"FULL\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"MASK1140\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"MASK1550\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"MASK1065\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"MASKLYOT\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"BRIGHTSKY\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"SUB256\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"SUB128\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"SUB64\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBARRAY\", \"LIST\", '1', \"SPLITLESSPRISM\")";
$objDatabase->execSQL($sql);

// Add the FILTER metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F560W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F770W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1000W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1130W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1280W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1500W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1800W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F2100W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F2550W\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F2550WR\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1065C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1140C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F1550C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"F2300C\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"P750L\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"FLEND\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"FND\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILTER\", \"LIST\", '1', \"OPAQUE\")";
$objDatabase->execSQL($sql);

// Add the CHANNEL metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"CHANNEL\", \"LIST\", '1', \"1\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"CHANNEL\", \"LIST\", '1', \"2\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"CHANNEL\", \"LIST\", '1', \"3\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"CHANNEL\", \"LIST\", '1', \"4\")";
$objDatabase->execSQL($sql);

// Add the BAND metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"BAND\", \"LIST\", '1', \"A\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"BAND\", \"LIST\", '1', \"B\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"BAND\", \"LIST\", '1', \"C\")";
$objDatabase->execSQL($sql);

// Add the GRATINGA metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"GRATINGA\", \"LIST\", '1', \"A\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"GRATINGA\", \"LIST\", '1', \"B\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"GRATINGA\", \"LIST\", '1', \"C\")";
$objDatabase->execSQL($sql);

// Add the GRATINGB metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"GRATINGB\", \"LIST\", '1', \"A\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"GRATINGB\", \"LIST\", '1', \"B\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"GRATINGB\", \"LIST\", '1', \"C\")";
$objDatabase->execSQL($sql);

// Add the TELESCOP metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"TELESCOP\", \"LIST\", '1', \"JWST\")";
$objDatabase->execSQL($sql);

// Add the INSTRUME metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"INSTRUME\", \"LIST\", '1', \"MIRI\")";
$objDatabase->execSQL($sql);

// Add the FILENAME metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILENAME\", \"STRING\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the DESCRIP metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DESCRIP\", \"STRING\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the AUTHOR metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"AUTHOR\", \"STRING\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the PEDIGREE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PEDIGREE\", \"LIST\", '1', \"GROUND\")";
$objDatabase->execSQL($sql);

// Add the SUBSTRT1 metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBSTRT1\", \"INTEGER\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the SUBSIZE1 metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBSIZE1\", \"INTEGER\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the SUBSTRT2 metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBSTRT2\", \"INTEGER\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the SUBSIZE2 metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SUBSIZE2\", \"INTEGER\", '1', \"\")";
$objDatabase->execSQL($sql);

// Add the FASTAXIS metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FASTAXIS\", \"LIST\", '1', \"1\")";
$objDatabase->execSQL($sql);

// Add the SLOWAXIS metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"SLOWAXIS\", \"LIST\", '1', \"2\")";
$objDatabase->execSQL($sql);


// Add the metadata which is not in the FITS files

// Add the PIPELINE MODULE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALDETECTOR1\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALIMAGE2\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALSPEC2_LRS\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALSPEC2_MRS\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALIMAGE3\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALCORON3\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALSLIT3\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALSLITLESS3\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE MODULE\", \"MULTILIST\", '0', \"CALIFU3\")";
$objDatabase->execSQL($sql);

// Add the PIPELINE STEP metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"data_rejection\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"droop_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"reset_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"saturation_check\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"dark_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"linearity_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"jump_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"latent_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"absolute_flux_calibration\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"flatfield_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"source extraction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"fringe_correction\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"PIPELINE STEP\", \"LIST\", '0', \"distortion_wavelength_calibration\")";
$objDatabase->execSQL($sql);

// Add the FILETYPE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILETYPE\", \"LIST\", '0', \"documentation\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILETYPE\", \"LIST\", '0', \"algorithm\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILETYPE\", \"LIST\", '0', \"referencefile\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"FILETYPE\", \"LIST\", '0', \"testcase file\")";
$objDatabase->execSQL($sql);

// Add the DELIVERY metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DELIVERY\", \"MULTILIST\", '0', \"1\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DELIVERY\", \"MULTILIST\", '0', \"2\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DELIVERY\", \"MULTILIST\", '0', \"2.1\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DELIVERY\", \"MULTILIST\", '0', \"3\")";
$objDatabase->execSQL($sql);

// Add the DOCTYPE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DOCTYPE\", \"LIST\", '0', \"cdp report\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DOCTYPE\", \"LIST\", '0', \"pipeline algorithm\")";
$objDatabase->execSQL($sql);

// Add the DOCVERSION metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DOCVERSION\", \"STRING\", '0', \"\")";
$objDatabase->execSQL($sql);

// Add the ALGTYPE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"ALGTYPE\", \"LIST\", '0', \"cdp_test\")";
$objDatabase->execSQL($sql);

$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"ALGTYPE\", \"LIST\", '0', \"cdp_creation\")";
$objDatabase->execSQL($sql);

// Add the ALGVERSION metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"ALGVERSION\", \"STRING\", '0', \"\")";
$objDatabase->execSQL($sql);

// Add the DOCNAME metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DOCNAME\", \"STRING\", '0', \"\")";
$objDatabase->execSQL($sql);

// Add the DEPENDENCY metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"DEPENDENCY\", \"STRING\", '0', \"\")";
$objDatabase->execSQL($sql);

// Add the HISTORY metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"HISTORY\", \"STRING\", '0', \"\")";
$objDatabase->execSQL($sql);

// Add the UPLOAD DATE metadata
$sql = "INSERT INTO metadata ( id, valueType, inFits, value ) VALUES ( \"UPLOAD DATE\", \"STRING\", '0', \"\")";
$objDatabase->execSQL($sql);


print "Database update successful.\n";
?>