<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

function lang_auth(){
	
	
	$language['AUTH_EMAIL'] = 'Электронная почта';
	$language['REGISTER'] = 'Регистрация';
	$language['AUTH_PASSWORD'] = 'Пароль';
	$language['AUTH_PASSWORD_SEEDOFF'] = 'Пароль на Seedoff.net';
	$language['AUTH_SEEDOFF_FAILED'] = 'Пользователь с данным логином и паролем отсутствует в базе данных Seedoff.net';
	$language['CONFIRM_PASSWORD'] = 'Повторите пароль';
	$language['FORGET_PASSWORD'] = 'Забыли пароль?';
	$language['WRONG_PASSWORD'] = 'Неверный пароль';
	$language['AUTH_LOGIN'] = 'Войти';
	$language['AUTH_LOGOUT'] = 'Выйти';
	$language['ALBUMS'] = 'Мои альбомы';
	$language['PERSONAL_MSG'] = 'Личные сообщения';
	$language['HEADER_REGISTER'] = 'Регистрация';
	$language['HEADER_FORGET'] = 'Я все забыл';
	$language['USERNAME'] = 'Логин';
	$language['USERNAME_SEEDOFF'] = 'Логин на Seedoff.net';
	$language['EMAIL'] = 'Почта';
	$language['SHOW_NAME'] = 'Имя';
	$language['EDIT_PROFILE'] = 'Редактирование профиля';
	$language['BIRTHDAY'] = 'День рождения';
	$language['LABEL_BIRTHDAY'] = 'День (ДД) - Месяц (ММ) - Год (ГГГГ)';
	$language['ERROR_VALID_EMAIL'] = 'Указан некорректный email';
	$language['ERROR_MIN_LENGTH'] = 'Пароль слишком короткий';
	$language['EDIT_PROFILE_SUCCESS'] = 'Изменение профиля прошло успешно';
	$language['ACCESS_AUTHORIZED'] = 'Доступ в данный раздел разрешен только авторизованным пользователям!';
	$language['USE_SEEDOFF_DATA'] = 'Использовать регистрационные данные с Seedoff';
	$language['VK_PROFILE'] = 'Профиль Вконтакте';
	$language['USER'] = 'Пользователь';
	$language['GUEST'] = 'Гость';
	$language['ADMIN'] = 'Админка';
	$language['User is already logged in'] = 'Пользователь уже вошел в систему';
	$language['SHOW_PROFILE'] = 'Показывать профиль';
	$language['ACCESS_ROLE']['guest'] = 'Всем';
	$language['ACCESS_ROLE']['user'] = 'Всем авторизованным';
	$language['ACCESS_ROLE']['admin'] = 'Никому';
	$language['TINY_STATIC'] = 'Короткие ссылки на изображения';
	
	return $language;
	
}


?>