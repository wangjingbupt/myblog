<?php
class ViewPhoto {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span9"><div class = "span12">';
		if($datas['del'] == 'faild')
		{
			$html .='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>删除失败!</strong></div>';
		}

		if(is_array($datas['photo']) && !empty($datas['photo']))
		{
			$photo = $datas['photo'];
			$album = $datas['album'];

			$operation = '';
			if($GLOBALS['LOGIN_DATA']['is_admin'] ==1)
			{
				$operation = '<a href="/photo/deletepic/'.$photo['_id'].'">删除</a>';
			}

			$photo['pubtime'] = date("Y-m-d H:i",$photo['createtime']);
			$html .='<div class="well"><div class="row-fluid"><div class="span8"><h2><a href="/photo/album/'.$album['_id'].'">'.$album['title'].'</a></h2></div><div class="span1 offset9"></div></div>';
			$html .='<div class="row-fluid" style="margin-top:20px"><div><div id="myCarousel" class="carousel slide"><div class="carousel-inner">';
			$html .= '<div class="item active" style="height:680px" ><center><img  style="max-height:600px" src="'.Tools::formatImgUrl($photo['standard']).'" alt=""><div class="carousel-caption"><p>'.$photo['description'].'</p></div></center></div>';
			$html .='</div>';
			$html .='</div>';
			$html .='<div class="row-fluid" id = "accordion2" ><div class="span2"><span style="color: #aaaaaa;"><small>'.$photo['pubtime'].'</small></span></div><div class="span2 offset8"  style="text-align:right;font-weight:bold;">'.$operation.'</div></div></div></div></div>';

		}
		$html .='</div></div>';
		$html .='<div class="span3">'; 
		if(is_array($datas['albums']) && !empty($datas['albums']))
		{
				foreach($datas['albums'] as $album)
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
