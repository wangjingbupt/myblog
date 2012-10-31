<?php
include(VIEW.'/post.php');
class ViewDustbinPhoto {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span11">';
		$html .= '<div class = "well">';
		$html .='<div><ul class="nav nav-pills"><li><a href="/dustbin/post">Post</a></li><li class="active"><a href="/dustbin/photo">Photos</a></li><li><a href="/dustbin/cms">Comments</a></li></ul></div>';
		if($datas['rec'] == 'succ')
		{
			$html .='<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>恢复成功!</strong></div>';
		}
		else if($datas['rec'] == 'faild')
		{
			$html .='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>恢复失败!</strong></div>';
		}
		if(is_array($datas['photos']) && !empty($datas['photos']))
		{
			$html .= '<table class="table table-hover" style="color:#7a0c7d;">';
			$html .='<tr><th style="text-align:center;">Photo</th><th>Description</th><th>Album</th><th style="text-align:center;">Pubtime</th><th style="text-align:center;">Operation</th></tr>';
			foreach($datas['photos'] as $photo)
			{
				$photo['pubtime'] = date("Y-m-d H:i",$photo['createtime']);
				$html .= '<tr><td style="width:120px;text-align:center;"><img style="max-width:100px" src="'.Tools::formatImgUrl($photo['thumb']).'" alt=""></td><td style="width:400px"><p style="color:#7a0c7d;">'.$photo['description'].'</p></td><td style="width:200px;"><p style="color:#7a0c7d;font-weight:bold;">'.$photo['albumTitle'].'</p></td><td style="width:120px;text-align:center;color:#999999;">'.$photo['pubtime'].'</td><td style="width:80px;text-align:center;"><a href="/dustbin/recoverPhoto/'.$photo['_id'].'">恢复</a></td></tr>';
			}
			$html .='</table>';
		}
		else
		{
			$html .='<p style="color:#999999">没有删除的照片</p>';
		}
		$html .='</div>';
		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
