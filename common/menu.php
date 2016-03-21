<?php
global $loggedUser, $loggedUserName, $baseURL, $objUser;
// We create the navbar for the menu and set the title.
echo "<nav class=\"navbar navbar-default\" role=\"navigation\">
        <div class=\"container-fluid\">
          <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">
              <span class=\"sr-only\">Toggle navigation</span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"" . $baseURL . "\">CDP browser " . $version . "</a>
          </div>
		  <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">";

// The menu when not logged in.
echo "     <ul class=\"nav navbar-nav\">
        	     <li class=\"dropdown\">
            	   <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">View <b class=\"caret\"></b></a>
	               <ul class=\"dropdown-menu\">
    	             <li><a href=\"" . $baseURL . "index.php\">All CDP files</a></li>
        	       </ul>
            	 </li>
           		</ul>";

// The extra menu's for the users.
if ($loggedUser) {
  echo "     <ul class=\"nav navbar-nav\">
             <li class=\"dropdown\">
               <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Download all<b class=\"caret\"></b></a>
	           <ul class=\"dropdown-menu\">
    	         <li><a href=\"" . $baseURL . "miri_cdp_full.bash.php\" target=\"_blank\" rel=\"external\">Full CDP</a></li>
               <li><a href=\"" . $baseURL . "miri_cdp_dhas.bash.php\" target=\"_blank\" rel=\"external\">DHAS</a></li>
    	         <li><a href=\"" . $baseURL . "miri_cdp_delivery.bash.php\" target=\"_blank\" rel=\"external\">By delivery</a></li>
    	         <li><a href=\"" . $baseURL . "miri_cdp_pipeline.bash.php\" target=\"_blank\" rel=\"external\">By pipeline module</a></li>
    	       </ul>
             </li>
           </ul>";

  // If we are logged in as administrator, we show the admin menu.
  if ($objUser->isAdministrator ( $loggedUser )) {
  echo "     <ul class=\"nav navbar-nav\">
        	     <li class=\"dropdown\">
            	   <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">CDP files <b class=\"caret\"></b></a>
	               <ul class=\"dropdown-menu\">
    	             <li><a href=\"" . $baseURL . "index.php?indexAction=deliver_cdp\">Deliver</a></li>
    	             <li><a href=\"" . $baseURL . "index.php?indexAction=import_csv_file\">Deliver using CSV file</a></li>
    	           </ul>
            	 </li>
             </ul>";

    echo "     <ul class=\"nav navbar-nav\">
        	     <li class=\"dropdown\">
            	   <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Admin <b class=\"caret\"></b></a>
	               <ul class=\"dropdown-menu\">
    	             <li><a href=\"" . $baseURL . "index.php?indexAction=admin_metadata\">Metadata</a></li>
		             <li><a href=\"" . $baseURL . "index.php?indexAction=admin_users\">Users</a></li>
        	       </ul>
            	 </li>
           		</ul>";
  }
}

if ($loggedUser) {
  // Set the name of the user and the possibility to log out.
  echo "<p class=\"navbar-text navbar-right\">Signed in as " . $loggedUserName . "</p>";

  // We add a logout button
  echo "<a class=\"btn btn-default navbar-right navbar-btn\" href=\"" . $baseURL . "index.php?indexAction=logout\">Log out</a>";
} else {
  // Set the log in button
  echo "	    <ul class=\"nav navbar-nav navbar-right\">
                 <button type=\"button\" class=\"btn btn-default navbar-btn\" data-toggle=\"modal\" data-target=\"#login\">Log in</button>
                </ul>";
}

// Closing the menu
echo "	  </div>
        </div>
      </nav>";

// If not logged in, make the login form
if (! $loggedUser) {
  require_once 'login.php';
}
?>
