<?php
class PhotoModel{


	public function __construct() {
		$this->PhotoD = new MyMongo('photo');

	}

	public function upload($files)
	{
		include(ROOT.'/weibo/config.php');
		include(ROOT.'/weibo/saetv2.ex.class.php');
		$token = '2.00BpT76C0NX5Yg03649a3e010NxkyI';

		$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token );

		if (!is_uploaded_file($files['tmp_name']))
			return false;

		$tmpFile = UPLOAD_TMP_DIR . $files['name'];

		if (!move_uploaded_file($files['tmp_name'],$tmpFile))
			return false;

		list($m,$s) =explode(' ',microtime());
		$status = '分享图片'.($s+$m);

		$ret = $c->upload($status, $tmpFile );

		@unlink($tmpFile);

		if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) 
			return false;

		$thumb_pic = file_get_contents($ret['thumbnail_pic']);
		$thumb_file = IMG_PATH . 'thumb/'.$ret['id'].'_'.$files['name'];
		if($thumb_pic)
		{
			@file_put_contents($thumb_file,$thumb_pic);
			$pic['thumbnail_pic'] = IMG_URL . 'thumb/'.$ret['id'].'_'.$files['name'];
		}
			
		$bmiddle_pic = file_get_contents($ret['bmiddle_pic']);
		$bmiddle_file = IMG_PATH . 'bmiddle/'.$ret['id'].'_'.$files['name'];
		if($bmiddle_pic)
		{
			file_put_contents($bmiddle_file,$bmiddle_pic);
			$pic['bmiddle_pic'] = IMG_URL . 'bmiddle/'.$ret['id'].'_'.$files['name'];
		}

		$original_pic = file_get_contents($ret['original_pic']);
		$original_file = IMG_PATH . 'original/'.$ret['id'].'_'.$files['name'];
		if($original_pic)
		{
			file_put_contents($original_file,$original_pic);
			$pic['original_pic'] = IMG_URL . 'original/'.$ret['id'].'_'.$files['name'];
		}

		
		return $pic;
	}	

	public function getAlbumList()
	{
		$this->PhotoD->setCollection('album');

		$cursor = $this->PhotoD->find(array('status'=>1));
		
		$cursor->sort(array('createtime'=>-1));
		
		return self::mongoObj2Array($cursor);
		
	}

	public function getAlbum($aid)
	{
		$this->PhotoD->setCollection('album');
		$id =new MOngoId($aid); 
		$doc = $this->PhotoD->findOne(array('status'=>1,'_id'=>$id));
		
		return self::mongoDoc2Array($doc);
		
	}

	public function getAlbumPhotos($aid)
	{
		$this->PhotoD->setCollection('photos');

		$cursor = $this->PhotoD->find(array('status'=>1,'album_id'=>$aid));
		
		$cursor->sort(array('createtime'=>-1));
		
		return self::mongoObj2Array($cursor);
		
	}

	public function mongoObj2Array($cursor)
	{
		$res = array();
		foreach($cursor as $doc)
		{
			$doc['_id'] = $doc['_id']->__toString();
			$res[] = $doc;
		}
		return $res;
	}

	public function mongoDoc2Array($doc)
	{
		$doc['_id'] = $doc['_id']->__toString();
		return $doc;	
	}
	
	
	
	
}




?>
