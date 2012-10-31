<?php
class ViewDustbinCms {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span11">';
		$html .= '<div class = "well">';
		$html .='<div><ul class="nav nav-pills"><li><a href="/dustbin/post">Post</a></li><li><a href="/dustbin/photo">Photos</a></li><li class="active"><a href="/dustbin/cms">Comments</a></li></ul></div>';
		if($datas['rec'] == 'succ')
		{
			$html .='<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>恢复成功!</strong></div>';
		}
		else if($datas['rec'] == 'faild')
		{
			$html .='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>恢复失败!</strong></div>';
		}
		if(is_array($datas['cms']) && !empty($datas['cms']))
		{
			$html .= '<table class="table table-hover" style="color:#7a0c7d;">';
			$html .='<tr><th style="">Content</th><th style="text-align:center;">UserName</th><th>Blog Title</th><th style="text-align:center;">Pubtime</th><th style="text-align:center;">Operation</th></tr>';
			foreach($datas['cms'] as $cms)
			{
				$cms['pubtime'] = date("Y-m-d H:i",$cms['createtime']);
				$html .= '<tr><td style="width:300px"><p style="color:#7a0c7d;">'.$cms['content'].'</p></td><td style="width:150px;text-align:center;color:#999999;">'.$cms['user_name'].'</td><td style="width:200px;text-align:center;color:#999999;">'.$cms['blogTitle'].'</td><td style="width:200px;text-align:center;color:#999999;">'.$cms['pubtime'].'</td><td style="width:80px;text-align:center;"><a href="/dustbin/recoverCms/'.$cms['_id'].'">恢复</a></td></tr>';
			}
			$html .='</table>';
		}
		else
		{
			$html .='<p style="color:#999999">没有删除的评论</p>';
		}
		$html .='</div>';
		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
