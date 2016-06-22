<?php
global $objCdp, $entryMessage;

foreach ($_POST['undeliver'] as $filename) {
  $objCdp->undeliver_file($filename);
}
$entryMessage = "Removed all requested files from the delivered CDP files.";
$_GET['indexAction']='deliver_cdp';
return;

?>
