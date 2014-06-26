<?php
  global $objUser, $baseURL, $objUtil, $loggedUser;
  
  // We create an array with all users
  $users = $objUser->getUsers();
  
  echo "<div class=\"container-fluid\">";
  echo "<h2>User administration</h2>";

  // Add a button to add a new user
  echo "<button type=\"button\" class=\"btn btn-success pull-right\" data-toggle=\"modal\" data-target=\"#addUser\">
  		 <span class=\"glyphicon glyphicon-plus\"></span>&nbsp;Add a new user
  		</button>";	
 
  echo "<br /><br />";

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
	  		echo "<td>" . ($value['role'] == 0?"Admin":"User") . "</td>";
	  		if ($value['role'] > 0) {
              echo "<td>
              		 <a title=\"Remove user " . $value["id"] . "\" style=\"color: black;text-decoration: none;\" href=\"". $baseURL . "index.php?indexAction=delete_user&id=". $value["id"] . "\" class=\"glyphicon glyphicon-trash \"></a>
              		 &nbsp;
              		 <a title=\"Make administrator\" style=\"color: black;text-decoration: none;\" href=\"". $baseURL . "index.php?indexAction=change_role&id=". $value["id"] . "\" class=\"glyphicon glyphicon-ok \"></a>
              		</td>";
	  		} else {
              echo "<td>";
              // It is not possible to change the role of yourself
              if ($value["id"] != $loggedUser) {
                echo " <a title=\"Remove administrator role\" style=\"color: black;text-decoration: none;\" href=\"". $baseURL . "index.php?indexAction=change_role&id=". $value["id"] . "\" class=\"glyphicon glyphicon-remove \"></a>";
              }
	  		  echo "</td>";
	  		}
	        echo "</tr>\n";
  }
  echo "    </tbody>
  		   </table>";
  echo $objUtil->addTablePager();

  echo "  </div>";
  
  // Setting the add new user modal form
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
  
  $objUtil->addTableJavascript();
?>