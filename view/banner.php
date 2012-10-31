	<?php
	
		if(empty($GLOBALS['LOGIN_DATA']))
		{
			$weibo_redirect_uri = urlencode(WB_CALLBACK_URL);
			$renren_redirect_uri = urlencode(RR_CALLBACK_URL);
			$instagram_redirect_uri= urlencode(IG_CALLBACK_URL);
			$login=<<<HTML
			<div class="offset10" style="width:30%">
			<div>
			<ul class="nav nav-pills">
			  <li class="dropdown">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i> <span style="color:#DDDDDD;font-weight:bold"> Login </span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href='https://api.weibo.com/oauth2/authorize?client_id=628803579&response_type=code&redirect_uri=$weibo_redirect_uri' ><img style="max-width:18px;" src='http://www.sinaimg.cn/blog/developer/wiki/LOGO_24x24.png'> <span style="color:#111111;font-weight:bold">&nbsp;&nbsp;Weibo</span></a></li>
							<li><a href='https://graph.renren.com/oauth/authorize?client_id=4e510ea83299443a8d4f520d46914b16&redirect_uri=$renren_redirect_uri&response_type=code&&scope=read_user_album+read_user_photo'><img style='max-width:16px;' src='http://wiki.dev.renren.com/mediawiki/images/0/0f/Ball32.png'><span style="color:#111111;font-weight:bold">&nbsp;&nbsp;Renren</span></a></li>
							<li><a href='https://api.instagram.com/oauth/authorize/?client_id=d191c0133cfc44c39642bb29b59dfac2&redirect_uri=$instagram_redirect_uri&response_type=code'><img style='max-width:16px;' src='http://img.lxsnow.me/sys/instagram@20.png'><span style="color:#111111;font-weight:bold">&nbsp;&nbsp;Instagram</span></a></li>	
						</ul>
				</li>
			</ul></div></div>

HTML;
		}else if($GLOBALS['LOGIN_DATA']['is_admin']==1)
		{
			$login_data = $GLOBALS['LOGIN_DATA'];
			$login = '<div class="offset10" style="width:30%">';
			$login .='
			<div>
			<ul class="nav nav-pills">
			  <li><a href="#"><img src="'.$login_data['profileImg'].'" style="margin:auto 3px;width:20px;b"> <span style="color:#DDDDDD;font-weight:bold">'.$login_data['nickName'].'</span></a></li>
			  <li class="dropdown">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-cog icon-white"></i><b class="caret"></b></a>
						<ul class="dropdown-menu">
						<li><a href="/editor/" style="font-weight:bold">发博文</a></li>
						<li><a href="/dustbin/post" style="font-weight:bold">垃圾箱</a></li>
						<li><a href="/callback/logout" style="font-weight:bold">登出</a></li>
						</ul>
				</li>
			</ul></div></div>';
			
		}
		else
		{

			$login_data = $GLOBALS['LOGIN_DATA'];
			$login = '<div class="offset10" style="width:30%">';
			$login .='
			<div>
			<ul class="nav nav-pills">
			  <li><a href="#"><img src="'.$login_data['profileImg'].'" style="margin:auto 3px;width:20px;b"> <span style="color:#DDDDDD;font-weight:bold">'.$login_data['nickName'].'</span></a></li>
			  <li class="dropdown">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-cog icon-white"></i><b class="caret"></b></a>
						<ul class="dropdown-menu">
						<li><a href="/callback/logout" style="font-weight:bold">登出</a></li>
						</ul>
				</li>
			</ul></div></div>';

		}

	
	?>
	
	<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container"><div class="row-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <span class="brand" style='color:#ffffff'> LXSnow</span>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?php echo $data['activeHome'];?>  ><a href="/">Home</a></li>
              <li <?php echo $data['activePhoto'];?>  ><a href="/photo">Photo</a></li>
            </ul>
          </div><!--/.nav-collapse -->
					<?php echo $login; ?>
        </div>
      </div></div>
    </div>
