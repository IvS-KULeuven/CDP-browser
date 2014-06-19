<?php
global $objMetadata;

$keyword = $_POST['keyword'];
$value = $_POST['currentValue'];

$objMetadata->deleteValue($keyword, $value);

$_GET['indexAction']='admin_metadata';
return;
?>