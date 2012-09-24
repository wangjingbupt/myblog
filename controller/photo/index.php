<?php
include(CONTROLLER."/control.php");
include(MODEL_PHOTO."/PhotoModel.php");


function photoDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'upload' :
			$className = 'PhotoUpload';
			include(CONTROLLER_PHOTO."/upload.php");
			new $className();
			break;
		default: 
			break;

	}
}

photoDispatch();
?>
