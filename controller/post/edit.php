<?php

class PostEdit extends control{


	public function checkPara(){

		$this->blogTitle = $_POST['post_title'];
		$this->blogContent = $_POST['post_content']; 
		$this->blogDate = $_POST['post_date'];
		$this->blogId = $_POST['post_id'];
		
		if($GLOBALS['LOGIN_DATA']['is_admin'] !=1 )
		{
			return false;
		}

		if($this->blogContent == '' )
			return false;

		if($this->blogTitle == '')
			$this->blogTitle = date('Y-m-d H:i');

		return true;

	}

	public function action(){
		
		$postModel = new PostModel();

		$data = $postModel->editPost($this->blogId,$this->blogTitle,$this->blogContent,$this->blogDate);
		
		if($data)
		{
			$this->display(array('code'=>'ok','data'=>$data));
		}

	}


	public function includeFiles()
	{


	}

}

?>
