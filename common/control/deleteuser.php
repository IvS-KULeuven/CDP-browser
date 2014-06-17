<?php
  global $objUser, $entryMessage, $loggedUser;

  $id = $_GET['id'];

  if ($objUser->isAdministrator($loggedUser)) {
  	// Only administrators can delete other users
  	
  	// Other administrators can not be deleted
  	if ($objUser->isAdministrator($id)) {
  		$entryMessage = "User " . $id . " is an administrator and can not be deleted.";
  	} else {
  		$objUser->deleteUser($id);
  		$entryMessage = "Succesfully deleted user <strong>" . $id . "</strong>.";
  	} 

  	// Return to admin_users
  	$_GET['indexAction']='admin_users';
  }

  return;
?>