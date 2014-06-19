<?php
// metadata.php
// The metadata class.

class Metadata {
  public  function getValidValues($key) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray("select * from metadata where id = \"" . $key . "\"", "value");
  }
  public  function getKeys() {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray("select DISTINCT(id) from metadata;");
  }
  public  function getType($key) {
    global $objDatabase;
    
    return $objDatabase->selectSingleValue("select * from metadata where id = \"" . $key . "\"", "valueType");
  }
  public  function keywordAlreadyTaken($key)
  { global $objDatabase;
    $keys = $this->getKeys();
  
    $taken = false;
    foreach($keys as $value) {
      if ($value["id"] == $key) {
        $taken = true;
      }
    }
    return $taken;
  }
  public  function addMetadata($keyword, $type, $value)
  { global $objDatabase;
    return $objDatabase->execSQL("INSERT INTO metadata (id, valueType, value) VALUES (\"$keyword\", \"" . strtoupper($type) . "\", \"$value\")");
  }
}
?>