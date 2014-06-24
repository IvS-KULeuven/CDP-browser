<?php
global $objCdp;

$filename = $_POST['filename'];
$delivery = $_POST['delivery'];

$objCdp->deliver_file($filename, $delivery);

$_GET['indexAction']='deliver_cdp';
return;

?>