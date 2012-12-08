<?php
include(MODEL_POST."/PostModel.php");

class CommentDelete extends control{


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

		$cms = $cmsModel->delCms($this->cid);
		if($cms['status'] == 0)
		{
			$postModel->decCmsNum($cms['blog_id']);
			$uri = '/detail/'.$cms['blog_id']."?del=succ";
			header("Location: $uri");
		}
		else{
			$uri = '/detail/'.$cms['blog_id']."?del=faild";
			header("Location: $uri");
			
		}
	}


	public function includeFiles()
	{
	}


	public function format($datas)
	{
	}
}

?>
