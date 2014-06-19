<?php
  global $objDatabase, $objMetadata, $objUtil;

  // We display a table with all known metadata keywords and possible values
  echo "<div class=\"container-fluid\">";
  
  // Add the button for the columns
  $objUtil->addTableColumSelector();
  
  
  
  
  // We make a table with all cdp keywords
  echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
  echo "    <thead>
             <th data-priority=\"critical\">Metadata name</th>
             <th data-priority=\"2\">Type</th>
             <th data-priority=\"2\">Possible values</th>
      <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th>
            </thead>";
  echo "    <tbody>";
  
  $metadata = $objMetadata->getKeys();
  
  foreach ($metadata as $key => $value) {
    $validValues = $objMetadata->getValidValues($value[0]);
    
    echo "<tr>";
    echo "<td>" . $value[0] . "</td>";
    echo "<td>" . $objMetadata->getType($value[0]) . "</td>";
    
    if (sizeof($validValues) > 1) {
      echo "<td>
             <div class=\"btn-group\">
             <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">" . $validValues[0][2] . "<span class=\"caret\"></span></button>";
      echo " <ul class=\"dropdown-menu\">";
    
      foreach ($validValues as $valid) {
        echo "   <li>" . $valid[2] . "</li>";
      }
      echo "</ul></div></td>";
    } else {
      echo "<td>" . $validValues[0][2] . "</td>";
    }
    
    echo "<td><span class=\"glyphicon glyphicon-download\"></span></td>";
    echo "</tr>\n";
  }

  echo "    </tbody>
			 </table>";
  
  echo $objUtil->addTablePager();
  
  $objUtil->addTableJavascript();
  
  echo "</div>";
  
  echo "<br /><br />";
  
//   // We also print the possible values for DETECTOR
//   print "<br />Possible DETECTOR values : <br />";
//   print_r();
?>