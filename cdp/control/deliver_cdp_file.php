<?php
global $objCdp, $objFits, $ftp_server;

$filename = $_POST['filename'];
$delivery = $_POST['DELIVERY'];

//$objCdp->deliver_file($filename, $delivery);

// Add all the other keys
foreach ($_POST as $key => $value) {
  if ($key != "indexAction" && $key != "filename") {
    $objCdp->addKey($filename, $key, $value);
  }
}

$fitsKeywords = $objFits->getHeader($filename);

foreach($fitsKeywords as $key => $value) {
  if ($key != "FILENAME") {
    $objCdp->addKey($filename, $key, $value);
  }
}
$_GET['indexAction']='deliver_cdp';
return;

?>