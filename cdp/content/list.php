<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";
	
echo "<h2>List of CDP files</h2>";
	
// We make some tabs, to see the different CDP releases
echo " <ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">";

$cdpVersions = $objCdp->getUsedCdpVersions();
$active = " class=\"active\"";
foreach($cdpVersions as $key) {
  echo "<li" . $active . "><a href=\"#cdp". str_replace('.', '_', $key['delivery']) . "\" data-toggle=\"tab\">CDP " . $key['delivery'] . "</a></li>";
  $active = "";
}
echo " </ul>";

// Add the button for the columns
$objUtil->addTableColumSelector();
	
echo " <div id=\"my-tab-content\" class=\"tab-content\">";

$active = " active";
foreach($cdpVersions as $key) {
  echo "  <div class=\"tab-pane" . $active . "\" id=\"cdp" . str_replace('.', '_', $key['delivery']) . "\">";
  $active = "";
  // We make a table with all files from the ftp site
  echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
  echo "    <thead><th data-priority=\"critical\">Filename</th><th data-priority=\"2\">Size</th><th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th></thead>";
  echo "    <tbody>";

  $items = $objCdp->getFilesForCdpDelivery($key['delivery']);
  foreach ($items as $key) {
    echo "<tr>";
    echo "<td>". $key["filename"] . "</td>"; 
  	echo "<td></td>";
  	echo "<td><span class=\"glyphicon glyphicon-download\"></span></td>";
    echo "</tr>\n";
  }
	
  echo "    </tbody>
           </table>";
  echo $objUtil->addTablePager();
  echo "  </div>";
}
echo "  </div>
	   </div><br /><br />";

$objUtil->addTableJavascript();

?>