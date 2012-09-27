<?php

define('ROOT',dirname(dirname(__FILE__)));
define('CONTROLLER', ROOT."/controller");
define('CONFIG', ROOT."/config");
define('UTIL', ROOT."/util");
define('DATA', ROOT."/data");
define('VIEW', ROOT."/view");
define('MODEL', ROOT."/model");

define('MODEL_POST', MODEL."/post");
define('MODEL_COMMENT', MODEL."/comment");
define('MODEL_PHOTO', MODEL."/photo");
define('MODEL_WEIBO', MODEL."/weibo");

define('CONTROLLER_POST', CONTROLLER."/post");
define('CONTROLLER_COMMENT', CONTROLLER."/comment");
define('CONTROLLER_PHOTO', CONTROLLER."/photo");
define('CONTROLLER_WEIBO', CONTROLLER."/weibo");

define('VIEW_POST', VIEW."/post");
define('VIEW_COMMENT', VIEW."/comment");
define('VIEW_PHOTO', VIEW."/photo");
define('VIEW_WEIBO', VIEW."/weibo");



define('UPLOAD_TMP_DIR', "/tmp/img/");
define('REDIRECT_URL', "http://lxsnow.me/");

define('IMG_PATH',ROOT.'/../images/snowblog/');
define('IMG_URL','http://img.lxsnow.me/');

?>
