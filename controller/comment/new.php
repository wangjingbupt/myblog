<?php

class CommentNew extends control{


	public function checkPara(){
		
		if(!empty($GLOBALS['LOGIN_DATA']))
		{
			$login_data = $GLOBALS['LOGIN_DATA'];
			$this->userName = $login_data['nickName'];
			$this->uid = $login_data['uid'];
			$this->user_type = $login_data['login_type'];
		}
		else{
			
			$this->userName = $_POST['cms_name'];
			$this->uid = 0;
			$this->user_type = 'normal';
		}

		$this->blogId = $_POST['blog_id'] ;
		$this->cmsContent = $_POST['cms_content']; 
		if($this->blogId == '' || $this->cmsContent == '' )
			return false;

		return true;

	}

	public function action(){
		$cmsModel = new CommentModel();

		$data = $cmsModel->newCms($this->blogId,$this->userName,$this->cmsContent,$this->uid,$this->user_type);

		if($data)
		{
			$postModel = new PostModel();
			$postModel->incCmsNum($this->blogId);

			$data['pubtime'] = date('Y-m-d H:i',$data['createtime']);
			$this->display(array('code'=>'ok','data'=>$data));
		}

	}


	public function includeFiles()
	{
			include(MODEL_POST."/PostModel.php");

	}
	

}

?>
