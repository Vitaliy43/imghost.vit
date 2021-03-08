<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('image_get_sizes')) :
function image_get_sizes($filename,$max_height, $max_width){
 	
	$sizes = getimagesize($filename);
	$width = $sizes[0];
	$height = $sizes[1];
	$proportion = $height/$width;
	if($width > $height){
		$result['width'] = $max_width;
		$result['height'] = round($max_width * $proportion);
	}
	else{
		$result['height'] = $max_height;
		$result['width'] = round($max_height / $proportion);
	}
	
	return $result;
		
 }
 
 endif;
 

function get_image_proportion($filename){
	
	$sizes = getimagesize($filename);
	$width = $sizes[0];
	$height = $sizes[1];
	return $height/$width;
}
 
class ImageHelper {
	
	public static $preview_path = 'preview';
	public static $preview_path_80 = 'preview_80';
	public static $web_path = 'web';
	public static $main_path = 'big';
	public static $avatar_path = 'avatars';
	public static $width_thumbnails = 240;
	public static $height_thumbnails = 180;
	public static $height_gallery = 300;
	public static $web_width = 1024;
	public static $size_fast_upload = 100;
	public static $width_main = 600;
	public static $font_path = 'fonts';
	public static $font_size = 14;
	public static $theme;
	public static $fb_thumbnails_path = 'thumbnails/fb';
	public static $web_pixel_size = 1179648;
	public static $zoomMaxWidth = 400;
	public static $zoomMaxHeight = 300;
	public static $zoomMinWidth = 80;
	public static $zoomMinHeight = 60;
	public static $preview_mode = true;
	public static $enable_compression = false;
	public static $max_width_cover = 500;
	public static $min_width_cover = 150;
//	public static $default_width_cover = 250;
	public static $default_width_cover = 500;
	public static $thumbnail_cover_size = 150;
	public static $preview_size = 240;
	public static $max_height = 6000;
	public static $max_width = 6000;
		///////////////////////////////// Блок переменных загрузки ///////////////////
	public static $max_number_of_files = 12;
	public static $max_number_of_files_iframe = 6;
	

	static function get_data_from_url($url){
		$buffer = explode('/',$url);
		$year = $buffer[count($buffer) - 3];
		$monthday = $buffer[count($buffer) - 2];
		$date['year'] = $year;
		$date['monthday'] = $monthday;
		return $date;
	}
	
	static function get_big_main_url($main_url){
		
		$buffer = explode('/image',$main_url);
		return SITE_URL.'/image/big'.$buffer[1];
		
	}
	
	/////////////////////////////////////////// Определяем, является ли гиф анимированным ///////////////////////////
	static function is_animate_gif($filename){
			
		$filecontents=file_get_contents($filename); 

		$str_loc=0; 
		$count=0; 
		while ($count < 2) 
		{ 

			$where1=strpos($filecontents,"\x00\x21\xF9\x04",$str_loc); 
			if ($where1 === FALSE) 
			{ 
				break; 
			} 
			else 
			{ 
				$str_loc=$where1+1; 
				$where2=strpos($filecontents,"\x00\x2C",$str_loc); 
				if ($where2 === FALSE) 
				{ 
					break; 
				} 
				else 
				{ 
					if ($where1+8 == $where2) 
				{ 
				$count++; 
				} 
				$str_loc=$where2+1; 
				} 
			} 
		} 

		if ($count > 1) 
		{ 
			return(true); 

		} 
		else 
		{ 
			return(false); 
		
		}
	}
	
	static function get_image_ext($mime){
		if(strpos($mime,'jpeg'))
			$ext = 'jpg';
		elseif(strpos($mime,'jpg'))
			$ext = 'jpg';
		elseif(strpos($mime,'png'))
			$ext = 'png';
		elseif(strpos($mime,'gif'))
			$ext = 'gif';
		else
			$ext = '';
		return $ext;
		
	}
	
	static function get_moder_preview_url($filename,$image_size=null){
		
		if(self::$thumbnail_cover_size != 150)
			$image_size = self::$thumbnail_cover_size;
		$buffer = explode('.',$filename);
		$ext = $buffer[count($buffer) - 1];
		array_pop($buffer);
		if(!$image_size)
			return implode('.',$buffer).'_150.'.$ext;
		else
			return implode('.',$buffer).'_'.$image_size.'.'.$ext;
		
	}
	
	static function get_poster_preview_url($filename){
		
		$buffer = explode('.',$filename);
		$ext = $buffer[count($buffer) - 1];
		array_pop($buffer);
		return implode('.',$buffer).'_poster.'.$ext;
			
	}
	
	static function get_big_poster_preview_url($filename){
		
		$buffer = explode('.',$filename);
		$ext = $buffer[count($buffer) - 1];
		array_pop($buffer);
		return implode('.',$buffer).'_500.'.$ext;
			
	}
	
	static function make_thumbnail($file_name, $file_name_destiny, $thumb_width, $thumb_height, $max_size, $showres, $alpng, $add_text = '')
{
	$image_info = @getimagesize($file_name);
	if(empty($image_info['mime']))
		return false;
    $alpng = false;

	switch ($image_info['mime'])
    {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $image = imagecreatefromGIF($file_name);
            }
            else {
                $err_str = 'GD не поддерживает GIF';
            }
            break;
        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $image = @imagecreatefromJPEG($file_name);
            }
            else {
                $err_str = 'GD не поддерживает JPEG';
            }
            break;
        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $image = imagecreatefromPNG($file_name);
                $alpng = true;
            }
            else {
                $err_str = 'GD не поддерживает PNG';
            }
            break;
        default:
            $err_str = 'GD не поддерживает ' . $image_info['mime'];
    }

    if (isset($err_str))
        return $err_str;
		
	if(!is_resource($image))
		return false;
		
    $image_width = imagesx($image);
    $image_height = imagesy($image);
	
	if(!$image_height)
		return false;
		
	if(!$image_width)
		return false;


	if(!$thumb_height)
    	$thumb_height = round($thumb_width * ($image_height/$image_width));
	elseif(!$thumb_width)
		$thumb_width = round($thumb_height * ($image_width/$image_height));
	
		$thumb = imagecreatetruecolor($thumb_width, $thumb_height);



    if ($alpng)
    {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
        imagefill($thumb, 0, 0, $transparent);
    }
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);

    // пишем размер картинки на миниатюре
		
	 if ($showres && $thumb_width>100 && $thumb_height>20)
    {
		
		   $white = imagecolorallocate($thumb, 255, 255, 255);

		if(isset($_POST['VOLUNTARY_TEXT_PREVIEW']) && $_POST['VOLUNTARY_TEXT_PREVIEW']){
			$s = $_POST['VOLUNTARY_TEXT_PREVIEW'];
		
			self::watermark_text($file_name_destiny,$file_name_destiny,$s,true,array('width'=>$thumb_width - 15,'height'=>$thumb_height-13,'color'=>$white));
		}
		else{
			if($add_text){
				$s = 'Seedoff.net';
				if(empty($_REQUEST['image_size']))
					$image_size = self::$default_width_cover;
				else
					$image_size = (int)$_REQUEST['image_size'];
    			imagestring($thumb, 2, $thumb_width-round(45 * ($image_size/150)), $thumb_height-round(13 * ($image_size/150)), $s, $white);
			}
			else{
				$s = $image_width.'x'.$image_height;
    			imagestring($thumb, 2, $thumb_width-55, $thumb_height-13, $s, $white);
				
			}
			 if ($alpng)
    			imagePNG($thumb, $file_name_destiny, 8);
    		else
    			imagejpeg($thumb, $file_name_destiny, 90);
			
		}
    	
    }
	else{
		 if ($alpng)
    		imagePNG($thumb, $file_name_destiny, 8);
    	else
    		imagejpeg($thumb, $file_name_destiny, 90);
	}

    //освобождаем память
    imagedestroy($image);
    imagedestroy($thumb);
	return true;
}
	
	static function resizeimg($big, $small,$thumbnail=0,$moderate_mode=false,$thumbnail_height=0) {
    // имя файла с маштабируемым изображением
	 $size_img = getimagesize($big);
    list($width_src, $height_src) = getimagesize($big);
	if(!$width_src || !$height_src)
		return false;
	    // получаем коэфицент сжатия исходного изображения
    $src_ratio = $width_src/$height_src;
	
    //$big = $folder.$big;
	if(self::$preview_mode){
		$width = self::$width_thumbnails;
		$height = self::$height_thumbnails;
		if($thumbnail && $thumbnail_height){
			$width = $thumbnail;
			$height = $thumbnail_height;

		}
	
		elseif($thumbnail && !$thumbnail_height){
			$width = $thumbnail;
			$height = round($width / $src_ratio);

		}
		elseif($thumbnail_height && !$thumbnail){
			$height = $thumbnail_height;
			$width = round($height * $src_ratio);

		}


	}
	else{
		if($thumbnail && $thumbnail_height){
			$width = $thumbnail;
			$height = $thumbnail_height;
		}
		elseif($thumbnail && !$thumbnail_height){
			$width = $thumbnail;
			$height = round($width / $src_ratio);
			
		}
		elseif($thumbnail_height && !$thumbnail){
			$height = $thumbnail_height;
			$width = round($height * $src_ratio);
		}
	}
	
	
 	if($width >= $width_src)
		$width = $width_src;
	
	if($height >= $height_src)
		$height = $height_src;
    // имя файла с уменьшенной копией
 	if(!$width || !$height)
		return false;
    //определиям коэфицент сжатия генерируемого изображения
    $ratio = $width/$height;
 
    // получаем размеры исходного изображения
   
 
    // если размеры меньше, то маштабирование не нужно
	if($big != $small){
		if(($width_src<$width) && ($height_src<$height)) {
        	copy($big, $small);
        return true;
    }
	}

    // вычисляем размеры уменьшенной копии, чтобы при мащтабировании сохранились пропорции исходного изображения
    if ($ratio<$src_ratio) {
        $height = $width/$src_ratio;
    }
    else {
        $width = $height*$src_ratio;
    }
    // создаем пустое изображение п заданным размерам
    $dest_img = imagecreatetruecolor($width,$height);
    $white    = imagecolorallocate($dest_img, 255, 255, 255);
    if ($size_img[2] == 2)      $src_img = imagecreatefromjpeg($big);
    else if ($size_img[2] == 1) $src_img = imagecreatefromgif($big);
    else if ($size_img[2] == 3) $src_img = imagecreatefrompng($big);
 
    // маштабируем изображение функцией imagecopysapled()
    // $dest_img - уменьшенная копия
    // $src_img  - исходное изображение
    // $width    - ширина уменьшенной копии
    // $height   - высота уменьшенной копии
    // $size_img[0] - ширина исходного изображения
    // $srze_img[1] - высота исходного изображения
 
    imagecopyresampled($dest_img,
                       $src_img,
                       0,
                       0,
                       0,
                       0,
                       $width,
                       $height,
                       $width_src,
                       $height_src);
					   
	if ($moderate_mode)
    {
    	$s = $width_src.'x'.$height_src;
    	$white = imagecolorallocate($dest_img, 255, 255, 255);
    	imagestring($dest_img, 2, $width-55, $height-13, $s, $white);
    }
	
	if($big == $small){
		unlink($big);
	}
 
    // сохраняем уменьшенную копию в файл
    if ($size_img[2]==2) 
		$result = imagejpeg($dest_img,$small);
    else if ($size_img[2]==1)
		$result = imagegif($dest_img,$small);
    else if ($size_img[2]==3)
		$result = imagepng($dest_img,$small);
    // очищаем память от созданных изображений
    imagedestroy($dest_img);
    imagedestroy($src_img);
    return $result;
	}
	
	static function create_image_from_url($url,$ext=''){
		
		if($ext){
			if($ext == 'jpg')
				$source = imagecreatefromjpeg($url);
			elseif($ext == 'gif')
				$source = imagecreatefromgif($url);
			else
				$source = imagecreatefrompng($url);
			
		}
		
		return $source;
	}
	
	
	static function save_modify_image($image,$url,$ext=''){
		
		$url_preview = str_replace(self::$main_path,self::$preview_path,$url);
		$url_preview_80 = str_replace('preview','preview_80',$url_preview);
		$url_preview_moder = self::get_moder_preview_url($url_preview);
		
		
		if($ext){
			if($ext == 'jpg'){
				$res = imagejpeg($image,$url);
			
			}
			elseif($ext == 'gif'){
				$res = imagegif($image,$url);
				
			}
			else{
				$res = imagepng($image,$url);
				
			}
			
				if($res){
					$sizes = getimagesize($url);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					if(file_exists($url_preview))
						unlink($url_preview);
						if($file_width > $file_height)
							$res_preview = self::make_thumbnail($url,$url_preview,self::$width_thumbnails,0,0,0,false);
						else
							$res_preview = self::make_thumbnail($url,$url_preview,0,self::$height_thumbnails,0,0,false);

					if(file_exists($url_preview_moder))
						unlink($url_preview_moder);
						if($file_width > $file_height)
							$res_preview = self::make_thumbnail($url,$url_preview_moder,self::$thumbnail_cover_size,0,0,1,false);
						else
							$res_preview = self::make_thumbnail($url,$url_preview_moder,0,self::$thumbnail_cover_size,0,1,false);
	
					if(file_exists($url_preview_80))
						unlink($url_preview_80);
						if($file_width > $file_height)
							$res_preview = self::make_thumbnail($url,$url_preview_80,80,0,0,1,false);
						else
							$res_preview = self::make_thumbnail($url,$url_preview_80,0,80,0,1,false);

					if($res_preview)
						return true;
					return false;
				}
	}
	
	}
	
	static function url_to_realpath($url,$with_host = false){
		if($with_host){
			$url = str_replace(IMGURL,'',$url);
		}
		$buffer_filename = str_replace('/',DIRECTORY_SEPARATOR,$url);
		return IMGDIR.$buffer_filename;
	}
	
	static function convert_to($source,$from,$to){
		
		if(strtolower($from) == strtolower($to))
			return false;
		$buffer = explode('.',$source);
		$ext = $buffer[1];

		$source_preview = str_replace(self::$main_path,self::$preview_path,$source);
		$new_source_preview = str_replace($from,strtolower($to),$source_preview);
		$new_source = str_replace($from,strtolower($to),$source);
		
		if($from == 'jpg'){
			$image = imagecreatefromjpeg($source);		

		}
		elseif($from == 'gif'){
			$image = imagecreatefromgif($source);

		}
		elseif($from == 'png'){
			$image = imagecreatefrompng($source);
        	imagealphablending($image, false);
        	imagesavealpha($image, true);
        	$transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
        	imagefill($image, 0, 0, $transparent);
    		
		}
		if(strtolower($to) == 'jpg'){
			$new_image = imagejpeg($image,$new_source);

		}
		elseif(strtolower($to) == 'gif'){
			$new_image = imagegif($image,$new_source);
		}
		elseif(strtolower($to) == 'png'){
			$new_image = imagepng($image,$new_source);
		}

		$new_source_preview_80 = str_replace('preview','preview_80',$new_source_preview);
		$new_source_preview_moder = self::get_moder_preview_url($new_source_preview);

		if($new_image){
					$sizes = getimagesize($new_source);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					if(file_exists($new_source_preview))
						unlink($new_source_preview);
						if($file_width > $file_height)
							$res_preview = self::make_thumbnail($new_source,$new_source_preview,self::$width_thumbnails,0,0,0,false);
						else
							$res_preview = self::make_thumbnail($new_source,$new_source_preview,0,self::$height_thumbnails,0,0,false);


					if(file_exists($new_source_preview_moder))
						unlink($new_source_preview_moder);
						if($file_width > $file_height)
							$res_preview = self::make_thumbnail($new_source,$new_source_preview_moder,self::$thumbnail_cover_size,0,0,1,false);
						else
							$res_preview = self::make_thumbnail($new_source,$new_source_preview_moder,0,self::$thumbnail_cover_size,0,1,false);
					
					if(file_exists($new_source_preview_80))
						unlink($new_source_preview_80);
						if($file_width > $file_height)
							$res_preview = self::make_thumbnail($new_source,$new_source_preview_80,80,0,0,1,false);
						else
							$res_preview = self::make_thumbnail($new_source,$new_source_preview_80,0,80,0,1,false);

					return true;
				}
		
		imagedestroy($image);
		if($new_image){
			$res = unlink($source);
			
			if($res){
				
				if($res_preview)
					return true;

			}

		}
		return false;
		
	}
	
	static function new_url($source,$ext){
		
		$buffer = explode('.',$source);
		if(count($buffer) == 2){
			$new_source = $buffer[0];

		}
		elseif(count($buffer) > 2){
			array_pop($buffer);
			$new_source = implode('.',$buffer);
		}
		if($new_source)
			return $new_source.'.'.$ext;
	}
	
	static function watermark_text($oldimage_name, $new_image_name,$water_mark_text,$preview=false,$parameters = array()){
	// получение значений шрифта, размера и текста, используемых для наложение
	// получаем размеры исходного изображения
	list($owidth,$oheight) = getimagesize($oldimage_name);
	$buffer = explode('.',$oldimage_name);
	if(count($buffer) < 2)
		return false;
	$ext = $buffer[count($buffer)-1];
	
	// задаем размеры для выходного изображения		

	$font_path = SITE_DIR.self::$theme.DIRECTORY_SEPARATOR.self::$font_path.DIRECTORY_SEPARATOR.'font1.ttf';
	$font_size = self::$font_size;
	$width = $owidth;
	$height = $oheight;
	// создаем выходное изображение размерами, указанными выше
	$image = imagecreatetruecolor($owidth, $oheight);
	if($ext == 'jpg')
		$image_src = imagecreatefromjpeg($oldimage_name);
	elseif($ext == 'png')
		$image_src = imagecreatefrompng($oldimage_name);
	elseif($ext == 'gif')
		$image_src = imagecreatefromgif($oldimage_name);
		
	// наложение на выходное изображение, исходного
	imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
	// задаем цвет для накладываемого текста
	$blue = imagecolorallocate($image, 79, 166, 185);
	// определяем позицию расположения водяного знака 
	$pos_x = $width*1.25 - (strlen($water_mark_text)-1)*$font_size; 
	$pos_y = $height - (round($height*0.1));
	// наложение текста на выходное изображение		
	if($preview && count($parameters) > 0){
//		imagettftext($image, $font_size, 0, $parameters['width'], $parameters['height'], $parameters['color'], $font_path, $water_mark_text);
		imagettftext($image, $font_size, 0, $pos_x, $pos_y, $parameters['color'], $font_path, $water_mark_text);
	}
	else
		imagettftext($image, $font_size, 0, $pos_x, $pos_y, $blue, $font_path, $water_mark_text);
	// сохраняем выходное изображение, уже с водяным знаком в формате jpg и качеством 100
	if($ext == 'jpg')
		$res = imagejpeg($image, $new_image_name, 100);
	elseif($ext == 'png')
		$res = imagepng($image, $new_image_name, 100);
	elseif($ext == 'gif')
		$res = imagegif($image, $new_image_name, 100);

	// уничтожаем изображения
	imagedestroy($image);
	if($res)
		return true;
	return false;
}

static function watermark_image($oldimage_name, $new_image_name){
	// получаем имя изображения, используемого в качестве водяного знака 
	global $image_path;
	// получаем размеры исходного изображения
	list($owidth,$oheight) = getimagesize($oldimage_name);
	// задаем размеры для выходного изображения 
	$width = 600;
	$height = 300; 
	// создаем выходное изображение размерами, указанными выше
	$im = imagecreatetruecolor($width, $height);
	$img_src = imagecreatefromjpeg($oldimage_name);
	// наложение на выходное изображение, исходного
	imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
	$watermark = imagecreatefrompng($image_path);
	// получаем размеры водяного знака
	list($w_width, $w_height) = getimagesize($image_path);
	// определяем позицию расположения водяного знака 
	$pos_x = $width - $w_width; 
	$pos_y = $height - $w_height;
	// накладываем водяной знак
	imagecopy($im, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
	// сохраняем выходное изображение, уже с водяным знаком в формате jpg и качеством 100
	imagejpeg($im, $new_image_name, 100);
	// уничтожаем изображения
	imagedestroy($im);
//	unlink($oldimage_name);
	return true;
}

// $src             - имя исходного файла
//  $dest            - имя генерируемого файла
//  $width, $height  - ширина и высота генерируемого изображения, в пикселях
//***********************************************************************************/
static function img_resize($src, $dest, $width='', $height='')
{
  $rgb=0xFFFFFF;
  $quality=100;
  if(!$width && !$height)
  	return false;
  if (!file_exists($src)) return false;
 
  $size = getimagesize($src);
 
  if ($size === false) return false;
  if(!$width)
 	$width = $size[0];
  if(!$height)
  	$height = $size[1];
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;
 
  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];
 
  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);
 
  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
 
  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);
 
  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, 
    $new_width, $new_height, $size[0], $size[1]);

	
	
  if($format == 'jpeg')
  	$res = imagejpeg($idest, $dest, $quality);
  elseif($format == 'gif')
  	$res = imagegif($idest, $dest, $quality);
  elseif($format == 'png')
   	$res = imagepng($idest, $dest, $quality);
	
  imagedestroy($isrc);
  imagedestroy($idest);
  if($res)
  	return true;
  return false;
 
}

static function get_exif($filename){
	
	if(!function_exists('exif_imagetype'))
		return '';
	if (exif_imagetype($filename) == IMAGETYPE_JPEG)
	{
	//считываем заголовки
	$imagedata = exif_read_data($filename, 0, true);
	if ($imagedata === false)
		return '';
	else
	{
		$buffer = '';
	//выводим массив заголовков по секциям
foreach ($imagedata as $key => $section)
{
foreach ($section as $name => $value){
	if($key == 'EXIF' && $name == 'MakerNote')
		continue;
	if($value == '')
		continue;
	$value = iconv('Windows-1251', 'UTF-8//TRANSLIT', $value);
	$buffer .= "$key.$name : $value ; ";

}
}
}

	return $buffer;
	
	}
	else
		return '';
}


static function random_hash(){

	return md5(time().rand(0,10));

}

static function al_check_uploadimage($al_file_name)
{
	$alfp = fopen($al_file_name, 'rb');

	if (!$alfp)
		return false;

	while (!feof($alfp))
	{
		
		if (preg_match('~(iframe|\\<\\?php|html|eval|body|script\W)~', fgets($alfp, 16384/*4096*/)) === 1)
		{

			fclose($alfp);
			return false;
		}
	}
	fclose($alfp);
	return true;
}

	
}

 

?>