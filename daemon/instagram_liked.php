<?php
include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');

function connMongo($dbName = 'blog')
{

	$m = new Mongo();
	$m_db = DbConf::$BDprefix."_".$dbName;
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

function downloadImg($images)
{
	$fileDir = ROOT.'/../images/snowblog/';
	$files =array();
	if(is_array($images) && !empty($images))
	{
		foreach($images as $k =>$v)
		{
			$file = @file_get_contents($v['url']);
			if($file)
			{
				$arr = explode('/',$v['url']);
				$num = count($arr)-1;
				if($k == 'low_resolution')
				{
					$filePath = $fileDir.'bmiddle/instagram_'.$arr[$num];
					$url = '/bmiddle/instagram_'.$arr[$num];
				}
				else if($k == 'thumbnail')
				{
					$filePath = $fileDir.'thumb/instagram_'.$arr[$num];
					$url = '/thumb/instagram_'.$arr[$num];
				}
				else if($k == 'standard_resolution')
				{
					$filePath = $fileDir.'original/instagram_'.$arr[$num];
					$url = '/original/instagram_'.$arr[$num];
				}
				else
					continue;

				@file_put_contents($filePath,$file);
				$files[$k]=$url;
			}
		}
	}
	return $files;
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
			'album_id'=>'506dddfdcb44e41132000000',
			'createtime'=>$like['created_time'],
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

function getPhotos($db)
{

	$c = $db->selectCollection('photos');
	$cursor = $c->find(array('album_id'=>'506dddfdcb44e41132000000'));	
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

function getLikeds($token)
{

	$curl = new Curl();
	$count = 20;
	$likes=array();
	$turl = 'https://api.instagram.com/v1/users/self/media/liked?access_token='.$token.'&count='.$count;
	$url = $turl;

	while(1)
	{
		$response = $curl->get($url);
		$res = json_decode($response,true);
		if($res['meta']['code'] !=200)
			break;
		$data = $res['data'];
	  $likes = array_merge($likes,$data);
		if(count($data) <$count)
			break;
		
		$c = $count-1;
		$max = $data[$c]['id'];
		$url = $turl.'&max_like_id='.$max;
	}
	return $likes;

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

function update_album($db,$photos)
{
	
	$c = $db->selectCollection('album');
	$doc = $c->findOne(array('album_id'=>'506dddfdcb44e41132000000'));	
	print_r($doc);
	print_r($photos);


}



$db = connMongo('blog');
$user = getAdminUser($db);
if(empty($user) || !is_array($user))
	exit;
$token = $user['token'];
$db = connMongo('photo');
$photos = getPhotos($db);
if(!is_array($photos))
	$photos = array();

$likes = getLikeds($token);
if(is_array($likes) && !empty($likes))
{
	$ls = getInsertData($photos,$likes);
	if(is_array($ls) && !empty($ls))
	{
		insertDb($db,$ls);
	}
}
$photos = getPhotos($db);
update_album($db,$photos);





?>
