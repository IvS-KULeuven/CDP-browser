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
  public function getDeliveredFiles() {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "select DISTINCT(filename) from cdp;" );
  }
  public function getFilesForCdpDelivery($delivery) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "SELECT * from cdp where name = \"delivery\" AND keyvalue = \"" . $delivery . "\"" );
  }
  public function getPipelineModules() {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "select distinct(keyvalue) from cdp where name=\"PIPELINE_MODULE\";" );
  }
  public function getDeliveries() {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "select distinct(keyvalue) from cdp where name=\"delivery\";" );
  }
  public function getFilesForPipelineModule($module) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "select filename from cdp where name=\"PIPELINE_MODULE\" and keyvalue=\"" . $module . "\"" );
  }
  public function getFilesForDelivery($delivery) {
    global $objDatabase;
    
    return $objDatabase->selectSingleArray ( "select filename from cdp where name=\"delivery\" and keyvalue=\"" . $delivery . "\"" );
  }
  public function getPipelineModulesFromFiles($filenames) {
    global $objDatabase;
    
    $steps = array ();
    foreach ( $filenames as $file ) {
      $newStep = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"PIPELINE_MODULE\"" );
      if ($newStep) {
        if ($newStep [0]) {
          if (! in_array ( $newStep [0] [0], $steps )) {
            array_push ( $steps, $newStep [0] [0] );
          }
        }
      }
    }
    return array_unique ( $steps );
  }
  public function getPipelineSteps($filenames) {
    global $objDatabase;
    
    $steps = array ();
    foreach ( $filenames as $file ) {
      $newStep = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"PIPELINE_STEP\"" );
      if ($newStep) {
        if ($newStep [0]) {
          if (! in_array ( $newStep [0] [0], $steps )) {
            array_push ( $steps, $newStep [0] [0] );
          }
        }
      }
    }
    return array_unique ( $steps );
  }
  public function getRefTypes($filenames) {
    global $objDatabase;
    
    $steps = array ();
    foreach ( $filenames as $file ) {
      $newStep = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"REFTYPE\"" );
      if ($newStep) {
        if ($newStep [0]) {
          if ($newStep [0] [0]) {
            if (! in_array ( $newStep [0] [0], $steps )) {
              array_push ( $steps, $newStep [0] [0] );
            }
          }
        }
      }
    }
    return array_unique ( $steps );
  }
  public function getDeliveriesFromFiles($filenames, $release) {
    global $objDatabase;
    
    $deliveries = array ();
    foreach ( $filenames as $file ) {
      if ($release == "") {
        $newDelivery = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"delivery\"" );
      } else {
        $newDelivery = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"delivery\" and keyvalue=\"" . $release . "\"" );
      }
      if (sizeof ( $newDelivery ) > 0) {
        if (! in_array ( $newDelivery [0] [0], $deliveries )) {
          array_push ( $deliveries, $newDelivery [0] [0] );
        }
      }
    }
    return array_unique ( $deliveries );
  }
  public function getFilesWithoutPipelineInformation($release) {
    $allFiles = $this->getFilesForCdpDelivery($release);
    
    // We now ask for the pipeline module of all files.
    // If the pipeline module is not set, we add the file to the list to return.
    $toReturn = [];
    foreach($allFiles as $file) {
      $pipelineModule = $this->getProperty($file[0], 'PIPELINE_MODULE');
      if (sizeof($pipelineModule) == 0) {
        $toReturn[] = $file[0];
      }
    }
    return $toReturn;
  }
  public function getFileTypes($filenames) {
    global $objDatabase;
    
    $fileTypes = array ();
    foreach ( $filenames as $file ) {
      $newFileType = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"FILETYPE\"" );
      if (! in_array ( $newFileType [0] [0], $fileTypes )) {
        array_push ( $fileTypes, $newFileType [0] [0] );
      }
    }
    return array_unique ( $fileTypes );
  }
  public function getFileNames($module, $step, $refType, $delivery, $fileType) {
    global $objDatabase;
    
    $origFiles = $objDatabase->selectSingleArray ( "select filename from cdp where name=\"PIPELINE_MODULE\" and keyvalue=\"" . $module . "\"" );
    
    $newFiles = Array ();
    if (count ( $origFiles ) > 0) {
      foreach ( $origFiles as $file ) {
        $stepFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file [0] . "\" and name=\"PIPELINE_STEP\" and keyvalue=\"" . $step . "\"" );
        if (count ( $stepFiles )) {
          array_push ( $newFiles, $stepFiles [0] [0] );
        }
      }
      $files = $newFiles;
      
      $newFiles = Array ();
      if (count ( $files ) > 0) {
        foreach ( $files as $file ) {
          $refFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file . "\" and name=\"REFTYPE\" and keyvalue=\"" . $refType . "\"" );
          if (count ( $refFiles )) {
            array_push ( $newFiles, $refFiles [0] [0] );
          }
        }
        $files = $newFiles;
        
        $newFiles = Array ();
        if (count ( $files ) > 0) {
          foreach ( $files as $file ) {
            $deliveryFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file . "\" and name=\"delivery\" and keyvalue=\"" . $delivery . "\"" );
            if (count ( $deliveryFiles )) {
              array_push ( $newFiles, $deliveryFiles [0] [0] );
            }
          }
          $files = $newFiles;
          
          $newFiles = Array ();
          if (count ( $files ) > 0) {
            foreach ( $files as $file ) {
              $fileFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file . "\" and name=\"FILETYPE\" and keyvalue=\"" . $fileType . "\"" );
              if (count ( $fileFiles )) {
                array_push ( $newFiles, $fileFiles [0] [0] );
              }
            }
            $files = $newFiles;
          }
        }
      }
    }
    return ($files);
  }
  public function getFileNamesCdp($delivery, $module, $step, $refType, $fileType) {
    global $objDatabase;
    
    $origFiles = $objDatabase->selectSingleArray ( "select filename from cdp where name=\"delivery\" and keyvalue=\"" . $delivery . "\"" );
    
    $newFiles = Array ();
    if (count ( $origFiles ) > 0) {
      foreach ( $origFiles as $file ) {
        $stepFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file [0] . "\" and name=\"PIPELINE_MODULE\" and keyvalue=\"" . $module . "\"" );
        if (count ( $stepFiles )) {
          array_push ( $newFiles, $stepFiles [0] [0] );
        }
      }
      $files = $newFiles;
      
      $newFiles = Array ();
      if (count ( $files ) > 0) {
        foreach ( $files as $file ) {
          $refFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file . "\" and name=\"PIPELINE_STEP\" and keyvalue=\"" . $step . "\"" );
          if (count ( $refFiles )) {
            array_push ( $newFiles, $refFiles [0] [0] );
          }
        }
        $files = $newFiles;
        
        $newFiles = Array ();
        if (count ( $files ) > 0) {
          foreach ( $files as $file ) {
            $deliveryFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file . "\" and name=\"REFTYPE\" and keyvalue=\"" . $refType . "\"" );
            if (count ( $deliveryFiles )) {
              array_push ( $newFiles, $deliveryFiles [0] [0] );
            }
          }
          $files = $newFiles;
          
          $newFiles = Array ();
          if (count ( $files ) > 0) {
            foreach ( $files as $file ) {
              $fileFiles = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file . "\" and name=\"FILETYPE\" and keyvalue=\"" . $fileType . "\"" );
              if (count ( $fileFiles )) {
                array_push ( $newFiles, $fileFiles [0] [0] );
              }
            }
            $files = $newFiles;
          }
        }
      }
    }
    return ($files);
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