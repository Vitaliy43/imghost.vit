<?php
define('BASEPATH','/');
require_once('/home/services/imghost/www/application/config/config.php');
require_once('/home/services/imghost/www/application\config\constants.php');
require_once('/home/services/imghost/www/application\helpers\image_helper.php');
mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']);
mysql_select_db($db['default']['database']);
$images_user_table = 'images';
$images_guest_table = 'images_guests';

?>