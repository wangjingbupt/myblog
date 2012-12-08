<?php
include(MODEL_COMMENT."/CommentModel.php");
include(MODEL_POST."/PostModel.php");

class DustbinCms extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][2]);
		$this->rec = $_GET['rec'];

		return true;

	}

	public function action(){
		$cmsModel = new CommentModel();
		$postModel = new PostModel();
		$datas['cms'] = $cmsModel->getDelCms($this->page);
		$datas['rec'] = $this->rec;
		if(is_array($datas['cms']) && !empty($datas['cms']))
		{
			foreach($datas['cms'] as &$cms)
			{
				$pid = $cms['blog_id'];
				if(!is_array($datas['post'][$pid]) or empty($datas['post'][$pid]))
				{
					$datas['post'][$pid] = $postModel->getDetail($pid);
				}
				$cms['blogTitle'] = $datas['post'][$pid]['title'];

			}
		}
//	print_r($datas);
//exit;


		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW_DUSTBIN.'/cms.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		ViewDustbinCms::render($datas);
		
		
		
		//print_r($datas);
	}

}
?>
