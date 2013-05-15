<?php

class PhotoInnerPhotos extends control{


	public function checkPara(){
		$this->aid = $GLOBALS['URL_PATH'][3];
		$this->del = $_GET['del'];
		$this->page = intval($GLOBALS['URL_PATH'][4]);

		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$datas['photos'] = $photoModel->getAlbumPhotos($this->aid,$this->page);
		$datas['del'] = $this->del;
//		print_r($datas['photos']);
		echo '<div>1</div>';
		
//		$this->format($datas);
	
	}


	public function includeFiles()
	{

		include(VIEW.'/photos.php');

	}


	public function format($datas)
	{
		$data['activeHome'] = '';
		$data['activePhoto'] = 'class="active"';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		ViewPhotos::render($datas);
	}

}

?>
