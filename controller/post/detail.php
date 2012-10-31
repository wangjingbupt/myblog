<?php

class PostDetail extends control{


	public function checkPara(){
		
		$this->blog_id = trim($GLOBALS['URL_PATH'][1]);
		$this->del = $_GET['del'];

		return true;

	}

	public function action(){
		$postModel = new PostModel();

		$datas['post'] = $postModel->getDetail($this->blog_id);

		$datas['recent'] = $postModel->getPostList();

		$datas['finder'] = $postModel->getFinder();

		$cmsModel = new CommentModel();
	
		$datas['comment'] = $cmsModel->getCmsList($this->blog_id);
		$datas['del'] = $this->del;

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/detail.php');
		include(MODEL_COMMENT."/CommentModel.php");

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		
		if(!empty($GLOBALS['LOGIN_DATA']))
		{
			$login_type = $GLOBALS['LOGIN_DATA']['login_type'];
			switch($login_type)
			{
				case 'weibo': 
				 $innerhtml_1='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><img src="http://img.lxsnow.me/sys/weibo@16.png"> <span><a href="http://weibo.com/u/'.$GLOBALS['LOGIN_DATA']['uid'].'" target="_blank" >';
				 $innerhtml_2 = '</a>: ';
				 $innerhtml_3 = '</span></div><div class="span2" style="text-align:right;"><small style="color:#999999">';
					break;
				case 'renren':
					$innerhtml_1='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><img src="http://img.lxsnow.me/sys/renren@16.png"> <span><a href="http://www.renren.com/'.$GLOBALS['LOGIN_DATA']['uid'].'/profile" target="_blank" >';
					$innerhtml_2 = '</a>: ';
					$innerhtml_3 = '</span></div><div class="span2" style="text-align:right;"><small style="color:#999999">';
					break;
				case 'instagram':
					$innerhtml_1 ='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><img src="http://img.lxsnow.me/sys/instagram@20.png" style="max-width:16px;"> <span style="color:#993377;">';
					$innerhtml_2 = '</span>: <span>';
					$innerhtml_3 = '</span></div><div class="span2" style="text-align:right;"><small style="color:#999999">';
					break;
			}
		}
		else{
			$innerhtml_1 ='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><i class="icon-user"></i> <span style="color:#993377;">';
			$innerhtml_2 = '</span>: <span>';
			$innerhtml_3= '</span></div><div class="span2" style="text-align:right;"><small style="color:#999999">';
		}

		$data['script'] =<<<HTML
		

<script type="text/javascript">  
$(document).ready(function(){         //DOM的onload事件处理函数   
		$("#cms_button").click(function(){           //当按钮button被点击时的处理函数   
			postdata();                                       //button被点击时执行postdata函数   
			});   
		});   
function postdata(){                              //提交数据函数   
	$.ajax({                                                  //调用jquery的ajax方法   
type: "POST",                                      //设置ajax方法提交数据的形式   
url: "/comment/new",                                       //把数据提交到ok.php   
data: "cms_name="+$("#cms_name").val()+"&cms_content="+$("#cms_content").val()+"&blog_id="+$("#blog_id").val(),     //输入框writer中的值作为提交的数据   
success: function(msg){                  //提交成功后的回调，msg变量是ok.php输出的内容。   
var dataObj=eval("("+msg+")");
if(dataObj.code == 'ok')
{
	var insertText ='$innerhtml_1'+dataObj.data.user_name+'$innerhtml_2'+dataObj.data.content+'$innerhtml_3'+dataObj.data.pubtime+'</small></div></div>';
	document.getElementById("cms_box").innerHTML = insertText+document.getElementById("cms_box").innerHTML;
	var insertText ='<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>评论成功!</strong></div>'
	document.getElementById("comment").innerHTML = insertText+document.getElementById("comment").innerHTML;
	document.getElementById("cms_num").innerHTML =parseInt(document.getElementById("cms_num").innerHTML)+1;
}
else
{
	var insertText ='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>评论失败!</strong></div>'
	document.getElementById("comment").innerHTML = insertText+document.getElementById("comment").innerHTML;
	
}

}   
});   
}   
</script>  
HTML;
		$GLOBALS['DATA'] = $data;
		ViewDetail::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
