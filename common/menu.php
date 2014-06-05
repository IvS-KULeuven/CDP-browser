<?php
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
            <a class=\"navbar-brand\" href=\"#\">CDP browser</a>
          </div>
		  <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">";

// Two links and a dropdown link
// echo "     <ul class=\"nav navbar-nav\">
//              <li class=\"active\"><a href=\"#\">Link</a></li>
//              <li><a href=\"#\">Link</a></li>
//              <li class=\"dropdown\">
//                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <b class=\"caret\"></b></a>
//                <ul class=\"dropdown-menu\">
//                  <li><a href=\"#\">Action</a></li>
//                  <li><a href=\"#\">Another action</a></li>
//                  <li class=\"divider\"></li>
//                  <li><a href=\"#\">Separated link</a></li>
//                </ul>
//              </li>
//            </ul>";

// A search field and button
// echo "      <form class=\"navbar-form navbar-left\" role=\"search\">
//               <div class=\"form-group\">
//                 <input type=\"text\" class=\"form-control\" placeholder=\"Search\">
//               </div>
//               <button type=\"submit\" class=\"btn btn-default\">Submit</button>
//             </form>";

// Set the log in button
// TODO : Check if the user is logged in. If this is the case, the login button should be changed to the name of the user
echo "	    <ul class=\"nav navbar-nav navbar-right\">
              <li><a href=\"#\" data-toggle=\"modal\" data-target=\"#login\">Log in</a></li>
            </ul>";

// Closing the menu
echo "	  </div>
        </div>
      </nav>";

// TODO : If not logged in, make the login form
require_once 'login.php';

?>