<?php
// cdp.php
// The cdp class collects all functions needed to read the files from the ftp server.
class Cdp {
  // Returns a list with all files from the ftp server.
  public function getFilesFromFtpServer() {
    global $ftp_server, $ftp_directory, $ftp_password, $ftp_user;

    // set up an ftp connection
    $conn_id = ftp_connect ( $ftp_server );

    if (! $conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return;
    } else {
      // try to login
      if (@ftp_login ( $conn_id, $ftp_user, $ftp_password)) {
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
    global $ftp_server, $ftp_directory, $ftp_password, $ftp_user;

    // set up an ftp connection
    $conn_id = ftp_connect ( $ftp_server );

    $toReturn = false;

    if (! $conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return $toReturn;
    } else {
      // try to login
      if (@ftp_login ( $conn_id, $ftp_user, $ftp_password)) {
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
    global $ftp_server, $ftp_directory, $ftp_user, $ftp_password;

    // set up an ftp connection
    $conn_id = ftp_connect ( $ftp_server ) or die ( "Couldn't connect to $ftp_server" );

    $toReturn = 0;

    if (! $conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return $toReturn;
    } else {
      // try to login
      if (@ftp_login ( $conn_id, $ftp_user, $ftp_password)) {
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
  public function getFilesForDHASDelivery() {
    global $objDatabase;

    return $objDatabase->selectSingleArray ( "SELECT * from cdp where name = \"INCLUDE_IN_DHAS\" AND keyvalue = \"y\"" );
  }
  public function getFilesForFullDelivery() {
    global $objDatabase;
    return $objDatabase->selectSingleArray ( "SELECT * from cdp where name = \"INCLUDE_IN_FULL_DELIVERY\" AND keyvalue = \"y\"" );
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
  public function getInDeliveryFromFiles($filenames) {
    global $objDatabase;

    $filesToInclude = array ();
    foreach ( $filenames as $file ) {
      $fileToInclude = $objDatabase->selectSingleArray ( "select filename from cdp where filename=\"" . $file [0] . "\" and name=\"INCLUDE_IN_DELIVERY\" and keyvalue=\"y\"" );

      if ($fileToInclude) {
        $f = $fileToInclude[0];
        array_push ( $filesToInclude, $f);
      }
    }
    return $filesToInclude;
  }
  public function getPipelineModulesFromFiles($filenames) {
    global $objDatabase;

    $steps = array ();
    foreach ( $filenames as $file ) {
      $newStep = $objDatabase->selectSingleArray ( "select keyvalue from cdp where filename=\"" . $file [0] . "\" and name=\"PIPELINE_MODULE\"" );
      if ($newStep) {
        foreach ($newStep as $step) {
          if (! in_array ( $step [0], $steps )) {
            array_push ( $steps, $step [0] );
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
              array_push ( $steps, trim($newStep [0] [0] ));
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
    $toReturn = array ();
    foreach($allFiles as $file) {
      $pipelineModule = $this->getProperty($file[0], 'PIPELINE_MODULE');
      if (sizeof($pipelineModule) == 0) {
        $toReturn[] = $file[0];
      }
    }
    return $toReturn;
  }
  public function getAllFilesWithoutPipelineInformation() {
    $allFiles = $this->getFilesForFullDelivery();

    // We now ask for the pipeline module of all files.
    // If the pipeline module is not set, we add the file to the list to return.
    $toReturn = array ();
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

    return $objDatabase->selectSingleArray ( "select a.filename from cdp as a, cdp as b, cdp as c, cdp as d, cdp as e,
                                                           where a.name=\"PIPELINE_MODULE\" and a.keyvalue=\"" . $module . "\"
                                                           and b.name=\"PIPELINE_STEP\" and b.keyvalue=\"" . $step . "\"
                                                           and c.name=\"REFTYPE\" and c.keyvalue=\"" . $refType . "\"
                                                           and d.name=\"delivery\" and d.keyvalue=\"" . $delivery . "\"
                                                           and e.name=\"FILETYPE\" and e.keyvalue=\"" . $fileType . "\"" );
  }
  public function getFileNamesCdp($delivery, $module, $step, $refType, $fileType) {
    global $objDatabase;

    return $objDatabase->selectSingleArray ( "select a.filename from cdp as a, cdp as b, cdp as c, cdp as d, cdp as e,
                                                           where a.name=\"delivery\" and a.keyvalue=\"" . $delivery . "\"
                                                           and b.name=\"PIPELINE_MODULE\" and b.keyvalue=\"" . $module . "\"
                                                           and c.name=\"PIPELINE_STEP\" and c.keyvalue=\"" . $step . "\"
                                                           and d.name=\"REFTYPE\" and d.keyvalue=\"" . $refType . "\"
                                                           and e.name=\"FILETYPE\" and e.keyvalue=\"" . $fileType . "\"" );
  }
  public function getFileNamesFull($module, $step, $refType, $fileType) {
    global $objDatabase;

    return $objDatabase->selectSingleArray ( "select a.filename from cdp as a, cdp as b, cdp as c, cdp as d, cdp as e,
                                                           where a.name=\"INCLUDE_IN_FULL_DELIVERY\" and a.keyvalue=\"y\"
                                                           and b.name=\"PIPELINE_MODULE\" and b.keyvalue=\"" . $module . "\"
                                                           and c.name=\"PIPELINE_STEP\" and c.keyvalue=\"" . $step . "\"
                                                           and d.name=\"REFTYPE\" and d.keyvalue=\"" . $refType . "\"
                                                           and e.name=\"FILETYPE\" and e.keyvalue=\"" . $fileType . "\"" );
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
  public function addArrayKey($filename, $name, $keyvalue) {
    global $objDatabase, $entryMessage;

    // In this case, the keyvalue is an array.
    foreach ($keyvalue as $key) {
      $objDatabase->execSQL ( "INSERT INTO cdp ( filename, name, keyvalue ) VALUES ( \"" . $filename . "\", \"" . $name . "\", \"" . $key . "\") " );
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
