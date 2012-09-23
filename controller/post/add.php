<?php

class PostAdd extends control{


	public function checkPara(){

		$this->blogTitle = $_POST['post_title'];
		$this->blogContent = $_POST['post_content']; 

		if($this->blogContent == '' )
			return false;

		if($this->blogTitle == '')
			$this->blogTitle = date('Y-m-d H:i');

		return true;

	}

	public function action(){
		
		$postModel = new PostModel();

		$data = $postModel->newPost($this->blogTitle,$this->blogContent);
		
		if($data)
		{
			$postModel->incFinderNum($data['createtime']);
			$this->display(array('code'=>'ok','data'=>$data));
		}

	}


	public function includeFiles()
	{


	}

}

?>
