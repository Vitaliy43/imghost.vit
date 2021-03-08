<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

function lang_exif(){
	$language['IFD0.Orientation'] = 'Ориентация';
	$language['IFD0.XResolution'] = 'Разрешение по X';
	$language['IFD0.YResolution'] = 'Разрешение по Y';
	$language['IFD0.Software'] = 'ПО';
	$language['IFD0.DateTime'] = 'Дата/время';
	$language['EXIF.ColorSpace'] = 'Цветовое пространство';
	$language['THUMBNAIL.Compression'] = 'Сжатие';
	$language['IFD0.Make'] = 'Фирма';
	$language['IFD0.Model'] = 'Модель';
	$language['EXIF.ExposureTime'] = 'Выдержка';
	$language['EXIF.FNumber'] = 'Диафрагма';
	$language['EXIF.DateTimeOriginal'] = 'Дата сьемки';
	$language['EXIF.DateTimeDigitized'] = 'Дата оцифровки';
	$language['EXIF.CompressedBitsPerPixel'] = 'Сжатых бит/пиксел';
	$language['EXIF.MaxApertureValue'] = 'Макс.диафрагма';
	$language['EXIF.Flash'] = 'Вспышка';
	$language['EXIF.FocalLength'] = 'Фокусное расстояние';
	
	$language['EXIF.ExposureBiasValue'] = 'Компенсация экспозиции в единицах EV (APEX)';
	$language['EXIF.UserComment'] = 'Комментарий';
	$language['EXIF.FocalPlaneXResolution'] = 'Плотность сенсоров на матрице по Х координат';
	$language['EXIF.FocalPlaneYResolution'] = 'Плотность сенсоров на матрице по Y координат';
	$language['EXIF.SensingMethod'] = 'Тип сенсора';
	$language['EXIF.FileSource'] = 'Источник изображения';
	$language['EXIF.CustomRendered'] = 'Обработка изображения';
	$language['EXIF.ExposureMode'] = 'Режим экспоавтоматики';
	$language['EXIF.SceneCaptureType'] = 'Сюжетная программа';
	
	
	return $language;
}

?>