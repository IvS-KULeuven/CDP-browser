<?php
global $objUtil, $objCdp;

echo "<div class=\"container-fluid\">";

echo "<h2>Undeliver CDP files</h2>";

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

// The already delivered CDP files
echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
echo "    <thead>
           <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\" data-priority=\"critical\">Undeliver</th>
           <th data-priority=\"critical\">Filename</th>
           <th data-priority=\"2\">Delivery Date</th>
           <th data-priority=\"4\">Size</th>
          </thead>";
echo "    <tbody>";

foreach ( $delivered as $key => $value ) {
  echo "<tr>";

  echo '<td><input type="checkbox" name="undeliver" value="' . $value [0] . '">';
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

  echo "</tr>\n";
}

echo "    </tbody>
		 </table>";
echo $objUtil->addTablePager ( "1" );

echo " </div>";
echo "<br /><br />";

$objUtil->addTableJavascript ( "1" );

?>
