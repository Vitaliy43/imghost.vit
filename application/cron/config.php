<?php

define('BASEPATH','/');
define('FROM_CRON',true);
ini_set('max_execution_time','0');
ini_set('memory_limit','1024M');
set_time_limit(0);
require_once('D:\server\www\imghost.vit\application\config\config.php');
require_once('D:\server\www\imghost.vit\application\config\constants.php');
require_once('D:\server\www\imghost.vit\application\helpers\image_helper.php');
require_once('D:\server\www\imghost.vit\application\helpers\my_url_helper.php');
mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']);
mysql_select_db($db['default']['database']);
@mysql_query ("SET NAMES `utf8`");
$images_user_table = 'images';
$images_guest_table = 'images_guests';
//$sync_db = 'imghost_seedoff';
$sync_db = 'imghost_seedoff_new';




?>