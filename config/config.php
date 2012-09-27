<?php

define('ROOT',dirname(dirname(__FILE__)));
define('CONTROLLER', ROOT."/controller");
define('CONFIG', ROOT."/config");
define('UTIL', ROOT."/util");
define('DATA', ROOT."/data");
define('VIEW', ROOT."/view");
define('MODEL', ROOT."/model");
define('WEIBO', ROOT."/weibo");

define('MODEL_POST', MODEL."/post");
define('MODEL_COMMENT', MODEL."/comment");
define('MODEL_PHOTO', MODEL."/photo");
define('MODEL_WEIBO', MODEL."/weibo");

define('CONTROLLER_POST', CONTROLLER."/post");
define('CONTROLLER_COMMENT', CONTROLLER."/comment");
define('CONTROLLER_PHOTO', CONTROLLER."/photo");
define('CONTROLLER_WEIBO', CONTROLLER."/weibo");
define('CONTROLLER_CALLBACK', CONTROLLER."/callback");

define('VIEW_POST', VIEW."/post");
define('VIEW_COMMENT', VIEW."/comment");
define('VIEW_PHOTO', VIEW."/photo");
define('VIEW_WEIBO', VIEW."/weibo");



define('UPLOAD_TMP_DIR', "/tmp/img/");
define('REDIRECT_URL', "http://lxsnow.me/");

define('IMG_PATH',ROOT.'/../images/snowblog/');
define('IMG_URL','http://img.lxsnow.me/');

define( "WB_AKEY" , '628803579' );
define( "WB_SKEY" , '53cc7c93724ae3fa4a39391f0d76d78c' );
define( "WB_CALLBACK_URL" , 'http://lxsnow.me/callback/weibo' );
define( "RR_CALLBACK_URL" , 'http://lxsnow.me/callback/renren' );
define( "IG_CALLBACK_URL" , 'http://lxsnow.me/callback/instagram' );

define( "RR_AKEY" , '4e510ea83299443a8d4f520d46914b16' );
define( "RR_SKEY" , '97fb6db5037d4ff7bad680f895eee712' );
define( "IG_AKEY" , 'd191c0133cfc44c39642bb29b59dfac2' );
define( "IG_SKEY" , '2ccc9565adef48608dc7eaebc33a4fd1' );

?>
