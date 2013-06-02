<?php

class PostAdd extends control{


	public function checkPara(){

		$this->blogTitle = $_POST['post_title'];
		$this->blogContent = $_POST['post_content']; 
		$this->blogDate = $_POST['post_date'];
		$this->blogTags = $_POST['post_tags'];
		
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

		$tags = array();
		if( $this->blogTags != '')
		{
			$tags = explode(',',$this->blogTags);
			$tags = array_unique($tags);
			foreach($tags as $t)
			{
				$tempTags[]=array('name'=>$t);
			}
			$tags = $tempTags;
		}

		$data = $postModel->newPost($this->blogTitle,$this->blogContent,$this->blogDate,$tags);
		
		if($data)
		{
			$postModel->incFinderNum($data['createtime']);
			$this->display(array('code'=>'ok','data'=>$data));
		}
		Tools::writeLog('tags','1');

	}


	public function includeFiles()
	{


	}

}

?>
