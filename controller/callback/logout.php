<?php

class CallBackLogout extends control{


	public function checkPara(){

		return true;

	}

	public function action(){
		session_destroy();
		header("Location: /");	

		
	}


	public function includeFiles()
	{


	}

}

?>
