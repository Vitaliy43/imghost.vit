<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

function lang_albums() {
	
	$language['ALBUMS']	 = 'Мои альбомы';
	$language['ALBUM' ] = 'Альбом';
	$language['CREATE_ALBUM'] = 'Создать папку';
	$language['EDIT_ALBUM'] = 'Редактировать папку';
	$language['NAME'] = 'Название';
	$language['DESCRIPTION'] = 'Описание';
	$language['ACCESS'] = 'Доступ';
	$language['PUBLIC'] = 'Публичная';
	$language['ALBUM_PUBLIC'] = 'Публичный';
	$language['PROTECTED'] = 'По паролю';
	$language['ALBUM_PROTECTED'] = 'Защищен паролем';
	$language['PRIVATE'] = 'Приватная';
	$language['ALBUM_PRIVATE'] = 'Приватный';
	$language['STATISTIC'] = 'Статистика';
	$language['FOLDERS'] = 'Папок';
	$language['TORRENTS'] = 'Раздач';
	$language['FILES'] = 'Файлов';
	$language['UPLOAD_PHOTO'] = 'Загрузить фото';
	$language['NO_FOLDERS'] = 'Папок нет';
	$language['NO_ALBUMS'] = 'Альбомов нет';
	$language['NO_FILES'] = 'Файлов нет';
	$language['FOLDERS_LIST'] = 'Список папок';
	$language['FILES_IN_ROOT'] = 'Файлы вне папок';
	$language['ALBUM_ERROR'] = 'При удалении альбома возникли ошибки';
	$language['NEW_PASSWORD'] = 'Новый пароль';
	$language['EXCLUDE_FROM_ALBUM'] = 'Исключить из альбома';
	$language['ACCESS_LEVEL'] = 'Уровень доступа';
	$language['ADDED'] = 'Добавлен';
	$language['ACCESS_DENIED'] = 'Доступ запрещен';
	$language['ACCESS_DENIED_PRIVATE'] = 'Доступ к данному альбому запрещен его владельцем!';
	$language['ACCESS_IMAGE_DENIED_PRIVATE'] = 'Доступ к данному изображению запрещен его владельцем!';
	$language['ACCESS_DENIED_PROTECTED'] = 'Доступ к альбому "%album%" защищен паролем!';
	$language['ACCESS_PROTECTED'] = 'Доступ ограничен';
	$language['OWNER'] = 'Владелец';
	
	return $language;
	
}


?>