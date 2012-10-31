<?php
include(MODEL_COMMENT."/CommentModel.php");

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

		$cms = $cmsModel->recoverCms($this->cid);
		$uri = "/dustbin/cms";
		if($cms['status'] == 1)
			$uri .='?rec=succ';
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
