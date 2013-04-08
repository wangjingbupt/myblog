<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');

function connMongo($dbName = 'blog')
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
	$user = $c->findOne(array('type'=>'instagram'));
	if(is_array($user) && !empty($user))
		return $user;

	return false;
}

function getAlbum($db)
{
	$c = $db->selectCollection('album');
	$doc = $c->findOne(array('type'=>'instagram'));
	if(is_array($doc) && !empty($doc))
		return $doc;

	$insert=array(
			'title'=>'INSTAGRAM LIKES',
			'photo_num'=>0,
			'createtime'=>time(),
			'uptime'=>time(),
			//  'cover_img'=>'/bmiddle/3494290901000890_4dbe1e5djw1dwx1gh82cqj.jpg',
			'cover_img'=>'',
			'type'=>'instagram',
			'status'=>1,
			);
	$c->insert($insert);
	if(isset($insert['_id']))
		return $insert;

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

function insertDb($db,$likes,$aid)
{
	$c = $db->selectCollection('photos');
	foreach($likes as $like)
	{
		if($like['type']!='image')
			continue;

		$images = downloadImg($like['images']);


		$insert = array(
				'album_id'=>$aid,
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

function getPhotos($db,$aid)
{

	$c = $db->selectCollection('photos');
	$cursor = $c->find(array('album_id'=>$aid));	
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

function update_album($db,$photos,$aid)
{
	$doc = getAlbum($db);
	$num = 0;
	foreach($photos as $photo )
	{
		if($cover['createtime']< $photo['createtime'])
		{
			$cover =$photo;
		}
		if($photo['status'] ==1)
		{
			$num++;
		}
	}
	$doc['cover_img'] = $cover['standard'];
	$doc['uptime'] = $cover['createtime'];
	$doc['photo_num'] =$num;

	$c = $db->selectCollection('album');
	$id = new MOngoId($aid);
	$sing = $c->update(array('type'=>'instagram'),$doc);	
}



is_start();
$db = connMongo('blog');
$user = getAdminUser($db);
if(empty($user) || !is_array($user))
{
	exit;
}
$token = $user['token'];
$db = connMongo('photo');
$album = getAlbum($db);
if(empty($album) || !is_array($album))
{
	exit;
}
$aid = $album['_id']->__toString();
$photos = getPhotos($db,$aid);
if(!is_array($photos))
	$photos = array();

$likes = getLikeds($token);
if(is_array($likes) && !empty($likes))
{
	$ls = getInsertData($photos,$likes);
	if(is_array($ls) && !empty($ls))
	{
		insertDb($db,$ls,$aid);
	}
}
$photos = getPhotos($db,$aid);
update_album($db,$photos,$aid);

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
