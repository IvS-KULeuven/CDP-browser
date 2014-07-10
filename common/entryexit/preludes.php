<?php
// preludes.php
// loads all libraries for further use in includeFile

preludesA();
if($loginErrorCode||$loginErrorText)
{ $entryMessage=$loginErrorCode." ".$loginErrorText;
}

function preludesA()
{ global $objDatabase, $objUtil, $objFits,
         $objUser, $objMetadata, $objCdp;

        if(!session_id()) session_start();
        require_once "lib/setup/databaseInfo.php";
        require_once "lib/database.php";               $objDatabase=new Database;
        require_once "lib/util.php";                   $objUtil=new Utils;
        require_once "lib/users.php";                  $objUser=new Users;
        require_once "lib/metadata.php";               $objMetadata=new Metadata;
        require_once "lib/cdp.php";                    $objCdp=new Cdp;
        require_once "lib/fits.php";                   $objFits=new Fits;
        require_once "common/control/loginuser.php";
        
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_csv', 'cdp/control/addcsv.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_user', 'common/control/adduser.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_metadata_keyword', 'metadata/control/addkeyword.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('delete_user', 'common/control/deleteuser.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('delete_keyword', 'metadata/control/deletekeyword.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('deliver_cdp_file', 'cdp/control/deliver_cdp_file.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('undeliver_cdp_file', 'cdp/control/undeliver_cdp_file.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_metadata_type', 'metadata/control/changekeyword.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_metadata_value', 'metadata/control/changevalue.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_metadata_location', 'metadata/control/changelocation.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('metadata_required', 'metadata/control/changerequired.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('add_possible_metadata_value', 'metadata/control/addvalue.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('delete_possible_metadata_value', 'metadata/control/deletevalue.php')))
        if(!($indexActionInclude=$objUtil->utilitiesCheckIndexActionAdmin('change_role', 'common/control/changeUserRole.php')));
        
		if ($indexActionInclude != "") {
			require_once $indexActionInclude;
		}
}