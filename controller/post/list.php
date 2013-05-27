<?php

class PostList extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][1]);

		return true;

	}

	public function action(){
		$postModel = new PostModel();
		$datas['post'] = $postModel->getPostList($this->page);
		$postNum = $postModel->getPostCount();
		if($postNum > POST_PAGE_NUM * ($this->page+1))
			$datas['hasNext'] = $this->page+1;

		if($this->page > 0)
			$datas['hasPrev'] = $this->page-1;

		$datas['recent'] = $postModel->getPostList();

		$datas['finder'] = $postModel->getFinder();

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
