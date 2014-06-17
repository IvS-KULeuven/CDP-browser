<?php
  global $objDatabase, $objMetadata;
  
  // We just print all the metadata types :
  print_r($objMetadata->getKeys());
  
  // We also print the possible values for DETECTOR
  print "<br />Possible DETECTOR values : <br />";
  print_r($objMetadata->getValidValues("DETECTOR"));
?>