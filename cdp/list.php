<?php
global $cdpLocation;

// We make some tabs, to see the different CDP releases

$ftp_server = "ftp.ster.kuleuven.be";

// set up a connection or die
$conn_id = ftp_connect($ftp_server);

if (!$conn_id) {
	$entryMessage= "Couldn't connect to $ftp_server";
} else {
	echo "<div class=\"container-fluid\">";
	echo " <ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">
	           <li class=\"active\"><a href=\"#allcdp\" data-toggle=\"tab\">All CDP files</a></li>";
//	           <li><a href=\"#cdp2\" data-toggle=\"tab\">CDP 2</a></li>
//	           <li><a href=\"#cdp1\" data-toggle=\"tab\">CDP 1</a></li>
	echo " </ul>";

	echo " <div id=\"my-tab-content\" class=\"tab-content\">
	        <div class=\"tab-pane active\" id=\"cdp3\">";
	
	// We make a table with all files from the ftp site
	echo "   <table class=\"table\">";
	echo "    <thead><th>Filename</th><th>Size</th><th>Action</th></thead>";
	echo "    <tbody>";
	
	$contents = ftp_nlist($conn_id, "/miri/CDP/");
	
	// output $contents
	print_r($contents);
	echo "    </tbody>
			 </table>";
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
   		   </div>";
	
}

?>