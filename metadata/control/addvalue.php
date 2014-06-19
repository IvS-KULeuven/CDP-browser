<?php
  global $objMetadata;
  
  $keyword = $_POST['keyword'];
  $value = $_POST['value'];

  // Check if the value is already known
  if ($objMetadata->isValidValue($keyword, $value)) {
    $entryMessage = "Value <strong>" . $value . "</strong> was already a possible value for <strong>" . $keyword . "</strong>";
  } else {
    $objMetadata->addValue($keyword, $value);
  }
  
  $_GET['indexAction']='admin_metadata';
  return;
?>