<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";

echo "<h2>List of CDP files</h2>";

// Add the button for the columns
$objUtil->addTableColumSelector();

// We make a table with all files from the ftp site
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
//[time] => 2013 [day] => 3 [month] => Sep
//[time] => 09:28 [day] => 4 [month] => Mar

  // Getting the date from the information
  $year = $value["time"];
  if (strpos($year, ":")) {
    $year = date("Y");
  }
  $date = $year . "-";
  $date .= date('m',strtotime($value["month"])) . "-";
  $date .= sprintf("%02d", $value["day"]);

  echo "<tr>";
  echo "<td>". $key . "&nbsp;<span class=\"pull-right badge\">CDP 1</span>&nbsp;<span class=\"pull-right badge alert-success\">CDP 2</span>&nbsp;</td>"; 
  echo "<td>" . $date . "</td>";
  echo "<td>" . $value['size'] . "</td>";
  echo "<td><span class=\"glyphicon glyphicon-download\"></span></td>";
  echo "</tr>\n";
}

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager();
echo "  </div>";
echo "  <br /><br />";

$objUtil->addTableJavascript();
?>