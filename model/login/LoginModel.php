<?php
class LoginModel{

	public function __construct() {
	}

	public function login($uname,$passwd)
	{
		if( $uname == "" || $passwd == "")
		{
			return false;
		}
		$token = md5(date('Y-m').$uname.$passwd);

		return Login::doLoginLocal($token);
	}	
}




?>
