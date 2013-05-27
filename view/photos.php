<?php
class ViewPhotos {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span9"><div class = "span12">';
		if($datas['del'] == 'succ')
		{
			$html .='<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>删除成功!</strong></div>';
		}
		if(is_array($datas['photos']) && !empty($datas['photos']))
		{
			$photos = $datas['photos'];
			$album = $datas['album'];

			if(date('Y',$album['createtime']) == date('Y'))
				$album['pubtime'] = date("m-d H:i",$album['createtime']);
			else
				$album['pubtime'] = date("Y-m-d H:i",$album['createtime']);
			$html .='<div class="well"><div class="row-fluid"><div class="span8"><h2>'.$album['title'].'</h2></div><div class="span1 offset9"></div></div>';
			$html .='<div class="row-fluid" style="margin-top:20px"><div><div id="myCarousel" class="carousel slide"><div class="carousel-inner">';
			$active = 'active';
			foreach($datas['photos'] as $photo)
			{
				 $html .= '<div class="item '.$active.'" style="height:600px" ><center><a href="/photo/pic/'.$photo['_id'].'"><img  style="max-height:600px" src="'.Tools::formatImgUrl($photo['standard']).'" alt=""><div class="carousel-caption"><p>'.$photo['description'].'</p></div></center></div>';
					$active ='';
			}
			$html .='</div><a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a><a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a></div>
			<div class="row-fluid" id = "accordion2" ><div class="span2"><span style="color: #aaaaaa;"><small>'.$album['pubtime'].'</small></span></div><div class="span2 offset8"  style="text-align:right;"></div></div>
			</div></div></div>';

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
