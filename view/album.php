<?php
class ViewAlbum {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span9"><div id = "photos">';
		if(is_array($datas['album']) && !empty($datas['album']))
		{
			foreach($datas['album'] as $album)
			{
				if(date('Y',$album['createtime']) == date('Y'))
					$album['pubtime'] = date("m-d H:i",$album['createtime']);
				else
					$album['pubtime'] = date("Y-m-d H:i",$album['createtime']);
				if($album['type'] == 'renren')
					$icon = '<span style="margin-right:5px;"><img src="http://img.lxsnow.me/sys/renren@16.png"></span>';
				else if($album['type'] == 'instagram')
					$icon = '<span style="margin-right:5px;"><img src="http://img.lxsnow.me/sys/instagram@20.png" style="max-width:16px;"></span>';
				$album['url'] = '/photo/album/'.$album['_id'];
				$html .='<div class="col">
					<div class = "well" style ="padding:0;margin:0">
					<div>
					<a href="'.$album['url'].'" ><img src="'.Tools::formatImgUrl($album['cover_img']).'" class="img-rounded" /></a>
					</div>
					<div>
						<span style="margin-left:8px;margin-top:4px;color:#993377;font-weight:bold">'. $icon .$album['title'].' ('.$album['photo_num'].')</span>
					</div>
					</div></div>';

			}
		}
		$html .='</div></div>';
		$html .='<div class="span3">'; 
		if(is_array($datas['album']) && !empty($datas['album']))
		{
				foreach($datas['album'] as $album)
				{
						if(mb_strlen($album['title'],'utf-8') > 8)
							$title = mb_substr($album['title'],0,7,'utf-8').'..';
						else
							$title = $album['title'];
						$pubtime = date("y-m-d",$album['createtime']);
						$url = '/photo/album/'.$album['_id'];
						//$pubtime = $post['pubtime'];
						$recentList .= <<<HTML
							<tr>
							<td style='width:70%;'><a href="$url">$title</a></td>
							<td style='width:30%;'><span style = 'color:#999999;font-size:9px;'>$pubtime</span></td>
							</tr>	
HTML;
				}

			$html .= <<<HTML
				<div class="well">
				<h5>
				相册列表
				</h5>
				<div class="row-fluid">
				<div class = "span11">
				<table class="table table-condensed">
				$recentList	
				</table>
				</div>
				</div>
				</div>

HTML;

		}

		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
