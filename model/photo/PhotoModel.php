<?php
class PhotoModel{


	public function __construct() {
		$this->CmsD = new MyMongo('comment');

	}

	public function upload()
	{
		include(ROOT.'/weibo/config.php');
		include(ROOT.'/weibo/saetv2.ex.class.php');
		$token = '2.00BpT76C0NX5Yg7d222a6d39ef2icE';

		$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token );

		if (!is_uploaded_file($_FILES['imgFile']['tmp_name']))
			return false;

		$tmpdir = '/tmp/img/';

		$tmpFile = $tmpdir.time().'_'. $_FILES['imgFile']['name'];

		if (!move_uploaded_file($_FILES['imgFile']['tmp_name'],$tmpFile))

		$ret = $c->upload('test1'.time(), $tmpFile );
		
		echo $ret['original_pic'];
		var_dump($ret);
		return ;
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
