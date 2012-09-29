<?php
include('../config/config.php');
include(CONFIG.'/db.conf.php');
include(UTIL.'/renren/RenrenRestApiService.class.php');

function connMongo()
{

	$m = new Mongo();
	$m_db = DbConf::$BDprefix."_blog";
	$db = $m->selectDB($m_db);
	return $db;

}

function getAdminUser($db)
{
	$c = $db->selectCollection('adminUser');
	$user = $c->findOne(array('type'=>'instagram'));
	if(is_array($user) && !empty($user))
		return $user;

	return false;
}

function insertDb($db,$likes)
{
	$c = $db->selectCollection('photos');
	foreach($likes as $like)
	{
		if($like['type']!='image')
			continue;
		
		$images = downloadImg($like['images']);


		$insert = array(
			'album_id'=>1,
			'liked_time'=>$like['created_time'],
			'org_link' =>$like['link'],
			'low' =>$images['low_resolution'],
			'thumb' =>$images['thumbnail'],
			'standard' =>$images['standard_resolution'],
			'instagram_id' =>$like['id'],
			'description'=>$like['caption']['text'],
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

function getAlbums($db)
{

	$c = $db->selectCollection('photo_album');
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
			if($photo['instagram_id'] == $like['id'])
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



//$db = connMongo();
//$user = getAdminUser($db);
//if(empty($user) || !is_array($user))
//	exit;
$token = $user['token'];
$uid = $user['uid'];
$token ='213266|6.55e60c6ab44be3b7a2e39840715c06d0.2592000.1351494000-342198441';
$uid = 342198441;
$uid = 236512134;

//$albums = getAlbums($db);
//if(!is_array($albums))
//	$albums = array();
//print_r($albums);
//exit;

$likes = getRenrenAlbums($token,$uid);
print_r($likes);exit;
if(is_array($likes) && !empty($likes))
{
	$ls = getInsertData($photos,$likes);
	if(is_array($ls) && !empty($ls))
	{
		insertDb($db,$ls);
	}
}






?>
