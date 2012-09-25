<?php
class PhotoModel{


	public function __construct() {
		$this->CmsD = new MyMongo('comment');

	}

	public function upload($files)
	{
		include(ROOT.'/weibo/config.php');
		include(ROOT.'/weibo/saetv2.ex.class.php');
		$token = '2.00BpT76C0NX5Yg7d222a6d39ef2icE';

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

	public function newCms($blog_id,$user_name,$content)
	{
		$this->CmsD->setCollection('blog_cms');
		$doc = array(
			'blog_id'=>$blog_id,
			'content'=>$content,
			'user_id'=>'',
			'user_name'=>$user_name,
			'status'=>1,
			'createtime'=>time(),
		);

		$sign = $this->CmsD->insert($doc);

		if(isset($doc['_id']))
			return self::mongoDoc2Array($doc);

		return false;
	}	

	public function getDetail($cms_id)
	{
		$this->CmsD->setCollection('blog_cms');
		$id = new MOngoId($cms_id);
		$cursor = $this->CmsD->findOne(array('_id'=>$id,'status'=>1));

		return self::mongoDoc2Array($cursor);

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
