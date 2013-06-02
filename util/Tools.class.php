<?php
class Tools
{
	public function formatImgUrl($Uri)
	{
		return IMG_URL.$Uri;
	}

	public function writeLog($name,$content)
	{
		$path = LOG_PATH . $name;
		$fp = fopen($path,'w');
		fwrite($fp,$content);
		fclose($fp);	
	}
}
?>
