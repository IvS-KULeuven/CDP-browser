<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";

echo "<h2>Deliver CDP files</h2>";

// We make the arrays with the delivered and not yet delivered files.
$items = $objCdp->getFilesFromFtpServer();

$notYetDelivered = Array();
$delivered = Array();

// Here, we make two arrays, one with the delivered files, and one with the not delivered files.
foreach ($items as $key => $value) {
  // Getting the date from the information
  $year = $value["time"];
  if (strpos($year, ":")) {
    $year = date("Y");
  }
  $date = $year . "-";
  $date .= date('m',strtotime($value["month"])) . "-";
  $date .= sprintf("%02d", $value["day"]);

  // Here we check if the file is already delivered.
  $cdpDelivery = $objCdp->getDelivery($key);

  if (sizeof($cdpDelivery) > 0) {
    $delivered[] = array($key, $date, $value['size']);
  } else {
    $notYetDelivered[] = array($key, $date, $value['size']);
  }
}



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

  foreach ($notYetDelivered as $key => $value) {
    echo "<tr>";
    echo "<td style=\"vertical-align: middle\">". $value[0] . "</td>&nbsp;";
  
    echo "<td style=\"vertical-align: middle\">" . $value[1] . "</td>";
    echo "<td style=\"vertical-align: middle\">" . $value[2] . "</td>";
    echo "<td style=\"vertical-align: middle\">";
    echo "<button type=\"button\" title=\"Deliver CDP file " . $value[0] . "\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#deliver" . str_replace('.', '_', $value[0]) . "\" >
  	        <span class=\"glyphicon glyphicon-pencil\"></span>
  		  </button></td>";
    echo "</tr>\n";
 }

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager();
echo "  </div>";

$objUtil->addTableJavascript();

// Tab with the already delivered CDP files
echo "  <div class=\"tab-pane\" id=\"alreadyDelivered\">";

echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
echo "    <thead>
           <th data-priority=\"critical\">Filename</th>
           <th data-priority=\"2\">Date</th>
           <th data-priority=\"4\">Size</th>
           <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th>
          </thead>";
echo "    <tbody>";

foreach ($delivered as $key => $value) {
  echo "<tr>";

  echo "<td style=\"vertical-align: middle\">". $value[0] . "&nbsp;";

  // Here we check if the file is already delivered.
  $cdpDelivery = $objCdp->getDelivery($value[0]);
  
  foreach($cdpDelivery as $number) {
    echo "<span class=\"pull-right badge alert-success\">CDP " . ($number['keyvalue']) . "</span>&nbsp;";
  }
  
  echo "</td>";
  
  echo "<td style=\"vertical-align: middle\">" . $value[1] . "</td>";
  echo "<td style=\"vertical-align: middle\">" . $value[2] . "</td>";
  echo "<td style=\"vertical-align: middle\">";
  echo "<button type=\"button\" title=\"Deliver CDP file " . $value[0] . "\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#deliver" . str_replace('.', '_', $value[0]) . "\" >
  		 <span class=\"glyphicon glyphicon-pencil\"></span>
  		</button></td>";
  
  echo "</tr>\n";
}

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager("1");

echo " </div>";

$objUtil->addTableJavascript("1");

echo "</div>";

// Setting the deliver CDP file modal form
$keywords = array_merge($delivered, $notYetDelivered);
$delivery = $objMetadata->getValidValues("DELIVERY");

foreach ($keywords as $key => $value) {
  echo "<div class=\"modal fade\" id=\"deliver". str_replace('.', '_', $value[0]) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Deliver " . $value[0] . "</h1>
                <div class=\"account-wall\">
                  <form role=\"form\" class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
       <div class=\"input-group\">
        <span class=\"input-group-addon\">Delivery</span>
        <select id=\"delivery\" name=\"delivery\" class=\"form-control\" required autofocus>";


echo "<option value=\"\"></option>";

foreach ($delivery as $key2) {
  echo "<option value=\"" . $key2['value'] . "\">" . $key2['value'] . "</option>";
}

echo "  </select>
       </div>";
echo "  <input type=\"hidden\" name=\"indexAction\" value=\"deliver_cdp_file\" />
        <input type=\"hidden\" name=\"filename\" value=\"". $value[0] ."\" />
        <input type=\"hidden\" name=\"size\" value=\"". $value[2] ."\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Deliver CDP file
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";
}
?>