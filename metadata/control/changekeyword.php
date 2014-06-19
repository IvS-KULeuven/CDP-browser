<?php
global $objMetadata, $entryMessage;

$keyword = $_POST['keyword'];
$type = $_POST['type'];
$value = $_POST['value'];

$objMetadata->changeType($keyword, $type, $value);

$_GET['indexAction']='admin_metadata';
return;
?>