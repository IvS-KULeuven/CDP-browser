<?php
  // HTML 5
  echo "<!DOCTYPE html>";
  echo "<html lang=\"en\">";
  
  // The head of the html page
  echo "<head>
  		  <link href=\"css/cdp.css\" rel=\"stylesheet\" type=\"text/css\">
  		  <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">
  		  <script src=\"js/jquery-1.11.1.min.js\"></script>
          <!-- Include all compiled plugins (below), or include individual files as needed -->
          <script src=\"js/bootstrap.min.js\"></script>
  		
  		  <title>CDP browser</title>
  		</head>";

  // The body of the html page
  echo "<body>";

  // Making the menu
  require_once 'common/menu.php';                                                                // Includes of all classes and assistance files

  // We make some tabs, to see the different CDP releases
  echo "<ul id=\"tabs\" class=\"nav nav-tabs\" data-tabs=\"tabs\">
          <li class=\"active\"><a href=\"#cdp3\" data-toggle=\"tab\">CDP 3</a></li>
          <li><a href=\"#cdp2\" data-toggle=\"tab\">CDP 2</a></li>
          <li><a href=\"#cdp1\" data-toggle=\"tab\">CDP 1</a></li>
        </ul>";

  echo "<div id=\"my-tab-content\" class=\"tab-content\">
          <div class=\"tab-pane active\" id=\"cdp3\">
            <h1>CDP 3 release</h1>
            <p>The CDP 3 release.</p>
          </div>
          <div class=\"tab-pane\" id=\"cdp2\">
            <h1>CDP 2 release</h1>
            <p>The CDP 2 release.</p>
          </div>
          <div class=\"tab-pane\" id=\"cdp1\">
            <h1>CDP 1 release</h1>
            <p>The CDP 1 release.</p>
          </div>
  		</div>";
  		
  
  // Making the footer
  echo "<div class=\"navbar navbar-fixed-bottom\">
  		  <p class=\"navbar-text\">Copyright 2014</p>
  		</div>";
  
  // Closing the html page
  echo "</html>"
?>
