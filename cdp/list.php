<?php
global $cdpLocation, $objUtil;

// We make some tabs, to see the different CDP releases

$ftp_server = "ftp.ster.kuleuven.be";

// set up a connection or die
$conn_id = ftp_connect($ftp_server);

if (!$conn_id) {
	$entryMessage = "Couldn't connect to $ftp_server";
} else {
	echo "<div class=\"container-fluid\">";
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

	// try to login
	if (@ftp_login($conn_id, 'anonymous', '')) {
		if (is_array($children = @ftp_rawlist($conn_id, "/miri/CDP/"))) {
			$items = array();
		
			foreach ($children as $child) {
				$chunks = preg_split("/\s+/", $child);
				list($item['rights'], $item['number'], $item['user'], $item['group'], $item['size'], $item['month'], $item['day'], $item['time']) = $chunks;
				$item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file';
				array_splice($chunks, 0, 8);
				$items[implode(" ", $chunks)] = $item;
			}
		
	  foreach ($items as $key => $value) {
	  	if ($key != '.' && $key != '..') {
	        echo "<tr>";
	  		echo "<td>". $key . "</td>"; 
	  		echo "<td>" . $value['size'] . "</td>";
	  		echo "<td><span class=\"glyphicon glyphicon-download\"></span></td>";
	        echo "</tr>\n";
	  	}
	  }
	  }
	} else {
	  $entryMessage = "Couldn't connect to $ftp_server";
	}
	
	// Close the connection to the ftp server
	ftp_close($conn_id);

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
}

?>