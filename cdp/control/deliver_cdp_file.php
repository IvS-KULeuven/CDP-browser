<?php
global $objCdp, $objFits, $ftp_server;

$filename = $_POST['filename'];
$delivery = $_POST['DELIVERY'];

print_r($objFits->getHeader($filename));
//exit;
$objCdp->deliver_file($filename, $delivery);

// Add all the other keys
foreach ($_POST as $key => $value) {
  if ($key != "indexAction") {
    $objCdp->addKey($filename, $key, $value);
  }
}

$_GET['indexAction']='deliver_cdp';
return;

?>