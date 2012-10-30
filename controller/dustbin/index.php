<?php
include(CONTROLLER."/control.php");


function dustbinDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'post' :
			$className = 'DustbinPost';
			include(CONTROLLER_DUSTBIN."/post.php");
			break;
		case 'photo' :
			$className = 'DustbinPhoto';
			include(CONTROLLER_DUSTBIN."/photo.php");
			break;
	}
new $className();
}

dustbinDispatch();

?>
