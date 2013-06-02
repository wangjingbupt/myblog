<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');

function checkTags()
{
	$path = LOG_PATH . 'tags'; 
	$fp = fopen($path,'r');
	$sign = fread($fp,4096);
	fclose($fp);
	if($sign == '1')
		return true;
	else
		return false;

}

function doneTags()
{
	$path = LOG_PATH . 'tags'; 
	$fp = fopen($path,'w');
	$sign = fwrite($fp,'0');
	fclose($fp);
}

function connMongo($dbName = 'blog')
{

	$m = new Mongo(DbConf::$mongoConf);
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
        $db->authenticate(DbConf::$mongoAuth[0],DbConf::$mongoAuth[1] );
	return $db;

}

function getPosts($db)
{
	$c = $db->selectCollection('post');
	$cursor = $c->find(array('status'=>1));
	
	return mongoObj2Array($cursor);
}

function makeTags($posts)
{	
	$tags =array();
	foreach($posts as $post)
	{
		if(!empty($post['tags']))
		{
			foreach($post['tags'] as $tag)
			{
				if($tag['name'] != '')
					$tags[$tag['name']] +=1;	
			}
		}
		
	}

	return $tags;

}


function updateTags($db,$tags)
{
	$c = $db->selectCollection('tags');
	foreach($tags as $k=>$v)
	{
		$insert = array(
			'name'	=> $k,
			'num'		=> $v,	
		);

		$sign = $c->update(array('name'=>$k),$insert,array('upsert'=>true));

	}
	echo 'ok';
	return true;

}

function mongoObj2Array($cursor)
{
	$res = array();
	foreach($cursor as $doc)
	{   
		$doc['_id'] = $doc['_id']->__toString();
		$res[] = $doc;
	}   
	return $res;
}



is_start();
$sign = checkTags();
if(!$sign)
	exit;
$db = connMongo('blog');
$posts = getPosts($db);
if(empty($posts))
	exit;

$tags = makeTags($posts);
print_r($tags);
//exit;
if(empty($tags))
	exit;
updateTags($db,$tags);
doneTags();


function is_start($key="",$file="")
{
	global  $argv ;
	if ($key!= "")
	{
		$s = "ps auwwx | grep '". $argv[0] ." "  . $key  . "' | grep -v grep | grep -v vi | grep -v '/bin/sh' | wc -l";
	}
	else
	{
		$s = "ps auwwx | grep '". $argv[0] . "' | grep -v grep | grep -v vi | grep -v '/bin/sh' | wc -l";
	}

	$handle = popen($s, "r");
	if($handle)
	{
		$num = fread($handle, 1024);
	}
	else
	{
		exit ;
	}
	pclose($handle);
	if($num  > 1)
	{
		exit ;
		return false ;
	}
	return true ;
}

?>
