<?php
  global $objUser, $entryMessage, $loggedUser;
  
  $id = $_GET['id'];
  
  if ($objUser->isAdministrator($loggedUser)) {
  	// Only administrators can change the role of other users
  	 
  	// Other administrators can not be deleted
  	if ($id == $loggedUser) {
  		$entryMessage = "You are not permitted to change the role of user <strong>" . $id . "</strong>.";
  	} else {
  		$entryMessage = $objUser->changeRole($id);
  	}
  
  	// Return to admin_users
  	$_GET['indexAction']='admin_users';
  }
  
  return;
?>