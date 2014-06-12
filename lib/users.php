<?php 
// users.php
// The users class collects all functions needed to enter, retrieve and adapt user data from the database and functions to display the data.

class Users
{ public  function addUser($id, $name, $firstname, $email, $password)
  { global $objDatabase; 
    return $objDatabase->execSQL("INSERT INTO users (id, name, firstname, email, password, role) VALUES (\"$id\", \"$name\", \"$firstname\", \"$email\", \"$password\", \"2\")");
  }
  public  function getAdministrators()
  { global $objDatabase; 
    return $objDatabase->selectSingleArray("SELECT id FROM users WHERE role = \"0\"",'id');
  }
  public  function getUserProperty($id,$property,$defaultValue='')
  { global $objDatabase; 
    return $objDatabase->selectSingleValue("SELECT ".$property." FROM users WHERE id=\"".$id."\"",$property,$defaultValue);
  }
  public  function getSortedUsers($sort)
  { global $objDatabase; 
    return $objDatabase->selectSingleArray("SELECT users.id FROM observers ORDER BY $sort",'id');
  }
  public  function setUserProperty($id, $property, $propertyValue)                                                 // sets a new value for the property of the observer
  { global $objDatabase; 
   $objDatabase->execSQL("UPDATE users SET ".$property."=\"".$propertyValue."\" WHERE id=\"".$id."\"");
  }
  public  function validateDeleteUser()
  { global $objDatabase,$entryMessage,$loggedUser;
    $objDatabase->execSQL("DELETE FROM users WHERE id=\"".($id=$objUtil->checkGetKey('validateDelete'))."\"");
    return "The user has been erased.";
  }
  public  function isAdministrator($userId) {
  	$role = $this->getUserProperty($userId, "role");
  	if ($role == 0) {
  		return true;
  	} else {
  		return false;
  	}
  }
  public  function validateObserver()
  { global $objDatabase,$objUtil, $entryMessage;
    $objDatabase->execSQL("UPDATE users SET role = \"".($role=1)."\" WHERE id=\"".($id=$objUtil->checkGetKey('validate'))."\"");

    return LangValidateObserverMessage1.' '.LangValidateObserverMessage2;
  }
}
?>
