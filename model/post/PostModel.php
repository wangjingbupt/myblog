<?php
class PostModel{

	private $_postLimit = 15;

	public function __construct() {
		$this->PostD = new MyMongo('blog');

	}

	public function getPostList($page=0)
	{
		$this->PostD->setCollection('post');
		$offset = $page * $this->_postLimit;

		$cursor = $this->PostD->find(array('status'=>1));
		
		$cursor->sort(array('createtime'=>-1))->skip($offset)->limit($this->_postLimit);
		
		return self::mongoObj2Array($cursor);
	}	

	public function getFinder()
	{
		$this->PostD->setCollection('finder');
		$cursor = $this->PostD->find(array('num'=>array('$gt'=>0)));
		$cursor->sort(array('dateYM'=>-1));

		return self::mongoObj2Array($cursor);

	}

	public function getDetail($blog_id)
	{
		$this->PostD->setCollection('post');
		$id = new MOngoId($blog_id);
		$doc = $this->PostD->findOne(array('_id'=>$id,'status'=>1));

		return self::mongoDoc2Array($doc);

	}

	public function incFinderNum($pubtime)
	{
		$this->PostD->setCollection('finder');
		$dateYM_str = date("Ym",$pubtime);
		$dateYM = intval($dateYM_str);

	
		$sign = $this->PostD->update(array('dateYM'=>$dateYM,'dateYM_str'=>$dateYM_str), array('$inc' => array("num" => 1)),array('upsert'=>true));

		return $sign;

	}

	public function incCmsNum($blog_id)
	{
		$this->PostD->setCollection('post');
		$id = new MOngoId($blog_id);

		$sign = $this->PostD->update(array('_id'=>$id,'status'=>1), array('$inc' => array("comment_num" => 1)));

		return $sign;

	}

	public function newPost($title,$content,$photoList=array())
	{
		$this->PostD->setCollection('post');
		if(!empty($photoList))
			$type = 1;
		else
			$type = 2;
		$doc = array(
			'title'=>$title,
			'content'=>$content,
			'photoList'=>$photoList,
			'type'=>$type,
			'status'=>1,
			'tags'=>array(),
			'createtime'=>time(),
			'uptime'=>time(),
			'comment_num'=>0,
			'like_num'=>0,
		);

		$sign = $this->PostD->insert($doc);
		if(isset($doc['_id']))
			return self::mongoDoc2Array($doc);

		return false;
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
