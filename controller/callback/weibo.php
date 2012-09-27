<?php

class CallBackWeibo extends control{


	public function checkPara(){

		$this->code = $_REQUEST['code'];
		if($this->code =="")
			return false;

		return true;

	}

	public function action(){
		Login::callbackWeibo($this->code);
	}


	public function includeFiles()
	{


	}

}

?>
