<?php

class DbConf{
	public static $BDprefix = 'lx';

	public static $mongoConf = '127.0.0.1:27017';
	public static $mongoAuth = array(
		'blog',
		'blog1987',
	);

	public static $mongoDbFields = array(
		'blog.post' =>array(
			  'id',
				'title',
				'content',
				'photoList',
				'type',
				'status',
				'tags',
				'createtime',
				'uptime',
				'comment_num',
				'like_num',
		),

	);


}

?>
