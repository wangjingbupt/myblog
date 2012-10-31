<?php
include(CONTROLLER."/control.php");


function dustbinDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'post' :
			$className = 'DustbinPost';
			include(CONTROLLER_DUSTBIN."/post.php");
			new $className();
			break;
		case 'photo' :
			$className = 'DustbinPhoto';
			include(CONTROLLER_DUSTBIN."/photo.php");
			new $className();
			break;
		case 'cms' :
			$className = 'DustbinCms';
			include(CONTROLLER_DUSTBIN."/cms.php");
			new $className();
			break;
	  case 'recoverPhoto':
			$className = 'DustbinRecoverPhoto';
			include(CONTROLLER_DUSTBIN."/recoverPhoto.php");
			new $className();
			break;
	  case 'recoverPost':
			$className = 'DustbinRecoverPost';
			include(CONTROLLER_DUSTBIN."/recoverPost.php");
			new $className();
			break;
	  case 'recoverCms':
			$className = 'DustbinRecoverCms';
			include(CONTROLLER_DUSTBIN."/recoverCms.php");
			new $className();
			break;
	}
}

dustbinDispatch();

?>
