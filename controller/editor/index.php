<?php
include(CONTROLLER."/control.php");


function editorDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		default: 
		  $className = 'EditorEditor';
			include(CONTROLLER."/editor/editor.php");
			new $className();
			break;

	}
}

editorDispatch();
?>
