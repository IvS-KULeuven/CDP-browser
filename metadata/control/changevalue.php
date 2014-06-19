<?php
global $objMetadata;

$keyword = $_POST['keyword'];
$currentValue = $_POST['currentValue'];
$newValue = $_POST['newValue'];

$objMetadata->changeValue($keyword, $currentValue, $newValue);

$_GET['indexAction']='admin_metadata';
return;
?>