<?php
// preludes.php
// loads all libraries for further use in includeFile

preludesA();
if($loginErrorCode||$loginErrorText)
{ $entryMessage=$loginErrorCode." ".$loginErrorText;
}

function preludesA()
{ global $objDatabase, $objUtil,
         $objUser, $objMetadata;

        if(!session_id()) session_start();
        require_once "lib/setup/databaseInfo.php";
        require_once "lib/database.php";               $objDatabase=new Database;
        require_once "lib/util.php";                   $objUtil=new Utils;
        require_once "lib/users.php";                  $objUser=new Users;
        require_once "lib/metadata.php";               $objMetadata=new Metadata;
        require_once "common/control/loginuser.php";
        
        // WATCH OUT : No ; at the end of the following if statement!!!!!!
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_user', 'common/control/adduser.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_metadata_keyword', 'metadata/control/addkeyword.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('delete_user', 'common/control/deleteuser.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('delete_keyword', 'metadata/control/deletekeyword.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_metadata_type', 'metadata/control/changekeyword.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_metadata_value', 'metadata/control/changevalue.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_possible_metadata_value', 'metadata/control/addvalue.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_role', 'common/control/changeUserRole.php')));
        
		if ($indexActionInclude != "") {
			require_once $indexActionInclude;
		}
}