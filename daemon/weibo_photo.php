<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
set_time_limit(0);
include('../config/config.php');
include(CONFIG.'/db.conf.php');
include('../util/weibo/saetv2.ex.class.php');

function connMongo($dbName = 'blog')
{

	$m = new Mongo(DbConf::$mongoConf);
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
  //$db->authenticate(DbConf::$mongoAuth[0],DbConf::$mongoAuth[1] );
	return $db;

}

function getAdminUser($db)
{
	$c = $db->selectCollection('adminUser');
	$user = $c->findOne(array('type'=>'weibo'));
	if(is_array($user) && !empty($user))
		return $user;

	return false;
}

function getAlbum($db)
{
	$c = $db->selectCollection('album');
	$doc = $c->findOne(array('type'=>'weibo'));
	if(is_array($doc) && !empty($doc))
		return $doc;

	$insert=array(
			'title'=>'WEIBO',
			'photo_num'=>0,
			'createtime'=>time(),
			'uptime'=>time(),
			//  'cover_img'=>'/bmiddle/3494290901000890_4dbe1e5djw1dwx1gh82cqj.jpg',
			'cover_img'=>'',
			'type'=>'weibo',
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
			$file = @file_get_contents($v);
			if($file)
			{
				$arr = explode('/',$v);
				$num = count($arr)-1;
				if($k == 'bmiddle_pic')
				{
					$filePath = $fileDir.'bmiddle/weibo_'.$arr[$num];
					$url = '/bmiddle/weibo_'.$arr[$num];
				}
				else if($k == 'thumbnail_pic')
				{
					$filePath = $fileDir.'thumb/weibo_'.$arr[$num];
					$url = '/thumb/weibo_'.$arr[$num];
				}
				else if($k == 'original_pic')
				{
					$filePath = $fileDir.'original/weibo_'.$arr[$num];
					$url = '/original/weibo_'.$arr[$num];
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
		$images = downloadImg($like['images']);

		if($images['bmiddle_pic'] =="")
			$images['bmiddle_pic'] = $images['thumbnail_pic'];

		if($images['original_pic'] == "")
			$images['original_pic'] = $images['bmiddle_pic'];

		$insert = array(
				'album_id'=>$aid,
				'createtime'=>$like['createtime'],
				'low' =>$images['bmiddle_pic'],
				'thumb' =>$images['thumbnail_pic'],
				'standard' =>$images['original_pic'],
				'weibo_id' =>$like['weibo_id'],
				'img_id' =>$like['img_id'],
				'description'=>$like['description'],
				'status'=>1,

				);
		$sign = $c->insert($insert);

		print_r($insert );
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
	//$cursor->sort(array('createtime'=>-1)->limit(1)
	$cursor->sort(array('createtime'=>-1));
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

function getWeibo($token,$lastID)
{
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token);
	$weibo = $c->user_timeline_by_id(1677691977,1,30,intval($lastID),0,1);
	if(!is_array($weibo['statuses']) || empty($weibo['statuses']))
	{
		return false;
	}
	$lastID = $weibo['next_cursor'];
	foreach($weibo['statuses'] as $f)
	{
		if(!empty($f['pic_urls']))
		{
			foreach($f['pic_urls'] as $imgs)
			{
				$img_arr = explode('/',$imgs['thumbnail_pic']);
				$img_id = $img_arr[count($img_arr)-1];
				$photo[] = array(
					'images'=>array(
							'thumbnail_pic' =>$imgs['thumbnail_pic'],
							'bmiddle_pic'   =>str_replace('thumbnail','bmiddle',$imgs['thumbnail_pic']),
							'original_pic'  =>str_replace('thumbnail','large',$imgs['thumbnail_pic']),
					),
					'weibo_id'			=>strval($f['id']),
					'img_id'				=> $img_id,
					'description'		=>$f['text'],
					'createtime'		=>strtotime($f['created_at']),
				);
			}
		}
	}
	return $photo;

}

function getLikeds($token)
{

	$curl = new Curl();
	$count = 20;
	$likes=array();
	$turl = 'https://api.weibo.com/2/statuses/user_timeline.json';
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
			if($photo['img_id'] == $like['img_id'])
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
	$sing = $c->update(array('type'=>'weibo'),$doc);	
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
$last_weibo_id = intval($photos[0]['weibo_id'])+1;
//$last_weibo_id = 0;
$feeds = getWeibo($token,$last_weibo_id);
if($feeds == false)
	echo $last_weibo_id;
if(is_array($feeds) && !empty($feeds))
{
	$ls = getInsertData($photos,$feeds);
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
