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
  public  function deleteKeyword($keyword)
  { global $objDatabase;
    return $objDatabase->execSQL("DELETE FROM metadata where id = \"" . $keyword . "\"");
  }
  public  function changeType($keyword, $type, $value) {
    // First, we remove the keyword, and then we add a new keyword with the given properties
    $this->deleteKeyword($keyword);
    $this->addMetadata($keyword, $type, $value);
  }
  public  function changeValue($keyword, $currentValue, $newValue) {
    global $objDatabase;
    return $objDatabase->execSQL("UPDATE metadata SET value = \"$newValue\" WHERE id = \"$keyword\" AND value=\"$currentValue\"");
  }
  public  function isValidValue($keyword, $value) {
    $values = $this->getValidValues($keyword);
    $toReturn = false;
    foreach ($values as $key) {
      if ($key[2] == $value) {
        return true;
      }
    }
    return false;
  }
  public  function addValue($keyword, $value) {
    // type is always LIST
    $type = "LIST";

    return $this->addMetadata($keyword, $type, $value);
  }
}
?>