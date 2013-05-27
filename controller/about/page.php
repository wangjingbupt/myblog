<?php

class AboutPage extends control{


	public function checkPara(){

		return true;

	}

	public function action(){

		$this->format($datas);
	}


	public function includeFiles()
	{

		include(VIEW.'/about.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = '';
		$data['activeAbout'] = 'class="active"';
		$GLOBALS['DATA'] = $data;
		ViewAbout::render();
	}

}

?>
