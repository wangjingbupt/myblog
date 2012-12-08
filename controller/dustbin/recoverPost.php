<?php
include(MODEL_POST."/PostModel.php");

class DustbinRecoverPost extends control{


	public function checkPara(){

		$this->pid = $GLOBALS['URL_PATH'][2];
		if($GLOBALS['LOGIN_DATA']['is_admin'] !=1 )
		{
			return false;
		}
		return true;

	}

	public function action(){
		
		
		$postModel = new PostModel();

		$post = $postModel->recoverPost($this->pid);
		$uri = "/dustbin/post";
		if($post['status'] == 1)
		{
			$postModel->incFinderNum($post['createtime']);
			$uri .='?rec=succ';
		}
	  else
			$uri .='?rec=faild';
		
		header("Location: $uri");
	
	}


	public function includeFiles()
	{
	}


	public function format($datas)
	{
	}

}

?>
