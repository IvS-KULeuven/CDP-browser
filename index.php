<?php
  if(!array_key_exists('indexAction',$_GET)&&array_key_exists('indexAction',$_POST))
	$_GET['indexAction']=$_POST['indexAction'];

  require_once 'common/entryexit/preludes.php';                                                 // Includes of all classes and assistance files
  
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

  // Import the database settings.
  require_once "lib/setup/databaseInfo.php";
  
  // Making the menu
  require_once 'common/menu.php';                                                                // Includes of all classes and assistance files

  // Page with the list of cdp files
  require_once 'cdp/list.php';
  
  // Making the footer
  echo "<div class=\"navbar navbar-default navbar-fixed-bottom\">
  		  <p class=\"navbar-text\">Copyright 2014</p>
  		</div>";

//   // Pagination
//   echo "<ul style=\"margin-top:0;\" class=\"pagination pull-right\">";
//   echo " <li><a href=\"&amp;multiplepagenr=0\">&laquo;</a></li>";
//   echo " <li><a href=\"&amp;multiplepagenr=0\">&lt;</a></li>";
//   echo " <li><a href=\"#\"><input style=\"height:20px;\" value=\"5\"></input></a></li>";
//   echo "<li><a href=\"&amp;multiplepagenr=1\">&gt;</a></li>";
//   echo "<li><a href=\"&amp;multiplepagenr=1\">&raquo;</a></li>";
//   echo "&nbsp;</ul>";
  
//   echo "<span style=\"padding-top:6px;\" class=\"pull-right\">";
//   echo "&nbsp;(24 resultaten in 2 paginas)&nbsp;";
//   echo "</span>";
  
  
  if(isset($entryMessage)&&$entryMessage) {                                                                 // dispays $entryMessage if any
  	echo "<div class=\"modal fade\" id=\"errorModal\" tabindex=\"-1\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
                                  <h4 class=\"modal-title\" id=\"myModalLabel\">CDP</h4>
                                </div>
                        <div class=\"modal-body\">" .
                          $entryMessage . "
                      </div>
            </div>
          </div>
        </div>";
  
  	echo "<script type=\"text/javascript\">";
  	echo "$(document).ready(function() {
          $('#errorModal').modal('show')
        });";
  	echo "</script>";
  }
  
  
  // Closing the html page
  echo "</html>"
?>
