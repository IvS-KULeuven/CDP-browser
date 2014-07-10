<?php
global $objMetadata;

// We check the file name
if($_FILES['csv']['tmp_name']) {
  $csvfile=$_FILES['csv']['tmp_name'];
  $data_array=file($csvfile);

  // The first line defines the keywords
  $keywords = $data_array[0];
  
  $keys_array = explode("|", $keywords);
  
  // We check if the first keyword is 'Filename'
  if (strtoupper($keys_array[0]) != "FILENAME") {
    $entryMessage = "Problem importing CSV file! The first keyword on should be Filename!";
    $_GET['indexAction']='import_csv_file';
    return;    
  }
  
  // We check the rest of the keywords. If they don't exist, we return with an error.
  for ($i = 1;$i < sizeof($keys_array);$i++) {
    // TODO : hasKey method should be tested!
    if ($objMetadata->hasKey($keys_array[$i])) {
      print($keys_array[$i] . "<br/>\n");
    }
  }
} else {
  $entryMessage = "Problem importing CSV file!";
  $_GET['indexAction']='import_csv_file';
}
exit;
?>