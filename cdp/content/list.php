<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";
	
echo "<h2>List of CDP files</h2>";
	
// We make some tabs, to see the different CDP releases
echo " <ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">";

$cdpVersions = $objCdp->getUsedCdpVersions();

// Sort to see the most recent cdp version as the first version.
rsort($cdpVersions);

$active = " class=\"active\"";
foreach($cdpVersions as $key) {
  echo "<li" . $active . "><a href=\"#cdp". str_replace('.', '_', $key['keyvalue']) . "\" data-toggle=\"tab\">CDP " . $key['keyvalue'] . "</a></li>";
  $active = "";
}
echo " </ul>";

echo " <div id=\"my-tab-content\" class=\"tab-content\">";

$active = " active";
$counter = 0;
foreach($cdpVersions as $key) {
  echo "  <div class=\"tab-pane" . $active . "\" id=\"cdp" . str_replace('.', '_', $key['keyvalue']) . "\">";
  $active = "";
  // We make a table with all files from the ftp site
  echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
  echo "    <thead><th data-priority=\"critical\">Filename</th><th data-priority=\"2\">Size</th><th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th></thead>";
  echo "    <tbody>";

  $items = $objCdp->getFilesForCdpDelivery($key['keyvalue']);
  
  foreach ($items as $key) {
    echo "<tr>";
    echo "<td>". $key["filename"] . "</td>";
    
    $properties = $objCdp->getProperty($key['filename'], "size");
  	echo "<td>" . $properties[0][2] . "</td>";
  	echo "<td>";
    echo "<button type=\"button\" title=\"Download " . $key["filename"] . "\" class=\"btn btn-default pull-right\" >
  	        <span class=\"glyphicon glyphicon-download\"></span>
  		  </button></td>";
  	echo "</td>";
    echo "</tr>\n";
  }
	
  echo "    </tbody>
           </table>";
  echo $objUtil->addTablePager($counter);
  echo "  </div>";
  $objUtil->addTableJavascript($counter);
  $counter++;
}
echo "  </div>
	   </div><br /><br />";


?>
