<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

function lang_imagelist(){
	
	$language['UPLOADED_IMAGES'] = 'Загруженные изображения';
	$language['PREVIEW'] = 'Превью';
	$language['FILENAME'] = 'Имя файла';
	$language['FILESIZE'] = 'Размер';
	$language['FILETYPE'] = 'Тип файла';
	$language['TAG'] = 'Тег';
	$language['DESCRIPTION'] = 'Комментарий';
	$language['DATA_UPLOADED'] = 'Дата загрузки';
	$language['ALBUM'] = 'Альбом';
	$language['CONFIRM_DELETE'] = 'Вы уверены, что хотите удалить данное изображение?';
	$language['MY_UPLOADS'] = 'Мои загрузки';
	$language['NO_PICTURES'] = 'Изображений нет';
	$language['NO_PICTURES_PUBLIC'] = 'Доступных для просмотра изображений нет';
	$language['LINKS'] = 'Ссылки';
	$language['SHOW_LINKS'] = 'Показать ссылки';
	$language['ORDER_BY_FILENAME'] = 'Сортировать по имени';
	$language['ORDER_BY_FILESIZE'] = 'Сортировать по размеру';
	$language['ORDER_BY_ADDED'] = 'Сортировать по дате';
	$language['SEARCH_BY_IMAGES'] = 'Поиск по картинкам';
	$language['SEARCH'] = 'Искать';

	return $language;
}

?>