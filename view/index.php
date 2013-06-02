<?php
include(VIEW.'/post.php');
class ViewIndex {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span9"><div class = "span12">';
		if(is_array($datas['post']) && !empty($datas['post']))
		{
			foreach($datas['post'] as $post)
			{
				if(date('Y',$post['createtime']) == date('Y'))
					$post['pubtime'] = date("m-d H:i",$post['createtime']);
				else
					$post['pubtime'] = date("Y-m-d H:i",$post['createtime']);

				$post['url'] = '/detail/'.$post['_id'];
				$post['comment_url'] = '/detail/'.$post['_id'].'#comment';

				$html .= ViewPost::post($post);
			}
		}
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/page/'.intval($datas['hasPrev']).'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/page/'.intval($datas['hasNext']).'">Next</a></li>';
		}
		$html .='</ul></div>';

		$html .='</div></div>';
		$html .='<div class="span3">'; 
		if(is_array($datas['recent']) && !empty($datas['recent']))
		{
				foreach($datas['recent'] as $post)
				{
					if($count++ <10)
					{
						//if(mb_strlen($post['title'],'utf-8') > 8)
						//$title = mb_substr($post['title'],0,7,'utf-8').'..';
						//else
						$title = $post['title'];
						$pubtime = date("y-m-d",$post['createtime']);
						$url = '/detail/'.$post['_id'];
						//$pubtime = $post['pubtime'];
						$recentList .= <<<HTML
							<tr>
							<td style='width:70%;'><a href="$url">$title</a></td>
							<td style='width:30%;'><span style = 'color:#999999;font-size:9px;'>$pubtime</span></td>
							</tr>	
HTML;
					}
				}

			$html .= <<<HTML
				<div class="well">
				<h5>
				最近发表的文章
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

		if(is_array($datas['finder']) && !empty($datas['finder']))
		{
			$html .= '<div class="well"><ul class="nav nav-tabs nav-stacked"><li><h5>归档</h5></li>';	
			foreach($datas['finder'] as $line)
			{
				$name = $line['dateYM_str'];
				$url ='/finder/'.$line['dateYM'];
				$html .='<li><a href="'.$url.'">'.$name.' ('.$line['num'].')</a></li>';
			}
			$html .= '</ul></div>';
		}

		if(is_array($datas['tags']) && !empty($datas['tags']))
		{
			$style = array('text-success','text-error','text-warning','text-info');

			foreach($datas['tags'] as $tag)
			{
				$tagName = $tag['name'];
				$class = $style[rand(0,3)];
				$tags .="<a href='/tag/$tagName' class='$class' >$tagName</a> "; 
			}

			$html .= '<div class="well"><h5>TAG</h5><div class="row-fluid"><div style="word-wrap:break-word;font-size:20px;line-height:38px">'.$tags.'</div></div></div>';
		}

		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
