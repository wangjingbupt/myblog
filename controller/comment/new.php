<?php

class CommentNew extends control{


	public function checkPara(){
		
		$this->blogId = $_POST['blog_id'] ;
		$this->userName = $_POST['cms_name'];
		$this->cmsContent = $_POST['cms_content']; 
		if($this->blogId == '' || $this->cmsContent == '' )
			return false;

		return true;

	}

	public function action(){
		$cmsModel = new CommentModel();

		$data = $cmsModel->newCms($this->blogId,$this->userName,$this->cmsContent);

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
