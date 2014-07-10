<?php
// Setting the log in modal form
echo "<div class=\"modal fade\" id=\"login\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
          <div class=\"modal-dialog\">
            <div class=\"modal-content\">
              <div class=\"modal-body\">
  		        <h1 class=\"text-center login-title\">Sign in to the CDP browser</h1>
                <div class=\"account-wall\">
                  <form class=\"form-signin\" action=\"".$baseURL."index.php\" method=\"post\">
                    <input type=\"text\" name=\"cdp_user\" class=\"form-control\" placeholder=\"User name\" required autofocus>
                    <input type=\"password\" name=\"passwd\" class=\"form-control\" placeholder=\"Password\" required>
                    <input type=\"hidden\" name=\"indexAction\" value=\"check_login\" />
                  	<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">
                      Sign in
  		            </button>
                  </form>
  		        </div>
  	  	      </div>
            </div>
          </div>
        </div>";

?>
