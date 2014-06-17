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
}
?>