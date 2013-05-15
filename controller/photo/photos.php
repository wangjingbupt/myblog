<?php

class PhotoPhotos extends control{


	public function checkPara(){

		$this->aid = $GLOBALS['URL_PATH'][2];
		$this->del = $_GET['del'];

		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$datas['photos'] = $photoModel->getAlbumPhotos($this->aid);
		$datas['albums'] = $photoModel->getAlbumList();
		$datas['album'] = $photoModel->getAlbum($this->aid);
		$datas['del'] = $this->del;
		
		$datas['album']['total_page'] = intval($datas['album']['photo_num']/ALBUM_PHOTO_LIMIT);
		
		$this->format($datas);
	
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
