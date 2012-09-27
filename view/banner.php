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
					<div><span id="connectBtn"></span></div>
					<script type="text/javascript">
					WB.widget.base.connectButton(
								document.getElementById("connectBtn"),
											{
																login:function(o){
																						alert(o.screen_name)  //这里放置用户登陆后您希望采取的操作
																										},
																														logout:function(){
																																				alert('logout');  //这里放置用户登出后，您希望采取的操作
																																								}
																																											}
																																													);
					</script>

        </div>
      </div>
    </div>
