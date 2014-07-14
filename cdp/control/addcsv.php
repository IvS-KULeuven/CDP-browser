<?php
global $objMetadata, $objCdp;

// We check the file name
if ($_FILES ['csv'] ['tmp_name']) {
  $csvfile = $_FILES ['csv'] ['tmp_name'];
  $data_array = file ( $csvfile );
  
  // The first line defines the keywords
  $keywords = $data_array [0];
  
  $keys_array = explode ( "|", $keywords );
  
  // We check if the first keyword is 'Filename'
  if (strtoupper ( $keys_array [0] ) != "FILENAME") {
    $entryMessage = "Problem importing CSV file! The first keyword on should be Filename!";
    $_GET ['indexAction'] = 'import_csv_file';
    return;
  }
  
  $correctCSV = true;
  // We check the rest of the keywords. If they don't exist, we return with an error.
  for($i = 1; $i < sizeof ( $keys_array ); $i ++) {
    if ($objMetadata->hasKey ( rtrim ( $keys_array [$i] ) )) {
    } else {
      $correctCSV = false;
    }
  }

  if (! $correctCSV) {
    $entryMessage = "Incorrect keywords in the CSV file!";
    $_GET ['indexAction'] = 'import_csv_file';
  } else {
    for($i = 1; $i < sizeof ( $data_array ); $i ++) {
      // All keywords are correct, we read the first line.
      $line = explode ( "|", $data_array [$i] );
      $filename = $line [0];
      $delivery = $line [array_search("DELIVERY", $keys_array)];
      $upload_date = $line [array_search("UPLOAD DATE", $keys_array)];
      
      // Check if the file exists... We only add the files which are available on the ftp server.
      if ($objCdp->existOnFtpServer ( $filename )) {
        // We deliver the files.
        $objCdp->deliver_file ( $filename, $delivery );
        
        // Add the date
        $objCdp->addKey ( $filename, str_replace ( ' ', '_', $keys_array [2] ), $line [2] );
        
        // Add the size of the file
        $objCdp->addKey ( $filename, "size", $objCdp->getSizeFromFtp ( $filename ) );
      }
    }
  }
} else {
  $entryMessage = "Problem importing CSV file!";
  $_GET ['indexAction'] = 'import_csv_file';
}
?>