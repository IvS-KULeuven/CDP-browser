<?php
  if(!array_key_exists('indexAction',$_GET)&&array_key_exists('indexAction',$_POST))
	$_GET['indexAction']=$_POST['indexAction'];

  // Include the version number
  require_once 'lib/setup/version.php';

  // Includes of all classes and assistance files
  require_once 'common/entryexit/preludes.php';

  // HTML 5
  echo "<!DOCTYPE html>";
  echo "<html lang=\"en\">";

  // The head of the html page
  echo "<head>
  		  <link href=\"css/cdp.css\" rel=\"stylesheet\" type=\"text/css\">
  		  <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">
          <script src=\"js/jquery-1.11.2.min.js\"></script>
          <!-- Include all compiled plugins (below), or include individual files as needed -->
          <script src=\"js/bootstrap.min.js\"></script>
          <script src=\"js/jquery.tablesorter.min.js\"></script>
          <script src=\"js/jquery.tablesorter.widgets.min.js\"></script>
          <script src=\"js/jquery.tablesorter.pager.min.js\"></script>
          <script src=\"js/widget-columnSelector.js\"></script>
          <link href=\"css/tablesorter.theme.bootstrap.css\" rel=\"stylesheet\">
      <title>CDP browser</title>";
  echo "</head>";

  // The body of the html page
  echo "<body>";

  // Import the database settings.
  require_once "lib/setup/databaseInfo.php";

  // Making the menu
  require_once 'common/menu.php';

  // Determine the page to show
  $includeFile=$objUtil->utilitiesDispatchIndexAction();

  // Page with the list of cdp files
  require_once $includeFile;

  // Making the footer
  echo "<div class=\"navbar navbar-default navbar-fixed-bottom\">
  		  <p class=\"navbar-text\">Copyright 2014-2019, <a href='mailto:wim.demeester@ster.kuleuven.be'>Wim De Meester</a>, <a href='http://www.ster.kuleuven.be/'>IvS</a>, KU Leuven.</p>
  		</div>";

  // dispays $entryMessage if any
  if(isset($entryMessage)&&$entryMessage) {
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

  echo "</body>";
  // Closing the html page
  echo "</html>"
?>
