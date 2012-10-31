<?php

class PhotoDelPhoto extends control{


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

		$photo = $photoModel->delPhoto($this->pid);
		if($photo['status'] == 0)
		{
			$uri = '/photo/album/'.$photo['album_id']."?del=succ";
			header("Location: $uri");
		}
		else{
			$uri = '/photo/pic/'.$photo['_id']."?del=faild";
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
