<?php
include(CONTROLLER."/control.php");
include(MODEL_POST."/PostModel.php");


function postDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'logout' :
			$className = 'LoginLogout';
			include(CONTROLLER_LOGIN."/logout.php");
			break;
		case 'login' :
 			$className = 'LoginLogin';
 			include(CONTROLLER_LOGIN."/login.php");
		default: 
			$className = 'LoginPage';
			include(CONTROLLER_LOGIN."/page.php");
			break;

	}
new $className();
}

postDispatch();

?>
