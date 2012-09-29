<?php

class Login{


	public function loginAll()
	{
		if(self::loginWeibo())
			return;
		if(self::loginRenren())
			return;
		if(self::loginInstagram())
			return;
	}

	public function callbackWeibo($code)
	{
		if($code == "")
			return false;

		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

		$keys = array();
		$keys['code'] = $code;
		$keys['redirect_uri'] = WB_CALLBACK_URL;
		try {
			$token = $o->getAccessToken( 'code', $keys ) ;
		} catch (OAuthException $e) {
			return false;
		}

		if ($token)
		{
			$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token'] );
			$uid = $token['uid'];

			$user_message = $c->show_user_by_id($uid);
			if (isset($user_message['error_code']) && $user_message['error_code'] > 0 )
			{
				return false;
			}

			$profileImg = $user_message['profile_image_url'];
			$nickName = $user_message['screen_name'];

			$_SESSION['weibo_token'] = $token['access_token'];
			$_SESSION['login_type'] = 'weibo';
			$_SESSION['weibo_uid'] = $uid;
			$_SESSION['weibo_profile_image_url'] = $user_message['profile_image_url'];
			$_SESSION['weibo_screen_name'] = $user_message['screen_name'];
			$cookie = array(
					'access_token'=>$token,
					'uid'=>$uid,
					);

		}

		return true;

	}

	public function loginWeibo()
	{

		if(isset($_SESSION['weibo_token']))
		{
			$this->loginData['token'] = $_SESSION['weibo_token'];
			$this->loginData['uid'] = $_SESSION['weibo_uid'];
			$this->loginData['profileImg'] = $_SESSION['weibo_profile_image_url'];
			$this->loginData['nickName'] = $_SESSION['weibo_screen_name'];
			$this->loginData['login_type'] = $_SESSION['login_type'];

			$GLOBALS['LOGIN_DATA'] = $this->loginData;
			return true;

		}
		return false;

	}

	public function callbackRenren($code)
	{
		if($code == "")
			return false;
		$oauthApi = new RenrenOAuthApiService;
		$post_params = array('client_id'=>RR_AKEY,
				'client_secret'=>RR_SKEY,
				'redirect_uri'=>RR_CALLBACK_URL,
				'grant_type'=>'authorization_code',
				'code'=>$code
				);
		$token_url='http://graph.renren.com/oauth/token';
		$access_info=$oauthApi->rr_post_curl($token_url,$post_params);

		if (isset($access_info['error']) && $access_info['error'] != '')
		{
			return false;
		}
		$user = $access_info['user'];
		foreach($user['avatar'] as $avatar)
		{	
			if($avatar['type'] == 'tiny')
			{
				$profile_image_url = $avatar['url'];
				break;
			}
		}


		$_SESSION['renren_token'] = $access_info['access_token'];
		$_SESSION['login_type'] = 'renren';
		$_SESSION['renren_uid'] = $user['id'];
		$_SESSION['renren_profile_image_url'] = $profile_image_url;
		$_SESSION['renren_name'] = $user['name'];

		return true;

	}


	public function loginRenren()
	{

		if(isset($_SESSION['renren_token']))
		{
			$this->loginData['token'] = $_SESSION['renren_token'];
			$this->loginData['uid'] = $_SESSION['renren_uid'];
			$this->loginData['profileImg'] = $_SESSION['renren_profile_image_url'];
			$this->loginData['nickName'] = $_SESSION['renren_name'];
			$this->loginData['login_type'] = $_SESSION['login_type'];

			$GLOBALS['LOGIN_DATA'] = $this->loginData;
			return true;

		}

		return false;

	}

	public function callbackInstagram($code)
	{
		if($code == "")
			return false;
		$oauthApi = new Instagram();
		$access_info=$oauthApi->getToken($code);

		if (isset($access_info['code']) && $access_info['code'] >0)
		{
			return false;
		}
		$user = $access_info['user'];
		$profile_image_url = $user['profile_picture'];


		$_SESSION['instagram_token'] = $access_info['access_token'];
		$_SESSION['login_type'] = 'instagram';
		$_SESSION['instagram_uid'] = $user['id'];
		$_SESSION['instagram_profile_image_url'] = $profile_image_url;
		$_SESSION['instagram_name'] = $user['username'];


		if($user['id'] ==54649922 )
		{
			$db = new MyMongo('blog','adminUser');
			$doc = $db->findOne(array('type'=>'instagram'));
			if(!is_array($doc)  || empty($doc))
			{
				$insert=array(
					'uid'=>$user['id'],
					'type'=>'instagram',
					'token' =>$access_info['access_token'],
				);
				$db->insert($insert);
				
			}

		}

		return true;

	}

	public function loginInstagram()
	{

		if(isset($_SESSION['instagram_token']))
		{
			$this->loginData['token'] = $_SESSION['instagram_token'];
			$this->loginData['uid'] = $_SESSION['instagram_uid'];
			$this->loginData['profileImg'] = $_SESSION['instagram_profile_image_url'];
			$this->loginData['nickName'] = $_SESSION['instagram_name'];
			$this->loginData['login_type'] = $_SESSION['login_type'];

			$GLOBALS['LOGIN_DATA'] = $this->loginData;
			return true;

		}

		return false;

	}

}

?>
