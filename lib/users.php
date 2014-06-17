<?php 
// users.php
// The users class collects all functions needed to enter, retrieve and adapt user data from the database and functions to display the data.

class Users
{ public  function addUser($id, $name, $firstname, $email, $password)
  { global $objDatabase; 
    return $objDatabase->execSQL("INSERT INTO users (id, name, firstname, email, password, role) VALUES (\"$id\", \"$name\", \"$firstname\", \"$email\", \"$password\", \"1\")");
  }
  public  function getAdministrators()
  { global $objDatabase; 
    return $objDatabase->selectSingleArray("SELECT id FROM users WHERE role = \"0\"",'id');
  }
  public  function getUserProperty($id,$property,$defaultValue='')
  { global $objDatabase; 
    return $objDatabase->selectSingleValue("SELECT ".$property." FROM users WHERE id=\"".$id."\"",$property,$defaultValue);
  }
  public  function getUsers()
  { global $objDatabase;
    return $objDatabase->selectSingleArray("SELECT * FROM users",'id');
  }
  public  function userIdAlreadyTaken($id)
  { global $objDatabase;
    $users = $this->getUsers();
    
    $taken = false;
    foreach($users as $value) {
    	if ($value["id"] == $id) {
    		$taken = true;
    	}
    }
    return $taken;
  }
  public  function setUserProperty($id, $property, $propertyValue)
  { // sets a new value for the property of the user
   global $objDatabase; 
   $objDatabase->execSQL("UPDATE users SET ".$property."=\"".$propertyValue."\" WHERE id=\"".$id."\"");
  }
  public  function deleteUser($id)
  { global $objDatabase,$loggedUser;
    $objDatabase->execSQL("DELETE FROM users WHERE id=\"".$id."\"");
  }
  public  function isAdministrator($userId) {
  	$role = $this->getUserProperty($userId, "role");
  	if ($role == 0) {
  		return true;
  	} else {
  		return false;
  	}
  }
  public  function validateUser()
  { global $objDatabase,$objUtil, $entryMessage;
    $objDatabase->execSQL("UPDATE users SET role = \"".($role=1)."\" WHERE id=\"".($id=$objUtil->checkGetKey('validate'))."\"");

    return LangValidateObserverMessage1.' '.LangValidateObserverMessage2;
  }
}
?>
