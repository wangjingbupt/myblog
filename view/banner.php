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
					<div class='well offset10' style='padding:0 5px;margin-top:7px;margin-bottom:0px;text-align:right;'><span id="wb_connect_btn"><span style='color:#993377; font-weight:bold'>LOGIN&nbsp;</span>
						<a href='https://api.weibo.com/oauth2/authorize?client_id=628803579&response_type=code&redirect_uri=<?php echo urlencode(REDIRECT_URL) ?>' ><img src='http://www.sinaimg.cn/blog/developer/wiki/LOGO_24x24.png'></a>
					<a href='https://graph.renren.com/oauth/authorize?client_id=4e510ea83299443a8d4f520d46914b16&redirect_uri=<?php echo urlencode(REDIRECT_URL) ?>&response_type=code'><img style='max-width:20px;' src='http://wiki.dev.renren.com/mediawiki/images/0/0f/Ball32.png'></a>
					<a href='https://api.instagram.com/oauth/authorize/?client_id=d191c0133cfc44c39642bb29b59dfac2&redirect_uri=<?php echo urlencode(REDIRECT_URL) ?>&response_type=code'><img style='max-width:20px;' src='http://img.lxsnow.me/sys/instagram@20.png'></a>	
					</span></div>
<script type="text/javascript">
WB2.anyWhere(function(W){
	    W.widget.connectButton({
				        id: "wb_connect_btn1",	
								        type:"3,2",
												        callback : {
																	            login:function(o){	//登录后的回调函数
																							            },	
																													            logout:function(){	//退出后的回调函数
																																			            }
																																									        }
																																													    });
});
</script>
        </div>
      </div>
    </div>
