<?php
include('../config/config.php');
include(CONFIG.'/db.conf.php');
include(UTIL.'/renren/RenrenRestApiService.class.php');

function connMongo($dbName='blog')
{

	$m = new Mongo(DbConf::$mongoConf);
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
        $db->authenticate(DbConf::$mongoAuth[0],DbConf::$mongoAuth[1] );
	return $db;

}

function getAdminUser($db)
{
	$c = $db->selectCollection('adminUser');
	$user = $c->findOne(array('type'=>'renren'));
	if(is_array($user) && !empty($user))
		return $user;

	return false;
}

function insertDb($db,$albums)
{
	$c = $db->selectCollection('album');
	foreach($albums as $album)
	{
		if($album['visible']!=99)
			continue;
		
		$image = downloadImg($album['url']);

		$insert = array(
			'title'=>$album['name'],
			'photo_num'=>intval($album['size']),
			'createtime'=>@strtotime($album['create_time']),
			'uptime'=>@strtotime($album['update_time']),
			'cover_img'=>$image,
			'type'=>'renren',
			'renren_id'=>$album['aid'],
			'status'=>1,

		);
		$sign = $c->insert($insert);
		if(isset($insert['_id']))
			continue;
		
		return false;
	}
	echo 'ok';
	return true;

}
function downloadImg($url)
{
	if($url =="")
		return '';
	$imgurl = '';
	$fileDir = ROOT.'/../images/snowblog/';
	$file = @file_get_contents($url);
	if($file)
	{
		$arr = explode('/',$url);
		$num = count($arr)-1;
		$filePath = $fileDir.'thumb/renren_'.$arr[$num];
		$imgurl = '/thumb/renren_'.$arr[$num];
		@file_put_contents($filePath,$file);
	}
	return $imgurl;
}

function getAlbums($db)
{

	$c = $db->selectCollection('album');
	$cursor = $c->find(array('type'=>'renren'));	
	return mongoObj2Array($cursor);
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

function getRenrenAlbums($token,$uid)
{

	$rrObj = new RenrenRestApiService;

	$count = 20;
	$albums=array();
	$page = 1;

	while(1)
	{
		$params = array('uid'=>$uid,'page'=>$page,'count'=>$count,'access_token'=>$token);
		$res = $rrObj->rr_post_curl('photos.getAlbums', $params);
		if(isset($res['error_code']))
			break;
		
	  $albums = array_merge($albums,$res);
		if(count($res) <$count)
			break;
		
		$page++;
	}
	return $albums;

}

function getInsertData($photos,$likes)
{
	if(empty($photos))
	{
		return $likes;
	}
	$ls =array();

	foreach($likes as $like)
	{
		foreach($photos as $photo)
		{
			if($photo['renren_id'] == $like['aid'])
			{
				$flag = true;
				break;
			}
		}
		if($flag == false)
			$ls[] = $like;

		$flag = false;
		
	}
	return $ls;
}

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


is_start();
$db = connMongo();
$user = getAdminUser($db);
if(empty($user) || !is_array($user))
	exit;

$token = $user['token'];
$uid = $user['uid'];
//$token ='213266|6.55e60c6ab44be3b7a2e39840715c06d0.2592000.1351494000-342198441';
//$uid = 342198441;
//$uid = 236512134;
$db = connMongo('photo');

$albums = getAlbums($db);
if(!is_array($albums))
	$albums = array();
//print_r($albums);
//exit;

$renren = getRenrenAlbums($token,$uid);
if(is_array($renren) && !empty($renren))
{
	$ls = getInsertData($albums,$renren);
	if(is_array($ls) && !empty($ls))
	{
		insertDb($db,$ls);
	}
}






?>
