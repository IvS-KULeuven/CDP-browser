<?php
global $objUtil;

echo "<div class=\"container-fluid\">";
	
echo "<h2>List of CDP files</h2>";
	
// We make some tabs, to see the different CDP releases
echo " <ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">
         <li class=\"active\"><a href=\"#allcdp\" data-toggle=\"tab\">All CDP files</a></li>";
//	           <li><a href=\"#cdp2\" data-toggle=\"tab\">CDP 2</a></li>
//	           <li><a href=\"#cdp1\" data-toggle=\"tab\">CDP 1</a></li>
echo " </ul>";

// Add the button for the columns
$objUtil->addTableColumSelector();
	
echo " <div id=\"my-tab-content\" class=\"tab-content\">
        <div class=\"tab-pane active\" id=\"cdp3\">";

// We make a table with all files from the ftp site
echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
echo "    <thead><th data-priority=\"critical\">Filename</th><th data-priority=\"2\">Size</th><th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th></thead>";
echo "    <tbody>";

$items = $objCdp->getFilesFromFtpServer();
	
foreach ($items as $key => $value) {
  if ($key != '.' && $key != '..') {
    echo "<tr>";
    echo "<td>". $key . "</td>"; 
  	echo "<td>" . $value['size'] . "</td>";
  	echo "<td><span class=\"glyphicon glyphicon-download\"></span></td>";
    echo "</tr>\n";
  }
}
	
echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager();
echo "  </div>";
//           <div class=\"tab-pane\" id=\"cdp2\">
//             <h1>CDP 2 release</h1>
//             <p>The CDP 2 release.</p>
//           </div>
//           <div class=\"tab-pane\" id=\"cdp1\">
//             <h1>CDP 1 release</h1>
//             <p>The CDP 1 release.</p>
//           </div>
echo "  </div>
	   </div><br /><br />";

$objUtil->addTableJavascript();

?>