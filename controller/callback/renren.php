<?php

class CallBackRenren extends control{


	public function checkPara(){

		$this->code = $_REQUEST['code'];
		if($this->code =="")
			return false;

		return true;

	}

	public function action(){
		Login::callbackRenren($this->code);
		header("Location: /");	

		
	}


	public function includeFiles()
	{


	}

}

?>
