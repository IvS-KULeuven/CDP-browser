<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";

echo "<h2>Deliver CDP files</h2>";

// We make the arrays with the delivered and not yet delivered files.
$items = $objCdp->getFilesFromFtpServer ();

$notYetDelivered = Array ();
$delivered = Array ();
$deliveredFiles = Array ();

// Here, we make two arrays, one with the delivered files, and one with the not delivered files.
foreach ( $items as $key => $value ) {
  // Getting the date from the information
  $year = $value ["time"];
  if (strpos ( $year, ":" )) {
    $year = date ( "Y" );
  }
  $date = $year . "-";
  $date .= date ( 'm', strtotime ( $value ["month"] ) ) . "-";
  $date .= sprintf ( "%02d", $value ["day"] );
  
  // Here we check if the file is already delivered.
  $cdpDelivery = $objCdp->getDelivery ( $key );
  
  if (sizeof ( $cdpDelivery ) > 0) {
    $delivered [] = array (
        $key,
        $date,
        $value ['size'] 
    );
    $deliveredFiles [] = $key;
  } else {
    $notYetDelivered [] = array (
        $key,
        $date,
        $value ['size'] 
    );
  }
}

// We also check if there are files which are not longer on the ftp server, but are already delivered.
$deliveredDatabase = $objCdp->getDeliveredFiles ();
foreach ( $deliveredDatabase as $filename ) {
  if (! in_array ( $filename [0], $deliveredFiles )) {
    $date = $objCdp->getProperty ( $filename [0], 'UPLOAD_DATE' );
    $dateObj = $date [0];
    $fileSize = $objCdp->getProperty ( $filename [0], 'size' );
    $fileSizeObj = $fileSize [0];
    $delivered [] = array (
        $filename [0],
        $dateObj ['keyvalue'],
        $fileSizeObj ['keyvalue'] 
    );
  }
}

// We make a button to add CDP files using a CSV file
echo "<form action=\"" . $baseURL . "index.php\" method=\"post\">
       <input type=\"hidden\" name=\"indexAction\" value=\"import_csv_file\" />
       <button type=\"submit\" class=\"btn btn-success pull-right\">
  	    <span class=\"glyphicon glyphicon-plus\"></span>&nbsp;Deliver using CSV file
  	   </button>
      </form>";

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

foreach ( $notYetDelivered as $key => $value ) {
  echo "<tr>";
  echo "<td style=\"vertical-align: middle\">" . $value [0] . "</td>&nbsp;";
  
  echo "<td style=\"vertical-align: middle\">" . $value [1] . "</td>";
  echo "<td style=\"vertical-align: middle\">" . $value [2] . "</td>";
  echo "<td style=\"vertical-align: middle\">";
  echo "<button type=\"button\" title=\"Deliver CDP file " . $value [0] . "\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#deliver" . str_replace ( ' ', '_', str_replace ( '.', '_', $value [0] )) . "\" >
  	        <span class=\"glyphicon glyphicon-pencil\"></span>
  		  </button></td>";
  echo "</tr>\n";
}

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager ( "0" );
echo "  </div>";
echo "<br /><br />";
$objUtil->addTableJavascript ( "0" );

// Tab with the already delivered CDP files
echo "  <div class=\"tab-pane\" id=\"alreadyDelivered\">";

echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
echo "    <thead>
           <th data-priority=\"critical\">Filename</th>
           <th data-priority=\"2\">Delivery Date</th>
           <th data-priority=\"4\">Size</th>
           <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th>
          </thead>";
echo "    <tbody>";

foreach ( $delivered as $key => $value ) {
  echo "<tr>";
  
  echo "<td style=\"vertical-align: middle\">" . $value [0] . "&nbsp;";
  
  // Here we check if the file is already delivered.
  $cdpDelivery = $objCdp->getDelivery ( $value [0] );
  foreach ( $cdpDelivery as $number ) {
    echo "<span class=\"pull-right badge alert-success\">CDP " . ($number ['keyvalue']) . "</span>&nbsp;";
  }
  
  echo "</td>";
  
  $date = $objCdp->getProperty ( $value [0], "UPLOAD_DATE" );
  
  echo "<td style=\"vertical-align: middle\">" . $date [0] ['keyvalue'] . "</td>";
  echo "<td style=\"vertical-align: middle\">" . $value [2] . "</td>";
  echo "<td style=\"vertical-align: middle\">";
  echo "<button type=\"button\" title=\"Edit CDP file " . $value [0] . "\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#deliver" . str_replace( ' ', '_', str_replace ( '.', '_', $value [0] )) . "\" >
  		 <span class=\"glyphicon glyphicon-pencil\"></span>
        </button>
        <button type=\"button\" title=\"Remove " . $value [0] . " from list of delivered CDP files\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#undeliver" . str_replace( ' ', '_', str_replace ( '.', '_', $value [0] )) . "\" >
         <span class=\"glyphicon glyphicon-remove\"></span>
 		</button>";
  
  echo "</tr>\n";
}

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager ( "1" );

echo " </div>";
echo "<br /><br />";

$objUtil->addTableJavascript ( "1" );

echo "</div>";

$externalKeywords = $objMetadata->getExternalKeywords ();

// Setting the deliver CDP file modal form
$keywords = array_merge ( $delivered, $notYetDelivered );
$delivery = $objMetadata->getValidValues ( "DELIVERY" );

foreach ( $keywords as $key => $value ) {
  if ($objCdp->isDelivered ( $value [0] )) {
    $update = true;
  } else {
    $update = false;
  }
  echo "<div class=\"modal fade\" id=\"deliver" . str_replace ( '.', '_', $value [0] ) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">";
  if ($update) {
    echo "Update ";
  } else {
    echo "Deliver ";
  }
  echo $value [0] . "</h1>
                <div class=\"account-wall\">
                  <form role=\"form\" class=\"form-signin\" action=\"" . $baseURL . "index.php\" method=\"post\">
       <div class=\"input-group\">
        <span class=\"input-group-addon required\">DELIVERY</span>";
  
  $type = $objMetadata->getType ( "DELIVERY" );
  $del = "";
  if ($update) {
    $del = $objCdp->getDelivery ( $value [0] );
  }
  if ($type == "LIST") {
    $validValues = $objMetadata->getValidValues ( $value [0] );
    echo "<select id=\"DELIVERY\" name=\"DELIVERY\" class=\"form-control\" required autofocus>
          <option value=\"\"></option>";
    
    foreach ( $delivery as $key2 ) {
      $del0 = $del [0];
      if ($key2 ['value'] == $del0 [2]) {
        $selected = " selected";
      } else {
        $selected = "";
      }
      echo "<option " . $selected . " value=\"" . $key2 ['value'] . "\">" . $key2 ['value'] . "</option>";
    }
  } else if ($type == "MULTILIST") {
    $validValues = $objMetadata->getValidValues ( $value [0] );
    echo "<select id=\"DELIVERY\" name=\"DELIVERY[]\" class=\"form-control\" required autofocus multiple=\"multiple\">
        <option value=\"\"></option>";
    
    foreach ( $delivery as $key2 ) {
      $selected = "";
      if ($update) {
        if (sizeof ( $del > 1 )) {
          foreach ( $del as $d ) {
            if ($d [2] == $key2 ['value']) {
              $selected = " selected";
            }
          }
        } else {
          if ($key2 ['value'] == $del [0] [2]) {
            $selected = " selected";
          }
        }
      }
      echo "<option" . $selected . " value=\"" . $key2 ['value'] . "\">" . $key2 ['value'] . "</option>";
    }
  }
  
  echo "  </select>
         </div>";
  
  // Loop over al the external Keywords
  foreach ( $externalKeywords as $key2 => $value2 ) {
    if ($value2 [0] != "DELIVERY") {
      $type = $objMetadata->getType ( $value2 [0] );
      $required = $objMetadata->isRequired ( $value2 [0] );
      if ($required) {
        $req = " required";
      } else {
        $req = "";
      }
      
      $del = "";
      if ($update) {
        $del = $objCdp->getProperty ( $value [0], str_replace ( ' ', '_', $value2 [0] ) );
      }
      
      echo "<div class=\"input-group\">
           <span class=\"input-group-addon $req\">" . $value2 [0] . "</span>";
      
      if ($type == "LIST") {
        $validValues = $objMetadata->getValidValues ( $value2 [0] );
        echo "<select id=\"" . $value2 [0] . "\" name=\"" . $value2 [0] . "\" class=\"form-control\" $req autofocus>
               <option value=\"\"></option>";
        
        foreach ( $validValues as $key3 ) {
          $selected = "";
          if ($update) {
            if ($key3 ['value'] == $del [0] [2]) {
              $selected = " selected";
            }
          }
          echo "<option" . $selected . " value=\"" . $key3 ['value'] . "\">" . $key3 ['value'] . "</option>";
        }
        echo "</select>";
      } else if ($type == "MULTILIST") {
        $validValues = $objMetadata->getValidValues ( $value2 [0] );
        echo "<select id=\"" . $value2 [0] . "\" name=\"" . $value2 [0] . "[]\" class=\"form-control\" $req autofocus multiple=\"multiple\">
               <option value=\"\"></option>";
        
        foreach ( $validValues as $key3 ) {
          $selected = "";
          if ($update) {
            if (sizeof ( $del > 1 )) {
              foreach ( $del as $d ) {
                if ($d [2] == $key3 ['value']) {
                  $selected = " selected";
                }
              }
            } else {
              if ($key3 ['value'] == $del [0] [2]) {
                $selected = " selected";
              }
            }
          }
          echo "<option" . $selected . " value=\"" . $key3 ['value'] . "\">" . $key3 ['value'] . "</option>";
        }
        echo "</select>";
      } else {
        $validValues = $objMetadata->getValidValues ( $value2 [0] );
        echo " <input type=\"text\" name=\"" . $value2 [0] . "\" class=\"form-control\" placeholder=\"" . $validValues [0] ["value"] . "\" value=\"";
        if ($update) {
          if (sizeof ( $del ) > 0) {
            echo $del [0] [2];
          }
        }
        echo "\" $req>";
      }
      echo "</div>";
    }
  }
  
  echo "  <input type=\"hidden\" name=\"indexAction\" value=\"deliver_cdp_file\" />
        <input type=\"hidden\" name=\"filename\" value=\"" . $value [0] . "\" />
        <input type=\"hidden\" name=\"size\" value=\"" . $value [2] . "\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Deliver CDP file
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";
  
  // Make the undeliver CDP modal
  if ($update) {
    echo "<div class=\"modal fade\" id=\"undeliver" . str_replace( ' ', '_', str_replace ( '.', '_', $value [0] )) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Remove $value[0] from list of delivered CDP files?</h1>
                <div class=\"account-wall\">
                  <form role=\"form\" class=\"form-signin\" action=\"" . $baseURL . "index.php\" method=\"post\">
                   <input type=\"hidden\" name=\"indexAction\" value=\"undeliver_cdp_file\" />
                   <input type=\"hidden\" name=\"cdpfile\" value=\"" . $value [0] . "\" />
                   <button type=\"submit\" title=\"Remove" . $value [0] . "!\" class=\"btn btn-lg btn-block btn-danger\">Remove!
                   </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>";
  }
}
?>
