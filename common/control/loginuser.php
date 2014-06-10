<?php 
// loginuser.php
// checks if the user is logged in based on cookie

login();

function login()
{ global $loggedUser,$loggedUserName,$entryMessage,
         $objUser,$loginErrorCode,$loginErrorText,$objUtil;
  $loggedUser='';
  $loggedUserName='';
  $_SESSION['admin']="no";
  $loginErrorCode="";
  $loginErrorText="";
  if($objUtil->checkGetKey('indexAction')=='logout')
  { $_SESSION['cdp_id']='';
  	setcookie("cdpsec","",time()-3600,"/");
  	$loggedUser="";
    $_GET['indexAction']='default_action';
  }
  elseif(array_key_exists('cdpsec',$_COOKIE)&&$_COOKIE['cdpsec'])
  { if(strlen($_COOKIE['cdpsec'])>32)
    { if(substr($_COOKIE['cdpsec'],0,32)==$objUser->getUserProperty(substr($_COOKIE['cdpsec'],32,255),'password'))
      { $_SESSION['cdp_id']=substr($_COOKIE['cdpsec'],32,255);
        $loggedUser=$_SESSION['cdp_id'];
  		  if($objUser->getUserProperty($_SESSION['cdp_id'],'role',2)=="0")                // administrator logs in 
          $_SESSION['admin']="yes";
  	  }
  		else
  		{ $loginErrorText="Wrong password cookie"; 																					
  		  $_GET['indexAction']='error_action';
  		}
    }
  	else
  	{ $loginErrorText="Wrong password cookie"; 																					
  	  $_GET['indexAction']='error_action';
  	}
  }
  elseif(array_key_exists('indexAction',$_GET)&&($_GET['indexAction']=='check_login'))                                                        // entered password
  { 
  	if(array_key_exists('cdp_user', $_POST)&&$_POST['cdp_user']&&array_key_exists('passwd', $_POST)&&$_POST['passwd'])              // all fields filled in
    { $login  = $_POST['cdp_user'];                                          // get password from form and encrypt
  	  $passwd = md5($_POST['passwd']);
  	  $passwd_db = $objUser->getUserProperty($login,'password');                  // get password from database 
      if($passwd_db==$passwd)                                                     // check if passwords match
      {
        if($objUser->getUserProperty($login,'role',2)=="2")                         // user in waitlist already tries to log in
  			{ $loginErrorCode="LangWelcome5";
  			  $loggedUser="";
  			} 
        elseif($objUser->getUserProperty($login,'role',2)=="1")                     // validated user
        { session_regenerate_id(true);
  			  $_SESSION['cdp_id']=$login;                                      // set session variable
          $_SESSION['admin']="no";                                                // set session variable
          $loggedUser=$_SESSION['cdp_id'];
          $cookietime=time()+(365*24*60*60);                                      // 1 year	      
  				setcookie("cdpsec",$passwd.$login,$cookietime,"/");
  	    }
        else                                                                      // administrator logs in 
        { session_regenerate_id(true);
        	$_SESSION['cdp_id']=$login;                              
          $_SESSION['admin']="yes";                           
          $loggedUser=$login;
          $cookietime=time()+(365*24*60*60);                                      // 1 year
          setcookie("cdpsec",$passwd.$login,$cookietime,"/");
        }
        $_GET['indexAction']='default_action';
      }
      else // passwords don't match
      { $loginErrorCode="The password you entered was not correct!";
  		  $_GET['indexAction']='error_action';
  		  $loggedUser="";
  		}
    }
    else // not all fields are filled in
    { $loginErrorCode="You did not fill in a username and a password!";
  		$_GET['indexAction']='error_action';
  	}
  }
  else
  {	$_SESSION['cdp_id']='';
  	setcookie("cdpsec","",time()-3600,"/");
  	$loggedUser="";
  }
  if($loginErrorCode||$loginErrorText)
  { $_SESSION['cdp_id']='';
  	setcookie("cdpsec","",time()-3600,"/");
  }
  if($loggedUser)
    $loggedUserName=$objUser->getUserProperty($loggedUser,'firstname')." ".$objUser->getUserProperty($loggedUser,'name');
}
global $loggedUser;
?>
