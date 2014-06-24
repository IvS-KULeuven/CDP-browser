<?php
global $objMetadata;

$keyword = $_POST['keyword'];
$location = $_POST['location'];

$objMetadata->changeLocation($keyword, $location);

$_GET['indexAction']='admin_metadata';
return;
?>