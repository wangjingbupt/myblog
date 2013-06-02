<?php

class EditorEditor extends control{


	public function checkPara(){
		
		$this->blog_id = trim($GLOBALS['URL_PATH'][1]);

		return true;

	}

	public function action(){

		if($this->blog_id != '')
		{
			$postModel = new PostModel();

			$datas['post'] = $postModel->getDetail($this->blog_id,0);
		}

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/editor.php');
		include(MODEL_POST."/PostModel.php");

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		
		$GLOBALS['DATA'] = $data;
		ViewEditor::render($datas);
		
	}

}

?>
