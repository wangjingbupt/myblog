<?php
include(CONFIG.'/db.conf.php');

class MyMongo{
	
	public function __construct($db = 'blog', $collection = '') {
		$this->db = DbConf::$BDprefix."_".$db	;
		$this->collection = $collection;
		$this->handler = new Mongo(DbConf::$mongoConf);
	
	}

	public function setDB($db)
	{
		$this->db = DbConf::$BDprefix."_".$db ;
		return true;
	}

	public function setCollection($collection)
	{
		$this->collection = $collection;
	}

	public function getDbHandler()
	{
		$this->dbHandler = $this->handler->selectDB($this->db);
	//	$this->dbHandler->authenticate(DbConf::$mongoAuth[0], DbConf::$mongoAuth[1]);
		return $this->dbHandler;
	}

	public function getColHandler()
	{
		if(!$this->dbHandler)
			$this->getDbHandler();

		$this->colHandler = $this->dbHandler->selectCollection($this->collection);
		return $this->colHandler;

	}


	public function findOne($param)
	{
		$this->getColHandler();

		return $this->colHandler->findOne($param);
	}

	public function find($param)
	{
		$this->getColHandler();

		return $this->colHandler->find($param);
	}

	public function insert($doc)
	{
		$this->getColHandler();
		return $this->colHandler->insert($doc);
	}

	public function update($param,$update,$op=array())
	{
		$this->getColHandler();
		return $this->colHandler->update($param,$update,$op);
	}


}



?>
