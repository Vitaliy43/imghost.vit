<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');


function lang_upload(){
	
	$language['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
	$language['PARTIALLY_UPLOADED'] = 'The uploaded file was only partially uploaded!';
	$language['NO_UPLOADED'] = 'No file was uploaded!';
	$language['ERROR_TEMP_FOLDER'] = 'Missing a temporary folder!';
	$language['ERROR_WRITE_DISK'] = 'Failed to write file to disk!';
	$language['ERROR_EXTENSION'] = 'File upload stopped by extension!';
	$language['UNKNOWN_UPLOAD_ERROR'] = 'No error code avaiable!';
	
	return $language;
}

?>