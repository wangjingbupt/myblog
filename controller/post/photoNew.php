<?php

class PostPhotoNew extends control{


	public function checkPara(){
		
		return true;
	}

	public function action(){

		$this->format();

	}


	public function includeFiles()
	{

		include(VIEW.'/photoNew.php');

	}
	
	public function format($datas=array())
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';

		$data['header']= <<<HTML
			<meta name="viewport" content="width=device-width">
			<link rel="stylesheet" href="/assets/css/style.css">
			<link rel="stylesheet" href="/assets/css/jquery.fileupload-ui.css">
HTML;
		$data['script'] = <<<HTML

HTML;
		$GLOBALS['DATA'] = $data;
		ViewPhotoNew::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
