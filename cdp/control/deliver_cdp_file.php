<?php
global $objCdp;

$filename = $_POST['filename'];
$delivery = $_POST['DELIVERY'];
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