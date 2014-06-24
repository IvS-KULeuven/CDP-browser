<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";

echo "<h2>List of CDP files</h2>";

// Add the button for the columns
$objUtil->addTableColumSelector();

// We make a table with all files from the ftp site
echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
echo "    <thead><th data-priority=\"critical\">Filename</th><th data-priority=\"2\">Size</th><th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th></thead>";
echo "    <tbody>";

$items = $objCdp->getFilesFromFtpServer();

foreach ($items as $key => $value) {
  echo "<tr>";
  echo "<td>". $key . "&nbsp;<span class=\"pull-right badge\">CDP 1</span>&nbsp;<span class=\"pull-right badge alert-success\">CDP 2</span>&nbsp;</td>"; 
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