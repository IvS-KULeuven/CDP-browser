<?php
global $cdpLocation;

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
	echo "   <div class=\"columnSelectorWrapper\">
              <input id=\"colSelect1\" type=\"checkbox\" class=\"hidden\">
              <label class=\"columnSelectorButton\" for=\"colSelect1\">Column</label>
              <div id=\"columnSelector\" class=\"columnSelector\">
              </div>
	         </div>";
	
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
			  <tfoot>
			    <tr>
                 <th colspan=\"3\" class=\"ts-pager form-horizontal\">
                 <button type=\"button\" class=\"btn first\"><i class=\"icon-step-backward glyphicon glyphicon-step-backward\"></i>
                 </button>
                 <button type=\"button\" class=\"btn prev\"><i class=\"icon-arrow-left glyphicon glyphicon-backward\"></i>
                 </button>	<span class=\"pagedisplay\"></span> 
                 <!-- this can be any element, including an input -->
                 <button type=\"button\" class=\"btn next\"><i class=\"icon-arrow-right glyphicon glyphicon-forward\"></i>
                 </button>
                 <button type=\"button\" class=\"btn last\"><i class=\"icon-step-forward glyphicon glyphicon-step-forward\"></i>
                 </button>
                 <select class=\"pagesize input-mini\" title=\"Select page size\">
                     <option selected=\"selected\" value=\"10\">10</option>
                     <option value=\"20\">20</option>
                     <option value=\"30\">30</option>
                     <option value=\"40\">40</option>
                 </select>
                 <select class=\"pagenum input-mini\" title=\"Select page number\"></select>";
    echo "       </th>
                </tr>
               </tfoot>			
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
   		   </div><br /><br />";

   	// Make the table sorter, add the pager and add the column chooser
   	echo "<script type=\"text/javascript\">";
   	echo "$(\"table\").tablesorter({
            theme: \"bootstrap\",
            widthFixed: true,
            headerTemplate: '{content} {icon}',
            widgets: [\"uitheme\", \"columnSelector\", \"filter\", \"zebra\"],
            widgetOptions : {
              // target the column selector markup
              columnSelector_container : $('#columnSelector'),
              // column status, true = display, false = hide
              // disable = do not display on list
              columnSelector_columns : {
                0: 'disable' /* set to disabled; not allowed to unselect it */
              },
              // remember selected columns (requires $.tablesorter.storage)
              columnSelector_saveColumns: true,

              // container layout
              columnSelector_layout : '<label><input type=\"checkbox\">{name}</label>',
              // data attribute containing column name to use in the selector container
              columnSelector_name  : 'data-selector-name',

             /* Responsive Media Query settings */
             // enable/disable mediaquery breakpoints
             columnSelector_mediaquery: true,
             // toggle checkbox name
             columnSelector_mediaqueryName: 'Auto: ',
             // breakpoints checkbox initial setting
             columnSelector_mediaqueryState: true,
             // responsive table hides columns with priority 1-6 at these breakpoints
             // see http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/#Applyingapresetbreakpoint
             // *** set to false to disable ***
             columnSelector_breakpoints : [ '20em', '30em', '40em', '50em', '60em', '70em' ],
             // data attribute containing column priority
             // duplicates how jQuery mobile uses priorities:
             // http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/
             columnSelector_priority : 'data-priority'
            }
          })
          .tablesorterPager({
            container: $(\".ts-pager\"),
            cssGoto: \".pagenum\",
            output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
          });";
   			
   	echo "</script>";
   	
}

?>