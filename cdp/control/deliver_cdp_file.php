<?php
global $objCdp, $objFits, $ftp_server, $objDatabase;

$filename = $_POST['filename'];

if (sizeof($_POST['DELIVERY']) > 1) {
  $cnt = 0;
  foreach ($_POST['DELIVERY'] as $delivery) {
    if ($cnt == 0) {
      $objCdp->deliver_file($filename, $delivery);
      $cnt = 1;
    } else {
      $objDatabase->execSQL ( "INSERT INTO cdp ( filename, name, keyvalue ) VALUES ( \"" . $filename . "\", \"delivery\", \"" . $delivery . "\") " );
    }
  }
} else {
  $delivery = $_POST['DELIVERY'];
  $objCdp->deliver_file($filename, $delivery);
}

// Add all the other keys
foreach ($_POST as $key => $value) {
  if ($key != "indexAction" && $key != "filename") {
    if (is_array($value)) {
      $objCdp->addArrayKey($filename, $key, $value);
    } else {
      $objCdp->addKey($filename, $key, $value);
    }
  }
}

// Add all the keys from the fits file
if (substr($filename, -5) == ".fits") {
  $fitsKeywords = $objFits->getHeader($filename);
  foreach($fitsKeywords as $key => $value) {
    if ($key != "FILENAME") {
      $objCdp->addKey($filename, $key, $value);
    }
  }
}
$_GET['indexAction']='deliver_cdp';
return;

?>