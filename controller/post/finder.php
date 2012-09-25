<?php

class PostFinder extends control{


	public function checkPara(){
		
		$this->date = $GLOBALS['URL_PATH'][1];
		$this->page = intval($GLOBALS['URL_PATH'][2]);

		return true;

	}

	public function action(){
		$postModel = new PostModel();
	
		$datas['post'] = $postModel->getFinderList($this->date,$this->page);

		$datas['finder'] = $postModel->getFinder();

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/finder.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		ViewFinder::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
