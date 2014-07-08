<?php
  global $objMetadata, $entryMessage;
  
  $keyword = $_POST['keyword'];
  $type = $_POST['type'];
  $location = $_POST['location'];
  $value = $_POST['value'];
  $required = $_POST['required'];

  // We check if the keyword is already used... If this is the case, we return with an error...
   if ($objMetadata->keywordAlreadyTaken($keyword)) {
     $entryMessage = "The metadata keyword <strong>" . $keyword . "</strong> does already exist. Please chose another one.";
   } else {
     $objMetadata->addMetadata($keyword, $location, $type, $value, $required);
   }
  
   $_GET['indexAction']='admin_metadata';
   return;
?>