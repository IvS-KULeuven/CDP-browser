<?php
  global $objUser, $baseURL;
  
  // We create an array with all users
  $users = $objUser->getUsers();
  
  echo "<div class=\"container-fluid\">";
  // Add the button for the columns
  echo "   <div class=\"columnSelectorWrapper\">
              <input id=\"colSelect1\" type=\"checkbox\" class=\"hidden\">
              <label class=\"columnSelectorButton\" for=\"colSelect1\">Column</label>
              <div id=\"columnSelector\" class=\"columnSelector\">
              </div>
	         </div>";
  
  // Add a button to add a new user
  echo "<button type=\"button\" class=\"btn btn-success pull-right\" data-toggle=\"modal\" data-target=\"#addUser\">
  		 <span class=\"glyphicon glyphicon-plus\"></span>&nbsp;Add a new user
  		</button>";	
  
  // We make a table with all files from the ftp site
  echo "   <table class=\"table table-striped table-hover tablesorter custom-popup\">";
  echo "    <thead>
  		     <th data-priority=\"critical\">id</th>
  		     <th data-priority=\"5\">First name</th>
  		     <th data-priority=\"2\">Name</th>
  		     <th data-priority=\"3\">Email</th>
  		     <th data-priority=\"4\">Role</th>
  		     <th class=\"filter-false columnSelector-disable\" data-sorter=\"false\">Action</th>
  		    </thead>";
  echo "    <tbody>";
  
  foreach ($users as $key => $value) {
	        echo "<tr>";
	  		echo "<td>". $value["id"] . "</td>"; 
	  		echo "<td>" . $value['firstname'] . "</td>";
	  		echo "<td>" . $value['name'] . "</td>";
	  		echo "<td>" . $value['email'] . "</td>";
	  		echo "<td>" . $value['role'] . "</td>";
	  		echo "<td><span class=\"glyphicon glyphicon-download\"></span></td>";
	        echo "</tr>\n";
  }
  echo "    </tbody>
			  <tfoot>
			    <tr>
                 <th colspan=\"6\" class=\"ts-pager form-horizontal\">
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
  
  // Setting the log in modal form
  echo "<div class=\"modal fade\" id=\"addUser\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Add a new user</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <input type=\"text\" name=\"id\" class=\"form-control\" placeholder=\"id\" required autofocus>
                    <input type=\"text\" name=\"firstname\" class=\"form-control\" placeholder=\"First Name\" required>
                    <input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"Name\" required>
                    <input type=\"email\" name=\"email\" class=\"form-control\" placeholder=\"email address\" required>
               		<input type=\"password\" name=\"passwd\" class=\"form-control\" placeholder=\"Password\" required>
                    <input type=\"hidden\" name=\"indexAction\" value=\"add_user\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Add user
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>
  	  </body>";
  
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
  
?>