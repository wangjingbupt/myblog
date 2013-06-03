<?php

class PostTag extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][2]);
		$this->tag = urldecode($GLOBALS['URL_PATH'][1]);

		if($this->tag=='')
			return false;

		return true;

	}

	public function action(){
		$postModel = new PostModel();
		$datas['post'] = $postModel->getPostByTag($this->tag,$this->page);
		$postNum = $postModel->getTagPostCount($this->tag);
		if($postNum > POST_PAGE_NUM * ($this->page+1))
			$datas['hasNext'] = $this->page+1;

		if($this->page > 0)
			$datas['hasPrev'] = $this->page-1;

		$datas['recent'] = $postModel->getPostByTag($this->tag,0);

		$datas['finder'] = $postModel->getFinder();
		$datas['tags']   = $postModel->getTags();

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/index.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		ViewIndex::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
