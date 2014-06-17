<?php
global $loggedUser, $loggedUserName,$baseURL,$objUser;
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
            <a class=\"navbar-brand\" href=\"".$baseURL."\">CDP browser</a>
          </div>
		  <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">";

// If we are logged in as administrator, we show the admin menu.

// Two links and a dropdown link
if ($loggedUser) {
	if ($objUser->isAdministrator($loggedUser)) {
		echo "     <ul class=\"nav navbar-nav\">
        	     <li class=\"dropdown\">
            	   <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Admin <b class=\"caret\"></b></a>
	               <ul class=\"dropdown-menu\">
    	             <li><a href=\"". $baseURL . "index.php?indexAction=admin_metadata\">Metadata</a></li>
		             <li><a href=\"". $baseURL . "index.php?indexAction=admin_users\">Users</a></li>
        	       </ul>
            	 </li>
           		</ul>";
	}
}

if ($loggedUser) {
	// Set the name of the user and the possibility to log out.
	echo "<p class=\"navbar-text navbar-right\">Signed in as ". $loggedUserName . "</p>";

	// We add a logout button
	echo "<a class=\"btn btn-default navbar-right navbar-btn\" href=\"".$baseURL."index.php?indexAction=logout\">Log out</a>";
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
if (!$loggedUser) {
  require_once 'login.php';
}
?>