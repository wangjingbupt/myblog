<?php
include(MODEL_PHOTO."/PhotoModel.php");

class DustbinPhoto extends control{


	public function checkPara(){

		$this->page = intval($GLOBALS['URL_PATH'][2]);
		$this->rec = $_GET['rec'];

		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$datas['photos'] = $photoModel->getDelPhotos($this->page);
		if(!is_array($datas['photos']))
		{
			$datas['photos'] = array();
		}
		foreach($datas['photos'] as &$photo)
		{
			$aid = $photo['album_id'];
			if(!is_array($datas['album'][$aid]) or empty($datas['album'][$aid]))
				$datas['album'][$aid] = $photoModel->getAlbum($aid);

		  $photo['albumTitle'] = $datas['album'][$aid]['title'];

		}
		$datas['rec'] = $this->rec;
		
		$this->format($datas);
	
	}


	public function includeFiles()
	{

		include(VIEW_DUSTBIN.'/photos.php');

	}


	public function format($datas)
	{
		$data['activeHome'] = '';
		$data['activePhoto'] = 'class="active"';
		$data['activeWeibo'] = '';
		$data['script'] = <<<HTML
			<script type='text/javascript' src='/assets/js/jquery.masonry.min.js'></script>
			<script type="text/javascript">
													function sleep(n) { 
														var start = new Date().getTime(); 
														while(true)  if(new Date().getTime()-start > n) break; 
													}
													window.onload = function(){
			$(function(){
				$('#photos').masonry({
					itemSelector : '.col',
				});
			});
														
													}
			</script>
			<script type="text/javascript">
			
			//$(function(){
				//$('#photos').masonry({
					//itemSelector : '.col',
			//	});
			//});
			</script>
HTML;
		$GLOBALS['DATA'] = $data;
		ViewDustbinPhoto::render($datas);
	}

}

?>
