<?php
global $objMetadata;

$required = $_POST['setRequired'];
$id = $_POST['id'];

$objMetadata->changeRequired($id, $required);

$_GET['indexAction']='admin_metadata';
return;
?>