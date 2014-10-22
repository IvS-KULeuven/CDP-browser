<?php
global $objUtil, $objCdp, $ftp_server, $ftp_directory, $baseUrl;
global $objUser, $loggedUser;

echo "<div class=\"container-fluid\">";

echo "<h2>List of CDP files</h2>";

// We make some tabs, to see the different CDP releases
echo " <ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">";

$cdpVersions = $objCdp->getUsedCdpVersions ();

// Sort to see the most recent cdp version as the first version.
rsort ( $cdpVersions );

$active = " class=\"active\"";
foreach ( $cdpVersions as $key ) {
  echo "<li" . $active . "><a href=\"#cdp" . str_replace ( '.', '_', $key ['keyvalue'] ) . "\" data-toggle=\"tab\">CDP " . $key ['keyvalue'] . "</a></li>";
  $active = "";
}
echo " </ul>";

echo " <div id=\"my-tab-content\" class=\"tab-content\">";

$active = " active";
$counter = 0;
foreach ( $cdpVersions as $key ) {
  echo "  <div class=\"tab-pane" . $active . "\" id=\"cdp" . str_replace ( '.', '_', $key ['keyvalue'] ) . "\">";
  
  // We make a button to download all CDP files from a given CDP release
  echo "<a href=\"" . $baseUrl . "miri_cdp.bash.php?release=" . $key ['keyvalue'] . "\" target=\"_blank\" rel=\"external\"><button type=\"submit\" class=\"btn btn-success\">
  	    <span class=\"glyphicon glyphicon-save\"></span>&nbsp;All files for CDP " . $key ['keyvalue'] . "
  	   </button></a>";
  
  // We make a button to download all a csv file with all CDP files from a given CDP release
  if ($objUser->isAdministrator ( $loggedUser )) {
    echo "&nbsp;&nbsp;<a href=\"" . $baseUrl . "cdp.csv.php?release=" . $key ['keyvalue'] . "\" target=\"_blank\" rel=\"external\"><button type=\"submit\" class=\"btn btn-success\">
  	    <span class=\"glyphicon glyphicon-save\"></span>&nbsp;CSV file for CDP " . $key ['keyvalue'] . "
  	   </button></a>";
  }
  
  // We make a button to download all CDP files from a given CDP release ordered by delivery
  echo "&nbsp;&nbsp;<a href=\"" . $baseUrl . "miri_cdp_delivery.bash.php?release=" . $key ['keyvalue'] . "\" target=\"_blank\" rel=\"external\"><button type=\"submit\" class=\"btn btn-success\">
  	    <span class=\"glyphicon glyphicon-save\"></span>&nbsp;Sorted by delivery for CDP " . $key ['keyvalue'] . "
  	   </button></a>";
  
  // We make a button to download all CDP files from a given CDP release
  echo "&nbsp;&nbsp;<a href=\"" . $baseUrl . "miri_cdp_pipeline.bash.php?release=" . $key ['keyvalue'] . "\" target=\"_blank\" rel=\"external\"><button type=\"submit\" class=\"btn btn-success\">
  	    <span class=\"glyphicon glyphicon-save\"></span>&nbsp;Sorted by pipeline module for CDP " . $key ['keyvalue'] . "
  	   </button></a>";
  
  $active = "";
  // We make a table with all files from the ftp site
  echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
  echo "    <thead><th data-priority=\"critical\">Filename</th>
             <th data-priority=\"2\">Pipeline Module</th>
             <th data-priority=\"2\">Pipeline Step</th>
             <th data-priority=\"3\">Size</th>
             <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th></thead>";
  echo "    <tbody>";
  
  $items = $objCdp->getFilesForCdpDelivery ( $key ['keyvalue'] );
  
  foreach ( $items as $key ) {
    echo "<tr>";
    echo "<td style=\"vertical-align: middle\">" . $key ["filename"] . "</td>";
    
    $properties = $objCdp->getProperty ( $key ['filename'], "PIPELINE_MODULE" );
    if ($properties) {
      if (sizeof($properties) > 1) {
        echo "<td style=\"vertical-align: middle\">";
        $cnt = 1;
        foreach($properties as $mod) {
          print $mod[2];
          if ($cnt < sizeof($properties)) {
            echo ", ";
            $cnt++;
          }
        }
        echo "</td>";        
      } else {
        echo "<td style=\"vertical-align: middle\">" . $properties [0] [2] . "</td>";
      }
    } else {
      echo "<td style=\"vertical-align: middle\"></td>";
    }
    $properties = $objCdp->getProperty ( $key ['filename'], "PIPELINE_STEP" );
    if ($properties) {
      echo "<td style=\"vertical-align: middle\">" . $properties [0] [2] . "</td>";
    } else {
      echo "<td style=\"vertical-align: middle\"></td>";
    }
    
    $properties = $objCdp->getProperty ( $key ['filename'], "size" );
    echo "<td style=\"vertical-align: middle\">" . $properties [0] [2] . "</td>";
    echo "<td>";
    echo "<a href=\"ftp://" . $ftp_server . $ftp_directory . $key ["filename"] . "\" role=\"button\" title=\"Download " . $key ["filename"] . "\" class=\"btn btn-default pull-right\" target=\"_blank\" >
  	        <span class=\"glyphicon glyphicon-save\"></span>
  		  </a></td>";
    echo "</td>";
    echo "</tr>\n";
  }
  
  echo "    </tbody>
           </table>";
  echo $objUtil->addTablePager ( $counter );
  echo "  </div>";
  $objUtil->addTableJavascript ( $counter );
  $counter ++;
}
echo "  </div>
	   </div><br /><br />";

?>
