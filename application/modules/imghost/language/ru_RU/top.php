<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

function lang_top(){
	
	$language['TITLE'] = 'Топ фото';
	$language['NEW_IMAGES'] = 'Новые изображения';
	$language['NEW_COMMENTS'] = 'Новые комментарии';
	$language['MOST_POPULAR'] = 'Самые популярные';
	$language['MOST_POPULAR_DESCRIPTION'] = 'Изображения, имеющие наибольшее количество просмотров';
	$language['MOST_RATING_DESCRIPTION'] = 'Изображения, имеющие наибольший рейтинг';
	$language['MOST_COMMENTED'] = 'Самые обсуждаемые';
	$language['MOST_RATING'] = 'Самые рейтинговые';
	$language['VOTE'] = 'голос';
	$language['BALL'] = 'балл';
	$language['NUM_VIEWS'] = 'Кол-во просмотров';
	$language['RATING'] = 'Оценка';

	
	return $language;
}

?>