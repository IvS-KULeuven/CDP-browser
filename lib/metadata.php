<?php
// metadata.php
// The metadata class.
class Metadata {
  public function getValidValues($key) {
    global $objDatabase;

    return $objDatabase->selectSingleArray ( "select * from metadata where id = \"" . $key . "\"", "value" );
  }
  public function getKeys() {
    global $objDatabase;

    return $objDatabase->selectSingleArray ( "select DISTINCT(id) from metadata;" );
  }
  public function getType($key) {
    global $objDatabase;

    return $objDatabase->selectSingleValue ( "select * from metadata where id = \"" . $key . "\"", "valueType" );
  }
  public function getLocation($key) {
    global $objDatabase;

    $inFits = $objDatabase->selectSingleValue ( "select * from metadata where id = \"" . $key . "\"", "inFits" );

    if ($inFits) {
      return "FITS";
    } else {
      return "External";
    }
  }
  public function keywordAlreadyTaken($key) {
    global $objDatabase;
    $keys = $this->getKeys ();

    $taken = false;
    foreach ( $keys as $value ) {
      if ($value ["id"] == $key) {
        $taken = true;
      }
    }
    return $taken;
  }
  public function addMetadata($keyword, $location, $type, $value, $required) {
    global $objDatabase;
    if ($location == "FITS") {
      $locationBit = 1;
    } else {
      $locationBit = 0;
    }
    return $objDatabase->execSQL ( "INSERT INTO metadata (id, inFits, valueType, value, required) VALUES (\"$keyword\", \"$locationBit\", \"" . strtoupper ( $type ) . "\", \"$value\", \"$required\")" );
  }
  public function deleteKeyword($keyword) {
    global $objDatabase;
    return $objDatabase->execSQL ( "DELETE FROM metadata where id = \"" . $keyword . "\"" );
  }
  public function changeType($keyword, $type, $value) {
    // First, we remove the keyword, and then we add a new keyword with the given properties
    $inFits = $this->getLocation ( $keyword );
    $required = $this->isRequired ( $keyword );
    $this->deleteKeyword ( $keyword );
    $this->addMetadata ( $keyword, $inFits, $type, $value, $required );
  }
  public function changeValue($keyword, $currentValue, $newValue) {
    global $objDatabase;
    return $objDatabase->execSQL ( "UPDATE metadata SET value = \"$newValue\" WHERE id = \"$keyword\" AND value=\"$currentValue\"" );
  }
  public function changeLocation($keyword, $location) {
    global $objDatabase;
    if ($location == "FITS") {
      $locationBit = 1;
    } else {
      $locationBit = 0;
    }
    return $objDatabase->execSQL ( "UPDATE metadata SET inFits = \"" . $locationBit . "\" WHERE id = \"$keyword\"" );
  }
  public function changeRequired($keyword, $newValue) {
    global $objDatabase;
    $keyword = str_replace('_', ' ', $keyword);
    return $objDatabase->execSQL ( "UPDATE metadata SET required = \"$newValue\" WHERE id = \"$keyword\"" );
  }
  public function isValidValue($keyword, $value) {
    $keyword = str_replace('_', ' ', $keyword);
    $values = $this->getValidValues ( $keyword );
    $type = $this->getType ( $keyword );
    if ($type == "LIST" || $type == "MULTILIST") {
      foreach ( $values as $key ) {
        if ($key ['value'] == $value) {
          return true;
        }
      }
    } else {
      return true;
    }
    return false;
  }
  public function hasKey($key) {
    $keys = $this->getKeys ();
    foreach ( $keys as $value ) {
      if (strtoupper ( $value ['id'] ) == strtoupper ( $key )) {
        return true;
      }
    }
    return false;
  }
  public function isRequired($key) {
    global $objDatabase;

    return $objDatabase->selectSingleValue ( "select * from metadata where id = \"" . $key . "\"", "required" );
  }
  public function addValue($keyword, $value, $type) {
    // type is always LIST or MULTILIST
    $inFits = $this->getLocation ( $keyword );
    $required = $this->isRequired ( $keyword );
    return $this->addMetadata ( $keyword, $inFits, $type, $value, $required );
  }
  public function deleteValue($keyword, $value) {
    global $objDatabase;
    return $objDatabase->execSQL ( "DELETE FROM metadata WHERE value = \"$value\" AND id = \"$keyword\"" );
  }
  public function getExternalKeywords() {
    global $objDatabase;
    return $objDatabase->selectSingleArray ( "SELECT DISTINCT(id) FROM metadata WHERE inFits = \"0\"" );
  }
}
?>
