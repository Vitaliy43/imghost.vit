<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class My_Upload extends CI_Model {

	public $fast_fields_count = 3;
	public $fast_fields_count_iframe = 6;
	public $multiple_fields_count = 12;
	public $multiple_fields_count_iframe = 6;
	public $multiple_user_fields_count = 30;
	protected $fast_form_fields = array('RESIZE_TO_WIDTH','RESIZE_TO_HEIGHT','ROTATE','NAME','WATERMARK','DESCRIPTION','CONVERT_TO','PREVIEW_WIDTH','PREVIEW_HEIGHT','PREVIEW_TITLE','TINYURL','TAGS','TAGS_CHILDREN','ALBUMS','ACCESS','JPEG_QUALITY','PREVIEW_SIZE');
	protected $fast_form_fields_modify_gd = array('RESIZE_TO','ROTATE','WATERMARK','CONVERT_TO');
	protected $max_filesize = 20000000;
	protected $max_avatarsize = 500000;
	protected $max_imgsize = 25000000;
	public $default_avatar = 'images/default_avatar.gif';
	public $maxlength_show_filename = 50;
	public $access_levels_files = array('public','private');
	public $templates_table = 'upload_templates';
	public $upload_by_one = true;
	
    public function __construct() {
        parent::__construct();
		$this->load->library('upload');
    }
	
	function is_exists_template($name,$user_id){
		$user_id = (int)$user_id;
		$sql = 'SELECT COUNT(*) AS num FROM '.$this->templates_table." WHERE user_id = $user_id AND show_name = '$name'";
		$res = $this->db->query($sql);
		if(!$res)
			return false;
		$num = $res->row()->num;
		if($num > 0)
			return true;
		return false;
	}
	
	function capture(&$response){
		
		$error = '';
		$success = '';
		$language = Language::get_languages('upload');
		$data = $_POST['BLOB'];
		if(!$data)
			return false;
		$ext = 'png';
		
    	$image = str_replace(" ", "+", $data);
    	$image = substr($image, strpos($image, ","));
		$image = base64_decode($image);
		$tmp_name = md5($_SERVER['REMOTE_ADDR'].time()).'.'.$ext;
		$fp = fopen(IMGDIR.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$tmp_name,'w+');
		$filesize = fwrite($fp,$image);
		fclose($fp);
		if(!$filesize){
			$response['error'] = 'Ошибка создания файла из буфера обмена!';
			return false;
		}

			
		$tmp_sizes = getimagesize(IMGDIR.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$tmp_name);
		$tmp_width = $tmp_sizes[0];
		$tmp_height = $tmp_sizes[1];

		if($this->my_auth->role == 'guest'){
			$hash = $this->guests->key.'_'.md5(rand(0,1000)+time());
			$is_identical = $this->ban_identical_files('guest',$this->guests->key,array('show_filename' => $language['FAST_SCREENSHOT'],'filesize' => $filesize, 'width' => $tmp_width, 'height' => $tmp_height));

			}
			else{
				$hash = $this->members->user_id.'_'.(rand(0,1000)+time());
				$is_identical = $this->ban_identical_files('user',$this->my_auth->user_id,array('show_filename' => $language['FAST_SCREENSHOT'],'filesize' => $filesize, 'width' => $tmp_width, 'height' => $tmp_height));

			}
		
		if($tmp_height*$tmp_width >= $this->max_imgsize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_IMGSIZE_DIRECTIVE'];
			return ;
		}

			$comment = '';
			
			//////////////////////////////////////////////// Предотвращаем загрузку файлов-копий в рамках одного аккаунта ////////////////////////////

			if($is_identical){
				$response['error'] = 'Данный файл уже загружен';
				$response['success'] = '';
				return $response;
			}
			
					
			$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
			$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;

			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
				
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";
			$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_html = '/image/'.$buffer_filename_url;
			$data_create = date('Y-m-d H:i:s');



			if(copy(IMGDIR.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$tmp_name,$filename_destiny)){
				ImageHelper::$preview_mode = true;
				unlink(IMGDIR.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$tmp_name);

				if(isset($_POST['PREVIEW_WIDTH']) && $_POST['PREVIEW_WIDTH'] > 0){
					$preview_width = (int)$_POST['PREVIEW_WIDTH'];
				}
				
				if(isset($_POST['PREVIEW_HEIGHT']) && $_POST['PREVIEW_HEIGHT'] > 0){
					$preview_height = (int)$_POST['PREVIEW_HEIGHT'];
				}
				
				if(ImageHelper::$enable_compression){
					
					if(isset($_POST['JPEG_QUALITY']) && $ext == 'jpg'){
						$jpeg_quality = (int)$this->input->post('JPEG_QUALITY');
						if($jpeg_quality >= 50 && $jpeg_quality < 100){
							$im = new Imagick($filename_destiny);
							$im->setImageCompression(Imagick::COMPRESSION_JPEG);
							$im->setImageCompressionQuality($jpeg_quality);
							$im->writeImage($filename_destiny);
							$im->clear();
							$im->destroy();
						}	
					}
				}
				
				if(empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,ImageHelper::$width_thumbnails,0,0,0,false);

				}
				elseif(!empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_width,0,0,0,false);


				}
				elseif(!empty($preview_height) && empty($preview_width)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_height,0,0,false);

				}
				
				$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_80,80,0,0,0,false);

				
				if($res){
					
					$urls = $this->modify_new_image($filename_destiny,array('big' => $filename_src_big, 'preview' => $filename_src_preview, 'destiny' => $filename_destiny));
					$filename_src_big = $urls['big'];
					$filename_src_preview = $urls['preview'];
					$filename_destiny = $urls['destiny'];
					$sizes = getimagesize($filename_destiny);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					$image_proportion = $file_height / $file_width;
					$show_filename = $language['SCREENSHOT'].' '.$data_create;
					$success = $lang_upload['UPLOAD_SUCCESSFULL'];
					
					$pixels = $file_height * $file_width;
					if($pixels > ImageHelper::$web_pixel_size){
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'));
				
						}	
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
							@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
						}
						$filename_destiny_web = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
						ImageHelper::$preview_mode = true;
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_web,ImageHelper::$web_width);

					}
					
					if($_POST['DESCRIPTION'])
							$comment = $_POST['DESCRIPTION'];
						if($_POST['NAME'])
							$show_filename = $_POST['NAME'];
							
					if(isset($_POST['TAGS']) && $_POST['TAGS'] != '0'){
						if(isset($_POST['TAGS_CHILDREN']) && $_POST['TAGS_CHILDREN'] != '0')
							$tag_id = (int)$_POST['TAGS_CHILDREN'];
						else
							$tag_id = (int)$_POST['TAGS'];
					}
					else{
						$tag_id = null;
					}
					
					if(isset($_POST['ALBUMS']) && $_POST['ALBUMS'] != 0){
						$album_id = $_POST['ALBUMS'];
						$access = $this->my_albums->get_access_album($album_id);

					}
					else{
						$album_id = null;
						if(isset($_POST['ACCESS'])){
							$access = $_POST['ACCESS'];
						}
						else
							$access = 'public';
						if(!in_array($access,$this->access_levels_files))
							$access = 'public';					
						}
					
					if(isset($_POST['TINYURL']) && $_POST['TINYURL'])
						$tiny_url = $this->bitly->get_url(SITE_URL.$filename_src_html);		
					else
						$tiny_url  = '';
					
					if($show_filename == 'blob' || $show_filename == 'undefined'){
						$show_filename = 'Screenshot-'.date('Y-m-d_H:i:s');
;
					}	
					

					if($this->my_auth->role == 'guest'){
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'guest_key' => $this->guests->key,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'access' => $access
						);
								
						
						if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
							$parameters['torrent_id'] = $_REQUEST['torrent_id'];
							$curr_time = time();
							$parameters['position'] = 0;
							$parameters['cover'] = 1;
							ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_moder,150,true);
						}
						
						if(!$this->add_image_guest($parameters)){
							unset($parameters['exif']);
							if(!$this->add_image_guest($parameters)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';
							}
							else{
								$last_id = $this->db->insert_id();
								if($last_id && isset($_REQUEST['torrent_id'])){
									$data_cover = array(
									'torrent_id' => (int)$_REQUEST['torrent_id'],
									'image_id' => $last_id
									);
									$this->db->insert('image_covers',$data_cover);
								}
								if($last_id)
									$response['link'] = '/images_guest/edit/'.$last_id;
								else
									$response['link'] = '';
							}
						}
						else{
							$last_id = $this->db->insert_id();
							if($last_id && isset($_REQUEST['torrent_id'])){
									$data_cover = array(
									'torrent_id' => (int)$_REQUEST['torrent_id'],
									'image_id' => $last_id
									);
									$this->db->insert('image_covers',$data_cover);
								}
							if($last_id)
								$response['link'] = '/images_guest/edit/'.$last_id;
							else
								$response['link'] = '';
						}
						
						$response['imglink'] = IMGURL.$filename_src_big;
						$response['id'] = $last_id;
						$response['imglink_html'] = SITE_URL.$filename_src_html;
						$response['image'] = '<a href="'.IMGURL.$filename_src_big.'" onclick="show_image(this);return false;"><img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
						$response['form_number'] = $_POST['current_form'];
						$response['width'] = $file_width;
						$response['height'] = $file_height;
						$response['tiny_url'] = $tiny_url;

					}
					else{
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'user_id' => $this->members->user_id,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'album_id' => $album_id,
						'access' => $access
						);
						
						if(!$this->add_image_member($parameters)){
							unset($parameters['exif']);
							if(!$this->add_image_member($parameters)){
								$error = $lang_main['DB_INSERT_ERROR'];

							}
							else{
								$last_id = $this->db->insert_id();
								
								if($last_id)
									$response['link'] = '/images/edit/'.$last_id;
								else
									$response['link'] = '';
							}

						}
						else{
							$last_id = $this->db->insert_id();
							if($last_id)
								$response['link'] = '/images/edit/'.$last_id;
							else
								$response['link'] = '';
						}

						$response['imglink'] = IMGURL.$filename_src_big;
						$response['id'] = $last_id;
						$response['imglink_html'] = SITE_URL.$filename_src_html;
						$response['image'] = '<a href="'.IMGURL.$filename_src_big.'" onclick="show_image(this);return false;"><img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
						$response['width'] = $file_width;
						$response['height'] = $file_height;
						$response['tiny_url'] = $tiny_url;
					}

						$response['role'] = $this->my_auth->role;
						$response['error'] = $error;
						$response['success'] = $success;
						$response['form_number'] = $_POST['current_form'];
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}
		$response['role'] = $this->my_auth->role;
		$response['error'] = $error;
		$response['success'] = $success;
		$response['form_number'] = $_POST['current_form'];

	}
	
	function set_template($user_id=null, $template_id = null){
		$arr = array();
		if(!$this->input->post('TEMPLATE_NAME'))
			return false;
		foreach($this->fast_form_fields as $item){
			
			if(isset($_POST[$item]) && $_POST[$item] != ''){
				if(($item == 'ACCESS' || $item == 'ALBUMS' || $item == 'ROTATE') && (!$_POST[$item] || $_POST[$item] == 'undefined'))
					continue;
				if(($item == 'RESIZE_TO_WIDTH' || $item == 'RESIZE_TO_HEIGHT') && !$_POST[$item])
					continue;
				if(($item == 'PREVIEW_WIDTH' || $item == 'PREVIEW_HEIGHT') && !$_POST[$item])
					continue;
				if($item == 'JPEG_QUALITY' && !ImageHelper::$enable_compression)
					continue;
				if($item == 'JPEG_QUALITY' && $_POST[$item] == 100)
					continue;
				$field = str_replace(';','',$_POST[$item]);
				$arr[$item] = $field;
			}		
		}
		$str = serialize($arr);
		if(!$user_id)
			$user_id = $this->my_auth->user_id;
		if(!$str)
			return false;
		$data = array(
		'id' => null,
		'user_id' => $user_id,
		'show_name' => $this->input->post('TEMPLATE_NAME'),
		'options' => $str,
		'comment' => $this->input->post('TEMPLATE_COMMENT')
		);
		if(!$template_id){
			$res = $this->db->insert($this->templates_table,$data);

		}
		else{
			$this->db->where('id', $template_id);
			unset($data['id']);
			unset($data['user_id']);
			$res = $this->db->update($this->templates_table,$data);

		}
		
		return $res;
	}
	
	function delete_template($id,$user_id){
		$this->db->where('id',$id);
		$this->db->where('user_id',$user_id);
		$res = $this->db->delete('upload_templates');
		return $res;
	}
	
	function get_options($arr,$language,$user_id,$parameters,$return_arr=false, $without_language = false){
		$new_arr = array();
						
		foreach($arr as $key=>$value){
			if($key == 'ALBUMS' && isset($parameters['albums']))
				$value = '<a href="/albums/'.$value.'" target="_blank">'.$parameters['albums'][$value].'</a>';
			elseif($key == 'ACCESS'){
				$value = $language[strtoupper($value)];
			}
			elseif($key == 'TAGS' && isset($parameters['tags'])){
				$value = $parameters['tags'][$value];
			}
			elseif($key == 'TINYURL'){
				
				if(!$without_language){
					if($value)
						$value = $language['YES'];
					else
						$value = $language['NO'];
				}
				
			}

			if(isset($language[$key]) && !$without_language){
				
				$new_arr[$key] = $language[$key].': '.$value;
			}
			
			if($without_language)
				$new_arr[$key] = $value;
		}
	
		if($return_arr)
			return $new_arr;
		$str = implode(' ; ',$new_arr);
		if(count($new_arr) > 0)
			return $str;
		return '';
	}
	
	function get_parameters($user_id){
		$parameters = array();
		$res_albums = $this->db->get_where('albums',array('user_id' => $user_id));
		foreach($res_albums->result_array() as $item){
			$parameters['albums'][$item['id']] = $item['name'];
		}
		$res_tags = $this->db->get('tags');
		foreach($res_tags->result_array() as $item){
			$parameters['tags'][$item['id']] = $item['value'];
		}
		
		return $parameters;
	}
	
	function get_template_by_id($id,$language){
		
		$this->db->select('id,show_name,options,user_id,comment');
		$this->db->where('id',$id);
		$res = $this->db->get($this->templates_table);
		if(!$res || !$res->row()->user_id)
			return false;
		
		$parameters = $this->get_parameters($res->row()->user_id);
		if(!$res || $res->num_rows() < 1)
			return array();
		$buffer = unserialize($res->row()->options);
		$options = $this->get_options($buffer, $language, $res->row()->user_id, $parameters, true, true);
		if($res->row()->comment)
			$options['COMMENT'] = $res->row()->comment;
		$options['NAME'] = $res->row()->show_name;

		return $options;

	}
	
	function list_templates($user_id,$language,$box=false){
		
		if($box){
			
			$this->db->select('id,show_name');
			$this->db->where('user_id',$user_id);
			$this->db->order_by('show_name');
			$res = $this->db->get($this->templates_table);
			if(!$res || count($res) < 1)
				return '';
			$arr = $res->result_array();
			return $arr;
		}
		else{
			$this->db->select('id,show_name,options');
			$this->db->where('user_id',$user_id);
			$this->db->order_by('show_name');
			$res = $this->db->get($this->templates_table);
			$parameters = $this->get_parameters($user_id);
			if(!$res || count($res) < 1)
				return array();
			$arr = $res->result_array();
			foreach($arr as $key=>$value){
				$buffer = unserialize($value['options']);
				$arr[$key]['options'] = $this->get_options($buffer,$language,$user_id,$parameters);
			}
			return $arr;
		}
		
	}
	
	function get_template_options($user_id,$id,$language,$return_arr=false){
		
		$this->db->select('options');
		$this->db->where('id',$id);
		$this->db->where('user_id',$user_id);
		$res = $this->db->get($this->templates_table);
		$parameters = $this->get_parameters($user_id);
		if(!$res || count($res) < 1)
			return array();
		$arr = $res->row_array();
		$buffer = unserialize($arr['options']);
		return $this->get_options($buffer,$language,$user_id,$parameters,$return_arr);
		
	}
	
	function num_templates($user_id){
		$user_id = (int)$user_id;
		$sql = "SELECT COUNT(*) AS num FROM ".$this->templates_table." WHERE user_id = $user_id";
		$res = $this->db->query($sql);
		if(!$res)
			return 0;
		return $res->row()->num;
	}
	
	function get_template($user_id,$id){
		$id = (int)$id;
		if(!$id)
			return '';
		$this->db->select('options');
		$this->db->where('user_id',$user_id);
		$this->db->where('id',$id);
		$res = $this->db->get($this->templates_table);
		if(!$res || count($res) < 1)
			return false;
		return $res->row_array();
	}
	
	function api(&$response){
		
		$num_files = (int)$_REQUEST['num_files'];
		$guest_key = $_REQUEST['token'];
		$torrent_id = (int)$_REQUEST['torrent_id'];
		for($i=1;$i<$num_files+1;$i++):
		$fileElementName = 'screen'.$i;
        
		if(empty($_FILES[$fileElementName]) || $_FILES[$fileElementName]['name'] == ''){
		      continue;
		}
	
		if(filesize($_FILES[$fileElementName]['tmp_name']) >= $this->max_filesize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
			return;
		}
		
		if(!ImageHelper::al_check_uploadimage($_FILES[$fileElementName]['tmp_name'])){
			$response['error'] = $lang_upload['ILEGAL_UPLOAD_INFECTION_MULTIPLE'];
			return;
		}
		$tmp_sizes = getimagesize($_FILES[$fileElementName]['tmp_name']);
		$tmp_width = $tmp_sizes[0];
		$tmp_height = $tmp_sizes[1];
		if($tmp_height*$tmp_width >= $this->max_imgsize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_IMGSIZE_DIRECTIVE'];
			return ;
		}
		
			if(strpos($_FILES[$fileElementName]['type'],'jpeg'))
				$ext = 'jpg';
			elseif(strpos($_FILES[$fileElementName]['type'],'png'))
				$ext = 'png';
			elseif(strpos($_FILES[$fileElementName]['type'],'gif'))
				$ext = 'gif';
			else
				$ext = '';
				
			if($ext != '')
				$correct_extension = true;	
			if($correct_extension){
			
			$data_create = date('Y-m-d H:i:s');
			if(isset($_REQUEST['DESCRIPTION']))
				$comment = $_REQUEST['DESCRIPTION'];
			else
				$comment = '';
				$hash = $guest_key.'_'.md5($_FILES[$fileElementName]['name'].(rand(0,1000)+time()));
				$is_identical = $this->ban_identical_files('guest',$guest_key,array('show_filename' => $_FILES[$fileElementName]['tmp_name'],'filesize' => filesize($_FILES[$fileElementName]['tmp_name']), 'width' => $tmp_width, 'height' => $tmp_height));
			
			//////////////////////////////////////////////// Предотвращаем загрузку файлов-копий в рамках одного аккаунта ////////////////////////////

			if($is_identical){
				$response['error'] = 'Данный файл уже загружен';
				$response['success'] = '';
				return $response;
			}
			
					
			$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
			$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;

			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
			}
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_html = '/image/'.$buffer_filename_url;

			if(move_uploaded_file($_FILES[$fileElementName]['tmp_name'],$filename_destiny)){
				$res = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview);
				$res2 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);
				
				if($res){
					$urls = $this->modify_new_image($filename_destiny,array('big' => $filename_src_big, 'preview' => $filename_src_preview, 'destiny' => $filename_destiny));
					$filename_src_big = $urls['big'];
					$filename_src_preview = $urls['preview'];
					$filename_destiny = $urls['destiny'];
					$sizes = getimagesize($filename_destiny);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					$image_proportion = $file_height / $file_width;
					$show_filename = $_FILES[$fileElementName]['name'];
					
					
					$success = $lang_upload['UPLOAD_SUCCESSFULL'];
					
					if($_REQUEST['DESCRIPTION'])
							$comment = $_REQUEST['DESCRIPTION'];
						if($_REQUEST['NAME'])
							$show_filename = $_REQUEST['NAME'];
							
					if(isset($_REQUEST['TAGS']) && $_REQUEST['TAGS'] != '0'){
						if(isset($_REQUEST['TAGS_CHILDREN']) && $_REQUEST['TAGS_CHILDREN'] != '0')
							$tag_id = (int)$_REQUEST['TAGS_CHILDREN'];
						else
							$tag_id = (int)$_REQUEST['TAGS'];
					}
					else{
						$tag_id = null;
					}
					
					if(isset($_REQUEST['ALBUMS']) && $_REQUEST['ALBUMS'] != 0){
						$album_id = $_REQUEST['ALBUMS'];
						$access = $this->my_albums->get_access_album($album_id);

					}
					else{
						$album_id = null;
						if(isset($_REQUEST['ACCESS'])){
							$access = $_REQUEST['ACCESS'];
						}
						else
							$access = 'public';
						if(!in_array($access,$this->access_levels_files))
							$access = 'public';					
						}
					
					$show_filename .= ' '.$fileElementName;
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'guest_key' => $guest_key,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'access' => $access,
						'rating' => 0,
						'views' => 0,
						'torrent_id' => $torrent_id
						);

						
						if(!$this->add_image_guest($parameters)){
							unset($parameters['exif']);
							if(!$this->add_image_guest($parameters)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';
							}
							else{
								$last_id = $this->db->insert_id();
								if($last_id)
									$response['link'] = '/images_guest/edit/'.$last_id;
								else
									$response['link'] = '';
							}
						}
						else{
							$last_id = $this->db->insert_id();
							if($last_id)
								$response['link'] = '/images_guest/edit/'.$last_id;
							else
								$response['link'] = '';
						}
						
						$response['imglink'][$i] = IMGURL.$filename_src_big;
						$response['imglink_html'][$i] = SITE_URL.$filename_src_html;
									
					
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}

		}
		else{
			$uploaded = 0;
				$error = $lang_upload['WRONG_EXTENSION'];
		}
		
		endfor;
	}
	
	function multiple(&$response){
		
		$lang_upload = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$fileElementName = 'files';
		$error = '';
		$success = '';
		$response['language'] = $lang_upload;

		if($_FILES[$fileElementName]['error'][0])
	{
		switch($_FILES[$fileElementName]['error'][0])
		{

			case '1':
				$error = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				break;
			case '2':
//				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form!';
				$error = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				break;
			case '3':
				$error = $lang_upload['PARTIALLY_UPLOADED'];
				break;
			case '4':
				$error = $lang_upload['NO_UPLOADED'];
				break;

			case '6':
				$error = $lang_upload['ERROR_TEMP_FOLDER'];
				break;
			case '7':
				$error = $lang_upload['ERROR_WRITE_DISK'];
				break;
			case '8':
				$error = $lang_upload['ERROR_EXTENSION'];
				break;
			case '999':
			default:
				$error = $lang_upload['UNKNOWN_UPLOAD_ERROR'];
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name'][0]) || $_FILES[$fileElementName]['tmp_name'][0] == 'none')
	{
		if($_POST['FILE_URL']){

			if($this->upload_by_one)
				$buffer = array($_POST['FILE_URL']);
			else
				$buffer = explode("\n",$_POST['FILE_URL']);
			unset($response['language']);

			if(count($buffer) < 1){
				
			}
			else{
				$counter = 0;
				foreach($buffer as $url){
					if(!$url)
						continue;
					$url = trim($url);
						$self = get_self_host($url);
						if($self){
							$old_url = $url;
							$url = ImageHelper::url_to_realpath($url,true);
							$check_url = true;
						}
						else{
							$check_url = true;
							
							$http_status = check_http_status($url);
							
							$tmp_sizes = getimagesize($url);
							$tmp_width = $tmp_sizes[0];
							$tmp_height = $tmp_sizes[1];
			
							if($tmp_width > ImageHelper::$max_width){
								$response['role'] = $this->my_auth->role;
								$response['success'] = '';
								$response['form_number'] = 'upload-multi-links';
								$response['error'] = $lang_upload['MAX_WIDTH_EXCEED'];
								return false;
							}
				
							if($tmp_height > ImageHelper::$max_height){
								$response['role'] = $this->my_auth->role;
								$response['success'] = '';
								$response['form_number'] = 'upload-multi-links';
								$response['error'] = $lang_upload['MAX_HEIGHT_EXCEED'];
								return false;
							}
							
							$response[$counter]['status'] = $http_status;
							$http_status = (int)$http_status;
							if($http_status >= 400){
							$response[$counter]['error'] = 'Ошибка';
							$response[$counter]['url'] = $url;
							if(isset($lang_upload['HTTP_STATUS'][$http_status]))
								$response[$counter]['error'] = $lang_upload['HTTP_STATUS'][$http_status];
							else
								$response[$counter]['error'] = 'Ошибка';
							$counter++;
							continue;
						
							}
					
					elseif(!$http_status){
							$http_status = check_url($url);
							$response[$counter]['status2'] = $http_status;
							$response[$counter]['error'] = $lang_main['WRONG_URL'];
							$counter++;
							continue;							
						
					}
					else{
						
						$check_url = true;
					}
							
						}
										
					
				if($check_url){
					
					if(!ImageHelper::al_check_uploadimage($url)){
						$error = $lang_upload['ILEGAL_UPLOAD_INFECTION_MULTIPLE'];
						continue;
					}
					
					$ext = pathinfo($url, PATHINFO_EXTENSION);
					if(strstr($ext,'?') != ''){
						$buffer = explode('?',$ext);
						$ext = $buffer[0];
					}
					$filename = get_filename_from_url($url);
				
			$data_create = date('Y-m-d H:i:s');
			$hash = md5(date('H').date('i').date('s').$_SERVER['REMOTE_ADDR']);
			if(isset($_POST['DESCRIPTION']))
				$comment = $_POST['DESCRIPTION'];
			else
				$comment = '';
			if($this->my_auth->role == 'guest'){
				$hash = md5($this->guests->key).'_'.md5($filename.'.'.$ext.(rand(0,1000)+time()));
				$image = $this->get_image_guest($hash);

			}
			else{
				$hash = $this->members->user_id.'_'.md5($filename.'.'.$ext.(rand(0,1000)+time()));
				$image = $this->get_image_member($hash);
			}
			
			$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
			$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;

			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";
			$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_html = '/image/'.$buffer_filename_url;
			
			if(copy($url,$filename_destiny)){
				ImageHelper::$preview_mode = true;
				
				if(isset($_POST['PREVIEW_WIDTH']) && $_POST['PREVIEW_WIDTH'] > 0){
					$preview_width = (int)$_POST['PREVIEW_WIDTH'];
				}
				
				if(isset($_POST['PREVIEW_HEIGHT']) && $_POST['PREVIEW_HEIGHT'] > 0){
					$preview_height = (int)$_POST['PREVIEW_HEIGHT'];
				}
				
				if(ImageHelper::$enable_compression){
					
					if(isset($_POST['JPEG_QUALITY']) && $ext == 'jpg'){
						$jpeg_quality = (int)$_POST['JPEG_QUALITY'];
						if($jpeg_quality >= 50 && $jpeg_quality < 100){
							$im = new Imagick($filename_destiny);
							$im->setImageCompression(Imagick::COMPRESSION_JPEG);
							$im->setImageCompressionQuality($jpeg_quality);
							$im->writeImage($filename_destiny);
							$im->clear();
							$im->destroy();
						}	
					}
				}
				
				if(empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,ImageHelper::$width_thumbnails,0,0,0,false);

				}
				elseif(!empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_width,0,0,0,false);


				}
				elseif(!empty($preview_height) && empty($preview_width)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_height,0,0,false);

				}
				
				$res2 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);
				
				if($res){
					$this->modify_new_image($filename_destiny);
					$sizes = getimagesize($filename_destiny);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					
					if($file_width > ImageHelper::$max_width){
						$response[$counter]['role'] = $this->my_auth->role;
						$response[$counter]['success'] = '';
						$response[$counter]['form_number'] = $_POST['current_form'];
						$response[$counter]['error'] = $lang_upload['MAX_WIDTH_EXCEED'];
						return false;
					}
				
					if($file_height > ImageHelper::$max_height){
						$response[$counter]['role'] = $this->my_auth->role;
						$response[$counter]['success'] = '';
						$response[$counter]['form_number'] = $_POST['current_form'];
						$response[$counter]['error'] = $lang_upload['MAX_HEIGHT_EXCEED'];
						return false;
					}
					
					$image_proportion = $file_height / $file_width;
					if(isset($old_url))
						$show_filename = get_show_filename($old_url);
					else
						$show_filename = get_show_filename($url);
					$success = $lang_upload['UPLOAD_SUCCESSFULL'];
					
					$pixels = $file_height * $file_width;
					if($pixels > ImageHelper::$web_pixel_size){
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'));
				
						}	
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));

							@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
						}
						$filename_destiny_web = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
						ImageHelper::$preview_mode = true;
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_web,ImageHelper::$web_width);

					}
						
					if($_POST['DESCRIPTION'])
						$comment = $_POST['DESCRIPTION'];
					if($_POST['NAME'])
						$show_filename = $_POST['NAME'];
						
					if(isset($_POST['TAGS']) && $_POST['TAGS'] != '0'){
						if(isset($_POST['TAGS_CHILDREN']) && $_POST['TAGS_CHILDREN'] != '0')
							$tag_id = (int)$_POST['TAGS_CHILDREN'];
						else
							$tag_id = (int)$_POST['TAGS'];
					}
					else{
						$tag_id = null;
					}
					
					if(isset($_POST['ALBUMS']) && $_POST['ALBUMS'] != 0){
						$album_id = $_POST['ALBUMS'];
						$access = $this->my_albums->get_access_album($album_id);

					}
					else{
						$album_id = null;
						if(isset($_POST['ACCESS'])){
							$access = $_POST['ACCESS'];
						}
						else
							$access = 'public';
						if(!in_array($access,$this->access_levels_files))
							$access = 'public';	
					}
						
					if(mb_strlen($show_filename) > $this->maxlength_show_filename)
						$show_filename = mb_substr($show_filename,0,$this->maxlength_show_filename);
						
					if(isset($_POST['TINYURL']) && $_POST['TINYURL'])
						$tiny_url = $this->bitly->get_url(SITE_URL.$filename_src_html);
					else
						$tiny_url = null;
						
					$last_id = 0;
					
					if($this->my_auth->role == 'guest'){
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'guest_key' => $this->guests->key,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'access' => $access,
						'rating' => 0,
						'views' => 0
						);
						
						if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
							$parameters['torrent_id'] = $_REQUEST['torrent_id'];
							$torrent_info = $this->get_torrent_info($_REQUEST['torrent_id']);
							if($torrent_info && isset($torrent_info->owner_key) && $torrent_info->owner_key != $_REQUEST['token']){
								$parameters['guest_key'] = $torrent_info->owner_key;
							}
							if(!$torrent_info)
								$last_position = 0;
							else
								$last_position = $torrent_info->max_position;
							if(isset($_REQUEST['position']))
								$position = $_REQUEST['position'] + $last_position;
							else
								$position = $last_position;
								
							$curr_time = time();		

							if(isset($_SESSION['last_position'][$_REQUEST['torrent_id']]))
								$parameters['position'] = $position + $_SESSION['last_position'][$_REQUEST['torrent_id']];
							else
								$parameters['position'] = $position;
							ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder,150,0,0,1,false);

						}
						
						if(!$this->add_image_guest($parameters,$last_id)){
							$error = $lang_main['DB_INSERT_ERROR'];
							$response[$counter]['link'] = 0;
						}
						else{
							if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
								$this->seedoff_sync->set_screen($last_id,$parameters);
							}
							if($last_id)
								$response[$counter]['link'] = '/images_guest/edit/'.$last_id;
							else
								$response[$counter]['link'] = 0;
						}
						$response[$counter]['thumbnail_url'] = $filename_src_preview;
						$response[$counter]['thumbnail_width'] = round(ImageHelper::$size_fast_upload/2);
						$response[$counter]['thumbnail_height'] = round((ImageHelper::$size_fast_upload*$image_proportion)/2);
						$response[$counter]['imglink'] = IMGURL.$filename_src_big;
						$response[$counter]['imglink_html'] = SITE_URL.$filename_src_html;
						$response[$counter]['image'] = '<img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'">';
						$response[$counter]['imglink_preview'] = $filename_src_preview;
						$response[$counter]['imglink_preview_html'] = htmlspecialchars('<a href="'.SITE_URL.$filename_src_html.'" target="_blank"><img src="'.$filename_src_preview.'" border="0" /></a>');
						$response[$counter]['imglink_preview_bb'] = '[URL='.SITE_URL.$filename_src_html.'][IMG]'.$filename_src_preview.'[/IMG][/URL]';
						$response[$counter]['html_link'] = $filename_src_html;
						$response[$counter]['size'] = filesize($filename_destiny);
						$response[$counter]['role'] = $this->my_auth->role;
						$response[$counter]['id'] = $last_id;
						$response[$counter]['ext'] = $ext;
						if($tiny_url)
							$response[$counter]['tiny_url'] = $tiny_url;
						$response[$counter]['error'] = $error;
						$response[$counter]['success'] = $success;
						$response[$counter]['name'] = $url;
						$response[$counter]['url'] = $filename_src_big;

						$response[$counter]['short_imglink_html'] = SITE_URL.'/image/'.$last_id;
						$response[$counter]['short_imglink'] = IMGURL.'/b/'.$last_id.'.'.$ext;
						$response[$counter]['short_imglink_preview'] = IMGURL.'/p/'.$last_id.'.'.$ext;
						$response[$counter]['short_imglink_preview_html'] = htmlspecialchars('<a href="'.$response[$counter]['short_imglink_html'].'" target="_blank"><img src="'.$response['short_imglink_preview'].'" border="0" /></a>');
						
						$response[$counter]['short_imglink_preview_bb'] = '[URL='.$response[$counter]['short_imglink_html'].'][IMG]'.$response[$counter]['short_imglink_preview'].'[/IMG][/URL]';
						
						$counter++;

					}
					else{
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'user_id' => $this->members->user_id,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'album_id' => $album_id,
						'access' => $access
						);
						if(!$this->add_image_member($parameters,$last_id)){
							$error = $lang_main['DB_INSERT_ERROR'];
							$response[$counter]['link'] = '';
						}
						else{
							if($last_id)
								$response[$counter]['link'] = '/images/edit/'.$last_id;
							else
								$response[$counter]['link'] = '';
						}
						$response[$counter]['thumbnail_url'] = $filename_src_preview;
						$response[$counter]['thumbnail_width'] = round(ImageHelper::$size_fast_upload/2);
						$response[$counter]['thumbnail_height'] = round((ImageHelper::$size_fast_upload*$image_proportion)/2);
						$response[$counter]['imglink'] = IMGURL.$filename_src_big;
						$response[$counter]['imglink_preview'] = $filename_src_preview;
						$response[$counter]['imglink_preview_html'] = htmlspecialchars('<a href="'.SITE_URL.$filename_src_html.'" target="_blank"><img src="'.$filename_src_preview.'" border="0" /></a>');
						$response[$counter]['imglink_preview_bb'] = '[URL='.SITE_URL.$filename_src_html.'][IMG]'.$filename_src_preview.'[/IMG][/URL]';
						$response[$counter]['imglink_html'] = SITE_URL.$filename_src_html;
						$response[$counter]['image'] = '<img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'">';
						$response[$counter]['html_link'] = $filename_src_html;
						$response[$counter]['size'] = filesize($filename_destiny);
						$response[$counter]['role'] = $this->my_auth->role;
						$response[$counter]['id'] = $last_id;
						$response[$counter]['ext'] = $ext;
						if($tiny_url)
							$response[$counter]['tiny_url'] = $tiny_url;
						$response[$counter]['error'] = $error;
						$response[$counter]['success'] = $success;
						$response[$counter]['name'] = $url;
						$response[$counter]['url'] = $filename_src_big;
						
						$response[$counter]['short_imglink_html'] = SITE_URL.'/image/'.$last_id;
						$response[$counter]['short_imglink'] = IMGURL.'/b/'.$last_id.'.'.$ext;
						$response[$counter]['short_imglink_preview'] = IMGURL.'/p/'.$last_id.'.'.$ext;
						$response[$counter]['short_imglink_preview_html'] = htmlspecialchars('<a href="'.$response[$counter]['short_imglink_html'].'" target="_blank"><img src="'.$response['short_imglink_preview'].'" border="0" /></a>');
						
						$response[$counter]['short_imglink_preview_bb'] = '[URL='.$response[$counter]['short_imglink_html'].'][IMG]'.$response[$counter]['short_imglink_preview'].'[/IMG][/URL]';
						
						$counter++;
					}
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}
				
			}
			else{
					$error = $lang_main['WRONG_URL'];
					continue;
			}
				}
				
			}
			
		}
		else{
			$error = $lang_upload['NO_UPLOADED'];

		}
	}else 
	{
		if(filesize($_FILES[$fileElementName]['tmp_name'][0]) >= $this->max_filesize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
			return;
		}
		$tmp_sizes = getimagesize($_FILES[$fileElementName]['tmp_name'][0]);
		if(!ImageHelper::al_check_uploadimage($_FILES[$fileElementName]['tmp_name'][0])){
			$response['error'] = $lang_upload['ILEGAL_UPLOAD_INFECTION'];
			return;
		}
		$tmp_width = $tmp_sizes[0];
		$tmp_height = $tmp_sizes[1];
		
		if($tmp_width > ImageHelper::$max_width){
			$response['role'] = $this->my_auth->role;
			$response['success'] = '';
			$response['form_number'] = $_POST['current_form'];
			$response['error'] = $lang_upload['MAX_WIDTH_EXCEED'];
			return false;
		}
				
		if($tmp_height > ImageHelper::$max_height){
			$response['role'] = $this->my_auth->role;
			$response['success'] = '';
			$response['form_number'] = $_POST['current_form'];
			$response['error'] = $lang_upload['MAX_HEIGHT_EXCEED'];
			return false;
		}
		
		if($tmp_height*$tmp_width >= $this->max_imgsize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_IMGSIZE_DIRECTIVE'];
			return ;
		}
		
			if(strpos($_FILES[$fileElementName]['type'][0],'jpeg'))
				$ext = 'jpg';
			elseif(strpos($_FILES[$fileElementName]['type'][0],'png'))
				$ext = 'png';
			elseif(strpos($_FILES[$fileElementName]['type'][0],'gif'))
				$ext = 'gif';
			else
				$ext = '';
				
			if($ext != '')
				$correct_extension = true;	
			
		if($correct_extension){
			
			$data_create = date('Y-m-d H:i:s');
			if(isset($_POST['DESCRIPTION']))
				$comment = $_POST['DESCRIPTION'];
			else
				$comment = '';
			if($this->my_auth->role == 'guest'){
				$hash = md5($this->guests->key).'_'.md5($_FILES[$fileElementName]['name'][0].(rand(0,1000)+time()));
				$image = $this->get_image_guest($hash);
			}
			else
			{
				$hash = $this->members->user_id.'_'.md5($_FILES[$fileElementName]['name'][0].(rand(0,1000)+time()));
				$image = $this->get_image_member($hash);	
			}
			
			
			$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
			$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;

			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";
			$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_html = '/image/'.$buffer_filename_url;


			if(move_uploaded_file($_FILES[$fileElementName]['tmp_name'][0],$filename_destiny)){
				ImageHelper::$preview_mode = true;
				
				if(isset($_POST['PREVIEW_WIDTH'][0]) && $_POST['PREVIEW_WIDTH'][0] > 0){
					$preview_width = (int)$_POST['PREVIEW_WIDTH'][0];
				}
				
				if(isset($_POST['PREVIEW_HEIGHT'][0]) && $_POST['PREVIEW_HEIGHT'][0] > 0){
					$preview_height = (int)$_POST['PREVIEW_HEIGHT'][0];
				}
				
				if(ImageHelper::$enable_compression){
					
					if(isset($_POST['JPEG_QUALITY'][0]) && $ext == 'jpg'){
						$jpeg_quality = (int)$_POST['JPEG_QUALITY'][0];
						if($jpeg_quality >= 50 && $jpeg_quality < 100){
							$im = new Imagick($filename_destiny);
							$im->setImageCompression(Imagick::COMPRESSION_JPEG);
							$im->setImageCompressionQuality($jpeg_quality);
							$im->writeImage($filename_destiny);
							$im->clear();
							$im->destroy();
						}	
					}
				}
				
				if(empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,ImageHelper::$width_thumbnails,0,0,0,false);

				}
				elseif(!empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_width,0,0,0,false);


				}
				elseif(!empty($preview_height) && empty($preview_width)){
					$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_height,0,0,false);

				}
				
				$res2 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);

				if($res){
					$urls = $this->modify_new_image($filename_destiny,array('big' => $filename_src_big, 'preview' => $filename_src_preview, 'destiny' => $filename_destiny),'multiple');
					$filename_src_big = $urls['big'];
					$filename_src_preview = $urls['preview'];
					$filename_destiny = $urls['destiny'];
					$sizes = getimagesize($filename_destiny);
					$file_width = $sizes[0];
					$file_height = $sizes[1];
					
					$image_proportion = $file_height / $file_width;
					$show_filename = $_FILES[$fileElementName]['name'][0];
					$success = $lang_upload['UPLOAD_SUCCESSFULL'];
					
					$pixels = $file_height * $file_width;

					if($pixels > ImageHelper::$web_pixel_size){
						
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'));
						}
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
							@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
						}
						$filename_destiny_web = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
						ImageHelper::$preview_mode = true;
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_web,ImageHelper::$web_width);

					}
					
					if($_POST['DESCRIPTION'][0])
							$comment = $_POST['DESCRIPTION'][0];
						else
							$comment = '';
					if($_POST['NAME'][0])
							$show_filename = $_POST['NAME'][0];
							
					if(isset($_POST['TAGS'][0]) && $_POST['TAGS'][0] != '0'){
						if(isset($_POST['TAGS_CHILDREN'][0]) && $_POST['TAGS_CHILDREN'][0] != '0')
							$tag_id = (int)$_POST['TAGS_CHILDREN'][0];
						else
							$tag_id = (int)$_POST['TAGS'][0];
					}
					else{
						$tag_id = null;
					}
					
					if(isset($_POST['ALBUMS'][0]) && $_POST['ALBUMS'][0] != 0){
						$album_id = $_POST['ALBUMS'][0];
						$access = $this->my_albums->get_access_album($album_id);

					}
					else{
						$album_id = null;
						if(isset($_POST['ACCESS'][0])){
							$access = $_POST['ACCESS'][0];
						}
						else
							$access = 'public';
						if(!in_array($access,$this->access_levels_files))
							$access = 'public';	
						}
						
					if(isset($_POST['TINYURL'][0]) && $_POST['TINYURL'][0])
						$tiny_url = $this->bitly->get_url(SITE_URL.$filename_src_html);
					else
						$tiny_url = null;
							
					if(mb_strlen($show_filename) > $this->maxlength_show_filename)
						$show_filename = mb_substr($show_filename,0,$this->maxlength_show_filename);
						
					$last_id = 0;
					
					if($show_filename == 'blob' || $show_filename == 'undefined'){
						$show_filename = 'Screenshot-'.date('Y-m-d_H:i:s');
;
					}

					if($this->my_auth->role == 'guest'){
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'guest_key' => $this->guests->key,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'access' => $access,
						'rating' => 0,
						'views' => 0
						);
						if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
							$parameters['torrent_id'] = $_REQUEST['torrent_id'];
							$torrent_info = $this->get_torrent_info($_REQUEST['torrent_id']);
							
							if($torrent_info && isset($torrent_info->owner_key) && $torrent_info->owner_key != $_REQUEST['token']){
								$parameters['guest_key'] = $torrent_info->owner_key;
							}
							if(!$torrent_info)
								$last_position = 0;
							else
								$last_position = $torrent_info->max_position;
							$position = $_POST['POSITION'][count($_POST['POSITION']) - 1] + $last_position;
							$curr_time = time();
							

							if(isset($_SESSION['last_position'][$_REQUEST['torrent_id']]))
								$parameters['position'] = $position + $_SESSION['last_position'][$_REQUEST['torrent_id']];
							else
								$parameters['position'] = $position;
							ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder,150,0,0,1,false);

						}
						if(!$this->add_image_guest($parameters,$last_id)){
							unset($parameters['exif']);
							if(!$this->add_image_guest($parameters,$last_id)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';
							}
							else{
								if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
									$this->seedoff_sync->set_screen($last_id,$parameters);
								}
								if($last_id)
									$response['link'] = '/images_guest/edit/'.$last_id;
								else
									$response['link'] = '';
							}
						}
						else{
							if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
								$this->seedoff_sync->set_screen($last_id,$parameters);
							}
								if($last_id)
									$response['link'] = '/images_guest/edit/'.$last_id;
								else
									$response['link'] = '';
						}
						$response['imglink'] = IMGURL.$filename_src_big;
						$response['position'] = $_POST['POSITION'][count($_POST['POSITION']) - 1];
						$response['last_position'] = $last_position;
						$response['imglink_preview'] = $filename_src_preview.'?'.ImageHelper::random_hash();
						$response['imglink_html'] = SITE_URL.$filename_src_html;
						$response['imglink_preview_html'] = '<a href="'.SITE_URL.$filename_src_html.'" target="_blank"><img src="'.$filename_src_preview.'" border="0" /></a>';
						$response['imglink_preview_bb'] = '[URL='.SITE_URL.$filename_src_html.'][IMG]'.$filename_src_preview.'[/IMG][/URL]';
						$response['size'] = filesize($filename_destiny);
						$response['image'] = '<img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'">';
						$response['id'] = $last_id;
						$response['ext'] = $ext;
						if($tiny_url)
							$response['tiny_url'] = $tiny_url;
						$response['thumbnail_url'] = $filename_src_preview;
						$response['thumbnail_width'] = round(ImageHelper::$size_fast_upload/2);
						$response['thumbnail_height'] = round((ImageHelper::$size_fast_upload*$image_proportion)/2);
						$response['name'] = $_FILES[$fileElementName]['name'][0];
						
						$response['short_imglink_html'] = SITE_URL.'/image/'.$last_id;
						$response['short_imglink'] = IMGURL.'/b/'.$last_id.'.'.$ext;
						$response['short_imglink_preview'] = IMGURL.'/p/'.$last_id.'.'.$ext;
//						$response['short_imglink_preview_html'] = htmlspecialchars('<a href="'.$response['short_imglink_html'].'" target="_blank"><img src="'.$response['short_imglink_preview'].'" border="0" /></a>');
						$response['short_imglink_preview_html'] = '<a href="'.$response['short_imglink_html'].'" target="_blank"><img src="'.$response['short_imglink_preview'].'" border="0" /></a>';
						$response['short_imglink_preview_bb'] = '[URL='.$response['short_imglink_html'].'][IMG]'.$response['short_imglink_preview'].'[/IMG][/URL]';
						
					}
					else{
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'user_id' => $this->members->user_id,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'album_id' => $album_id,
						'access' => $access,
						'rating' => 0,
						'views' => 0
						);
						if(!$this->add_image_member($parameters,$last_id)){
							unset($parameters['exif']);
							if(!$this->add_image_member($parameters,$last_id)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';

							}
							else{
								if($last_id)
									$response['link'] = '/images/edit/'.$last_id;
								else
									$response['link'] = '';
							}
						}
						else{
							$last_id = $this->db->insert_id();
								if($last_id)
									$response['link'] = '/images/edit/'.$last_id;
								else
									$response['link'] = '';
						}
						$response['imglink'] = IMGURL.$filename_src_big;
						$response['imglink_preview'] = $filename_src_preview.'?'.ImageHelper::random_hash();
						$response['imglink_html'] = SITE_URL.$filename_src_html;
						$response['imglink_preview_html'] = '<a href="'.SITE_URL.$filename_src_html.'" target="_blank"><img src="'.$filename_src_preview.'" border="0" /></a>';
						$response['imglink_preview_bb'] = '[URL='.SITE_URL.$filename_src_html.'][IMG]'.$filename_src_preview.'[/IMG][/URL]';
						$response['size'] = filesize($filename_destiny);
						$response['image'] = '<img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'">';
						$response['id'] = $last_id;
						$response['ext'] = $ext;
						if($tiny_url)
							$response['tiny_url'] = $tiny_url;
						$response['thumbnail_url'] = $filename_src_preview;
						$response['thumbnail_width'] = round(ImageHelper::$size_fast_upload/2);
						$response['thumbnail_height'] = round((ImageHelper::$size_fast_upload*$image_proportion)/2);
						$response['name'] = $_FILES[$fileElementName]['name'][0];
						
						$response['short_imglink_html'] = SITE_URL.'/image/'.$last_id;
						$response['short_imglink'] = IMGURL.'/b/'.$last_id.'.'.$ext;
						$response['short_imglink_preview'] = IMGURL.'/p/'.$last_id.'.'.$ext;
//						$response['short_imglink_preview_html'] = htmlspecialchars('<a href="'.$response['short_imglink_html'].'" target="_blank"><img src="'.$response['short_imglink_preview'].'" border="0" /></a>');
						$response['short_imglink_preview_html'] = '<a href="'.$response['short_imglink_html'].'" target="_blank"><img src="'.$response['short_imglink_preview'].'" border="0" /></a>';
						$response['short_imglink_preview_bb'] = '[URL='.$response['short_imglink_html'].'][IMG]'.$response['short_imglink_preview'].'[/IMG][/URL]';
					}
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}


		}
		else{
			$uploaded = 0;
				$error = $lang_upload['WRONG_EXTENSION'];
		}
				
		
	}	
	if(isset($_FILES[$fileElementName]['tmp_name'][0])){
		$response['role'] = $this->my_auth->role;
		$response['error'] = $error;
		$response['success'] = $success;
	}

	}
	
	
	function set_avatar(&$response){
		
		$lang_upload = Language::get_languages('upload');
		$fileElementName = 'AVATAR_FILE';
		$response['avatar'] = 1;
		$response['success'] = '';

	
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				break;
			case '2':
//				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form!';
				$error = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				break;
			case '3':
				$error = $lang_upload['PARTIALLY_UPLOADED'];
				break;
			case '4':
				$error = $lang_upload['NO_UPLOADED'];
				break;

			case '6':
				$error = $lang_upload['ERROR_TEMP_FOLDER'];
				break;
			case '7':
				$error = $lang_upload['ERROR_WRITE_DISK'];
				break;
			case '8':
				$error = $lang_upload['ERROR_EXTENSION'];
				break;
			case '999':
			default:
				$error = $lang_upload['UNKNOWN_UPLOAD_ERROR'];
		}
		}
		else{
			
			
			if(filesize($_FILES[$fileElementName]['tmp_name']) >= $this->max_avatarsize){
				$response['error'] = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				return;
			}
					
			if(strpos($_FILES[$fileElementName]['type'],'jpeg'))
				$ext = 'jpg';
			elseif(strpos($_FILES[$fileElementName]['type'],'png'))
				$ext = 'png';
			elseif(strpos($_FILES[$fileElementName]['type'],'gif'))
				$ext = 'gif';
			else
				$ext = '';
				
			if($ext != '')
				$correct_extension = true;	
			
		if($correct_extension){
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$avatar_path.DIRECTORY_SEPARATOR.$this->members->user_id.".$ext";
			$filename_src = '/'.ImageHelper::$avatar_path.'/'.$this->members->user_id.".$ext";
			
			if(move_uploaded_file($_FILES[$fileElementName]['tmp_name'],$filename_destiny)){
					$response['success'] = 1;
					$response['image'] = IMGURL.$filename_src."?hash=".md5(mktime());
;
					$this->db->select('avatar');
					$res_avatar = $this->db->get_where('users',array('id'=>$this->my_auth->user_id));
					if($res_avatar->row()->avatar && $filename_src != $res_avatar->row()->avatar){
						$current_avatar = ImageHelper::url_to_realpath($res_avatar->row()->avatar);
						unlink($current_avatar);
					}
					$this->db->where('id',$this->members->user_id);
					$this->db->update('users',array('avatar' => $filename_src));
						
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}


		else{
			$uploaded = 0;
				$error = $lang_upload['WRONG_EXTENSION'];
		}
		}
		$response['error'] = $error;
	}
	
	function set_preview_cover(){
		
		$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";

	}
	
	
	
	function fast(&$response){
		
		$lang_upload = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$fileElementName = 'UPLOADED_FILE';
		$error = '';
		$success = '';
		$response['language'] = $lang_upload;

		if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				break;
			case '2':
//				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form!';
				$error = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
				break;
			case '3':
				$error = $lang_upload['PARTIALLY_UPLOADED'];
				break;
			case '4':
				$error = $lang_upload['NO_UPLOADED'];
				break;

			case '6':
				$error = $lang_upload['ERROR_TEMP_FOLDER'];
				break;
			case '7':
				$error = $lang_upload['ERROR_WRITE_DISK'];
				break;
			case '8':
				$error = $lang_upload['ERROR_EXTENSION'];
				break;
			case '999':
			default:
				$error = $lang_upload['UNKNOWN_UPLOAD_ERROR'];
		}
	}
	elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none' && ($_POST['FILE_URL']))
	{
		if($_POST['FILE_URL']){
			$http_status = (int)check_http_status($_POST['FILE_URL']);
			if($http_status >= 400){
				if(isset($lang_upload['HTTP_STATUS'][$http_status]))
					$response['error'] = $lang_upload['HTTP_STATUS'][$http_status];
				else
					$response['error'] = 'Ошибка';
			}
			elseif(!$http_status){
				$response['error'] = $lang_main['WRONG_URL'];
				return;
			}
			else{
				$check_url = true;
			}
			$tmp_sizes = getimagesize($_POST['FILE_URL']);
			$tmp_width = $tmp_sizes[0];
			$tmp_height = $tmp_sizes[1];
			
			if($tmp_width > ImageHelper::$max_width){
				$response['role'] = $this->my_auth->role;
				$response['success'] = '';
				$response['form_number'] = $_POST['current_form'];
				$response['error'] = $lang_upload['MAX_WIDTH_EXCEED'];
				return false;
			}
				
			if($tmp_height > ImageHelper::$max_height){
				$response['role'] = $this->my_auth->role;
				$response['success'] = '';
				$response['form_number'] = $_POST['current_form'];
				$response['error'] = $lang_upload['MAX_HEIGHT_EXCEED'];
				return false;
			}
			
			if($check_url){
				if(!ImageHelper::al_check_uploadimage($_POST['FILE_URL'])){
						$response['error'] = $lang_upload['ILEGAL_UPLOAD_INFECTION_MULTIPLE'];
						return;
					}
				$ext = pathinfo($_POST['FILE_URL'], PATHINFO_EXTENSION);
				if(strstr($ext,'?') != ''){
					$buffer = explode('?',$ext);
					$ext = $buffer[0];
				}
				$filename = get_filename_from_url($_POST['FILE_URL']);
				
			$data_create = date('Y-m-d H:i:s');
			if(isset($_POST['DESCRIPTION']))
				$comment = $_POST['DESCRIPTION'];
			else
				$comment = '';
			if($this->my_auth->role == 'guest'){
				$hash = md5($this->guests->key).'_'.md5($filename.(rand(0,1000)+time()).'.'.$ext);	
	
			}
			else{
				$hash = $this->members->user_id.'_'.md5($filename.(rand(0,1000)+time()).'.'.$ext);
		
			}
			
			$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
			$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;

			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
				
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			if(isset($_REQUEST['image_size']) && ($_REQUEST['image_size'] >= ImageHelper::$min_width_cover && $_REQUEST['image_size'] <= ImageHelper::$max_width_cover))
				$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_".$_REQUEST['image_size'].".$ext";
			else
				$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_".ImageHelper::$default_width_cover.".$ext";
			$filename_destiny_preview_moder_overlib = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";
			$filename_destiny_preview_moder_poster = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_poster.$ext";
			$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_html = '/image/'.$buffer_filename_url;
			
			if(copy($_POST['FILE_URL'],$filename_destiny)){
				
				if(ImageHelper::$enable_compression){
					
					if(isset($_POST['JPEG_QUALITY']) && $ext == 'jpg'){
						$jpeg_quality = (int)$this->input->post('JPEG_QUALITY');
						if($jpeg_quality >= 50 && $jpeg_quality < 100){
							$im = new Imagick($filename_destiny);
							$im->setImageCompression(Imagick::COMPRESSION_JPEG);
							$im->setImageCompressionQuality($jpeg_quality);
							$im->writeImage($filename_destiny);
							$im->clear();
							$im->destroy();
						}	
					}
					
				}
				
				ImageHelper::$preview_mode = true;
				if(isset($_POST['PREVIEW_WIDTH']) && $_POST['PREVIEW_WIDTH'] > 0){
					$preview_width = (int)$_POST['PREVIEW_WIDTH'];
				}
				
				$sizes = getimagesize($filename_destiny);
				$file_width = $sizes[0];
				$file_height = $sizes[1];
				
				if($file_width > ImageHelper::$max_width){
					$response['role'] = $this->my_auth->role;
					$response['success'] = '';
					$response['form_number'] = $_POST['current_form'];
					$response['error'] = $lang_upload['MAX_WIDTH_EXCEED'];
					return false;
				}
				
				if($file_height > ImageHelper::$max_height){
					$response['role'] = $this->my_auth->role;
					$response['success'] = '';
					$response['form_number'] = $_POST['current_form'];
					$response['error'] = $lang_upload['MAX_HEIGHT_EXCEED'];
					return false;
				}
				
				$image_proportion = $file_height / $file_width;
				
				if(isset($_POST['TEXT_ON_PREVIEW']) && $_POST['TEXT_ON_PREVIEW'] != 'none')
					$showres = 1;
				else
					$showres = 0;
				
				
				if(isset($_POST['PREVIEW_SIZE']) && $_POST['PREVIEW_SIZE']){
					
					$preview_size = $_POST['PREVIEW_SIZE'];
					
					if($file_width > $file_height){
						if($preview_size >= $file_width)
							$preview_size = $file_width;
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_size,0,0,$showres,false);

					}
					else{
						if($preview_size >= $file_height)
							$preview_size = $file_height;
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_size,0,$showres,false);
					}
						
					
				}
				else{
					
					if(isset($_POST['PREVIEW_HEIGHT']) && $_POST['PREVIEW_HEIGHT'] > 0){
						$preview_height = (int)$_POST['PREVIEW_HEIGHT'];
					}
					
					if(empty($preview_width) && empty($preview_height)){
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,ImageHelper::$width_thumbnails,0,0,0,false);
					}
					elseif(!empty($preview_width) && empty($preview_height)){
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_width,0,0,0,false);

					}
					elseif(!empty($preview_height) && empty($preview_width)){
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_height,0,0,false);

					}
					
				}
				
				
				$res2 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);
				if($res){
					$this->modify_new_image($filename_destiny);
					
					$show_filename = get_show_filename($_POST['FILE_URL']);
					$success = $lang_upload['UPLOAD_SUCCESSFULL'];
					
					$pixels = $file_height * $file_width;
					if($pixels > ImageHelper::$web_pixel_size){
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'));
				
						}	
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
							@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
						}
						$filename_destiny_web = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
						ImageHelper::$preview_mode = true;
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_web,ImageHelper::$web_width);

					}
					
					if($_POST['DESCRIPTION'])
						$comment = $_POST['DESCRIPTION'];
					if($_POST['NAME'])
						$show_filename = $_POST['NAME'];
					if(isset($_POST['TAGS']) && $_POST['TAGS'] != '0'){
						if(isset($_POST['TAGS_CHILDREN']) && $_POST['TAGS_CHILDREN'] != '0')
							$tag_id = (int)$_POST['TAGS_CHILDREN'];
						else
							$tag_id = (int)$_POST['TAGS'];
					}
					else{
						$tag_id = null;
					}
					
					if(isset($_POST['ALBUMS']) && $_POST['ALBUMS'] != 0){
						$album_id = $_POST['ALBUMS'];
						$access = $this->my_albums->get_access_album($album_id);
					}
					else{
						$album_id = null;
						if(isset($_POST['ACCESS'])){
							$access = $_POST['ACCESS'];
						}
						else
							$access = 'public';
						if(!in_array($access,$this->access_levels_files))
							$access = 'public';
					}	
					
					if(isset($_POST['TINYURL']) && $_POST['TINYURL'])
						$tiny_url = $this->bitly->get_url(SITE_URL.$filename_src_html);		
					else
						$tiny_url  = '';	
							
					if(mb_strlen($show_filename) > $this->maxlength_show_filename)
						$show_filename = mb_substr($show_filename,0,$this->maxlength_show_filename);
						
					$last_id = 0;	
							
					if($this->my_auth->role == 'guest'){
						
						$is_identical = $this->ban_identical_files('guest',$this->guests->key,array('show_filename' => $show_filename,'filesize' => filesize($filename_destiny), 'width' => $file_width, 'height' => $file_height));
										
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'guest_key' => $this->guests->key,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'access' => $access
						);
						
						if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
							if(ImageHelper::is_animate_gif($filename_destiny)){
								$response['role'] = $this->my_auth->role;
								$response['success'] = '';
								$response['form_number'] = $_POST['current_form'];
								$response['error'] = $lang_upload['ANIMATED_GIF_BAN'];
								return false;
							}
							$parameters['torrent_id'] = $_REQUEST['torrent_id'];
							$curr_time = time();
							$parameters['position'] = 0;
							$parameters['cover'] = 1;
							$torrent_info = $this->get_torrent_info($_REQUEST['torrent_id']);
							if($torrent_info && isset($torrent_info->owner_key) && $torrent_info->owner_key != $_REQUEST['token']){
								$parameters['guest_key'] = $torrent_info->owner_key;
							}
							if(isset($_REQUEST['image_size']) && ($_REQUEST['image_size'] >= ImageHelper::$min_width_cover && $_REQUEST['image_size'] <= ImageHelper::$max_width_cover))
							{
								ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder,$_REQUEST['image_size'],0,0,1,false,'Seedoff.net');

							}
							else{
								ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder,ImageHelper::$default_width_cover,0,0,1,false,'Seedoff.net');


							}
//							ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder_overlib,150,0,0,1,false);
							ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder_poster,150,0,0,0,false);
							
						}
						
						
						if(!$is_identical){
							if(!$this->add_image_guest($parameters,$last_id)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';
							}
							else{
								if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
									if(isset($_REQUEST['image_size']))
										$this->seedoff_sync->set_cover($parameters,$_REQUEST['image_size']);
									else
										$this->seedoff_sync->set_cover($parameters,ImageHelper::$default_width_cover);

								}
								if($last_id){
									$response['link'] = '/images_guest/edit/'.$last_id;
									if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id']))
										$response['link'] .= '?token='.$_REQUEST['token'].'&torrent_id='.$_REQUEST['torrent_id'].'&cover=1';

								}
								else
									$response['link'] = '';
							}
							$response['imglink'] = IMGURL.$filename_src_big;
							$response['id'] = $last_id;
							$response['type'] = 'guest';
							$response['imglink_html'] = SITE_URL.$filename_src_html;
							$response['image'] = '<a href="'.IMGURL.$filename_src_big.'" onclick="show_image(this);return false;"><img src="'.$filename_src_preview.'?'.ImageHelper::random_hash().'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
							$response['width'] = $file_width;
							$response['height'] = $file_height;
							$response['tiny_url'] = $tiny_url;
							$response['ext'] = $ext;
							
						}
						
						
					}
					else{
						
						$is_identical = $this->ban_identical_files('guest',$this->members->user_id,array('show_filename' => $show_filename,'filesize' => filesize($filename_destiny), 'width' => $file_width, 'height' => $file_height));
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'user_id' => $this->members->user_id,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'album_id' => $album_id,
						'access' => $access
						);
						if(!$is_identical){
							if(!$this->add_image_member($parameters,$last_id)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';
							}
							else{
								if($last_id){
									$response['link'] = '/images/edit/'.$last_id;
									
								}	
								else
									$response['link'] = '';
							}
							$response['imglink'] = IMGURL.$filename_src_big;
							$response['id'] = $last_id;
							$response['type'] = 'user';
							$response['imglink_html'] = SITE_URL.$filename_src_html;
							$response['image'] = '<a href="'.IMGURL.$filename_src_big.'" onclick="show_image(this);return false;"><img src="'.$filename_src_preview.'?'.ImageHelper::random_hash().'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
							$response['width'] = $file_width;
							$response['height'] = $file_height;
							$response['tiny_url'] = $tiny_url;
							$response['ext'] = $ext;

						}
						
					}
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}
				
			}
			else{
				$response['error'] = $lang_main['WRONG_URL'];
				return;
			}
		}
		else{
			if(isset($_POST['BLOB']) && $_POST['BLOB']){
				$this->capture($response);
				return;
			}
			else{
				$response['error'] = $lang_upload['NO_UPLOADED'];
				return;
			}
		}	
		
	}
	

	else 
	{
	
		if(filesize($_FILES[$fileElementName]['tmp_name']) >= $this->max_filesize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_FILESIZE_DIRECTIVE'];
			return;
		}
		
		if(!ImageHelper::al_check_uploadimage($_FILES[$fileElementName]['tmp_name'])){
			$response['error'] = $lang_upload['ILEGAL_UPLOAD_INFECTION_MULTIPLE'];
			return;
		}
		$tmp_sizes = getimagesize($_FILES[$fileElementName]['tmp_name']);
		$tmp_width = $tmp_sizes[0];
		$tmp_height = $tmp_sizes[1];
		
		if($tmp_width > ImageHelper::$max_width){
			$response['role'] = $this->my_auth->role;
			$response['success'] = '';
			$response['form_number'] = $_POST['current_form'];
			$response['error'] = $lang_upload['MAX_WIDTH_EXCEED'];
			return false;
		}
				
		if($tmp_height > ImageHelper::$max_height){
			$response['role'] = $this->my_auth->role;
			$response['success'] = '';
			$response['form_number'] = $_POST['current_form'];
			$response['error'] = $lang_upload['MAX_HEIGHT_EXCEED'];
			return false;
		}
		
		if($tmp_height*$tmp_width >= $this->max_imgsize){
			$response['error'] = $lang_upload['EXCEEDS_UPLOAD_IMGSIZE_DIRECTIVE'];
			return ;
		}
		
			if(strpos($_FILES[$fileElementName]['type'],'jpeg'))
				$ext = 'jpg';
			elseif(strpos($_FILES[$fileElementName]['type'],'png'))
				$ext = 'png';
			elseif(strpos($_FILES[$fileElementName]['type'],'gif'))
				$ext = 'gif';
			else
				$ext = '';
				
			if($ext != '')
				$correct_extension = true;	
			if($correct_extension){
			
			$data_create = date('Y-m-d H:i:s');
			if(isset($_POST['DESCRIPTION']))
				$comment = $_POST['DESCRIPTION'];
			else
				$comment = '';
			if($this->my_auth->role == 'guest'){
				$hash = md5($this->guests->key).'_'.md5($_FILES[$fileElementName]['name'].(rand(0,1000)+time()));
				$is_identical = $this->ban_identical_files('guest',$this->guests->key,array('show_filename' => $_FILES[$fileElementName]['tmp_name'],'filesize' => filesize($_FILES[$fileElementName]['tmp_name']), 'width' => $tmp_width, 'height' => $tmp_height));

			}
			else{
				$hash = $this->members->user_id.'_'.md5($_FILES[$fileElementName]['name'].(rand(0,1000)+time()));
				$is_identical = $this->ban_identical_files('user',$this->my_auth->user_id,array('show_filename' => $_FILES[$fileElementName]['tmp_name'],'filesize' => filesize($_FILES[$fileElementName]['tmp_name']), 'width' => $tmp_width, 'height' => $tmp_height));

			}
			//////////////////////////////////////////////// Предотвращаем загрузку файлов-копий в рамках одного аккаунта ////////////////////////////

			if($is_identical){
				$response['error'] = 'Данный файл уже загружен';
				$response['success'] = '';
				return $response;
			}
			
					
			$buffer_filename = date('Y').DIRECTORY_SEPARATOR.date('m').date('d').DIRECTORY_SEPARATOR.$hash;
			$buffer_filename_url = date('Y').'/'.date('m').date('d').'/'.$hash;

			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
				
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y'));
			}
			if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
				mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
				@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
			}
			
			$filename_destiny = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$main_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_destiny_preview = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			if(isset($_REQUEST['image_size']) && ($_REQUEST['image_size'] >= ImageHelper::$min_width_cover && $_REQUEST['image_size'] <= ImageHelper::$max_width_cover))
				$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_".$_REQUEST['image_size'].".$ext";
			else
				$filename_destiny_preview_moder = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_".ImageHelper::$default_width_cover.".$ext";
			$filename_destiny_preview_moder_overlib = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_150.$ext";
			$filename_destiny_preview_moder_poster = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path.DIRECTORY_SEPARATOR.$buffer_filename."_poster.$ext";
			$filename_destiny_preview_80 = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$preview_path_80.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
			$filename_src_big = '/'.ImageHelper::$main_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_preview = IMGURL.'/'.ImageHelper::$preview_path.'/'.$buffer_filename_url.".$ext";
			$filename_src_html = '/image/'.$buffer_filename_url;


			if(move_uploaded_file($_FILES[$fileElementName]['tmp_name'],$filename_destiny)){
				ImageHelper::$preview_mode = true;

				if(isset($_POST['PREVIEW_WIDTH']) && $_POST['PREVIEW_WIDTH'] > 0){
					$preview_width = (int)$_POST['PREVIEW_WIDTH'];
				}
				
				if(isset($_POST['PREVIEW_HEIGHT']) && $_POST['PREVIEW_HEIGHT'] > 0){
					$preview_height = (int)$_POST['PREVIEW_HEIGHT'];
				}
				
				if(ImageHelper::$enable_compression){
					
					if(isset($_POST['JPEG_QUALITY']) && $ext == 'jpg'){
						$jpeg_quality = (int)$this->input->post('JPEG_QUALITY');
						if($jpeg_quality >= 50 && $jpeg_quality < 100){
							$im = new Imagick($filename_destiny);
							$im->setImageCompression(Imagick::COMPRESSION_JPEG);
							$im->setImageCompressionQuality($jpeg_quality);
							$im->writeImage($filename_destiny);
							$im->clear();
							$im->destroy();
						}	
					}
					
				}
				
				$sizes = getimagesize($filename_destiny);
				$file_width = $sizes[0];
				$file_height = $sizes[1];
				
				$image_proportion = $file_height / $file_width;
				
				if(isset($_POST['TEXT_ON_PREVIEW']) && $_POST['TEXT_ON_PREVIEW'] != 'none')
					$showres = 1;
				else
					$showres = 0;
				
				if(isset($_POST['PREVIEW_SIZE']) && $_POST['PREVIEW_SIZE']){
					
					$preview_size = $_POST['PREVIEW_SIZE'];
					
					if($file_width > $file_height){
						if($preview_size >= $file_width)
							$preview_size = $file_width;
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_size,0,0,$showres,false);

					}
					else{
						if($preview_size >= $file_height)
							$preview_size = $file_height;
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_size,0,$showres,false);
					}
						
					
				}
				else{
					
					if(isset($_POST['PREVIEW_HEIGHT']) && $_POST['PREVIEW_HEIGHT'] > 0){
						$preview_height = (int)$_POST['PREVIEW_HEIGHT'];
					}
					
					if(empty($preview_width) && empty($preview_height)){
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,ImageHelper::$width_thumbnails,0,0,0,false);
					}
					elseif(!empty($preview_width) && empty($preview_height)){
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,$preview_width,0,0,0,false);

					}
					elseif(!empty($preview_height) && empty($preview_width)){
						$res = ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview,0,$preview_height,0,0,false);

					}
					
				}
				
				$res2 = ImageHelper::resizeimg($filename_destiny,$filename_destiny_preview_80,80);
				
				if($res){
					
					$urls = $this->modify_new_image($filename_destiny,array('big' => $filename_src_big, 'preview' => $filename_src_preview, 'destiny' => $filename_destiny));
					$filename_src_big = $urls['big'];
					$filename_src_preview = $urls['preview'];
					$filename_destiny = $urls['destiny'];
					
					$show_filename = $_FILES[$fileElementName]['name'];
					$success = $lang_upload['UPLOAD_SUCCESSFULL'];
					
					$pixels = $file_height * $file_width;
					if($pixels > ImageHelper::$web_pixel_size){
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y'));
				
						}	
						if(!is_dir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'))){
							mkdir(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'));
							@chmod(IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').date('d'),0777);
						}
						$filename_destiny_web = IMGDIR.DIRECTORY_SEPARATOR.ImageHelper::$web_path.DIRECTORY_SEPARATOR.$buffer_filename.".$ext";
						ImageHelper::$preview_mode = true;
						ImageHelper::resizeimg($filename_destiny,$filename_destiny_web,ImageHelper::$web_width);

					}
					
					if($_POST['DESCRIPTION'])
							$comment = $_POST['DESCRIPTION'];
						if($_POST['NAME'])
							$show_filename = $_POST['NAME'];
							
					if(isset($_POST['TAGS']) && $_POST['TAGS'] != '0'){
						if(isset($_POST['TAGS_CHILDREN']) && $_POST['TAGS_CHILDREN'] != '0')
							$tag_id = (int)$_POST['TAGS_CHILDREN'];
						else
							$tag_id = (int)$_POST['TAGS'];
					}
					else{
						$tag_id = null;
					}
					
					if(isset($_POST['ALBUMS']) && $_POST['ALBUMS'] != 0){
						$album_id = $_POST['ALBUMS'];
						$access = $this->my_albums->get_access_album($album_id);

					}
					else{
						$album_id = null;
						if(isset($_POST['ACCESS'])){
							$access = $_POST['ACCESS'];
						}
						else
							$access = 'public';
						if(!in_array($access,$this->access_levels_files))
							$access = 'public';					
						}
					
					if(isset($_POST['TINYURL']) && $_POST['TINYURL'])
						$tiny_url = $this->bitly->get_url(SITE_URL.$filename_src_html);		
					else
						$tiny_url  = '';
						
					if(mb_strlen($show_filename) > $this->maxlength_show_filename)
						$show_filename = mb_substr($show_filename,0,$this->maxlength_show_filename);
					$last_id = 0;

					if($this->my_auth->role == 'guest'){
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'guest_key' => $this->guests->key,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'access' => $access
						);
						
						
						if(isset($_REQUEST['torrent_id']) && $_REQUEST['torrent_id']){
							if(ImageHelper::is_animate_gif($filename_destiny)){
								$response['role'] = $this->my_auth->role;
								$response['success'] = '';
								$response['form_number'] = $_POST['current_form'];
								$response['error'] = $lang_upload['ANIMATED_GIF_BAN'];
								return false;
							}
							$parameters['torrent_id'] = $_REQUEST['torrent_id'];
							$curr_time = time();
							$parameters['position'] = 0;
							$parameters['cover'] = 1;
							$torrent_info = $this->get_torrent_info($_REQUEST['torrent_id']);
							if($torrent_info && isset($torrent_info->owner_key) && $torrent_info->owner_key != $_REQUEST['token']){
								$parameters['guest_key'] = $torrent_info->owner_key;
							}

							if(isset($_REQUEST['image_size']) && ($_REQUEST['image_size'] >= ImageHelper::$min_width_cover && $_REQUEST['image_size'] <= ImageHelper::$max_width_cover))
							{
								ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder,$_REQUEST['image_size'],0,0,1,false,'Seedoff.net');

							}
							else{
								ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder,ImageHelper::$default_width_cover,0,0,1,false,'Seedoff.net');

							}
//							ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder_overlib,150,0,0,1,false);
							ImageHelper::make_thumbnail($filename_destiny,$filename_destiny_preview_moder_poster,150,0,0,0,false);

							if(isset($_REQUEST['image_size']))
								$this->seedoff_sync->set_cover($parameters,$_REQUEST['image_size']);
							else
								$this->seedoff_sync->set_cover($parameters,ImageHelper::$default_width_cover);

						}
						
						if(!$this->add_image_guest($parameters)){
							unset($parameters['exif']);
							if(!$this->add_image_guest($parameters)){
								$error = $lang_main['DB_INSERT_ERROR'];
								$response['link'] = '';
							}
							else{
								$last_id = $this->db->insert_id();
								if($last_id && isset($_REQUEST['torrent_id'])){
									$data_cover = array(
									'torrent_id' => (int)$_REQUEST['torrent_id'],
									'image_id' => $last_id
									);
									$this->db->insert('image_covers',$data_cover);
								}
								if($last_id){
									$response['link'] = '/images_guest/edit/'.$last_id;
									if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id']))
										$response['link'] .= '?token='.$_REQUEST['token'].'&torrent_id='.$_REQUEST['torrent_id'].'&cover=1';
								}		
								else
									$response['link'] = '';
							}
						}
						else{
							$last_id = $this->db->insert_id();
							if($last_id && isset($_REQUEST['torrent_id'])){
									$data_cover = array(
									'torrent_id' => (int)$_REQUEST['torrent_id'],
									'image_id' => $last_id
									);
									$this->db->insert('image_covers',$data_cover);
								}
							if($last_id){
									$response['link'] = '/images_guest/edit/'.$last_id;
									if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id']))
										$response['link'] .= '?token='.$_REQUEST['token'].'&torrent_id='.$_REQUEST['torrent_id'].'&cover=1';
							}
							else
								$response['link'] = '';
						}
						
						$response['imglink'] = IMGURL.$filename_src_big;
						$response['id'] = $last_id;
						$response['imglink_html'] = SITE_URL.$filename_src_html;
						$response['image'] = '<a href="'.IMGURL.$filename_src_big.'" onclick="show_image(this);return false;"><img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
						$response['form_number'] = $_POST['current_form'];
						$response['width'] = $file_width;
						$response['height'] = $file_height;
						$response['tiny_url'] = $tiny_url;
						$response['ext'] = $ext;

					}
					else{
						
						$parameters = array(
						'url' => $filename_src_big,
						'main_url' => $filename_src_html,
						'tiny_url' => $tiny_url,
						'filename' => $hash,
						'show_filename' => $show_filename,
						'size' => filesize($filename_destiny),
						'width' => $file_width,
						'height' => $file_height,
						'user_id' => $this->members->user_id,
						'added' => $data_create,
						'comment' => $comment,
						'exif' => ImageHelper::get_exif($filename_destiny),
						'tag_id' => $tag_id,
						'album_id' => $album_id,
						'access' => $access
						);
						
						if(!$this->add_image_member($parameters,$last_id)){
							unset($parameters['exif']);
							if(!$this->add_image_member($parameters,$last_id)){
								$error = $lang_main['DB_INSERT_ERROR'];

							}
							else{
								
								if($last_id)
									$response['link'] = '/images/edit/'.$last_id;
								else
									$response['link'] = '';
							}

						}
						else{
							if($last_id)
								$response['link'] = '/images/edit/'.$last_id;
							else
								$response['link'] = '';
						}

						$response['imglink'] = IMGURL.$filename_src_big;
						$response['id'] = $last_id;
						$response['imglink_html'] = SITE_URL.$filename_src_html;
						$response['image'] = '<a href="'.IMGURL.$filename_src_big.'" onclick="show_image(this);return false;"><img src="'.$filename_src_preview.'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
						$response['width'] = $file_width;
						$response['height'] = $file_height;
						$response['tiny_url'] = $tiny_url;
						$response['ext'] = $ext;

					}
				}
				else{
					$error = $lang_upload['UPLOAD_ERROR'];

				}
			}

		}
		else{
			$uploaded = 0;
				$error = $lang_upload['WRONG_EXTENSION'];
		}
				
	}	
	$response['role'] = $this->my_auth->role;
	$response['error'] = $error;
	$response['success'] = $success;
	$response['form_number'] = $_POST['current_form'];

	}
	
	function get_last_position($torrent_id){
		$torrent_id = (int)$torrent_id;
		$this->db->select_max('max_position');
		$this->db->where('id',$torrent_id);
		$res = $this->db->get('torrents');
		if(!$res || $res->num_rows() < 1)	
			return 0;
		$position = $res->row()->max_position;
		if(is_null($position))
			return 0;
		return $position;
	
	}
	
	function get_torrent_info($torrent_id){
		$torrent_id = (int)$torrent_id;
		$res = $this->db->get_where('torrents',array('id' => $torrent_id));
		if(!$res || $res->num_rows() < 1)	
			return false;
		return $res->row();
	}
	
	function add_image_member($parameters,&$last_id){
		if($this->my_files->use_main_table_mode < 2){
			$this->db->delete($this->members->images_table,array('filename' => $parameters['filename']));
			$res = $this->db->insert($this->members->images_table,$parameters);
			$last_id = $this->db->insert_id();

		}
		else{
			$this->db->delete($this->my_files->main_table,array('filename' => $parameters['filename']));
			$res = $this->db->insert($this->my_files->main_table,$parameters);
			$last_id = $this->db->insert_id();
		}
	
		if($this->my_files->use_main_table_mode == 1)
			$res = $this->my_files->set_picture('user',$parameters,$last_id);
		return $res;
	}
	
	function add_image_guest($parameters,&$last_id){
		if($this->my_files->use_main_table_mode < 2){
			$this->db->delete($this->guests->images_table,array('filename' => $parameters['filename']));
			$res = $this->db->insert($this->guests->images_table,$parameters);
			$last_id = $this->db->insert_id();

		}
		else{
			$this->db->delete($this->my_files->main_table,array('filename' => $parameters['filename']));
			$res = $this->db->insert($this->my_files->main_table,$parameters);
			$last_id = $this->db->insert_id();
		}

		if($this->my_files->use_main_table_mode == 1)
			$res = $this->my_files->set_picture('guest',$parameters,$last_id);
		return $res;
	}
	
	function get_image_guest($hash){
		if($this->my_files->use_main_table_mode == 2)
			$query = $this->db->get_where($this->my_files->main_table,array('filename' => $hash));
		else
			$query = $this->db->get_where($this->guests->images_table,array('filename' => $hash));

		
		$image = $query->row();

		$real_path = ImageHelper::url_to_realpath($image->url);
		if(!file_exists($real_path))
			return false;
		return $image;
	}
    
    function get_image_member($filename){
        if($this->my_files->use_main_table_mode == 2)
		    $query = $this->db->get_where($this->my_files->main_table,array('filename' => $filename));
		else
        	$query = $this->db->get_where($this->members->images_table,array('filename' => $filename));
		$image = $query->row();

		$real_path = ImageHelper::url_to_realpath($image->url);
		if(!file_exists($real_path))
			return false;
		return $image;
    }
	
	function modify_new_image($address,$urls,$type='fast'){
		
		
		$buffer = explode('.',$address);
		$real_path = $address;
		if(count($buffer) < 1)
			return;
		
		$ext = $buffer[count($buffer)-1];
		$empty_fields = true;
		$empty_fields_gd = true;
		foreach($this->fast_form_fields as $field){
			if($type == 'fast')
				$buffer_field = $_REQUEST[$field];
			else
				$buffer_field = $_REQUEST[$field][0];
			if($type == 'fast' && $_REQUEST[$field])	{
				$empty_fields = false;
				break;
			}
			elseif($type == 'multiple' && $_REQUEST[$field][0]){
				$empty_fields = false;
				break;
			}

		}
		
		foreach($this->fast_form_fields_modify_gd as $field){
				if($type == 'fast')
					$buffer_field = $_REQUEST[$field];
				else
					$buffer_field = $_REQUEST[$field][0];
				if($type == 'fast' && $_REQUEST[$field]){
					$empty_fields_gd = false;
					break;
				}
				elseif($type == 'multiple' && $_REQUEST[$field][0]){
					$empty_fields_gd = false;
					break;
				}

			}
			
			
		if(!$empty_fields){		
			
			$data = array();
			if(!$empty_fields_gd)
				$source = ImageHelper::create_image_from_url($real_path,$ext);
			if($type == 'fast')	
				$rotate = $_REQUEST['ROTATE'];
			else 
				$rotate = $_REQUEST['ROTATE'][count($_REQUEST['ROTATE'])-1];
			if($rotate > 0){
				$degrees = (int)$rotate;
				$new_image = imagerotate($source,$degrees,0);
				
				$res_rotate = ImageHelper::save_modify_image($new_image,$real_path,$ext);
				if($res_rotate){
					$sizes = getimagesize($real_path);
					$data['width'] = $sizes[0];
					$data['height'] = $sizes[1];

				}
				
			}
			if($type == 'fast')
				$buffer_convert_to = $_REQUEST['CONVERT_TO'];
			else
				$buffer_convert_to = $_REQUEST['CONVERT_TO'][0];
			
			if($buffer_convert_to){
			
				$res_convert = ImageHelper::convert_to($real_path,$ext,$buffer_convert_to);
				$urls['big'] = ImageHelper::new_url($urls['big'],$buffer_convert_to);
				$urls['preview'] = ImageHelper::new_url($urls['preview'],$buffer_convert_to);
				$urls['destiny'] = ImageHelper::new_url($urls['destiny'],$buffer_convert_to);
				if($res_convert)
					$data['url'] = $urls['big'];
			}

			if($type == 'fast')
				$buffer_watermark = $_REQUEST['WATERMARK'];
			else
				$buffer_watermark = $_REQUEST['WATERMARK'][0];
			if($buffer_watermark){
				$watermark = strip_tags($buffer_watermark);
				$res_watermark = ImageHelper::watermark_text($real_path,$real_path,$watermark);
			}
			
			if($type == 'fast'){
				if(isset($_REQUEST['RESIZE_TO_WIDTH']) && isset($_REQUEST['RESIZE_TO_HEIGHT'])){
					$resize_to_width = $_REQUEST['RESIZE_TO_WIDTH'];
					$resize_to_height = $_REQUEST['RESIZE_TO_HEIGHT'];
					ImageHelper::$preview_mode = false;
				}
				
			}
			else{
				
				if(isset($_REQUEST['RESIZE_TO_WIDTH'][0]) && isset($_REQUEST['RESIZE_TO_HEIGHT'][0])){
					$resize_to_width = $_REQUEST['RESIZE_TO_WIDTH'][0];
					$resize_to_height = $_REQUEST['RESIZE_TO_HEIGHT'][0];
					ImageHelper::$preview_mode = false;

				}
			}
			
			if($resize_to_width && $resize_to_height){
				$width = (int)$resize_to_width;
				$height = (int)$resize_to_height;
				$res = ImageHelper::resizeimg($real_path,$real_path,$width,false,$height);
				$data['width'] = $width;
				$data['height'] = $height;
				
			}
			elseif($resize_to_width){
				$width = (int)$resize_to_width;
				$res = ImageHelper::resizeimg($real_path,$real_path,$width);
				$data['width'] = $width;

			}
			elseif($resize_to_height){
				$height = (int)$resize_to_height;
				$res = ImageHelper::resizeimg($real_path,$real_path,0,false,$height);
				$data['height'] = $height;
				
			}
			
		}	
		
		return $urls;
			
	}
	
	function modify_existing_image($image,&$modify_url,$type = 'fast',$from_seedoff = false){
		
		$buffer = explode('.',$image->url);
		$real_path = ImageHelper::url_to_realpath($image->url);
		if(count($buffer) < 1)
			return;
		
		$ext = $buffer[count($buffer)-1];
		$empty_fields = true;
		$empty_fields_gd = true;
		foreach($this->fast_form_fields as $field){
			if($type == 'fast')
				$buffer_field = $_POST[$field];
			else
				$buffer_field = $_POST[$field][0];
			if($type == 'fast' && $_POST[$field])	{
				$empty_fields = false;
				break;
			}
			elseif($type == 'multiple' && $_POST[$field][0]){
				$empty_fields = false;
				break;
			}

		}
		
		
		foreach($this->fast_form_fields_modify_gd as $field){
				if($type == 'fast')
					$buffer_field = $_POST[$field];
				else
					$buffer_field = $_POST[$field][0];
				if($type == 'fast' && $_POST[$field]){
					$empty_fields_gd = false;
					break;
				}
				elseif($type == 'multiple' && $_POST[$field][0]){
					$empty_fields_gd = false;
					break;
				}

			}
			
		if(isset($_POST['is_update']) && $this->my_auth->role != 'guest'){
			if(isset($_POST['ALBUMS']))
				$empty_fields = false;
		}
		if($image->cover)
			ImageHelper::$thumbnail_cover_size = $this->seedoff_sync->get_image_size($image->torrent_id);
		else
			ImageHelper::$thumbnail_cover_size = 150;
			
		if(!$empty_fields){
						
			$data = array();
			if(!$empty_fields_gd)
				$source = ImageHelper::create_image_from_url($real_path,$ext);
			if($type == 'fast'){
				if(isset($_POST['FREE_ROTATE']) && $_POST['FREE_ROTATE'])
					$rotate = $_POST['FREE_ROTATE'];
				else
					$rotate = $_POST['ROTATE'];
			}
			else{
				$rotate = $_POST['ROTATE'][0];

			}
			if($rotate > 0){
				$degrees = (int)$rotate;
				
				$new_image = imagerotate($source,$degrees,0);		
				$res_rotate = ImageHelper::save_modify_image($new_image,$real_path,$ext);

				imagedestroy($new_image);
				if($res_rotate){
					$sizes = getimagesize($real_path);
					$data['width'] = $sizes[0];
					$data['height'] = $sizes[1];
					$code = date('His').rand(0,10);
					$modify_url .= 'rotate='.$code;
				}		
			}
			
			if($type == 'fast')
				$convert_to = $_POST['CONVERT_TO'];
			else
				$convert_to = $_POST['CONVERT_TO'][0];
			if($convert_to){	
				$res_convert = ImageHelper::convert_to($real_path,$ext,$convert_to);
				$new_url = ImageHelper::new_url($image->url,$convert_to);
				if($res_convert)
					$data['url'] = $new_url;

			}
			if($type == 'fast')
				$watermark = $_POST['WATERMARK'];
			else
				$watermark = $_POST['WATERMARK'][0];
			if($watermark){
				$watermark = strip_tags($watermark);
				$res_watermark = ImageHelper::watermark_text($real_path,$real_path,$watermark);
				$data['size'] = filesize($real_path);
			}
			
			if($type == 'fast'){
				if(isset($_REQUEST['RESIZE_TO_WIDTH']) && isset($_REQUEST['RESIZE_TO_HEIGHT'])){
					$resize_to_width = $_REQUEST['RESIZE_TO_WIDTH'];
					$resize_to_height = $_REQUEST['RESIZE_TO_HEIGHT'];
					ImageHelper::$preview_mode = false;
				}
				
			}
			else{
				
				if(isset($_REQUEST['RESIZE_TO_WIDTH'][0]) && isset($_REQUEST['RESIZE_TO_HEIGHT'][0])){
					$resize_to_width = $_REQUEST['RESIZE_TO_WIDTH'][0];
					$resize_to_height = $_REQUEST['RESIZE_TO_HEIGHT'][0];
					ImageHelper::$preview_mode = false;

				}
			}
			
			if($resize_to_width && $resize_to_height){
				$width = (int)$resize_to_width;
				$height = (int)$resize_to_height;
				$res = ImageHelper::resizeimg($real_path,$real_path,$width,false,$height);
				if($res){
					$data['width'] = $width;
					$data['height'] = $height;
					$data['size'] = filesize($real_path);
				}
				
			}
			elseif($resize_to_width){
				$width = (int)$resize_to_width;
				$res = ImageHelper::resizeimg($real_path,$real_path,$width);
				if($res){
					$data['width'] = $width;
					$data['size'] = filesize($real_path);
				}
				

			}
			elseif($resize_to_height){
				$height = (int)$resize_to_height;
				$res = ImageHelper::resizeimg($real_path,$real_path,0,false,$height);
				if($res){
					$data['height'] = $height;
					$data['size'] = filesize($real_path);
				}
				

			}
			
			if($type == 'fast'){
				$description = $_POST['DESCRIPTION'];
				$name = $_POST['NAME'];
			}
			else{
				$description = $_POST['DESCRIPTION'][0];
				$name = $_POST['NAME'][0];

			}
			if($type == 'fast'){
				if(isset($_POST['TAGS']) && $_POST['TAGS'] != '0'){
				if(isset($_POST['TAGS_CHILDREN']) && $_POST['TAGS_CHILDREN'] != '0')
					$data['tag_id'] = (int)$_POST['TAGS_CHILDREN'];
				else
					$data['tag_id'] = (int)$_POST['TAGS'];
				}
				else
				{
					if(!$image->tag_id)
						$data['tag_id'] = null;
				}	
			}
			else{
				if(isset($_POST['TAGS'][0]) && $_POST['TAGS'][0] != '0'){
				if(isset($_POST['TAGS_CHILDREN'][0]) && $_POST['TAGS_CHILDREN'][0] != '0')
					$data['tag_id'] = (int)$_POST['TAGS_CHILDREN'][0];
				else
					$data['tag_id'] = (int)$_POST['TAGS'][0];
				}
				else
				{
					if(!$image->tag_id)
						$data['tag_id'] = null;
				}	
			}
			if($this->my_auth->role != 'guest' && !$from_seedoff){
				if($type == 'fast'){
					if(isset($_POST['ALBUMS']) && $_POST['ALBUMS'] != 0){
						$data['album_id'] = (int)$_POST['ALBUMS'];
					}
					else{
						$data['album_id'] = null;
						if(isset($_POST['ACCESS']) && $_POST['ACCESS'] != 'public')
							$data['access']	 = $_POST['ACCESS'];
						else
							$data['access'] = 'public';
					}
				}
				else{
					if(isset($_POST['ALBUMS'][0]) && $_POST['ALBUMS'][0] != 0){
						$data['album_id'] = (int)$_POST['ALBUMS'][0];
					}
					else{
						$data['album_id'] = null;
						$data['access'] = 'public';
					}
					$data['access'] = $this->my_albums->get_access_album($data['album_id']);
				}

			}
			else{
				if($type == 'fast'){
					if(isset($_POST['ACCESS']) && $_POST['ACCESS'] != 'undefined')
						$data['access'] = $_POST['ACCESS'];
					else
						$data['access'] = $image->access;
				}
				else{
					if(isset($_POST['ACCESS'][0]))
						$data['access'] = $_POST['ACCESS'][0];
					else
						$data['access'] = $image->access;
				}
				if(!in_array($data['access'],$this->access_levels_files))
					$data['access'] = 'public';
			}
			if($type == 'fast'){
				if(isset($_POST['TINYURL']) && $_POST['TINYURL'])
					$data['tiny_url'] = $this->bitly->get_url(SITE_URL.$image->main_url);		
					
			}
			else{
				if(isset($_POST['TINYURL'][0]) && $_POST['TINYURL'][0])
					$data['tiny_url'] = $this->bitly->get_url(SITE_URL.$image->main_url);		
			}
			
			
			if($description)
				$data['comment'] = $description;
				
			if($name)
				$data['show_filename'] = $name;
				
			if(mb_strlen($data['show_filename']) > $this->maxlength_show_filename)
				$data['show_filename'] = mb_substr($data['show_filename'],0,$this->maxlength_show_filename);
				

			if(isset($_POST['PREVIEW_WIDTH']) && $_POST['PREVIEW_WIDTH'] > 0){
					$preview_width = (int)$_POST['PREVIEW_WIDTH'];
				}
				
				if(isset($_POST['PREVIEW_HEIGHT']) && $_POST['PREVIEW_HEIGHT'] > 0){
					$preview_height = (int)$_POST['PREVIEW_HEIGHT'];
				}
				
				$real_path_preview = str_replace('big','preview',$real_path);
				if(empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::resizeimg($real_path,$real_path_preview);
				}
				elseif(!empty($preview_width) && empty($preview_height)){
					$res = ImageHelper::resizeimg($real_path,$real_path_preview,$preview_width);

				}
				elseif(!empty($preview_height) && empty($preview_width)){
					$res = ImageHelper::resizeimg($real_path,$real_path_preview,0,false,$preview_height);

				}
				if(!$data['access'] || $data['access'] == 'undefined')
					unset($data['access']);
				

			if(count($data) > 0){

				$this->db->where('id',$image->id);
				if($this->my_auth->role == 'guest' || $from_seedoff){
					if($this->my_files->use_main_table_mode == 2){
						$res = $this->db->update($this->my_files->main_table,$data);

					}
					elseif($this->my_files->use_main_table_mode == 1 && $image->guest_key){
						$res = $this->db->update($this->guests->images_table,$data);
						$this->db->where('old_image_id',$image->id);
						$this->db->where('guest_key',$image->guest_key);
						$this->db->update($this->my_files->main_table,$data);

					}
					else
						$res = $this->db->update($this->guests->images_table,$data);
	
					if(isset($data['url']) && $image->torrent_id){
						if($image->cover){
							$this->db->where('torrent_id',$image->torrent_id);
							$this->db->update($this->seedoff_sync->covers_table, array('url' => $data['url']));
						}
						else{
							$this->db->where('image_id',$image->id);
							$this->db->update($this->seedoff_sync->images_table, array('url' => $data['url']));

						}
					}

				}
				else{
					if($this->my_files->use_main_table_mode == 2){
						$res = $this->db->update($this->my_files->main_table,$data);

					}
					elseif($this->my_files->use_main_table_mode == 1 && $image->user_id){
						$res = $this->db->update($this->members->images_table,$data);
						$this->db->where('old_image_id',$image->id);
						$this->db->where('user_id',$image->user_id);
						$this->db->update($this->my_files->main_table,$data);

					}
					else
						$res = $this->db->update($this->members->images_table,$data);
						
				}
					
				return $res;
				
			}
			
			
			return false;
			
		}


		return false;

	}
	

	function ban_identical_files($type,$id,$image_parameters){
		
		if($type == 'guest'){
			if($this->my_files->use_main_table_mode < 2){
				$this->db->select('id');
				$this->db->where('guest_key',$id);
				$this->db->where('show_filename',$image_parameters['show_filename']);
				$this->db->where('size',$image_parameters['size']);
				$this->db->where('width',$image_parameters['width']);
				$this->db->where('height',$image_parameters['height']);
				$res = $this->db->get($this->guests->images_table);
				if(!$res)
					return false;
				if($res->num_rows() < 1)
					return false;
				
			}
			else{
				// Блок для pictures
			
				$this->db->select('id');
				$this->db->where('guest_key',$id);
				$this->db->where('show_filename',$image_parameters['show_filename']);
				$this->db->where('size',$image_parameters['size']);
				$this->db->where('width',$image_parameters['width']);
				$this->db->where('height',$image_parameters['height']);
				$res = $this->db->get($this->my_files->main_table);
				if(!$res)
					return false;
				if($res->num_rows() < 1)
					return false;
			
			}
			
			
			
		}
		else{
			if($this->my_files->use_main_table_mode < 2){
				$this->db->select('id');
				$this->db->where('user_id',$id);
				$this->db->where('show_filename',$image_parameters['show_filename']);
				$this->db->where('size',$image_parameters['size']);
				$this->db->where('width',$image_parameters['width']);
				$this->db->where('height',$image_parameters['height']);
				$res = $this->db->get($this->members->images_table);
				if(!$res)
					return false;
				if($res->num_rows() < 1)
					return false;
				
			}
			else{
				// Блок для pictures
			
				$this->db->select('id');
				$this->db->where('user_id',$id);
				$this->db->where('show_filename',$image_parameters['show_filename']);
				$this->db->where('size',$image_parameters['size']);
				$this->db->where('width',$image_parameters['width']);
				$this->db->where('height',$image_parameters['height']);
				$res = $this->db->get($this->my_files->main_table);
				if(!$res)
					return false;
				if($res->num_rows() < 1)
					return false;
			
				
			}

			
		}
		return true;
	}
	
	
}

?>