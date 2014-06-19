<?php
  global $objMetadata;
  
  $keyword = $_POST['keyword'];
  $value = $_POST['value'];

  // Check if the 
  if ($objMetadata->isValidValue($keyword, $value)) {
  } else {
    $objMetadata->addValue($keyword, $value);
  }
  
  $_GET['indexAction']='admin_metadata';
  return;
?>