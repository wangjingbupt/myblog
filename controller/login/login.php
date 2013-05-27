<?php

class LoginLogin extends control{


	public function checkPara(){
		
		$this->userName = $_POST['uname'];
		$this->passwd = $_POST['passwd'];
		$this->remember = $_POST['remember'] == 'on'? 1:0;

		return true;

	}

	public function action(){

		$loginModel = new LoginModel();
  		$sign = $loginModel->login($this->userName,$this->passwd,$this->remember); 
		if($sign)
		{
			$uri = "/";
		}
		else
		{
			$uri = "/login?error=1";
		}
		header("Location: $uri");

	}


	public function includeFiles()
	{
			include(MODEL_LOGIN."/LoginModel.php");

	}
	

}

?>
