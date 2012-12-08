<?php
include(MODEL_COMMENT."/CommentModel.php");
include(MODEL_POST."/PostModel.php");

class DustbinRecoverCms extends control{


	public function checkPara(){

		$this->cid = $GLOBALS['URL_PATH'][2];
		if($GLOBALS['LOGIN_DATA']['is_admin'] !=1 )
		{
			return false;
		}
		return true;

	}

	public function action(){
		
		
		$cmsModel = new CommentModel();
		$postModel = new PostModel();

		$cms = $cmsModel->recoverCms($this->cid);
		$uri = "/dustbin/cms";
		if($cms['status'] == 1)
		{
			$postModel->incCmsNum($cms['blog_id']);
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
