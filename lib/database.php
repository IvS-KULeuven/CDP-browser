<?php
// database.php
// The database class collects all functions needed to login and logout from the database.

class Database
{ private $databaseId;

  public function execSQL($sql)
  { if(!$this->databaseId) {echo "Database connection lost..."; $this->newLogin();}
    try {
      $run = $this->databaseId->query($sql);
    } catch(PDOException $ex) {
      $entryMessage = "A database error occured!"; //user friendly message
    }
  }

  public function selectSingleValue($sql,$name,$nullvalue='')
  { if(!$this->databaseId) {echo "Database connection lost..."; $this->newLogin();}

    try {
      $run = $this->databaseId->query($sql);
    } catch(PDOException $ex) {
      $entryMessage = "A database error occured!"; //user friendly message
    }
    
    $get = $run->fetch(PDO::FETCH_ASSOC);
    if($get)
      if ($get[$name]!='')
	    return $get[$name];
      else
	    return null;
      else
	    return null;
  }

  function __construct()
  { global $dbname,$host,$user,$pass;
    if(!$this->databaseId)
    { $this->databaseId = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $pass);
    }
    return $this->databaseId;
  }
}
?>