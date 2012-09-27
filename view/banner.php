	<?php
	
		if(empty($GLOBALS['LOGIN_DATA']))
		{
			$weibo_redirect_uri = urlencode(WB_CALLBACK_URL);
			$renren_redirect_uri = urlencode(RR_CALLBACK_URL);
			$instagram_redirect_uri= urlencode(IG_CALLBACK_URL);
			$login=<<<HTML

					<div class='well offset10' style='padding:0 5px;margin-top:7px;margin-bottom:0px;text-align:right;'><span style='color:#993377; font-weight:bold'>LOGIN&nbsp;</span>
						<a href='https://api.weibo.com/oauth2/authorize?client_id=628803579&response_type=code&redirect_uri=$weibo_redirect_uri' ><img style="max-width:22px;" src='http://www.sinaimg.cn/blog/developer/wiki/LOGO_24x24.png'></a>
					<a href='https://graph.renren.com/oauth/authorize?client_id=4e510ea83299443a8d4f520d46914b16&redirect_uri=$renren_redirect_uri&response_type=code'><img style='max-width:20px;' src='http://wiki.dev.renren.com/mediawiki/images/0/0f/Ball32.png'></a>
					<a href='https://api.instagram.com/oauth/authorize/?client_id=d191c0133cfc44c39642bb29b59dfac2&redirect_uri=$instagram_redirect_uri&response_type=code'><img style='max-width:20px;' src='http://img.lxsnow.me/sys/instagram@20.png'></a>	
					</div>

HTML;
		}else
		{
			$login_data = $GLOBALS['LOGIN_DATA'];
			$login = '<div class="well1 offset10" style="margin-top:8px;width:15%">';
			$login .='<img src="'.$login_data['profileImg'].'" style="margin:auto 3px;width:20px;b"> <span style="margin-right:8px;color:#993377;font-weight:bold">'.$login_data['nickName'].'</span> <a href="/callback/logout" style="font-weight:bold">登出</a> ';

			$login .='</div>';
		}

	
	?>
	
	<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <span class="brand" style='color:#ffffff'> LXSnow</span>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?php echo $data['activeHome'];?>  ><a href="/">Home</a></li>
              <li <?php echo $data['activePhoto'];?> ><a href="/photo">Photo</a></li>
              <li <?php echo $data['activeWeibo'];?> ><a href="/weibo">Weibo</a></li>
            </ul>
          </div><!--/.nav-collapse -->
					<?php echo $login; ?>
        </div>
      </div>
    </div>
