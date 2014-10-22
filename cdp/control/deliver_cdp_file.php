<?php
global $objCdp, $objFits, $ftp_server;

$filename = $_POST['filename'];
$delivery = $_POST['DELIVERY'];

$objCdp->deliver_file($filename, $delivery);

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