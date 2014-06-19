<?php
  global $objDatabase, $objMetadata, $baseURL;
  
  // We just print all the metadata types :
//  print_r($objMetadata->getKeys());
  
  // We also print the possible values for DETECTOR
//   print "<br />Possible DETECTOR values : <br />";
//   print_r($objMetadata->getValidValues("DETECTOR"));
  
  require_once "lib/fits.php";
   $fits = new Fits();
   $keywords = $fits->getHeader("/lhome/wim/Downloads/MIRI_FM_IM_F1000W_PSF_02.00.01.fits");

   print_r($keywords);
?>