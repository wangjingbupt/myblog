<?php
include('../config/config.php');
include(CONFIG.'/db.conf.php');
include(UTIL.'/renren/RenrenRestApiService.class.php');

function connMongo($dbName='blog')
{

	$m = new Mongo();
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
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

function insertDb($db,$photos,$id)
{
	$c = $db->selectCollection('photos');
	foreach($photos as $photo)
	{
		$standard = downloadLargeImg($photo['url_large']);
		$main = downloadMainImg($photo['url_main']);
		$thumb = downloadImg($photo['url_head']);


		$insert = array(
			'album_id'=>$id,
			'createtime'=>@strtotime($photo['time']),
			'thumb' =>$thumb,
			'standard' =>$standard,
			'low'=>$main,
			'renren_id' =>strval($photo['pid']),
			'description'=>$photo['caption'],
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

function downloadMainImg($url)
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
		$filePath = $fileDir.'bmiddle/renren_'.$arr[$num];
		$imgurl = '/bmiddle/renren_'.$arr[$num];
		@file_put_contents($filePath,$file);
	}
	return $imgurl;
}

function downloadLargeImg($url)
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
		$filePath = $fileDir.'original/renren_'.$arr[$num];
		$imgurl = '/original/renren_'.$arr[$num];
		@file_put_contents($filePath,$file);
	}
	return $imgurl;
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

function getLocalbumPhotos($db,$id)
{

	$c = $db->selectCollection('photos');
	$cursor = $c->find(array('album_id'=>$id));	
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

function getRenRenPhotos($token,$uid,$aid)
{

	$rrObj = new RenrenRestApiService;

	$count = 20;
	$photos=array();
	$page = 1;

	while(1)
	{
		$params = array('uid'=>$uid,'page'=>$page,'count'=>$count,'aid'=>$aid,'access_token'=>$token);
		$res = $rrObj->rr_post_curl('photos.get', $params);
		if(isset($res['error_code']))
			break;
		
	  $photos = array_merge($photos,$res);
		if(count($res) <$count)
			break;
		
		$page++;
	}
	return $photos;

}

function getInstertPhoto($photos,$likes)
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
			if($photo['renren_id'] == $like['pid'])
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



$db = connMongo();
$user = getAdminUser($db);
//if(empty($user) || !is_array($user))
//	exit;
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
foreach($albums as $album)
{
		$albumPhotos = getRenRenPhotos($token,$uid,$album['renren_id']);
		if(is_array($albumPhotos) && !empty($albumPhotos))
		{
			$locAlbumPhoto = getLocalbumPhotos($db,$album['_id']);
			$insertPhotos = getInstertPhoto($locAlbumPhoto,$albumPhotos);
			if(is_array($insertPhotos) && !empty($insertPhotos))
			{
					insertDb($db,$insertPhotos,$album['_id']);

			}
		}
}





?>
