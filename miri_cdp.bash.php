<?php 
// miri_cdp.bash
// exports a bash file to download the CDP files

header ("Content-Type: text/plain");
header ("Content-Disposition: attachment; filename=\"miri_cdp.bash\"");

miri_cdp();

function miri_cdp()
{ 
  print "TEST";
}
?>