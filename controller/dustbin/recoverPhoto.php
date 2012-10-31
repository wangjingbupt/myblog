<?php
include(MODEL_PHOTO."/PhotoModel.php");

class DustbinRecoverPhoto extends control{


	public function checkPara(){

		$this->pid = $GLOBALS['URL_PATH'][2];
		if($GLOBALS['LOGIN_DATA']['is_admin'] !=1 )
		{
			return false;
		}
		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$photo = $photoModel->recoverPhoto($this->pid);
		$uri = "/dustbin/photo";
		if($photo['status'] == 1)
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
