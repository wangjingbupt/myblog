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
		case 'album' :
			$className = 'PhotoPhotos';
			include(CONTROLLER_PHOTO."/photos.php");
			new $className();
			break;
	  case 'pic' :
			$className = 'PhotoPhoto';
			include(CONTROLLER_PHOTO."/photo.php");
			new $className();
			break;
	  case 'deletepic' :
			$className = 'PhotoDelPhoto';
			include(CONTROLLER_PHOTO."/delPhoto.php");
			new $className();
			break;
		default: 
			$className = 'PhotoAlbum';
			include(CONTROLLER_PHOTO."/album.php");
			new $className();
			break;

	}
}

photoDispatch();
?>
