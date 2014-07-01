<?php
global $objCdp;

$filename = $_POST['filename'];
$delivery = $_POST['delivery'];
$size = $_POST['size'];

$objCdp->deliver_file($filename, $delivery);
$objCdp->addKey($filename, "size", $size);

$_GET['indexAction']='deliver_cdp';
return;

?>