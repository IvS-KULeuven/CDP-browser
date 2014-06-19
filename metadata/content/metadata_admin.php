<?php
  global $objDatabase, $objMetadata, $objUtil;

  // We display a table with all known metadata keywords and possible values
  echo "<div class=\"container-fluid\">";
  
  echo "<h2>Metadata administration</h2>";

  // Add the button for the columns
  $objUtil->addTableColumSelector();
  
  // Add a button to add a new keyword
  echo "<button type=\"button\" class=\"btn btn-success pull-right\" data-toggle=\"modal\" data-target=\"#addMetadataKeyword\">
  		 <span class=\"glyphicon glyphicon-plus\"></span>&nbsp;Add a new keyword
  		</button>";
  
  // We make a table with all cdp keywords
  echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
  echo "    <thead>
             <th data-priority=\"critical\">Keyword</th>
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
  
  echo "</div>";
  
  echo "<br /><br />";
  
  // Setting the add new metadata keyword modal form
  echo "<div class=\"modal fade\" id=\"addMetadataKeyword\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Add a new keyword</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Metadata keyword</span>
                      <input type=\"text\" name=\"keyword\" class=\"form-control\" placeholder=\"keyword\" required autofocus>
                    </div>
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Type</span>
                      <select name=\"type\" class=\"form-control\">
                       <option value=\"Integer\">Integer</option>
                       <option value=\"String\">String</option>
                       <option value=\"List\">List</option>
                      </select>
                    </div>
                      <div class=\"input-group\">
                      <span class=\"input-group-addon\">Default value</span>
                      <input type=\"text\" name=\"value\" class=\"form-control\" placeholder=\"Value\">
                    </div>
                    <input type=\"hidden\" name=\"indexAction\" value=\"add_metadata_keyword\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Add keyword
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>
  	  </body>";
  
  $objUtil->addTableJavascript();
?>