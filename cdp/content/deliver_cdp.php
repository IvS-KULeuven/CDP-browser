<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";

echo "<h2>Deliver CDP files</h2>";

// We make a tab for the delivered files and for the files that are not delivered yet. 
echo " <ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">";

echo "<li class=\"active\"><a href=\"#toDeliver\" data-toggle=\"tab\">To deliver</a></li>";
echo "<li><a href=\"#alreadyDelivered\" data-toggle=\"tab\">Already delivered</a></li>";

echo "</ul>";

// We make a table with all files from the ftp site
echo " <div id=\"my-tab-content\" class=\"tab-content\">";
echo "  <div class=\"tab-pane active\" id=\"toDeliver\">";
echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
echo "    <thead>
           <th data-priority=\"critical\">Filename</th>
           <th data-priority=\"2\">Date</th>
           <th data-priority=\"4\">Size</th>
           <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th>
          </thead>";
echo "    <tbody>";

$items = $objCdp->getFilesFromFtpServer();

foreach ($items as $key => $value) {
  // Getting the date from the information
  $year = $value["time"];
  if (strpos($year, ":")) {
    $year = date("Y");
  }
  $date = $year . "-";
  $date .= date('m',strtotime($value["month"])) . "-";
  $date .= sprintf("%02d", $value["day"]);

  echo "<tr>";
  echo "<td style=\"vertical-align: middle\">". $key . "&nbsp;";
  
  // Here we check if the file is already delivered. If so, we add a badge.
  $cdpDelivery = $objCdp->getDelivery($key);
  
  if (sizeof($cdpDelivery) > 0) {
    foreach($cdpDelivery as $number) {
      echo "<span class=\"pull-right badge alert-success\">CDP " . ($number['delivery']) . "</span>&nbsp;";
    }
  }

  echo "<td style=\"vertical-align: middle\">" . $date . "</td>";
  echo "<td style=\"vertical-align: middle\">" . $value['size'] . "</td>";
  echo "<td style=\"vertical-align: middle\">";
//          <a title=\"Remove keyword " . $key . "\" style=\"color: black;text-decoration: none;\" href=\"". $baseURL . "index.php?indexAction=delete_keygfword&keyword=". $key. "\" class=\"glyphicon glyphicon-remove \"></a>
//          &nbsp;
  echo " <a title=\"Deliver CDP file " . $key . "\" style=\"color: black;text-decoration: none;\" href=\"". $baseURL . "index.php?indexAction=deliver_file&filename=". $key . "\" class=\"glyphicon glyphicon-pencil \"></a>
        </td>";
  echo "</tr>\n";
}

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager();
echo "  </div>";
echo "  <br /><br />";

$objUtil->addTableJavascript();
echo " </div>";

// Tab with the already delivered CDP files
echo "  <div class=\"tab-pane\" id=\"alreadyDelivered\">";

echo "Already delivered";
echo "</div>";

?>