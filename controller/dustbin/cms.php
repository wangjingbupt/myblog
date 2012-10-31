<?php
include(MODEL_COMMENT."/CommentModel.php");

class DustbinCms extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][2]);
		$this->rec = $_GET['rec'];

		return true;

	}

	public function action(){
		$cmsModel = new CommentModel();
		$datas['cms'] = $cmsModel->getDelCms($this->page);
		$datas['rec'] = $this->rec;
//		print_r($datas);exit;


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
