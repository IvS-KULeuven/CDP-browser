<?php
// metadata.php
// The metadata class.

class Metadata {
  public  function getValidValues($key) {

  }
  public  function getKeys() {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray("select DISTINCT(id) from metadata;");
  }
}
?>