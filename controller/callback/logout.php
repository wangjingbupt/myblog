<?php

class CallBackLogout extends control{


	public function checkPara(){

		return true;

	}

	public function action(){
		session_destroy();
		$referer = $_SERVER['HTTP_REFERER'];
		if($referer == '')
			$referer ='/';
		header("Location: {$referer}");	

		
	}


	public function includeFiles()
	{


	}

}

?>
