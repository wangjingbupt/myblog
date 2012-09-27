<?php
include(CONTROLLER."/control.php");

function callbackDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'weibo' :
			$className = 'CallbackWeibo';
			include(CONTROLLER_CALLBACK."/weibo.php");
			new $className();
			break;
		case 'renren' :
			$className = 'CallbackRenren';
			include(CONTROLLER_CALLBACK."/renren.php");
			new $className();
			break;
		case 'instagram' :
			$className = 'CallbackInstagram';
			include(CONTROLLER_CALLBACK."/instagram.php");
			new $className();
			break;
		case 'logout' :
			$className = 'CallbackLogout';
			include(CONTROLLER_CALLBACK."/logout.php");
			new $className();
			break;
		default: 
			break;

	}
	$uri = $_SESSION['REQUEST_URI'];
	if($uri == '')
		$uri ='/';
	header("Location: $uri");	
}

callbackDispatch();
?>
