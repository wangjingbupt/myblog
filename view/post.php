<?php

class ViewPost {

public function photoPost($post)
{
	$html = <<<HTML
						<div class="well">
							<div class="row-fluid">
								<div class="span2">
									<h2><%= blog.title %></h2>
								</div>
								<div class="span1 offset9">
									<!-- <p><a class="btn btn-inverse btn-mini">分享</a></p> -->
								</div>
							</div>

							<!--	
							<div>
								 <small>发表于</small>
							</div>
							-->

							<div class="row-fluid" style="margin-top:20px">
								<div>
								<% if blog.photoList?%>
									<div id="myCarousel" class="carousel slide">
										<div class="carousel-inner">
										<% blog.photoList.each do |photo|%>
											<div class="item active">
												<img src="<%= photo %>" alt="">
												<div class="carousel-caption">
													<h4><%= photo%></h4>
													<p><%= photo %></p>
												</div>
											</div>
										<% end %>
										</div>
										<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
										<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
									</div>
									<% end %>
									<div>
										<%= blog.content %>
								</div>

								</div>
								<div class="row-fluid" id = "accordion2" >
									<div class="span2"><span style="color: #aaaaaa;"><small><%= blog.content %></small></span></div>
									<div class="span2 offset8"  style="text-align:right;"><!-- <a href="#">Like(<%= blog.like_num%>)</a>--> <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"><small>评论(<%= blog.comment_num %>)</small></a></div>
								</div>
								<div id="collapseOne" class="collapse in" style="width:95%;margin:0 auto;">
									<div style="padding:10px"> 
										<div class="row-fluid commentbox" style="width:95%;">
											<div class="span2" style="text-align:right;padding-right:5px;"><i class="icon-user"></i> <span>user1:</span></div>
											<div class="span10" style='word-wrap:break-word; overflow:hidden'> asddddddddddd</div>
										</div>
									</div>
								</div>

							</div>
						</div><!--/.well -->

<% end %>



HTML;


}
public function post($post)
{
	$title = $post['title'];
	$content = $post['content'];
	$pubtime = $post['pubtime'];
	$like_num = $post['like_num'];
	$comment_url =$post['comment_url'];
	$comment_num = $post['comment_num'];
	$url = $post['url'];
	$operation = '';
	if($GLOBALS['LOGIN_DATA']['is_admin'] ==1)
	{
				$operation = '&nbsp;&nbsp;<a href="/deletepost/'.$post['_id'].'"><small>删除</small></a>';
				$operation .= '&nbsp;&nbsp;<a href="/editor/'.$post['_id'].'"><small>编辑</small></a>';
	}
	$html = <<<HTML
						<div class="well">
							<div class="row-fluid">
								<div class="span10">
									<h2><a href="$url">$title</a></h2>
								</div>
								<div class="span1 offset1">
									 <!-- <p><a class="btn btn-inverse btn-mini">分享</a></p> -->
								</div>
							</div>

							<!--	
							<div>
								 <small>发表于</small>
							</div>
							-->

							<div class="row-fluid" style="margin-top:20px">
								<div>
									<div style='margin-bottom:15px;'>
									<p>
										$content
									</p>
								</div>

								</div>
								<!--
								<div class="row-fluid" id = "accordion2" >
									<div class="span2"><span style="color: #aaaaaa;"><small>$pubtime</small></span></div>
									<div class="span2 offset8"  style="text-align:right;"><a href="#">Like($like_num)</a><a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"><small>评论($comment_num)</small></a></div>
								</div>
								<div id="collapseOne" class="collapse in" style="width:95%;margin:0 auto;">
									<div style="padding:10px"> 
										<div class="row-fluid commentbox" style="width:95%;">
											<div class="span2" style="text-align:right;padding-right:5px;"><i class="icon-user"></i> <span>user1:</span></div>
											<div class="span10" style='word-wrap:break-word; overflow:hidden'> asddddddddddd</div>
										</div>
									</div>
								</div>
								-->
								<div class="row-fluid" id = "accordion2" >
									<div class="span2"><span style="color: #aaaaaa;"><small>$pubtime</small></span></div>
									<div class="span2 offset8"  style="text-align:right;"><!--<a href="#">Like($like_num)</a> --><a href="$comment_url"><small>评论(<span id='cms_num'>$comment_num</span>)</small></a>$operation</div>
								</div>
							</div>
						</div><!--/.well -->
HTML;

return $html;

}
public function comment($comments,$post=array())
{
	if(!empty($GLOBALS['LOGIN_DATA']))
	{
		$login_data = $GLOBALS['LOGIN_DATA'];
		$name = '<span style="color:#993377;font-weight:bold">'.$login_data['nickName'].'</span><input type="hidden" value = "'.$login_data['nickName'].'" id="cms_name" name="cms_name">';
		$l = 2;
		$r = 7;
	}
	else
	{
		$name = "<input type='text' id='cms_name' name='cms_name' style='height:30px;' placeholder='Do not too long!!'>";
		$l =4;
		$r = 7;
	}
	$blog_id = $post['_id'];
	$html=<<<HTML
			<div class="well">
				<div class="row-fluid" style="width:95%;margin:0 auto;" id = 'comment'>
				<div id='comment_notice'></div>
					<legend>评论</legend>
					<div class="span$l">
						<label>昵称</label>
						$name
					</div>
					<div class="span$r">
						<label>评论</label>
						<textarea rows="2" id='cms_content' name='cms_content'  class='span12'  placeholder="Say something…"></textarea>
					</div>
				<div class="span2 offset9" style='text-align:right;'>
				<input type='hidden' name="blog_id" id="blog_id" value="$blog_id" />
				<button type="submit" name="cms_button" id="cms_button" class="btn btn-inverse btn-small">走你</button>
				</div>
				</div>
			<div id='cms_box' name='cms_box'>
HTML;
		if(is_array($comments) && !empty($comments))
		{
			foreach($comments as $comment)
			{
				if($GLOBALS['LOGIN_DATA']['is_admin'] ==1)
				{
					$operation = '&nbsp;&nbsp;<a href="/comment/delete/'.$comment['_id'].'"><small style="font-weight:bold;">Delete</small></a>';
				}
				$cms_pubtime = date('Y-m-d H:i',$comment['createtime']);
				switch($comment['user_type'])
				{
					case 'weibo': 
						$html .='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><img src="http://img.lxsnow.me/sys/weibo@16.png"> <span><a href="http://weibo.com/u/'.$comment['user_id'].'" target="_blank" >'.$comment['user_name'].'</a>: '.$comment['content'].'</span></div><div class="span3" style="text-align:right;"><small style="color:#999999">'.$cms_pubtime.'</small>'.$operation.'</div></div>';
						break;
					case 'renren':
						$html .='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><img src="http://img.lxsnow.me/sys/renren@16.png"> <span><a href="http://www.renren.com/'.$comment['user_id'].'/profile" target="_blank" >'.$comment['user_name'].'</a>: '.$comment['content'].'</span></div><div class="span3" style="text-align:right;"><small style="color:#999999">'.$cms_pubtime.'</small>'.$operation.'</div></div>';
						break;
					case 'instagram':
						$html .='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><img src="http://img.lxsnow.me/sys/instagram@20.png" style="max-width:16px;"> <span style="color:#993377;">'.$comment['user_name'].'</span>:<span> '.$comment['content'].'</span></div><div class="span3" style="text-align:right;"><small style="color:#999999">'.$cms_pubtime.'</small>'.$operation.'</div></div>';
						break;
					default :
						$html .='<div class="row-fluid commentbox" style="width:95%;"><div class="span9" style="text-align:left;padding-right:5px;word-wrap:break-word; overflow:hidden"><i class="icon-user"></i> <span>'.$comment['user_name'].': '.$comment['content'].'</span></div><div class="span3" style="text-align:right;"><small style="color:#999999">'.$cms_pubtime.'</small>'.$operation.'</div></div>';
						break;
				}
			}
		}
		$html .='</div></div>';
		return $html;
}

}


?>
