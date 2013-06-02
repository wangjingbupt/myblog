<?php
include(VIEW.'/post.php');
class ViewEditor {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];
		if(!empty($datas['post']))
		{
			$post = $datas['post'];
			$post_id = $post['_id'];
			$title = $post['title'];
			$date = date('Y-m-d H:i:s',$post['createtime']);
		}

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');
		include(VIEW.'/sinaBlogEditor.php');
		$html .= ViewPost::post($post);
		echo $html;

			
		include(VIEW.'/footer.php');
	}


}
?>
