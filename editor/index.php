<?php
include('../config/db.conf.php');

$m = new Mongo(DbConf::$mongoConf);
$db = $m->selectDB(DbConf::$BDprefix."_blog");
$c = $db->selectCollection('post');

$cursor = $c->find();
$num = $cursor.count();

?>

<!DOCTYPE HTML>
<html>
	<head>

    <meta charset="utf-8">
    <title>LXsnow's blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
		<?php echo $data['header']?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/css/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/css/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/css/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/css/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/css/apple-touch-icon-57-precomposed.png">
  </head>
		<style>
			.enty-editor {height:400px;}
			.box {width:100%;margin:0 auto;}
			.ex {margin:24px 0;}
		</style>
		<link href="style/css/editor.css" type="text/css" rel="stylesheet" />
		<link href="style/css/panel.css" type="text/css" rel="stylesheet" />
		<script>
			if(window.console) {
				window.console = {};
				window.console.log = function(){};
			}
		</script>
	</head>
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
              <li class="active" ><a href="/">Home</a></li>
              <li><a href="/photo">Photo</a></li>
              <li><a href="/weibo">Weibo</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
		<div class="container">
			<div class="well" style='height:750px;' id='blog'>
				<legend>New Blog</legend>
					<label>标题</label>
					<input type="text" placeholder="" name='post_title' id='post_title' class="input-xxlarge">
					<label>正文</label>
					<div class="box">
						<div class="pro_tools" id="testSaveButtons"></div>
						<div id="frame" class="enty-editor">
							<textarea id="frameToText" name='frameToText'  class="se_textarea"></textarea>
						</div>
					</div>
					<div class='span2 offset10' style='margin-top:40px;'>
						<button type="submit" name="post_button" id="post_button" class="btn btn-inverse">提交</button>
					</div>
			</div>
		</div>
		<script type="text/javascript" src="sinaeditor_min.js"></script>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
		<script>
			var href = window.location.href;
			var loc = href.substring(0,href.lastIndexOf('/'));
			var textCSS = loc+'/style/css/contents.css';
			window.onload = function(){
				var config = {
					"id": "myEditor",
					//编辑器的按钮存放的base dom id 或者dom
					"toolBase": 'testSaveButtons',
					"initType": {
						"name": "initFromStatic",
						"args": {
							"parent": document.getElementById('frame')
						}
					},
					//可选
					"filter": {
						"name": "pasteFilter",
						"args": {
							"tagName": "SCRIPT|INPUT|IFRAME|TEXTAREA|SELECT|BUTTON",
							"noFlashExchange": false,
							"attribute": "id"
						}
					},
					"editorName": 'SinaEditor._.entyimpl.normalEditor',
					"styles": "body {\
									margin:0px;\
									padding:0px;\
									width:100%;\
									height:100%;\
								}\
								.biaoqing {\
									width:22px;\
									height:22px;\
								}",
					"styleLinks": [textCSS],
					"plugns": [{
						"name": "addContent"
					},{
						"name": "showSource",
						"args": {
							"entyArea": document.getElementById('frameToText')
						}
					},
					{
						"name": "forecolor"
					}, {
						"name": "underline"
					},{
						"name": "italic"
					}, {
						"name": "bold"
					}, {
						"name": "linkBubble"
					}, {
						"name": "imgBubble"
					}, {
						"name": "flashBubble"
					}, {
						"name": "redoManager"
					}, {
						"name": "imgUI"
					}, {
						"name": "submit"
					}, {
						"name": "historyUI",
						"args" : {
							"id" : <?php echo $num ;?>
						}
					}]
				};
				window.editor1 = SinaEditor.createEditor(config);
			}
$(document).ready(function(){         //DOM的onload事件处理函数   
		$("#post_button").click(function(){           //当按钮button被点击时的处理函数   
			postdata();                                       //button被点击时执行postdata函数   
			});   
		});   

function postdata(){                              //提交数据函数   
	$.ajax({                                                  //调用jquery的ajax方法   
type: "POST",                                      //设置ajax方法提交数据的形式   
url: "/add",                                       //把数据提交到ok.php   
data: "post_title="+$("#post_title").val()+"&post_content="+window.editor1.operation.submit(),     //输入框writer中的值作为提交的数据   
success: function(msg){                  //提交成功后的回调，msg变量是ok.php输出的内容。   
var dataObj=eval("("+msg+")");
if(dataObj.code == 'ok')
{
	window.location.href='/detail/'+dataObj.data._id;
}
else
{
	var insertText ='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>发表失败!</strong></div>'
	document.getElementById("blog").innerHTML = insertText+document.getElementById("blog").innerHTML;
		
}

}   
});   
}   
		</script>


  </body>
</html>
