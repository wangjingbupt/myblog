<?php
class CommentModel{

	
	private $_cmsDelLimit = 20;

	public function __construct() {
		$this->CmsD = new MyMongo('comment');

	}

	public function getCmsList($blog_id)
	{
		$this->CmsD->setCollection('blog_cms');

		$cursor = $this->CmsD->find(array('status'=>1,'blog_id'=>$blog_id));
		
		$cursor->sort(array('createtime'=>-1));
		
		return self::mongoObj2Array($cursor);
	}	

	public function newCms($blog_id,$user_name,$content,$uid,$user_type)
	{
		$this->CmsD->setCollection('blog_cms');
		$doc = array(
			'blog_id'=>$blog_id,
			'content'=>$content,
			'user_id'=>$uid,
			'user_name'=>$user_name,
			'status'=>1,
			'user_type'=>$user_type,
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
	
	public function getDelCms($page=0)
	{

		$this->CmsD->setCollection('blog_cms');
		$offset = $page * $this->_cmsDelLimit;
		$cursor = $this->CmsD->find(array('status'=>0));
		$cursor->sort(array('createtime'=>-1))->skip($offset)->limit($this->_cmsDelLimit);
		return self::mongoObj2Array($cursor);
	}


	public function delCms($cid)
	{

		$this->CmsD->setCollection('blog_cms');
		$id =new MOngoId($cid); 

		$doc = $this->CmsD->findOne(array('_id'=>$id));
		$doc['status'] =0;
		$this->CmsD->update(array('_id' => $doc['_id']), $doc);
		
		return self::mongoDoc2Array($doc);

	}

	public function recoverCms($cid)
	{

		$this->CmsD->setCollection('blog_cms');
		$id =new MOngoId($cid); 

		$doc = $this->CmsD->findOne(array('_id'=>$id));
		$doc['status'] =1;
		$this->CmsD->update(array('_id' => $doc['_id']), $doc);
		
		return self::mongoDoc2Array($doc);

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
