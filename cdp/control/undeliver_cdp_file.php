<?php
global $objCdp, $entryMessage;

$filename = $_POST['cdpfile'];

$objCdp->undeliver_file($filename);

$entryMessage = "Removed <strong>" . $filename . "</strong> from the delivered CDP files.";
$_GET['indexAction']='deliver_cdp';
return;

?>