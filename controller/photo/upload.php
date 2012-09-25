<?php

class PhotoUpload extends control{


	public function checkPara(){

		if(empty($_FILES))
			return false;
		$this->ac = $GLOBALS['URL_PATH'][2];
		if($this->ac == 1)
		{
			$this->files =array(
					'name' => $_FILES['files']['name'][0],
					'type' => $_FILES['files']['type'][0],
					'tmp_name' => $_FILES['files']['tmp_name'][0],
					'error' => $_FILES['files']['error'][0],
					'size' => $_FILES['files']['size'][0],
			
			); 
		}
		else
			$this->files = $_FILES['imgFile'];


		return true;

	}

	public function action(){
		
		
		$photoModel = new PhotoModel();

		$res = $photoModel->upload($this->files);

		if($res != false)
		{
			if($this->ac ==1)
			{
				$ret[] =array(
					'name'=> $this->files['name'],
					'size'=> $this->files['size'],
					'type'=> $this->files['type'],
					'url' => $res['original_pic'],
					'thumbnail_url' => $res['thumbnail_pic'],
				);	
				$this->display($ret);
			}
			else
			{
				echo $res['original_pic'];
			}
		}
	}


	public function includeFiles()
	{


	}

}

?>
