<?php
include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');

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

function downloadImg($images)
{
	$fileDir = ROOT.'../images/snowblog/';
	$files =array();
	if(is_array($images) && !empty($images))
	{
		foreach($images as $k =>$v)
		{
			$file = @file_get_contents($v['url']);
			if($file)
			{
				$arr = explode('/',$v['url']);
				$num = count($arr-1);
				if($k == 'low_resolution')
				{
					$filePath = $fileDir.'bmiddle/istagram_'.$arr[$num];
					$url = '/bmiddle/istagram_'.$arr[$num];
				}
				else if($k == 'thumbnail')
				{
					$filePath = $fileDir.'thumb/istagram_'.$arr[$num];
					$url = '/thumb/istagram_'.$arr[$num];
				}
				else if($k == 'original')
				{
					$filePath = $fileDir.'original/istagram_'.$arr[$num];
					$url = '/original/istagram_'.$arr[$num];
				}
				else
					continue;

				@file_put_contents($filePath,$$file);
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
		if(!$sign)
			return false;
	}
	return true;

}

function getPhotos($db)
{

	$c = $db->selectCollection('photos');
	$cursor = $c->find(array('album_id'=>1));	
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

function getLikeds($token,$max)
{

	$curl = new Curl();
	$count = 1;
	$likes=array();
	$turl = 'https://api.instagram.com/v1/users/self/media/liked?access_token='.$token.'&count='.$count;
	$url = $turl;
	if($max != '')
		$url = $turl.'&max_like_id='.$max;

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




$db = connMongo();
$user = getAdminUser($db);
$token = $user['token'];
$token = '55126795.d191c01.5d5b9a66630e4512b61d03d00375b24b';
$photos = getPhotos($db);
if(!is_array($photos))
	$photos = array();
$max ='';
foreach($photos as $photo)
{
	$id = $photo['instagram_id'];
	if($id  > $max)
		$max = $id;
}

$likes = getLikeds($token,$max);
print_r($photos);
print_r($likes);
exit;
if(is_array($likes) && !empty($likes))
	insertDb($db);







?>
