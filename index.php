<?php
//error_reporting(E_ALL);
//ini_set('display_errors',1);

include('config/config.php');
include(DATA.'/mongo.class.php');



function dispatch()
{
	list($path,$params) = explode('?',ltrim($_SERVER['REQUEST_URI'],'/'),2);

	$GLOBALS['URL_PATH'] = explode('/',$path);


	$filePath = ROOT."/controller/".$GLOBALS['URL_PATH'][0]."/index.php";
	

	if(file_exists($filePath))
	{
		include($filePath);
	}
	else
	{
		include( ROOT."/controller/post/index.php");
	}
}

dispatch();


?>
