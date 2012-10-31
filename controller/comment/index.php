<?php
include(CONTROLLER."/control.php");
include(MODEL_COMMENT."/CommentModel.php");


function commentDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'new' :
			$className = 'CommentNew';
			include(CONTROLLER_COMMENT."/new.php");
			new $className();
			break;
		case 'delete' :
			$className = 'CommentDelete';
			include(CONTROLLER_COMMENT."/delCms.php");
			new $className();
			break;
		default: 
			break;

	}
}

commentDispatch();
?>
