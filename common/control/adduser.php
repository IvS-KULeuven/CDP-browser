<?php
global $objUser, $entryMessage;

$id = $_POST['id'];
$firstname = $_POST['firstname'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = md5($_POST['passwd']);

// We check if the id is already taken... If this is the case, we return with an error...
if ($objUser->userIdAlreadyTaken($id)) {
	$entryMessage = "The given user id does already exist. Please chose another one.";
} else {
	$objUser->addUser($id, $name, $firstname, $email, $password);
}

$_GET['indexAction']='admin_users';
return;
?>