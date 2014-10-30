<?php
// miri_cdp.bash
// exports a bash file to download the CDP files
header ( "Content-Type: text/plain" );
header ( "Content-Disposition: attachment; filename=\"cdp" . $_GET ['release'] . ".csv\"" );

$release = $_GET ['release'];
miri_cdp ( $release );
function miri_cdp($release) {
  $loginErrorCode = "";
  $loginErrorText = "";
  require_once 'common/entryexit/preludes.php';
  
  global $objCdp, $objMetadata;
  
  // We first print the header
  print "Filename|DELIVERY";
  
  $externalKeywords = $objMetadata->getExternalKeywords ();
  foreach ( $externalKeywords as $key => $value ) {
    if ($value ['id'] != "DELIVERY") {
      print "|" . $value ['id'];
    }
  }
  print "\n";
  
  // Here, we add all files which belong to the given CDP release.
  $items = $objCdp->getFilesForCdpDelivery ( $release );
  
  foreach ( $items as $key ) {
    print $key ['filename'] . "|" . $release;
    foreach ( $externalKeywords as $key2 => $value ) {
      if ($value ['id'] != "DELIVERY") {
        print "|";
        $property = $objCdp->getProperty($key['filename'], str_replace(' ', '_', $value ['id']));
        if (!empty($property)) {
          print $property[0][2];
        }
      }
    }
    print "\n";
  }
}
?>