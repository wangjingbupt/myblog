		<style>
			.enty-editor {height:400px;}
			.box {width:100%;margin:0 auto;}
			.ex {margin:24px 0;}
		</style>
		<link href="/assets/css/editor.css" type="text/css" rel="stylesheet" />
		<link href="/assets/css/panel.css" type="text/css" rel="stylesheet" />
		<script>
			if(window.console) {
				window.console = {};
				window.console.log = function(){};
			}
		</script>
		<div class="container">
			<div class="well" style='height:750px;' id='blog'>
				<legend>New Blog</legend>
					<label>标题</label>
					<input type="text" placeholder="" name='post_title' id='post_title' class="input-xxlarge" value="<?php echo $title?>" >
					<label>日期</label>
					<input type="text" placeholder="" name='post_date' id='post_date' class="input-xxlarge" value="<?php echo $date?>">
					<label>TAGS</label>
					<input type="text" placeholder="" name='post_tags' id='post_tags' class="input-xxlarge" value="<?php echo $tags?>">
					<label>正文</label>
					<div class="box">
						<div class="pro_tools" id="testSaveButtons"></div>
						<div id="frame" class="enty-editor">
							<textarea id="frameToText" name='frameToText'  class="se_textarea"></textarea>
						</div>
					</div>
					<div class='span2 offset10' style='margin-top:40px;'>
					<?php 
						if(!empty($post))
						{
							echo "<input type='hidden' name ='edit_post_id' id='edit_post_id' value='$post_id' />";
							echo '<button type="submit" name="edit_button" id="edit_button" class="btn btn-inverse">编辑</button>';
						}
						else
						{
							echo '<button type="submit" name="post_button" id="post_button" class="btn btn-inverse">提交</button>';
							
						}
					
					?>
					</div>
			</div>
		</div>
    <script src="/assets/js/jquery.js"></script>
		<script type="text/javascript" src="/assets/js/sinaeditor_min.js"></script>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		<script>
			var href = window.location.href;
			var loc = href.substring(0,href.lastIndexOf('/'));
			var textCSS = '/assets/css/contents.css';
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
					"plugns": [
					{
						"name": "addContent"
					},
					{
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
							"id" : '0',
						}
					}]
				};
				window.editor1 = SinaEditor.createEditor(config);
			}
$(document).ready(function(){         //DOM的onload事件处理函数   
		$("#post_button").click(function(){           //当按钮button被点击时的处理函数   
			postdata();                                       //button被点击时执行postdata函数   
			});   
		$("#edit_button").click(function(){
			editdata();
		});
		}); 
  

function postdata(){                              //提交数据函数   
	$.ajax({                                                  //调用jquery的ajax方法   
type: "POST",                                      //设置ajax方法提交数据的形式   
url: "/add",                                       //把数据提交到ok.php   
data: "post_title="+$("#post_title").val()+"&post_date="+$("#post_date").val()+"&post_tags="+$("#post_tags").val()+"&post_content="+encodeURIComponent(window.editor1.operation.submit()),     //输入框writer中的值作为提交的数据   
success: function(msg){                  //提交成功后的回调，msg变量是ok.php输出的内容。   
var dataObj=eval("("+msg+")");
if(dataObj.code == 'ok')
{
	window.location.href='/detail/'+dataObj.data._id;
}
else
{
	var insertText ='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>发表失败!</strong></div>';
	document.getElementById("blog").innerHTML = insertText+document.getElementById("blog").innerHTML;
		
}

}   
});   
}   
function editdata(){                              //提交数据函数   
	$.ajax({                                                  //调用jquery的ajax方法   
type: "POST",                                      //设置ajax方法提交数据的形式   
url: "/edit",                                       //把数据提交到ok.php   
data: "post_title="+$("#post_title").val()+"&post_date="+$("#post_date").val()+"&post_tags="+$("#post_tags").val()+"&post_id="+$("#edit_post_id").val()+"&post_content="+encodeURIComponent(window.editor1.operation.submit()),     //输入框writer中的值作为提交的数据   
success: function(msg){                  //提交成功后的回调，msg变量是ok.php输出的内容。   
var dataObj=eval("("+msg+")");
if(dataObj.code == 'ok')
{
	window.location.href='/detail/'+dataObj.data._id;
}
else
{
	var insertText ='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>发表失败!</strong></div>';
	document.getElementById("blog").innerHTML = insertText+document.getElementById("blog").innerHTML;
		
}

}   
});   
}   

		</script>

