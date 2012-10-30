<?php

class PhotoAlbum extends control{


	public function checkPara(){

		$this->page = intval($GLOBALS['URL_PATH'][2]);

		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$datas['album'] = $photoModel->getAlbumList($this->page);
		
		$this->format($datas);
	
	}


	public function includeFiles()
	{

		include(VIEW.'/album.php');

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
		ViewAlbum::render($datas);
	}

}

?>
