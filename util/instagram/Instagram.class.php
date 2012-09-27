<?php
class Instagram {
	
		public function __construct()
		{
			$this->AKEY = IG_AKEY;
			$this->SKEY = IG_SKEY;
			$this->REDIRECT_URI =IG_CALLBACK_URL;
			$this->auth_url = 'https://api.instagram.com/oauth/access_token';
		}


		public function getToken($code)
		{
			$param =array(
				'client_id'=>$this->AKEY,
				'client_secret'=>$this->SKEY,
				'grant_type'=>'authorization_code',
				'redirect_uri'=>$this->REDIRECT_URI,
				'code'=>$code,
			);

			return json_decode(self::postRequest($this->auth_url,$param),true);

		}

		public function postRequest($url,$param)
		{
			$c = new Curl();
			return $c->post($url,$param); 

		}






}





?>
