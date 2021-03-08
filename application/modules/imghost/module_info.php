<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$com_info = array(
	'menu_name'   => lang('Imghost', 'Основной модуль'),              // Menu name
	'description' => lang('Главный модуль, использует функции других модулей в зависимости от контента'),         // Module Description
	'admin_type'  => 'window',               // Open admin class in new window or not. Possible values window/inside
	'window_type' => 'xhr',                  // Load method. Possible values xhr/iframe
        'w'           => 600,                    // Window width
	'h'           => 550,                    // Window height
	'version'     => '1.0',                  // Module version
	'author'      => 'vitaliy43'      // Author info
);

/* End of file module_info.php */
