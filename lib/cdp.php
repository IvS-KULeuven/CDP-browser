<?php
// cdp.php
// The cdp class collects all functions needed to read the files from the ftp server.
class Cdp {
  // Returns a list with all files from the ftp server.
  public function getFilesFromFtpServer() {
    global $ftp_server, $ftp_directory;
    
    // set up an ftp connection
    $conn_id = ftp_connect ( $ftp_server );
    
    if (! $conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return;
    } else {
      // try to login
      if (@ftp_login ( $conn_id, 'anonymous', '' )) {
        if (is_array ( $children = @ftp_rawlist ( $conn_id, $ftp_directory ) )) {
          $items = array ();
          
          foreach ( $children as $child ) {
            $chunks = preg_split ( "/\s+/", $child );
            list ( $item ['rights'], $item ['number'], $item ['user'], $item ['group'], $item ['size'], $item ['month'], $item ['day'], $item ['time'] ) = $chunks;
            $item ['type'] = $chunks [0] {0} === 'd' ? 'directory' : 'file';
            array_splice ( $chunks, 0, 8 );
            if ($item ["type"] == "file") {
              $items [implode ( " ", $chunks )] = $item;
            }
          }
        }
      } else {
        $entryMessage = "Couldn't connect to $ftp_server";
      }
      
      // Close the connection to the ftp server
      ftp_close ( $conn_id );
      
      return $items;
    }
  }
  // Returns true if the files exists on the ftp server
  public function existOnFtpServer($filename) {
    global $ftp_server, $ftp_directory;
    
    // set up an ftp connection
    $conn_id = ftp_connect ( $ftp_server );
    
    $toReturn = false;
    
    if (! $conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return $toReturn;
    } else {
      // try to login
      if (@ftp_login ( $conn_id, 'anonymous', '' )) {
        if (is_array ( $children = @ftp_rawlist ( $conn_id, $ftp_directory ) )) {
          $items = array ();
          
          foreach ( $children as $child ) {
            $chunks = preg_split ( "/\s+/", $child );
            list ( $item ['rights'], $item ['number'], $item ['user'], $item ['group'], $item ['size'], $item ['month'], $item ['day'], $item ['time'] ) = $chunks;
            $item ['type'] = $chunks [0] {0} === 'd' ? 'directory' : 'file';
            array_splice ( $chunks, 0, 8 );
            if ($item ["type"] == "file") {
              if ($chunks [0] == $filename) {
                $toReturn = true;
              }
            }
          }
        }
      } else {
        $entryMessage = "Couldn't connect to $ftp_server";
      }
      
      // Close the connection to the ftp server
      ftp_close ( $conn_id );
      
      return $toReturn;
    }
  }
  // Get size from ftp server
  public function getSizeFromFtp($filename) {
    global $ftp_server, $ftp_directory;
    
    // set up an ftp connection
    $conn_id = ftp_connect ( $ftp_server ) or die ( "Couldn't connect to $ftp_server" );
    
    $toReturn = 0;
    
    if (! $conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return $toReturn;
    } else {
      // try to login
      if (@ftp_login ( $conn_id, 'anonymous', '' )) {
        if (is_array ( $children = @ftp_rawlist ( $conn_id, $ftp_directory ) )) {
          $items = array ();
          
          foreach ( $children as $child ) {
            $chunks = preg_split ( "/\s+/", $child );
            list ( $item ['rights'], $item ['number'], $item ['user'], $item ['group'], $item ['size'], $item ['month'], $item ['day'], $item ['time'] ) = $chunks;
            $item ['type'] = $chunks [0] {0} === 'd' ? 'directory' : 'file';
            array_splice ( $chunks, 0, 8 );
            $items [implode ( " ", $chunks )] = $item;
          }
          // Close the connection to the ftp server
          ftp_close ( $conn_id );
          
          foreach ( $items as $key => $value ) {
            if ($key == $filename) {
              return ($value ['size']);
            }
          }
        }
      } else {
        // Close the connection to the ftp server
        ftp_close ( $conn_id );
        
        $entryMessage = "Couldn't connect to $ftp_server";
      }
      
      return $toReturn;
    }
  }
  public function deliver_file($filename, $delivery) {
    global $objDatabase;

    $objDatabase->execSQL ( "INSERT INTO cdp ( filename, name, keyvalue ) VALUES ( \"" . $filename . "\", \"delivery\", \"" . $delivery . "\") " );
  }
  public function undeliver_file($filename) {
    global $objDatabase;

    $objDatabase->execSQL ( "DELETE FROM cdp where filename = \"" . $filename . "\";" );
  }
  public function getDelivery($filename) {
    global $objDatabase;

    return $objDatabase->selectSingleArray ( "SELECT * from cdp where name=\"delivery\" AND filename=\"" . $filename . "\"" );
  }
  public function getUsedCdpVersions() {
    global $objDatabase;

    return array_reverse ( $objDatabase->selectSingleArray ( "SELECT DISTINCT(keyvalue) from cdp where name=\"delivery\"" ) );
  }
  public function getFilesForCdpDelivery($delivery) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "SELECT * from cdp where name = \"delivery\" AND keyvalue = \"" . $delivery . "\"" );
  }
  public function getPipelineModules() {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray("select distinct(keyvalue) from cdp where name=\"PIPELINE_MODULE\";");
  }
  public function getFilesForPipelineModule($module) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ("select filename from cdp where name=\"PIPELINE_MODULE\" and keyvalue=\"" . $module . "\"");    
  }
  public function getPipelineSteps($filenames) {
    global $objDatabase;
    
    $steps = array();
    foreach ($filenames as $file) {
      $newStep = $objDatabase->selectSingleArray ("select keyvalue from cdp where filename=\"" . $file[0] . "\" and name=\"PIPELINE_STEP\"");
      if (!in_array($newStep[0][0], $steps)) {
        array_push($steps, $newStep[0][0]);
      }
    }
    return array_unique($steps);
  }
  public function addKey($filename, $name, $keyvalue) {
    global $objDatabase, $entryMessage;
    
    if ($name == "UPLOAD_DATE") {
      $dateArray = date_parse ( $keyvalue );
      
      if (! ($dateArray ['year'] && $dateArray ['month'] && $dateArray ['day'])) {
        $entryMessage = "Invalid date format! <strong>UPLOAD DATE</strong> is not changed!";
        return;
      } else {
        if (checkdate ( $dateArray ['month'], $dateArray ['day'], $dateArray ['year'] )) {
          $keyvalue = $dateArray ['year'] . '-' . sprintf ( "%02d", $dateArray ['month'] ) . '-' . sprintf ( "%02d", $dateArray ['day'] );
        } else {
          $entryMessage = "Invalid date! <strong>UPLOAD DATE</strong> is not changed!";
          return;
        }
      }
    }
    // Only add the key if the key was not yet known. If the key is already in the database, we need to update the value.
    if ($objDatabase->selectSingleArray ( "SELECT * from cdp where filename = \"" . $filename . "\" AND name = \"" . $name . "\"" )) {
      $objDatabase->execSQL ( "UPDATE cdp SET keyvalue = \"" . $keyvalue . "\" WHERE filename = \"" . $filename . "\" AND name = \"" . $name . "\"" );
    } else {
      $objDatabase->execSQL ( "INSERT INTO cdp ( filename, name, keyvalue ) VALUES ( \"" . $filename . "\", \"" . $name . "\", \"" . $keyvalue . "\") " );
    }
  }
  public function getProperty($filename, $keyword) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "SELECT * from cdp where filename=\"" . $filename . "\" AND name=\"" . $keyword . "\"" );
  }
  public function isDelivered($filename) {
    global $objDatabase;
    
    $count = $objDatabase->selectSingleValue ( "select COUNT(*) from cdp where filename = \"" . $filename . "\";", "COUNT(*)" );
    
    if ($count > 0) {
      return true;
    } else {
      return false;
    }
  }
}
?>