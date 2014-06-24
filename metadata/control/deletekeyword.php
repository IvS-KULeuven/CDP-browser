<?php
  global $objMetadata, $objUser, $entryMessage, $loggedUser;

  $keyword = $_GET['keyword'];

  if ($objUser->isAdministrator($loggedUser)) {
  // Only administrators can delete keywords
   
  $objMetadata->deleteKeyword($keyword);
  $entryMessage = "Succesfully deleted keyword <strong>" . $keyword . "</strong>.";

  // Return to admin_metadata
  $_GET['indexAction']='admin_metadata';
}

return;
?>