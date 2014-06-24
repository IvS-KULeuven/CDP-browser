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
             <th data-priority=\"4\">Location</th>
             <th data-priority=\"2\">Type</th>
             <th data-priority=\"2\">Possible values</th>
      <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th>
            </thead>";
  echo "    <tbody>";
  
  $metadata = $objMetadata->getKeys();

  foreach ($metadata as $key => $value) {
    $validValues = $objMetadata->getValidValues($value[0]);

    echo "<tr>";
    echo "<td style=\"vertical-align: middle\">" . $value[0] . "</td>";
    echo "<td style=\"vertical-align: middle\">" . $objMetadata->getLocation($value[0]) . 
        "<button type=\"button\" title=\"Edit location\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#changeLocationMetadata" . str_replace(' ', '_', $value[0]) . "\" >
  		 <span class=\"glyphicon glyphicon-pencil\"></span>
  		</button></td>";
    echo "<td style=\"vertical-align: middle\">" . $objMetadata->getType($value[0]) . 
         "<button type=\"button\" title=\"Edit type\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#changeTypeMetadata" . str_replace(' ', '_', $value[0]) . "\" >
  		 <span class=\"glyphicon glyphicon-pencil\"></span>
  		</button></td>";
    
    if (sizeof($validValues) > 1) {
      echo "<td style=\"vertical-align: middle\">
             <div class=\"btn-group\">
             <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\">" . $validValues[0]["value"] . "<span class=\"caret\"></span></button>";
      echo " <ul class=\"dropdown-menu\">";
    
      foreach ($validValues as $valid) {
        echo "   <li>" . $valid["value"] . "</li>";
      }
      echo "</ul></div>";
    } else {
      echo "<td style=\"vertical-align: middle;\">" . $validValues[0]["value"];
    }
    echo "<button type=\"button\" title=\"Change possible value\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#changeMetadataValue" . str_replace(' ', '_', $value[0]) . "\" >
  		 <span class=\"glyphicon glyphicon-pencil\"></span>
  		</button>";
    
     if ($objMetadata->getType($value[0]) == "LIST") {
       if (sizeof($validValues) > 1) {
         echo "<button type=\"button\" title=\"Delete possible value\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#deleteValue" . str_replace(' ', '_', $value[0]) . "\" >
                <span class=\"glyphicon glyphicon-minus\"></span>
               </button>";
       }
       echo "<button type=\"button\" title=\"Add possible value\" class=\"btn btn-default pull-right\" data-toggle=\"modal\" data-target=\"#addValue" . str_replace(' ', '_', $value[0]) . "\" >
              <span class=\"glyphicon glyphicon-plus\"></span>
             </button>";
     }
    
    echo "</td>";
    echo "<td style=\"vertical-align: middle\"><a title=\"Remove keyword " . $value[0] . "\" style=\"color: black;text-decoration: none;\" href=\"". $baseURL . "index.php?indexAction=delete_keyword&keyword=". $value[0] . "\" class=\"glyphicon glyphicon-trash \"></a></td>";
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
                      <span class=\"input-group-addon\">Location</span>
                      <select name=\"location\" class=\"form-control\">
                       <option value=\"FITS\">FITS</option>
                       <option value=\"External\">External</option>
                      </select>
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
        </div>";
  
  foreach ($metadata as $key => $value) {
    // Setting the change metadata value modal form
    $validValues = $objMetadata->getValidValues($value[0]);
    
    echo "<div class=\"modal fade\" id=\"changeMetadataValue" . str_replace(' ', '_', $value[0]) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Change possible value for keyword " . $value[0] . "</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Current value</span>";
    if ($objMetadata->getType($value[0]) == "LIST") {
      echo "           <select name=\"currentValue\" class=\"form-control\">";

      foreach ($validValues as $valid) {
        echo "          <option value=\"" . $valid[2] . "\">" . $valid[2] . "</option>";
      }
      echo "           </select>";
    } else {
      echo "           <input type=\"text\" name=\"currentValue\" class=\"form-control\" placeholder=\"Value\" value=\"". $validValues[0][2] . "\" disabled>";
      echo "           <input type=\"hidden\" name=\"currentValue\" value=\"" . $validValues[0][2] . "\" />";
    }
    echo "          </div>
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">  New value  </span>
                      <input type=\"text\" name=\"newValue\" class=\"form-control\" placeholder=\"Value\">
                    </div>
                    <input type=\"hidden\" name=\"keyword\" value=\"" . $value[0] . "\" />
                    <input type=\"hidden\" name=\"indexAction\" value=\"change_metadata_value\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Change value
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";

    // Setting the change metadata type modal form
    echo "<div class=\"modal fade\" id=\"changeTypeMetadata" . str_replace(' ', '_', $value[0]) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Change type for keyword " . $value[0] . "</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Type</span>
                      <select name=\"type\" class=\"form-control\">
                       <option value=\"Integer\"" . ($objMetadata->getType($value[0]) == "INTEGER"?" selected":"") . ">Integer</option>
                       <option value=\"String\"" . ($objMetadata->getType($value[0]) == "STRING"?" selected":"") . ">String</option>
                       <option value=\"List\"" . ($objMetadata->getType($value[0]) == "LIST"?" selected":"") . ">List</option>
                      </select>
                    </div>
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Default value</span>
                      <input type=\"text\" name=\"value\" class=\"form-control\" placeholder=\"Value\">
                    </div>
                    <input type=\"hidden\" name=\"keyword\" value=\"" . $value[0] . "\" />
                    <input type=\"hidden\" name=\"indexAction\" value=\"change_metadata_type\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Change type
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";

    // Setting the change location type modal form
    echo "<div class=\"modal fade\" id=\"changeLocationMetadata" . str_replace(' ', '_', $value[0]) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Change location for keyword " . $value[0] . "</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Location</span>
                      <select name=\"location\" class=\"form-control\">
                       <option value=\"FITS\"" . ($objMetadata->getLocation($value[0]) == "FITS"?" selected":"") . ">FITS</option>
                       <option value=\"External\"" . ($objMetadata->getLocation($value[0]) == "External"?" selected":"") . ">External</option>
                      </select>
                    </div>
                    <input type=\"hidden\" name=\"keyword\" value=\"" . $value[0] . "\" />
                    <input type=\"hidden\" name=\"indexAction\" value=\"change_metadata_location\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Change location
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";
    
    // Setting the add possible value modal form
    echo "<div class=\"modal fade\" id=\"addValue" . str_replace(' ', '_', $value[0]) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Add a possible value for keyword " . $value[0] . "</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">New value</span>
                      <input type=\"text\" name=\"value\" class=\"form-control\" placeholder=\"Value\">
                    </div>
                    <input type=\"hidden\" name=\"keyword\" value=\"" . $value[0] . "\" />
                    <input type=\"hidden\" name=\"indexAction\" value=\"add_possible_metadata_value\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Add value
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";

    // Setting the delete possible value modal form
    echo "<div class=\"modal fade\" id=\"deleteValue" . str_replace(' ', '_', $value[0]) . "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Delete a possible value for keyword " . $value[0] . "</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <div class=\"input-group\">
                      <span class=\"input-group-addon\">Value to delete</span>";
    echo "           <select name=\"currentValue\" class=\"form-control\">";

    foreach ($validValues as $valid) {
      echo "          <option value=\"" . $valid[2] . "\">" . $valid[2] . "</option>";
    }
    echo "           </select>";
    echo "          </div>
                    <input type=\"hidden\" name=\"keyword\" value=\"" . $value[0] . "\" />
                    <input type=\"hidden\" name=\"indexAction\" value=\"delete_possible_metadata_value\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Delete value
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";
  }

  echo "</body>";
  $objUtil->addTableJavascript();
?>
