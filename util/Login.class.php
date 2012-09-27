<?php

class Login{


	public function loginAll()
	{
		session_start();
		self::loginWeibo();
	}

	public function loginWeibo()
	{
			
			if(isset($_SESSION['weibo_token']))
			{
				$token = $_SESSION['weibo_token'];
				$uid = $_SESSION['weibo_uid'];
			}
			else if(!empty($_COOKIE));
			{
				foreach($_COOKIE as $k => $v)
				{
					if(preg_match('/weibojs_/',$k))
					{
						$arr = explode('&',$v);
						foreach($arr as $pa)
						{
							list($key,$value) = explode('=',$pa);
							$weibo_cookie[$key] = $value;
						}
						$token = $weibo_cookie['access_token'];
						$uid = $weibo_cookie['uid'];
					}

				}
			}
			if($token != '')
			{

				$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token );
				if($uid == "")
				{
					$uid = $c->get_uid();
				}

				$user_message = $c->show_user_by_id($uid);
				if (isset($user_message['error_code']) && $user_message['error_code'] > 0 )
				{
					return false;
				}
				$this->loginData['profileImg'] = $user_message['profile_image_url'];
				$this->loginData['nickName'] = $user_message['screen_name'];
				


			}
		
	}

}

?>
