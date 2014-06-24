<?php
  global $objMetadata, $entryMessage;
  
  $keyword = $_POST['keyword'];
  $type = $_POST['type'];
  $location = $_POST['location'];
  $value = $_POST['value'];
  
  // We check if the keyword is already used... If this is the case, we return with an error...
   if ($objMetadata->keywordAlreadyTaken($keyword)) {
     $entryMessage = "The metadata keyword <strong>" . $keyword . "</strong> does already exist. Please chose another one.";
   } else {
     $objMetadata->addMetadata($keyword, $location, $type, $value);
   }
  
   $_GET['indexAction']='admin_metadata';
   return;
?>