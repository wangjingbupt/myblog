<?php

class CallBackInstagram extends control{


	public function checkPara(){

		$this->code = $_REQUEST['code'];
		if($this->code =="")
			return false;

		return true;

	}

	public function action(){
		Login::callbackInstagram($this->code);
	}


	public function includeFiles()
	{


	}

}

?>
