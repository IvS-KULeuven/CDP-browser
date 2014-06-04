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
  echo "<body>
  		  <h1>This is the CDP browser.</h1>
  		  <button class=\"btn btn-primary btn-lg\" data-toggle=\"modal\" data-target=\"#login\">
            Log in
  		  </button>
  		
  		
  		  <div class=\"modal fade\" id=\"login\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
            <div class=\"modal-dialog\">
              <div class=\"modal-content\">
  		        <div class=\"modal-body\">
  		          <h1 class=\"text-center login-title\">Sign in to continue to CDP browser</h1>
                  <div class=\"account-wall\">
                    <img class=\"profile-img\" src=\"https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120\"
                    alt=\"\">
                    <form class=\"form-signin\">
                      <input type=\"text\" class=\"form-control\" placeholder=\"User name\" required autofocus>
                      <input type=\"password\" class=\"form-control\" placeholder=\"Password\" required>
                      <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                        Sign in
  		              </button>

  		              <label class=\"checkbox pull-left\">
                        <input type=\"checkbox\" value=\"remember-me\">
                        Remember me
                      </label>
                      <a href=\"#\" class=\"pull-right need-help\">Need help? </a><span class=\"clearfix\"></span>
                    </form>
  		          </div>
  	  	        </div>
              </div>
            </div>
          </div>
  		</body>";

  // Closing the html page
  echo "</html>"
?>
  

              
