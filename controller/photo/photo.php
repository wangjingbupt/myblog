<?php

class PhotoPhoto extends control{


	public function checkPara(){

		$this->pid = $GLOBALS['URL_PATH'][2];
		$this->del = $_GET['del'];


		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$datas['photo'] = $photoModel->getPhoto($this->pid);
		if(is_array($datas['photo']) && !empty($datas['photo']))
		{
			$this->aid = $datas['photo']['album_id'];
			$datas['album'] = $photoModel->getAlbum($this->aid);
		}
		$datas['albums'] = $photoModel->getAlbumList();
		$datas['del'] = $this->del;
		
		$this->format($datas);
	
	}


	public function includeFiles()
	{

		include(VIEW.'/photo.php');

	}


	public function format($datas)
	{
		$data['activeHome'] = '';
		$data['activePhoto'] = 'class="active"';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		ViewPhoto::render($datas);
	}

}

?>
