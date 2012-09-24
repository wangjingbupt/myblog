<?php

class PhotoUpload extends control{


	public function checkPara(){

		print_r($_FILES);
		if(empty($_FILES))
			return false;

		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$res = $photoModel->upload();
		print_r($res);

	}


	public function includeFiles()
	{


	}

}

?>
