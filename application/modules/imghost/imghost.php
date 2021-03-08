<?php
session_start();
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Imghost extends MY_Controller{
	

	public $per_page = 12;
	
	function __construct(){
		parent::__construct();
		$this->load->model('my_tags');

		if(isset($_POST['is_gallery_history']))
			return;

		$this->load->module('core');
		$this->load->model('my_upload');
		$this->load->library('pagination');
		$this->load->helper('time');
		$this->load->helper('my_string');
		$this->load->helper('view');
		Language::load_language('albums');
		$this->beforeFilter();
 
	}
	
	function add_fields(){
		
		$lang_upload = Language::get_languages('upload');
		$lang_albums = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		
		$tags = $this->my_tags->get_main_tags();
		$options['0'] = $lang_main['ALL'];
		$uriSegments = $this->uri->segment_array();
		
		if($this->my_auth->role != 'guest')
			ImageHelper::$max_number_of_files = $this->my_upload->multiple_user_fields_count;
		
		foreach($tags as $tag){
			$options[$tag['id']] = $tag['value'];
		}
		if($this->my_auth->role == 'guest')
			$is_guest = 1;
		else
			$is_guest = 0;
		$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;"');
		$tags_box_multiple = form_dropdown('TAGS[]',$options,0,'class="tags combobox TAGS" onchange="get_categories(this);" style="width:110px;"');
		$tags_box_multiple_internet = form_dropdown('TAGS',$options,0,'class="tags combobox TAGS" onchange="get_categories(this);" style="width:110px;"');
		if($this->my_auth->role != 'guest'){
			$buffer_arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr_albums = array('0' => '----');
			if($buffer_arr_albums){
				foreach($buffer_arr_albums as $album)
					$arr_albums[$album['id']] = $album['name'];
			}
			if(count($arr_albums) > 0){
				$albums_box = form_dropdown('ALBUMS',$arr_albums,0,'class="tags combobox" style="width:110px;" id="ALBUMS" onchange="block_access_fast(this);return false;"');
				$albums_box_multiply = form_dropdown('ALBUMS[]',$arr_albums,0,'class="tags combobox ALBUMS" style="width:110px;" id="ALBUMS" onchange="block_access(this);return false;"');
				$albums_box_multiply_internet = form_dropdown('ALBUMS',$arr_albums,0,'class="tags combobox ALBUMS" style="width:110px;" id="ALBUMS" onchange="block_access(this);return false;"');

			}
			else{
				$albums_box = '<select name="ALBUMS" style="width:110px;" id="ALBUMS" class="tags combobox"></select>';
				$albums_box_multiply = $albums_box;
				$albums_box_multiply_internet = $albums_box;
			}
		}
		else{
			$albums_box = '';
			$albums_box_multiply = '';
			$albums_box_multiply_internet = '';
		}
		$data_upload_fast = array(
		'language' => $lang_upload,
		'form' => $this->get_widget('upload_fast_form',array('language' => $lang_upload,'fields_count' => $this->my_upload->fast_fields_count,'upload_progress' => ini_get("session.upload_progress.name"),'tags' => $tags_box, 'is_guest' => $is_guest, 'albums' => $albums_box,'lang_albums' => $lang_albums, 'iframe' => 0))
		);
		
		$data = array('language' => $lang_upload,'fields_count' => $this->my_upload->fast_fields_count,'upload_progress' => ini_get("session.upload_progress.name"),'tags' => $tags_box, 'is_guest' => $is_guest, 'albums' => $albums_box,'lang_albums' => $lang_albums, 'iframe' => 0);

		$response['content'] = $this->get_widget('upload_fast_form', $data);
		echo json_encode($response);
		exit;
	}
	
	function categories(){
		$uriSegments = $this->uri->segment_array();
		if($uriSegments[2] == 0){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;

		}
		$tags = $this->my_tags->get_by_parent_tag($uriSegments[2]);
		if($tags){
			$options['0'] = 'Все';
			foreach($tags as $tag){
				$options[$tag['id']] = $tag['value'];
			}
			if(isset($_POST['tag_id']) && array_key_exists($_POST['tag_id'],$options))
				$selected = $_POST['tag_id'];
			else
				$selected = 0;
			if(isset($_POST['is_multiple']))
				$tags_box = form_dropdown('TAGS_CHILDREN[]',$options,$selected,'class="tags combobox" style="width:110px;"');
			else
				$tags_box = form_dropdown('TAGS_CHILDREN',$options,$selected,'class="tags combobox" style="width:110px;" id="TAGS_CHILDREN"');
			$response['content'] = $tags_box;
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		
	}
	
	function account_net(){
		
		$uriSegments = $this->uri->segment_array();
		if($uriSegments[2] == 'vk'){
			$this->load->model('socialnet/vk');
			$current_owner_id = (int)$this->input->post('owner_id');
			if($current_owner_id){
				setcookie('vk_owner_id',$current_owner_id,time() + (86400*365),'/');
				$_SESSION['vk_owner_id'] = $current_owner_id;
				$response['answer'] = $current_owner_id;
			}
		}
		elseif($uriSegments[2] == 'fb'){
			$current_owner_id = (int)$this->input->post('owner_id');
			
			if($current_owner_id){
				$_SESSION['fb_owner_id'] = $current_owner_id;
				$res = $this->load->model('socialnet/fb');
				$response['owner_id'] = $current_owner_id;
				if($res)
					$response['answer'] = 1;
				else
					$response['answer'] = 0;
			}

		}
		elseif($uriSegments[2] == 'pic'){
			$res = $this->load->model('socialnet/pic');
			if($res){
				$_SESSION['google_owner_id'] = $this->pic->owner_id;
				$response['answer'] = 1;
			}
			else{
				$response['answer'] = 0;
			}
		}
		
		echo json_encode($response);
		exit;
	}
	
	function synchronize(){
		
		Language::load_language('sync');
		$language = Language::get_languages('sync');
		$uriSegments = $this->uri->segment_array();
		$nets = $this->socialnet->get_settings();
		
		if(isset($_SESSION['google_owner_id']) || empty($_COOKIE['google_owner_id'])){
			setcookie('google_owner_id',$_SESSION['google_owner_id'],time() + (86400*365),'/');
		}
		if($uriSegments[2] == 'ok' && isset($_GET['code'])){
			$_SESSION['ok']['code'] = $_GET['code'];

		}
		$authorized = array();
		if(empty($_COOKIE['vk_owner_id'])){
			if(isset($_SESSION['vk_owner_id'])){
				setcookie('vk_owner_id',$_SESSION['vk_owner_id'],time() + (86400*365),'/');
				$vk_authorized = 1;
				$authorized['vk'] = 1;
			}
			else
				$vk_authorized = 0;
				$authorized['vk'] = 0;
		}
		else{
			$vk_authorized = 1;
			$authorized['vk'] = 1;
		}
		$this->template->assign('vk_authorized',$vk_authorized);
		if(isset($_SESSION['ok'])){
			$ok_authorized = 1;
			$authorized['ok'] = 1;
		}
		else{
			$ok_authorized = 0;
			$authorized['ok'] = 0;
		}
		$this->template->assign('ok_authorized',$ok_authorized);

		if(isset($_SESSION['google_owner_id']) || isset($_COOKIE['google_owner_id'])){
			$pic_authorized = 1;
			$authorized['pic'] = 1;
		}
		else{
			$pic_authorized = 0;
			$authorized['pic'] = 0;
		}
		$this->template->assign('ok_authorized',$ok_authorized);

		if(count($uriSegments) >= 2 ){
			if($uriSegments[2] == 'vk'){
				$this->load->model('socialnet/vk');
				if(!$this->vk->activity)
					redirect(site_url('sync'));
				$this->vk_sync();
				$this->site_title = $language['SYNCHRONIZE_VK'];
				
				$data_net_panel = array(
				'albums' => $this->vk->get_current_albums(),
				'THEME' => $this->theme_path.'/',
				'net' => 'vk',
				'language' => $language
				);
				if($uriSegments[count($uriSegments)] == 'reverse')
					$data_net_panel['is_reverse'] = 1;
				else
					$data_net_panel['is_reverse'] = 0;
				$net_panel = $this->get_widget('sync_net',$data_net_panel);
				$select_net = 'vk';
				$dual_sync = true;
			}
			elseif($uriSegments[2] == 'fb'){
				$this->load->model('socialnet/fb');	
				if(!$this->fb->activity)
					redirect(site_url('sync'));
				$fb_init = $this->fb_init($language);
				$this->template->assign('fb_init',$fb_init);
				$this->site_title = $language['SYNCHRONIZE_FB'];
				
				if(!$this->fb->is_connected() && $this->config->item('is_work')){
					$data_net_panel = array(
					'language' => $language,
					);
					$net_panel = $this->get_widget('fb_init',$data_net_panel);
					$fb_init_show = 1;
				}
				else{
					$data_net_panel = array(
					'language' => $language,
					'albums' => $this->fb->get_current_albums(),
					'THEME' => $this->theme_path.'/',
					'net' => 'fb'
					);
					$net_panel = $this->get_widget('sync_net',$data_net_panel);
				}
				
				$select_net = 'fb';
				$dual_sync = false;
			}
			elseif($uriSegments[2] == 'ok'){
				$this->load->model('socialnet/ok');
				if(!$this->ok->activity)
					redirect(site_url('sync'));
				$this->site_title = $language['SYNCHRONIZE_OK'];
				$this->ok->get_object();
				$ok = $this->ok->instance;
				$ok->setRedirectUrl(site_url('sync/ok'));				


				if(isset($_SESSION['ok']['token_expires']) && mktime() < $_SESSION['ok']['token_expires'])
					$token = '{"token_type":"session","refresh_token":"'.$_SESSION['ok']['refresh_token'].'","access_token":"'.$_SESSION['ok']['access_token'].'","expires":'.$_SESSION['ok']['token_expires'].'}';
				else{
					if(isset($_SESSION['ok']['token_expires']))
						unset($_SESSION['ok']);
				}
								
				if(isset($_SESSION['ok']['code'])){

					if($ok){
						if($token){
							$ok->setToken($token);

						}
						else{

							$ok->getToken($_SESSION['ok']['code']);
							$_SESSION['ok']['refresh_token'] = $ok->token['refresh_token'];
							$_SESSION['ok']['access_token'] = $ok->token['access_token'];
							$_SESSION['ok']['token_expires'] = $ok->token['expires'];	
							$this->ok->set_current_user();
							$this->ok->set_current_albums();
	
							}					
					}	
				}	
				
				if(empty($_SESSION['ok']) && $this->config->item('is_work')){

					if($ok){
						$error = '';
						$login = '<a href="' . $ok->getLoginUrl(array('VALUABLE ACCESS', 'SET STATUS')) . '">Login</a>';
					}
					else{
						$error = $language['OK_MESSAGE_ERROR'];
						$login = '';
					}
					$data_net_panel = array(
					'language' => $language,
					'error' => $error,
					'login' => $login
					);
					$net_panel = $this->get_widget('ok_init',$data_net_panel);
					$ok_init_show = 1;
				}
				else{
					$data_net_panel = array(
					'language' => $language,
					'albums' => $this->ok->get_current_albums(),
					'THEME' => $this->theme_path.'/',
					'net' => 'ok'
					);
					$net_panel = $this->get_widget('sync_net',$data_net_panel);
				}
				$select_net = 'ok';
				$dual_sync = false;


			}
			elseif($uriSegments[2] == 'pic'){
				$this->load->model('socialnet/pic');	
				if(!$this->pic->activity)
					redirect(site_url('sync'));
				$this->site_title = $language['SYNCHRONIZE_GOOGLE'];
				$error = '';
				
				if(isset($_SESSION['google_owner_id']) || isset($_COOKIE['google_owner_id'])){
					$this->pic->set_current_albums();
					$data_net_panel = array(
					'language' => $language,
					'albums' => $this->pic->get_current_albums(),
					'THEME' => $this->theme_path.'/',
					'net' => 'pic'
					);
					$net_panel = $this->get_widget('sync_net',$data_net_panel);
				}
				else{
					$data_net_panel = array(
					'language' => $language,
					'api_id' => $this->pic->api_id,
					'error' => $language['GOOGLE_MESSAGE_ERROR']
					);
					$net_panel = $this->get_widget('pic_init',$data_net_panel);
					$pic_init_show = 1;
				}

				$select_net = 'pic';
				$dual_sync = true;
		
			}
			
			else{
				redirect(site_url(''));
			}
				
		}
		else{
			$net_panel = '';
			$select_net = '';
			$this->site_title = $language['SYNCHRONIZE_NET'];

		}
		if(isset($_POST['is_sync']) && $_POST['type'] == 'net'){
			$response['content'] = $this->get_widget('sync_net',$data_net_panel);
			echo json_encode($response);
			exit;
		}
		
		$data_local_panel = array(
		'albums' => $this->my_albums->get_albums_by_userid($this->my_auth->user_id),
		'THEME' => $this->theme_path.'/',
		'language' => $language
		);
		if($uriSegments[count($uriSegments)] == 'reverse')
			$data_local_panel['is_reverse'] = 1;
		else
			$data_local_panel['is_reverse'] = 0;
				
		if($this->members->fb_profile){
			$fb_authorized = 1;
			$authorized['fb'] = 0;

		}
		else{
			$fb_authorized = 0;
			$authorized['fb'] = 0;

		}
			
		$language['SYNC_FROM_LOCAL'] = str_replace('%net%',$this->net_names[$select_net],$language['SYNC_FROM_LOCAL']);
		$language['SYNC_FROM_NET'] = str_replace('%net%',$this->net_names[$select_net],$language['SYNC_FROM_NET']);
		
		$data = array(
		'language' => $language,
		'THEME' => $this->theme_path.'/',
		'local_panel' => $this->get_widget('sync_local',$data_local_panel),
		'net_panel' => $net_panel,
		'select_net' => $select_net,
		'vk_authorized' => $vk_authorized,
		'fb_authorized' => $fb_authorized,
		'ok_authorized' => $ok_authorized,
		'pic_authorized' => $pic_authorized,
		'is_work' => $this->config->item('is_work'),
		'dual_sync' => $dual_sync,
		'nets' => $nets,
		'authorized' => $authorized
		);
		
		
		if($uriSegments[count($uriSegments)] == 'reverse')
			$data['is_reverse'] = 1;
		else
			$data['is_reverse'] = 0;
	
		if(isset($_POST['is_sync'])){
			$response['content'] = $this->get_widget('sync_local',$data_local_panel);
			echo json_encode($response);
			exit;
			
		}
		
		if(isset($_POST['is_ajax'])){
			$response['content'] = $this->get_page('sync',$data);
			$response['title'] = $this->site_title;
			
			$response['error_message'] = $language[strtoupper($uriSegments[2]).'_MESSAGE_ERROR'];
			if(empty($fb_init_show))
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}

		$this->template->assign('is_sync',1);
		$this->template->assign('content',$this->get_page('sync',$data));
		$this->display_layout();

	}
	
	function seedoff_sync(){
		
		Language::load_language('imagelist');
		Language::load_language('image');
		Language::load_language('profile');
		$lang_upload = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$lang_profile = Language::get_languages('profile');
		$lang_albums = Language::get_languages('albums');
		$lang_images = Language::get_languages('imagelist');
		$lang_image = Language::get_languages('image');
		$lang_upload['ADD_PHOTO'] = str_ireplace('%num%',$this->my_upload->fast_fields_count,$lang_upload['ADD_PHOTO']);
		$tags = $this->my_tags->get_main_tags();
		$options['0'] = $lang_main['ALL'];
		$uriSegments = $this->uri->segment_array();
		if(isset($uriSegments[2]) && $uriSegments[2] == 'cover')
			$is_cover = true;
		else
			$is_cover = false;
		$this->template->assign('iframe_width',$this->iframe_width);
		if(count($this->guests->usertokeninfo) > 0)
			$user_id = $this->guests->usertokeninfo['id'];
		else
			$user_id = $this->my_auth->user_id;
		if(isset($_REQUEST['token'])){
			$token = $_REQUEST['token'];
			$this->seedoff_sync->set_user($token);
		}
		if($uriSegments[1] == 'seedoff_upload' || $uriSegments[2] == 'cover'){
			foreach($tags as $tag){
			$options[$tag['id']] = $tag['value'];
		}
		if($this->my_auth->role == 'guest')
			$is_guest = 1;
		else
			$is_guest = 0;
		if($uriSegments[1] == 'seedoff_upload'){
			$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;"');
			$tags_box_multiple = form_dropdown('TAGS[]',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;"');
			$buffer_arr_albums = $this->my_albums->get_albums_by_userid($user_id);
			$arr_albums = array('0' => '----');
			if($buffer_arr_albums){
				foreach($buffer_arr_albums as $album)
					$arr_albums[$album['id']] = $album['name'];
			}
			if($buffer_arr_albums){
				$albums_box = form_dropdown('ALBUMS',$arr_albums,0,'class="tags combobox" style="width:110px;" id="ALBUMS" onchange="block_access_fast(this);return false;"');
				
			}
			else{
				$albums_box = '';
			}
		}
		
		if(isset($token))
			$this->template->assign('token',$token);
		else
			$this->template->assign('token','');
		if(count($this->guests->usertokeninfo) > 0)
			$have_token = 1;
		else
			$have_token = 0;
		if(isset($_REQUEST['from_edit_fast']))
			$fields_count = 1;
		else
			$fields_count = $this->my_upload->multiple_fields_count_iframe;	

		$data_multiple = array('language' => $lang_upload,'THEME' => $this->theme_path,'tags' => $tags_box_multiple,'is_guest' => $is_guest,'albums' => $albums_box_multiply,'lang_main' => $lang_main,'lang_albums' => $lang_albums, 'iframe'=> 0, 'fields_count' => ImageHelper::$max_number_of_files, 'albums_internet' => $albums_box_multiply_internet, 'tags_internet' => $tags_box_multiple_internet, 'enable_compression' => ImageHelper::$enable_compression, 'compression_jpeg_box' => $compression_jpeg_box, 'lang_image' => $lang_images);
			
		$templates = $this->my_upload->list_templates($user_id,$lang_upload,true);
		if(count($templates) > 0){
			$arr_templates = array('0' => '--------');
			foreach($templates as $item)
				$arr_templates[$item['id']] = $item['show_name'];
			$templates_box = form_dropdown('templates',$arr_templates,0,'style="width:110px;" id="list_templates" onchange="select_template(this);return false;" disabled');
			
			$data_multiple['templates_box'] = $templates_box;
			$data_multiple['have_templates'] = 1;

		}
		else{
			$data_multiple['have_templates'] = 0;

		}

		if($is_cover){
			if($this->my_files->use_main_table_mode == 2)
				$guest_table = $this->my_files->main_table;
			else
				$guest_table = $this->guests->images_table;
			$res = $this->db->get_where($guest_table, array('torrent_id' => (int)$_REQUEST['torrent_id'],'cover' => 1));
			$image = $res->row();
			foreach($tags as $tag)
				$options[$tag['id']] = $tag['value'];
			if($image->tag_id)	
				$tags_box = form_dropdown('TAGS',$options,$image->tag_id,'class="tags combobox" onchange="get_categories(this);" style="width:110px;"');
			else
				$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;"');
				
			$access_box = form_dropdown('ACCESS',array('public' => $lang_albums['ALBUM_PUBLIC'], 'private' => $lang_albums['ALBUM_PRIVATE']),$image->access,'class="combobox" style="width:110px;" id="ACCESS"');

			$buffer_arr_albums = $this->my_albums->get_albums_by_userid($user_id);
			$arr_albums = array('0' => '----');
			if($buffer_arr_albums){
				foreach($buffer_arr_albums as $album)
					$arr_albums[$album['id']] = $album['name'];
			}
			if($image->album_id)
				$selected = $image->album_id;
			else
				$selected = 0;
			if($buffer_arr_albums){
				$albums_box = form_dropdown('ALBUMS',$arr_albums,$selected,'class="tags combobox" style="width:110px;" id="ALBUMS" onchange="block_access_fast(this);return false;"');
				
			}
			else{
				$albums_box = '';
			}
			
			$imglink_preview = str_replace('big','preview',$image->url);
			if($image){
				$proportion = $image->height / $image->width;
				if($proportion < 1){
					$preview_width = 103;
					$preview_height = round(103 * $proportion);
				}
				else{
					$preview_height = 103;
					$preview_width = round(103 / $proportion);
				}
				
				$data_fast = array('language' => $lang_upload,'THEME' => $this->theme_path,'tags' => $tags_box,'is_guest' => $is_guest,'albums' => $albums_box,'lang_main' => $lang_main,'lang_albums' => $lang_albums, 'iframe' => 0, 'have_token' => $have_token, 'torrent_id' => (int)$_REQUEST['torrent_id'], 'token' => $_REQUEST['token'], 'access_box' => $access_box, 'imglink' => IMGURL.$image->url, 'delete_link' => '/images_guest/delete/'.$image->id.'?torrent_id='.$_REQUEST['torrent_id'].'&token='.$_REQUEST['token'], 'imglink_preview' => IMGURL.$imglink_preview, 'image_id' => $image->id, 'type' => 'edit', 'preview_width' => $preview_width, 'preview_height' => $preview_height);
				$this->template->assign('type_operation','edit');
			}	
			else{
				$data_fast = array('language' => $lang_upload,'THEME' => $this->theme_path,'tags' => $tags_box,'is_guest' => $is_guest,'albums' => $albums_box,'lang_main' => $lang_main,'lang_albums' => $lang_albums, 'iframe' => 0, 'have_token' => $have_token, 'torrent_id' => (int)$_REQUEST['torrent_id'], 'token' => $_REQUEST['token'], 'access_box' => $access_box, 'type' => 'upload');
				$this->template->assign('type_operation','upload');

			}
			
			if(isset($_REQUEST['image_size']))	
				$data_fast['image_size'] = $_REQUEST['image_size'];
			else
				$data_fast['image_size'] = 250;
			$this->template->assign('content',$this->get_widget('edit_fast_form_seedoff',$data_fast));

		}
	
		else{

			$data_fast = array('language' => $lang_upload,'THEME' => $this->theme_path,'tags' => $tags_box_multiple,'is_guest' => $is_guest,'albums' => $albums_box_multiply,'lang_main' => $lang_main,'lang_albums' => $lang_albums, 'iframe' => 0, 'have_token' => $have_token, 'torrent_id' => (int)$_REQUEST['torrent_id'], 'token' => $_REQUEST['token']);
			
			if(isset($_REQUEST['image_size']))	
				$data_fast['image_size'] = $_REQUEST['image_size'];
			else
				$data_fast['image_size'] = 250;
			if(isset($_REQUEST['from_edit_fast']))
				$this->template->assign('content',$this->get_widget('upload_fast_form_seedoff',$data_fast));
			else
				$this->template->assign('content',$this->get_widget('public/upload_multiple',$data_multiple,'php'));
		}
		
		if(isset($_REQUEST['torrent_id']))
			$this->template->assign('torrent_id',$_REQUEST['torrent_id']);
		else
			$this->template->assign('torrent_id',0);
			if(isset($_REQUEST['width']))
				$width = $_REQUEST['width'];
			else
				$width = 0;
				
			if(isset($_REQUEST['height']))
				$height = $_REQUEST['height'];
			else
				$height = 0;
			$this->template->assign('width',$width);
			$this->template->assign('height',$height);
			$this->layout = 'seedoff_upload';
			if(isset($_REQUEST['from_edit']))
				$this->template->assign('from_edit',1);
			else
				$this->template->assign('from_edit',0);

		}
		else{
			$torrent_id = (int)$_REQUEST['torrent_id'];
		if(isset($_REQUEST['torrent_id']))
			$this->template->assign('torrent_id',$torrent_id);
		else
			$this->template->assign('torrent_id',0);
			$buffer_width = (int)$_REQUEST['width'];
			$cols = floor($buffer_width / 240);
			if(isset($_REQUEST['width'])){
				$width = (int)$_REQUEST['width'].'px';
			}
			else
				$width = '400px';
				
			if(isset($_REQUEST['height'])){
				$height = (int)$_REQUEST['height'].'px';
			}
			else
				$height = '300px';
			if($is_cover){
				$torrent_id = (int)$_REQUEST['torrent_id'];
				$token = $_REQUEST['token'];
				$res = $this->db->get_where($guest_table, array('torrent_id' => $torrent_id, 'cover' => 1));
				if(!$res){
					echo 'Нет файла для редактирования';
					exit;
				}
				
			}
			else{
				$cols = 2;
				$this->template->assign('width',$width);
				$this->template->assign('height',$height);
				$this->template->assign('cols',$cols);
				$files = $this->my_files->get_files_by_torrent_id($torrent_id,$_REQUEST['token']);
				
				$data = array(
				'files' => $files,
				'language' => $lang_main,
				'lang_images' => $lang_images,
				'lang_image' => $lang_image,
				'lang_main' => $lang_main,
				'lang_upload' => $lang_upload,
				'token' => $_REQUEST['token'],
				'width' => $width,
				'height' => $height,
				'THEME' => $this->theme_path.'/',
				'from_resort' => 0
				);
				if(isset($_REQUEST['display']) && $_REQUEST['display'] == 'table')
					$data['display'] = 'table';
				else
					$data['display'] = 'block';
					
				if($this->seedoff_sync->user['id_level'] == 9)
					$data['delete_without_confirm'] = 1;
				else
					$data['delete_without_confirm'] = 0;

				$this->template->assign('content',$this->get_widget('torrent_files',$data));
			}
			

			$this->layout = 'seedoff_edit';
		}
	
		$this->display_layout(true);
	}
	
	function index(){
		
		Language::load_language('imagelist');
		$lang_upload = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$lang_image = Language::get_languages('imagelist');
		$lang_albums = Language::get_languages('albums');
		$lang_upload['ADD_PHOTO'] = str_ireplace('%num%',$this->my_upload->fast_fields_count,$lang_upload['ADD_PHOTO']);
		$tags = $this->my_tags->get_main_tags();
		$options['0'] = $lang_main['ALL'];
		$uriSegments = $this->uri->segment_array();
		
		
		if($this->my_auth->role != 'guest')
			ImageHelper::$max_number_of_files = $this->my_upload->multiple_user_fields_count;
		
		foreach($tags as $tag){
			$options[$tag['id']] = $tag['value'];
		}
		if($this->my_auth->role == 'guest')
			$is_guest = 1;
		else
			$is_guest = 0;
		$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;"');
		$tags_box_multiple = form_dropdown('TAGS[]',$options,0,'class="tags combobox TAGS" onchange="get_categories(this);" style="width:110px;"');
		$tags_box_multiple_internet = form_dropdown('TAGS',$options,0,'class="tags combobox TAGS" onchange="get_categories(this);" style="width:110px;"');
		if($this->my_auth->role != 'guest'){
			$buffer_arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr_albums = array('0' => '----');
			if($buffer_arr_albums){
				foreach($buffer_arr_albums as $album)
					$arr_albums[$album['id']] = $album['name'];
			}
			if(count($arr_albums) > 0){
				$albums_box = form_dropdown('ALBUMS',$arr_albums,0,'class="tags combobox" style="width:110px;" id="ALBUMS" onchange="block_access_fast(this);return false;"');
				$albums_box_multiply = form_dropdown('ALBUMS[]',$arr_albums,0,'class="tags combobox ALBUMS" style="width:110px;" id="ALBUMS" onchange="block_access(this);return false;"');
				$albums_box_multiply_internet = form_dropdown('ALBUMS',$arr_albums,0,'class="tags combobox ALBUMS" style="width:110px;" id="ALBUMS" onchange="block_access(this);return false;"');

			}
			else{
				$albums_box = '<select name="ALBUMS" style="width:110px;" id="ALBUMS" class="tags combobox"></select>';
				$albums_box_multiply = $albums_box;
				$albums_box_multiply_internet = $albums_box;
			}
		}
		else{
			$albums_box = '';
			$albums_box_multiply = '';
			$albums_box_multiply_internet = '';
		}
		
		$compression_jpeg_options = array();
		for($i = 100; $i > 45; $i = $i - 5){
			$compression_jpeg_options[$i] = $i;
		}
		$compression_png_options = array();
		for($i=0;$i<10;$i++){
			$show_val = 100 - $i*10;
			$compression_png_options[$i] = $show_val;
		}
		
		$compression_jpeg_box = form_dropdown('JPEG_QUALITY',$compression_jpeg_options,100,'class="combobox" id="JPEG_QUALITY"');
		$compression_png_box = form_dropdown('PNG_QUALITY',$compression_png_options,0,'class="combobox" id="PNG_QUALITY"');
		$data_form = array('language' => $lang_upload,'fields_count' => $this->my_upload->fast_fields_count,'upload_progress' => ini_get("session.upload_progress.name"),'tags' => $tags_box, 'is_guest' => $is_guest, 'albums' => $albums_box,'lang_albums' => $lang_albums, 'iframe' => 0, 'enable_compression' => ImageHelper::$enable_compression, 'compression_jpeg_box' => $compression_jpeg_box, 'compression_png_box' => $compression_png_box);
		$data_form['preview_size'] = ImageHelper::$preview_size;
		
		$data_upload_fast = array(
		'language' => $lang_upload,
		'form' => $this->get_widget('upload_fast_form',$data_form)
		);
		
		$data_multiple = array('language' => $lang_upload,'THEME' => $this->theme_path,'tags' => $tags_box_multiple,'is_guest' => $is_guest,'albums' => $albums_box_multiply,'lang_main' => $lang_main,'lang_albums' => $lang_albums, 'iframe'=> 0, 'fields_count' => ImageHelper::$max_number_of_files, 'albums_internet' => $albums_box_multiply_internet, 'tags_internet' => $tags_box_multiple_internet, 'enable_compression' => ImageHelper::$enable_compression, 'compression_jpeg_box' => $compression_jpeg_box, 'lang_image' => $lang_image);
		if($this->my_auth->role != 'guest'){
			$user = $this->users->get_user_by_id($this->my_auth->user_id);
			$user_profile = $user->row_array();
		}
		if(isset($user_profile) && $user_profile['tiny_static'])
			$data_multiple['tiny_static'] = 1;
		else
			$data_multiple['tiny_static'] = 0;

		$templates = $this->my_upload->list_templates($this->my_auth->user_id,$lang_upload,true);
		if(count($templates) > 0){
			$arr_templates = array('0' => '--------');
			foreach($templates as $item)
				$arr_templates[$item['id']] = $item['show_name'];
			$templates_box = form_dropdown('templates',$arr_templates,0,'style="width:110px;" id="list_templates" onchange="select_template(this);return false;" disabled');
			
			$data_multiple['templates_box'] = $templates_box;
			$data_multiple['have_templates'] = 1;

		}
		else{
			$data_multiple['have_templates'] = 0;

		}
		
		$data = array(
		'language' => $lang_upload,
		'upload_fast' => $this->get_widget('upload_fast',$data_upload_fast),
		'upload_multiple' => $this->get_widget('public/upload_multiple',$data_multiple,'php'),
		'is_main' => 1
		);
		if(count($uriSegments) > 0){
			if($uriSegments[1] == 'multi')
				$data['one_uploader'] = 'multi';
			elseif($uriSegments[1] == 'fast')
				$data['one_uploader'] = 'fast';

		}
		
		$this->template->assign('content',$this->get_page('index',$data));
		$this->template->assign('with_main_banner',1);
		$this->site_title = 'Бесплатный фотохостинг картинок без регистрации! Загрузить фото и получить ссылку';
		
		$this->display_layout(true);
	}
	
	function capture_row(){
		
		$lang_upload = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$lang_albums = Language::get_languages('albums');
		$data_multiple = array('language' => $lang_upload,'THEME' => $this->theme_path,'tags' => $tags_box_multiple,'is_guest' => $is_guest,'albums' => $albums_box_multiply,'lang_main' => $lang_main,'lang_albums' => $lang_albums, 'iframe'=> 0, 'fields_count' => ImageHelper::$max_number_of_files, 'albums_internet' => $albums_box_multiply_internet, 'tags_internet' => $tags_box_multiple_internet, 'enable_compression' => ImageHelper::$enable_compression, 'compression_jpeg_box' => $compression_jpeg_box);
		$response['content'] = $this->get_widget('upload_multiple_row',$data_multiple);
		echo json_encode($response);
	}
	
	
	function album_history(){
		
		$uriSegments = $this->uri->segment_array();
		Language::load_language('albums');
		Language::load_language('gallery');
		$language = Language::get_languages('gallery');
		$lang_album = Language::get_languages('albums');
		
		if(count($uriSegments) == 2){
			$cur_page = 0;
			$album_id = $uriSegments[2];
		}
		elseif(count($uriSegments) == 3){
			$cur_page = ($uriSegments[3] - 1) * $this->per_page;
			$album_id = $uriSegments[2];
		}
		
		if(count($url_parameters) < 1 && isset($_SESSION['url_parameters']))
			unset($_SESSION['url_parameters']);
		
		$prev_page = (int)$_POST['prev_page'];
		$next_page = (int)$_POST['next_page'];
		$current_index = (int)$_POST['current_index'];
		$parameters = array(
		'prev_page' => $prev_page,
		'next_page' => $next_page,
		'cur_page' => $cur_page,
		'current_index' => $current_index
		);
		$_SESSION['from_gallery_album'] = 1;
		$_SESSION['is_album'] = 1;
		$res = $this->set_history_album($parameters,$album_id);

		if($res)
			$response['answer'] = 1;
		else
			$response['answer'] = 0;
		echo json_encode($response);
		exit;
	}
	
	function gallery_history(){
		$uriSegments = $this->uri->segment_array();
		$url_parameters = array();
		if(count($uriSegments) == 2){
			$cur_page = ($uriSegments[2] - 1);
		}
		elseif(count($uriSegments) == 3){
			$cur_page = 0;
			$url_parameters[$uriSegments[2]] = $uriSegments[3];
			$this->my_tags->children = $this->my_tags->get_by_parent_tag($uriSegments[3]);
		}
		elseif(count($uriSegments) ==4){
			$cur_page = ($uriSegments[4] - 1);
			$url_parameters[$uriSegments[2]] = $uriSegments[3];
			$this->my_tags->children = $this->my_tags->get_by_parent_tag($uriSegments[3]);
		}
		else
			$cur_page = 0;
		if(count($url_parameters) < 1 && isset($_SESSION['url_parameters']))
			unset($_SESSION['url_parameters']);
		
		$prev_page = (int)$_POST['prev_page'];
		$next_page = (int)$_POST['next_page'];
		$current_index = (int)$_POST['current_index'];
		$parameters = array(
		'prev_page' => $prev_page,
		'next_page' => $next_page,
		'cur_page' => $cur_page,
		'current_index' => $current_index
		);
		$_SESSION['from_gallery'] = 1;
		$res = $this->set_history($parameters,$url_parameters);

		if($res)
			$response['answer'] = 1;
		else
			$response['answer'] = 0;
		echo json_encode($response);
		exit;

	}
	
	function torrent(){
		
		$uriSegments = $this->uri->segment_array();
		Language::load_language('albums');
		Language::load_language('gallery');
		Language::load_language('imagelist');
		$language = Language::get_languages('gallery');
		$lang_album = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		$lang_images = Language::get_languages('imagelist');
		
		if(count($uriSegments) == 2){
			$cur_page = 0;
			$torrent_id = $uriSegments[2];
		}
		elseif(count($uriSegments) == 3){
			$cur_page = ($uriSegments[3] - 1) * $this->per_page;
			$torrent_id = $uriSegments[2];

		}
		if(!$torrent_id)
		   redirect('', 'location');
		if(isset($_POST['is_ajax']) && isset($_POST['album_password'])){
			$res_password = $this->my_albums->set_password($album_id);
			if(!$res_password){
				$lang_auth = Language::get_languages('auth');
				$response['content'] = $lang_auth['WRONG_PASSWORD'];
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			else{
				$response['answer'] = 1;
				echo json_encode($response);
				exit;
			}

		}
		   
		$arr_torrent_info = $this->seedoff_sync->get_torrent_info($torrent_id);
		if($arr_torrent_info)
			$this->site_title = $lang_album['ALBUM'].' "'.$arr_torrent_info['name'].'"';
		   		   
		$config['base_url'] = site_url('gallery');
		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->seedoff_sync->get_count_files_in_torrent($torrent_id);
		
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$pages = ceil($config['total_rows'] / $this->per_page);
		if(isset($_POST['is_load_more']) && isset($_POST['page'])){
			$page = (int)$_POST['page'];
			if($page < 2){
				$response['answer'] = 0;
			}
			else{
				$images = $this->seedoff_sync->get_files_by_torrent($torrent_id,($page - 1) * $this->per_page,$this->per_page);
			}
		}
		else{
			$images = $this->seedoff_sync->get_files_by_torrent($torrent_id,$this->per_page,$cur_page);
		}
		$data_album_info = array(
		'info' => $arr_torrent_info,
		'language' => $lang_album
		);
		$album_info = $this->get_widget('album_info',$data_album_info);
		if(isset($_POST['is_load_more']) || !$cur_page)
			$all_uploaded = $config['total_rows'];
		else
			$all_uploaded = count($images);
		
		$data = array(
		'paginator' => $paginator,
		'images' => $images,
		'language' => $language,
		'lang_album' => $lang_album,
		'all_uploaded' => $all_uploaded,
		'pages' => $pages,
		'album_info' => $album_info,
		'album_id' => $torrent_id,
		'lang_main' => $lang_main,
		'lang_images' => $lang_images,
		'type' => 'torrent'
		);
		
		if($this->seedoff_sync->is_owner_torrent_id($torrent_id, $this->members->seedoff_token))
			$data['is_owner'] = 1;
		else
			$data['is_owner'] = 0;
		
		if(isset($_POST['is_ajax']) && isset($_POST['is_load_more'])){
			if(count($images) > 0){
				$response['content'] = $this->get_widget('album_load_more',$data);
				$response['answer'] = 1;
				$response['title'] = $this->site_title;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		
		$this->template->assign('content',$this->get_page('album',$data));
		$this->template->assign('is_gallery',1);
		$this->display_layout();

	}
	
	function album(){
		
		$uriSegments = $this->uri->segment_array();
		Language::load_language('albums');
		Language::load_language('gallery');
		Language::load_language('imagelist');
		$language = Language::get_languages('gallery');
		$lang_album = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		$lang_images = Language::get_languages('imagelist');
		
		if(count($uriSegments) == 2){
			$cur_page = 0;
			$album_id = $uriSegments[2];
		}
		elseif(count($uriSegments) == 3){
			$cur_page = ($uriSegments[3] - 1) * $this->per_page;
			$album_id = $uriSegments[2];

		}
		if(!$album_id)
		   redirect('', 'location');
		if(isset($_POST['is_ajax']) && isset($_POST['album_password'])){
			$res_password = $this->my_albums->set_password($album_id);
			if(!$res_password){
				$lang_auth = Language::get_languages('auth');
				$response['content'] = $lang_auth['WRONG_PASSWORD'];
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			else{
				$response['answer'] = 1;
				echo json_encode($response);
				exit;
			}

		}
		   
		$arr_album_info = $this->my_albums->get_album_info($album_id);
		if($arr_album_info)
			$this->site_title = $lang_album['ALBUM'].' "'.$arr_album_info['name'].'"';
		   
		if($arr_album_info['access'] == 'private' && (!$this->my_auth->user_id ||  $arr_album_info['user_id'] != $this->my_auth->user_id )){
			if(!$this->dx_auth->is_admin())
				$this->accessDenied('private',$lang_album);
		}
		elseif($arr_album_info['access'] == 'protected' && (!$this->my_auth->user_id ||  $arr_album_info['user_id'] != $this->my_auth->user_id )){
			if(empty($_SESSION['album_password'][$album_id]) && !$this->dx_auth->is_admin())
				$this->accessDenied('protected',$lang_album,array('album_id' => $album_id,'album_name' => $arr_album_info['name']));

		}
		   
		$config['base_url'] = site_url('gallery');
		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->my_albums->get_count_file_in_album($album_id,$this->my_auth->user_id);
		
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$pages = ceil($config['total_rows'] / $this->per_page);
		if(isset($_POST['is_load_more']) && isset($_POST['page'])){
			$page = (int)$_POST['page'];
			if($page < 2){
				$response['answer'] = 0;
			}
			else{
				$images = $this->my_albums->get_files_by_album($album_id,$this->my_auth->user_id,($page - 1) * $this->per_page,$this->per_page);
			}
		}
		else{
			$images = $this->my_albums->get_files_by_album($album_id,$this->my_auth->user_id,$this->per_page,$cur_page);
		}
		$data_album_info = array(
		'info' => $arr_album_info,
		'language' => $lang_album
		);
		;

		$album_info = $this->get_widget('album_info',$data_album_info);
		if(isset($_POST['is_load_more']) || !$cur_page)
			$all_uploaded = $config['total_rows'];
		else
			$all_uploaded = count($images);
		
		$data = array(
		'paginator' => $paginator,
		'images' => $images,
		'language' => $language,
		'lang_album' => $lang_album,
		'all_uploaded' => $all_uploaded,
		'pages' => $pages,
		'album_info' => $album_info,
		'album_id' => $album_id,
		'lang_main' => $lang_main,
		'lang_images' => $lang_images,
		'type' => 'album'
		);
		
		if($arr_album_info['user_id'] == $this->my_auth->user_id)
			$data['is_owner'] = 1;
		else
			$data['is_owner'] = 0;
		
		if(isset($_POST['is_ajax']) && isset($_POST['is_load_more'])){
			if(count($images) > 0){
				$response['content'] = $this->get_widget('album_load_more',$data);
				$response['answer'] = 1;
				$response['title'] = $this->site_title;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		
		$this->template->assign('content',$this->get_page('album',$data));
		$this->template->assign('is_gallery',1);
		$this->display_layout();

	}
	
	function gallery_favourite(){
		
		Language::load_language('gallery');
		Language::load_language('poll');
		$language = Language::get_languages('gallery');
		$lang_main = Language::get_languages('main');
		$uriSegments = $this->uri->segment_array();
		$this->site_title = $language['TITLE_FAVOURITES'];
		$parameters = array();
		if(count($uriSegments) == 2){
			$cur_page = ($uriSegments[2] - 1) * $this->per_page;
		}
		elseif(count($uriSegments) == 3){
			$cur_page = 0;
		}
		elseif(count($uriSegments) == 4){
			$cur_page = ($uriSegments[4] - 1) * $this->per_page;
		}
		else{
			$cur_page = 0;
		}
			
		$config['base_url'] = site_url('favourite_list');
		$config['total_rows'] = $this->my_files->count_all_files_favourite($this->my_auth->user_id);
		
		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		if(count($uriSegments) == 2)
			$config['uri_segment'] = 2;
		elseif(count($uriSegments) == 4)
			$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$pages = ceil($config['total_rows'] / $this->per_page);
		if(isset($_POST['is_load_more']) && isset($_POST['page'])){
			$page = (int)$_POST['page'];
			if($page < 2){
				$response['answer'] = 0;
			}
			else{
				$images = $this->my_files->get_files_favourites($this->my_auth->user_id,($page - 1) * $this->per_page,$this->per_page);
			}
		}
		else{
			$images = $this->my_files->get_files_favourites($this->my_auth->user_id,$this->per_page,$cur_page);
		}
		
		if(count($uriSegments) == 2)
			$cur_page_data = $uriSegments[2];
		elseif(count($uriSegments) == 4)
			$cur_page_data = $uriSegments[3];

		$data_search = array(
		'THEME' => $this->theme_path.'/',
		'language' => $language
		);
		
		if(isset($_POST['is_load_more']) || !$cur_page)
			$all_uploaded = $config['total_rows'];
		else
			$all_uploaded = count($images);
			
		$data = array(
		'paginator' => $paginator,
		'images' => $images,
		'language' => $language,
		'all_uploaded' => $all_uploaded,
		'pages' => $pages,
		'cur_page' => $cur_page_data,
		'tag' => $curr_tag,
		'THEME' => $this->theme_path.'/',
		'lang_main' => $lang_main
		);
		if(isset($_POST['is_ajax']) && isset($_POST['is_load_more'])){
			if(count($images) > 0){
				$response['content'] = $this->get_widget('gallery_load_more_favourites',$data);
				$response['answer'] = 1;
				$response['title'] = $this->site_title;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		$this->template->assign('content',$this->get_page('gallery_favourites',$data));
		$this->template->assign('is_gallery',1);
		$this->display_layout();
	}
	
	
	function gallery_top(){
		
		Language::load_language('top');
		$language = Language::get_languages('top');
		$lang_main = Language::get_languages('main');
		$uriSegments = $this->uri->segment_array();
		$this->site_title = $language['TITLE'];
		$this->per_page = 10;
		$data = array(
		'language' => $language,
		'THEME' => $this->theme_path.'/',	
		);
		
		if(count($uriSegments) == 1){
			$cur_page = ($uriSegments[2] - 1) * $this->per_page;
			$page = 'all';
		}
		elseif(count($uriSegments) == 3){
			
			$cur_page = $uriSegments[3];
			$page = $uriSegments[2];
		}
		if($page == 'all'){
			
			$num_views = $this->my_files->count_all_files_top('views');
			$images_views = $this->my_files->get_files_for_top('views',0,$this->per_page);
			$data_views = array(
			'language' => $language,
			'images' => $images_views,
			'THEME' => $this->theme_path.'/',
			'cur_page' => $cur_page,
			'is_ajax' => 0
			);
			if($num_views > $this->per_page){
				$data_views['show_links'] = 1;
				$data_views['next_link'] = site_url('top/views').'/'.$this->per_page;
			}
			else
				$data_views['show_links'] = 0;
			$data['top_views'] = $this->get_widget('top_views',$data_views);
			
			$num_rating = $this->my_files->count_all_files_top('rating');
			$images_rating = $this->my_files->get_files_for_top('rating',0,$this->per_page);
			$data_rating = array(
			'language' => $language,
			'images' => $images_rating,
			'THEME' => $this->theme_path.'/',
			'cur_page' => $cur_page,
			'is_ajax' => 0
			);
			if($num_rating > $this->per_page){
				$data_rating['show_links'] = 1;
				$data_rating['next_link'] = site_url('top/rating').'/'.$this->per_page;
			}
			else
				$data_rating['show_links'] = 0;
			$data['top_rating'] = $this->get_widget('top_rating',$data_rating);
			
		}
		elseif($page == 'views'){
			
			$num_views = $this->my_files->count_all_files_top('views');
			$images_views = $this->my_files->get_files_for_top('views',$cur_page,$this->per_page);
			if(count($images_views) > 0)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			$data_views = array(
			'language' => $language,
			'images' => $images_views,
			'THEME' => $this->theme_path.'/',
			'cur_page' => $cur_page,
			'is_ajax' => 1
			);
			
			if($cur_page + $this->per_page > $num_views && $cur_page != 0){
				$data_views['show_next'] = 0;
				$data_views['show_prev'] = 1;
				$data_views['prev_link'] = '/top/views/'.($cur_page - $this->per_page);
			}
			elseif($cur_page + $this->per_page < $num_views && $cur_page == 0){
				$data_views['show_next'] = 1;
				$data_views['show_prev'] = 0;
				$data_views['next_link'] = '/top/views/'.($cur_page + $this->per_page);
			}
			elseif($cur_page + $this->per_page < $num_views && $cur_page != 0){
				$data_views['show_next'] = 1;
				$data_views['show_prev'] = 1;
				$data_views['next_link'] = '/top/views/'.($cur_page + $this->per_page);
				$data_views['prev_link'] = '/top/views/'.($cur_page - $this->per_page);
			}
			
			$response['content'] = $this->get_widget('top_views',$data_views);
			echo json_encode($response);
			exit;
		}
		elseif($page == 'rating'){
			
			$num_rating = $this->my_files->count_all_files_top('rating');
			$images_rating = $this->my_files->get_files_for_top('rating',$cur_page,$this->per_page);
			if(count($images_rating) > 0)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			$data_rating = array(
			'language' => $language,
			'images' => $images_rating,
			'THEME' => $this->theme_path.'/',
			'cur_page' => $cur_page,
			'is_ajax' => 1
			);
			
			if($cur_page + $this->per_page > $num_rating && $cur_page != 0){
				$data_rating['show_next'] = 0;
				$data_rating['show_prev'] = 1;
				$data_rating['prev_link'] = '/top/rating/'.($cur_page - $this->per_page);
			}
			elseif($cur_page + $this->per_page < $num_rating && $cur_page == 0){
				$data_rating['show_next'] = 1;
				$data_rating['show_prev'] = 0;
				$data_rating['next_link'] = '/top/rating/'.($cur_page + $this->per_page);
			}
			elseif($cur_page + $this->per_page < $num_rating && $cur_page != 0){
				$data_rating['show_next'] = 1;
				$data_rating['show_prev'] = 1;
				$data_rating['next_link'] = '/top/rating/'.($cur_page + $this->per_page);
				$data_rating['prev_link'] = '/top/rating/'.($cur_page - $this->per_page);
			}
				
			$response['content'] = $this->get_widget('top_rating',$data_rating);
			echo json_encode($response);
			exit;
		}
		
		$this->template->assign('content',$this->get_page('top',$data));
		$this->display_layout();
	}
	
	function gallery_genres(){
		
		if(isset($_REQUEST['tagname']))
			$search_tag = $_REQUEST['tagname'];
		else
			$search_tag = '';
		
		Language::load_language('gallery');
		Language::load_language('auth');
		Language::load_language('top');
		$language = Language::get_languages('gallery');
		$lang_main = Language::get_languages('main');
		$lang_auth = Language::get_languages('auth');
		$lang_top = Language::get_languages('top');
		Language::load_language('imagelist');
		$lang_image = Language::get_languages('imagelist');
		$uriSegments = $this->uri->segment_array();
		$this->load->model('genres');
		$genres_list = $_REQUEST['genres_list'];
		$buffer = explode(',',$genres_list);
		$config['base_url'] = site_url('gallery/genres');
		$config['total_rows'] = $this->genres->get_count_by_list($genres_list);
		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$config['uri_segment'] = 3;
		if(count($uriSegments) == 3){
				$cur_page = ($uriSegments[3] - 1) * $this->per_page;

		}
		else{
			$cur_page = 0;
		}

		$this->site_title = $language['TITLE'];

		$pages = ceil($config['total_rows'] / $this->per_page);

		$images = $this->my_files->get_files_by_genres($this->per_page,$cur_page,$genres_list);
		if(isset($_POST['is_load_more']) || !$cur_page)
			$all_uploaded = $config['total_rows'];
		else
			$all_uploaded = count($images);
			
		$tags = $this->my_tags->get_main_tags();
		$options['0'] = $lang_main['ALL'];
		foreach($tags as $tag){
			$options[$tag['id']] = $tag['value'];
		}
		if($curr_tag && $curr_tag['parent_id'] == 0){
			$tags_box = form_dropdown('TAGS',$options,$curr_tag['id'],'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS"');
			
			if($this->my_tags->children){
				$child_options = array();
				$child_options[0] = $lang_main['ALL'];
				
				foreach($this->my_tags->children as $child)
					$child_options[$child['id']] = $child['value'];
				$children_tags_box = form_dropdown('TAGS_CHILDREN',$child_options,0,'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS_CHILDREN"');
			}		
			else
				$children_tags_box = '<select id="TAGS_CHILDREN" class="tags combobox" style="width:150px;" name="TAGS_CHILDREN"></select>';

		}
		elseif($curr_tag && $curr_tag['parent_id'] != 0){
			$tags_box = form_dropdown('TAGS',$options,$curr_tag['parent_id'],'class="tags combobox" onchange="get_categories(this);" style="width:150px;" ID="TAGS"');
				$children = $this->my_tags->get_by_parent_tag($curr_tag['parent_id']);
				$child_options = array();
				$child_options[0] = $lang_main['ALL'];
				foreach($children as $child)
					$child_options[$child['id']] = $child['value'];
				$children_tags_box = form_dropdown('TAGS_CHILDREN',$child_options,$curr_tag['id'],'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS_CHILDREN"');

		}
		else{
			$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS"');
			$children_tags_box = '<select id="TAGS_CHILDREN" class="tags combobox" style="width:150px;" name="TAGS_CHILDREN"></select>';

		}
			
		$data_search = array(
		'tags_box' => $tags_box,
		'children_tags_box' => $children_tags_box,
		'THEME' => $this->theme_path.'/',
		'language' => $language,
		'popular_tags' => $popular_tags
		);
		$search_panel = $this->get_widget('search_tags',$data_search);
		$language['IMAGES_WITH_TAG'] = $language['IMAGES_WITH_GENRES'];
		$genres = array('value' => $this->genres->get_names_by_ids($genres_list));
			
		$data = array(
		'paginator' => $paginator,
		'images' => $images,
		'language' => $language,
		'lang_images' => $lang_image,
		'lang_auth' => $lang_auth,
		'all_uploaded' => $all_uploaded,
		'pages' => $pages,
		'cur_page' => $cur_page_data,
		'tag' => $genres,
		'search_panel'  => $search_panel,
		'THEME' => $this->theme_path.'/',
		'lang_main' => $lang_main,
		'lang_top' => $lang_top,
		'is_top' => $is_top,
		'top_sort' => $this->my_files->top_sort,
		'is_ajax' => false
		);
		if($this->my_auth->role != 'guest')
			$data['type'] = 'user';
		else
			$data['type'] = 'guest';
			
			
		if(isset($_POST['is_ajax']) && isset($_POST['is_load_more'])){
			if(count($images) > 0){
				$response['content'] = $this->get_widget('gallery_load_more',$data);
				$response['answer'] = 1;
				$response['title'] = $this->site_title;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		elseif(isset($_POST['is_ajax']) && isset($_POST['is_search'])){
			$response['content'] = $this->get_widget('gallery_search',$data);
			$response['title'] = $this->site_title;
			$response['parent_tag'] = $curr_tag['parent_id'];
			$response['header'] = $language['IMAGES_WITH_TAG'].': '.$curr_tag['value'];
			$response['header_short_tag'] = $language['IMAGES_WITH_TAG'];
			$response['header_short_tags'] = $language['IMAGES_WITH_TAGS'];
			echo json_encode($response);
			exit;
		}
			
		$this->template->assign('content',$this->get_page('gallery',$data));
		$this->template->assign('is_gallery',1);
		$this->display_layout();

	}
	
	
	function search(){
		
		if(isset($_REQUEST['q'])){
			$text = $_REQUEST['q'];
			$sql = "SELECT * FROM search_result WHERE UPPER(`name`) RLIKE UPPER('^$text') ORDER BY views DESC";
			$query = $this->db->query($sql);
			$response = '';
			$show_types = array(
			'tag' => 'тег',
			'album' => 'альбом',
			'torrent' => 'альбом'
			);
			foreach($query->result_array() as $row){
				$row['name'] = str_replace('|','/',$row['name']);
				$uniq = $row['uniq'];
//				$id = $row['id'];
				$response .= $row['name'].' - '.$show_types[$row['type']]."|$uniq\n";
			}
		
			echo $response;
			exit;
		}
		else{
			
			$text = $_REQUEST['text'];
			$type_object = $_REQUEST['type_object'];
			$object_id = (int)$_REQUEST['object_id'];
			$buffer = explode(' - ',$text);
			if(count($buffer) < 2){
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			if(count($buffer) == 2){
				$text = $buffer[0];
				
			}
			else{
				array_pop($buffer);
				$text = implode(' - ',$buffer);
			}
			if($type_object && $object_id)
				$sql = "SELECT * FROM search_result WHERE `type` = '$type_object' AND object_id = $object_id";
			else
				$sql = "SELECT * FROM search_result WHERE `name` LIKE '%$text%'";
			$query = $this->db->query($sql);
			if($query || $query->num_rows() > 0){
				$response['answer'] = 1;
				$uniq = $query->row()->uniq;
				list($type,$object_id) = explode('-',$uniq);
				if($type == 'tag')
					$response['url'] = '/gallery/'.$type.'s/'.$object_id;
				else
					$response['url'] = '/'.$type.'s/'.$object_id;
				if(!$object_id)
					$response['answer'] = 0;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
			
		}
		
	}
	
	function gallery(){
		
		if(isset($_REQUEST['tagname']))
			$search_tag = $_REQUEST['tagname'];
		else
			$search_tag = '';
		
		Language::load_language('gallery');
		Language::load_language('auth');
		Language::load_language('top');
		$language = Language::get_languages('gallery');
		$lang_main = Language::get_languages('main');
		$lang_auth = Language::get_languages('auth');
		$lang_top = Language::get_languages('top');
		Language::load_language('imagelist');
		$lang_image = Language::get_languages('imagelist');
		$uriSegments = $this->uri->segment_array();
		if(count($uriSegments) >= 2 && $uriSegments[2] == 'top'){
			$this->site_title = $lang_top['TITLE'];
			$is_top = 1;
			$this->my_files->is_top = true;
			if(count($uriSegments) > 2)
				$this->my_files->top_sort = $uriSegments[3];
		}
		
		else{
			$this->site_title = $language['TITLE'];
			$is_top = 0;
		}
		$parameters = array();

		if(!$is_top){
			if(count($uriSegments) == 2){
				if($search_tag){
					$cur_page = 0;
					$curr_tag = $this->my_tags->get_tag_by_name($search_tag);
				}
				else{
					$cur_page = ($uriSegments[2] - 1) * $this->per_page;
					$curr_tag = false;
				}

			}
			elseif(count($uriSegments) == 3){
				$cur_page = 0;
				$curr_tag = $this->my_tags->get_tag_by_id($uriSegments[3]);
			}
			elseif(count($uriSegments) == 4){
				$cur_page = ($uriSegments[4] - 1) * $this->per_page;
				$curr_tag = $this->my_tags->get_tag_by_id($uriSegments[3]);
			}
			else{
				$cur_page = 0;
				$curr_tag = false;
			}
		
		}
		else{
			$curr_tag = false;
			if(count($uriSegments) < 4)
				$cur_page = 0;
			else
				$cur_page = ($uriSegments[4] - 1) * $this->per_page;

		}
		
		if(!$is_top){
			$config['base_url'] = site_url('gallery');
			if(count($uriSegments) < 3){
				$config['total_rows'] = $this->my_files->count_all_files();
				if($search_tag && count($curr_tag) > 0){
					$parameters['tags'] = $curr_tag['id'];
					$this->my_tags->children = $this->my_tags->get_by_parent_tag($curr_tag['id']);
				}
			}
			else{
				$parameters[$uriSegments[2]] = $uriSegments[3];
				$this->my_tags->children = $this->my_tags->get_by_parent_tag($uriSegments[3]);
				$config['total_rows'] = $this->my_files->count_all_files($parameters);
			}
			$config['per_page'] = $this->per_page;
			$config['use_page_numbers'] = TRUE;
			if(count($uriSegments) == 2)
				$config['uri_segment'] = 2;
			elseif(count($uriSegments) == 4)
				$config['uri_segment'] = 4;
		
			}	
		else{
			$config['base_url'] = site_url('gallery/top');
			$count_files = $this->my_files->count_all_files();
			if($count_files > $this->my_files->count_top)
				$count_files = $this->my_files->count_top;
			$config['total_rows'] = $count_files;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 4;
			$parameters = array();
		}
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$pages = ceil($config['total_rows'] / $this->per_page);
		if(isset($_POST['is_load_more']) && isset($_POST['page'])){
			$page = (int)$_POST['page'];
			if($page < 2){
				$response['answer'] = 0;
			}
			else{
				$images = $this->my_files->get_files(($page - 1) * $this->per_page,$this->per_page,$parameters);
			}
		}
		else{
			$images = $this->my_files->get_files($this->per_page,$cur_page,$parameters);
		}
		if(count($uriSegments) == 2)
			$cur_page_data = $uriSegments[2];
		elseif(count($uriSegments) == 4)
			$cur_page_data = $uriSegments[3];

		$tags = $this->my_tags->get_main_tags();
		$options['0'] = $lang_main['ALL'];
		foreach($tags as $tag){
			$options[$tag['id']] = $tag['value'];
		}
		if($curr_tag && $curr_tag['parent_id'] == 0){
			$tags_box = form_dropdown('TAGS',$options,$curr_tag['id'],'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS"');
			
			if($this->my_tags->children){
				$child_options = array();
				$child_options[0] = $lang_main['ALL'];
				
				foreach($this->my_tags->children as $child)
					$child_options[$child['id']] = $child['value'];
				$children_tags_box = form_dropdown('TAGS_CHILDREN',$child_options,0,'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS_CHILDREN"');
			}		
			else
				$children_tags_box = '<select id="TAGS_CHILDREN" class="tags combobox" style="width:150px;" name="TAGS_CHILDREN"></select>';

		}
		elseif($curr_tag && $curr_tag['parent_id'] != 0){
			$tags_box = form_dropdown('TAGS',$options,$curr_tag['parent_id'],'class="tags combobox" onchange="get_categories(this);" style="width:150px;" ID="TAGS"');
				$children = $this->my_tags->get_by_parent_tag($curr_tag['parent_id']);
				$child_options = array();
				$child_options[0] = $lang_main['ALL'];
				foreach($children as $child)
					$child_options[$child['id']] = $child['value'];
				$children_tags_box = form_dropdown('TAGS_CHILDREN',$child_options,$curr_tag['id'],'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS_CHILDREN"');

		}
		else{
			$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:150px;" id="TAGS"');
			$children_tags_box = '<select id="TAGS_CHILDREN" class="tags combobox" style="width:150px;" name="TAGS_CHILDREN"></select>';

		}
		if(!$is_top){
			$popular_tags = $this->my_tags->get_popular_tags();
			$data_search = array(
			'tags_box' => $tags_box,
			'children_tags_box' => $children_tags_box,
			'THEME' => $this->theme_path.'/',
			'language' => $language,
			'popular_tags' => $popular_tags,
			'curr_tag' => $curr_tag
			);
			$search_panel = $this->get_widget('search_tags',$data_search);
		}
		else{
			$search_panel = '';
		}
		
		if(isset($_POST['is_load_more']) || !$cur_page)
			$all_uploaded = $config['total_rows'];
		else
			$all_uploaded = count($images);
			
		$data = array(
		'paginator' => $paginator,
		'images' => $images,
		'language' => $language,
		'lang_images' => $lang_image,
		'lang_auth' => $lang_auth,
		'all_uploaded' => $all_uploaded,
		'pages' => $pages,
		'cur_page' => $cur_page_data,
		'tag' => $curr_tag,
		'search_panel'  => $search_panel,
		'THEME' => $this->theme_path.'/',
		'lang_main' => $lang_main,
		'lang_top' => $lang_top,
		'is_top' => $is_top,
		'top_sort' => $this->my_files->top_sort,
		'is_ajax' => false
		);
		if($this->my_auth->role != 'guest')
			$data['type'] = 'user';
		else
			$data['type'] = 'guest';
		
		if(isset($_POST['is_ajax']) && isset($_POST['is_load_more'])){
			if(count($images) > 0){
				$response['content'] = $this->get_widget('gallery_load_more',$data);
				$response['answer'] = 1;
				$response['title'] = $this->site_title;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
		}
		elseif(isset($_POST['is_ajax']) && isset($_POST['is_search'])){
			$response['content'] = $this->get_widget('gallery_search',$data);
			$response['title'] = $this->site_title;
			$response['parent_tag'] = $curr_tag['parent_id'];
			$response['header'] = $language['IMAGES_WITH_TAG'].': '.$curr_tag['value'];
			$response['header_short_tag'] = $language['IMAGES_WITH_TAG'];
			$response['header_short_tags'] = $language['IMAGES_WITH_TAGS'];
			echo json_encode($response);
			exit;
		}

		if(isset($_POST['is_ajax']) && isset($_POST['is_top'])){
			$data['is_ajax'] = true;
			$response['content'] = $this->get_page('gallery',$data);
			echo json_encode($response);
			exit;
		}
		$this->template->assign('content',$this->get_page('gallery',$data));
		$this->template->assign('is_gallery',1);
		$this->display_layout();

	}
	
	function exif(){
		Language::load_language('exif');
		$this->load->model('exif');
		$uriSegments = $this->uri->segment_array();
		$exif_array = $this->exif->get_info($uriSegments[2],$uriSegments[3]);
		if(count($exif_array) > 0){
			$response['content'] = $this->get_widget('exif',array('exif' => $exif_array));
			$response['answer'] = 1;
		}
		else{
			$response['answer'] = 0;
		}
		echo json_encode($response);
	
	}
	

	function set_poll(){
		$this->load->model('poll');
		$vote = (int)$_REQUEST['vote'];
		$id = (int)$_REQUEST['id'];
		$type = $_REQUEST['type'];
		$this->poll->update_rating($id,$type,$vote);
		$response['content'] = $this->poll->rating_bar($id,$type);
		echo json_encode($response);
		exit;
	}
	
	
	function image(){
		
		$this->load->model('poll');
		$big_image = false;
		$uriSegments = $this->uri->segment_array();
		Language::load_language('albums');
		Language::load_language('gallery');
		Language::load_language('image');
		Language::load_language('exif');
		Language::load_language('comments');
		Language::load_language('auth');
		Language::load_language('imagelist');
		$this->load->model('exif');
		$this->load->model('genres');
		$language_gallery = Language::get_languages('gallery');
		$language_image = Language::get_languages('image');
		$lang_auth = Language::get_languages('auth');
		$lang_main = Language::get_languages('main');
		$lang_album = Language::get_languages('albums');
		$lang_imagelist= Language::get_languages('imagelist');
		$lang_comments = Language::get_languages('comments');
		$lang_upload = Language::get_languages('upload');
		$this->template->assign('is_opener',1);
		$from_seedoff = 0;
		$this->my_files->browse_mode = true;
		$this->my_files->show_actions = true;
		if($uriSegments[2] == 'big'){
			if(count($uriSegments) == 3){
				$is_tiny = true;
			}
			else{
				$buffer_url = '/image/'.$uriSegments[3].'/'.$uriSegments[4].'/'.$uriSegments[5];
				$buffer_filename = explode('_',$uriSegments[5]);
			}

			$this->layout = 'big_image';
			$big_image = true;
		}
		else{
			if(count($uriSegments) == 2){
				$is_tiny = true;

			}
			else{
				$buffer_url = '/image/'.$uriSegments[2].'/'.$uriSegments[3].'/'.$uriSegments[4];
				$buffer_filename = explode('_',$uriSegments[4]);
				$is_tiny = false;
			}
	
		}
		if(!$is_tiny):
		$is_key = preg_match('#\D+#',$buffer_filename[0]);
		if($is_key){
			$image = $this->my_files->get_file_guest_by_main_url($buffer_url);
			$owner = $language_gallery['GUEST'];
			$authorized = null;
			$type = 'guest';
		}
		else{
			$image = $this->my_files->get_file_user_by_main_url($buffer_url);
			$owner = $image->username;
			$authorized = $image->user_id;
			$type = 'user';
		}
		else:
			$this->my_files->tiny_mode = true;
			if($uriSegments[2] == 'big')
				$image = $this->my_files->get_file_by_id($uriSegments[3]);
			else
				$image = $this->my_files->get_file_by_id($uriSegments[2]);
			if($image->username){
				$owner = $image->username;
				$authorized = $image->user_id;
				$type = 'user';
			}
			else{
				$owner = $language_gallery['GUEST'];
				$authorized = null;
				$type = 'guest';
			}
		
		endif;
		
		
		if(!$image){
			$this->template->assign('content',$this->error_404());
			if(isset($_POST['is_ajax'])){
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			$this->display_layout();
			exit;
		}
		
		if($big_image){
			if($image->show_filename)
				$this->site_title = $image->show_filename;
			$this->template->assign('image',IMGURL.$image->url);
			$this->template->assign('main_url',$image->main_url);
			$this->template->assign('language',$language_image);
			if(isset($_POST['is_ajax'])){
				$response['content'] = $this->get_widget('big_image',array());
				$response['image_height'] = $image->height;
				echo json_encode($response);
				exit;
			}
			else{
				$this->display_layout();
				exit;
			}
			
		}
		
		if($type == 'user'){
			if(isset($_POST['is_ajax']) && isset($_POST['album_password'])){
			$res_password = $this->my_albums->set_password($image->album_id);
			if(!$res_password){
				$lang_auth = Language::get_languages('auth');
				$response['content'] = $lang_auth['WRONG_PASSWORD'];
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			else{
				$response['answer'] = 1;
				echo json_encode($response);
				exit;
			}

		}
		
		if($image->access == 'private' && $image->user_id != $this->my_auth->user_id){
			if(!$this->dx_auth->is_admin())
				$this->accessDenied('private',$lang_album,array('type' => 'image'));

		}
		elseif($image->access == 'protected' && $image->user_id != $this->my_auth->user_id){
			if(empty($_SESSION['album_password']) && !$this->dx_auth->is_admin())
				$this->accessDenied('protected',$lang_album,array('album_id' => $image->album_id,'album_name' => $image->album_name,'type' => 'image'));
		}
		}
		else{
			if($image->access == 'private' && $image->guest_key != $this->guests->key){
				if(!$this->dx_auth->is_admin())
					$this->accessDenied('private',$lang_album,array('type' => 'image'));

			}
		}
		if(isset($image->old_url))	
			$filename = ImageHelper::url_to_realpath($image->old_url);
		else
			$filename = ImageHelper::url_to_realpath($image->url);
		
		if(!$filename){
			$this->template->assign('content',$this->error_404());
			if(isset($_POST['is_ajax'])){
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			$this->display_layout();
			exit;
		}
		if(isset($_POST['is_ajax']))
			$is_ajax = 1;
		else
			$is_ajax = 0;
			

		if((isset($_SESSION['prev_link']) && $_SESSION['prev_link'] == current_url()) || (isset($_SESSION['next_link']) && $_SESSION['next_link'] == current_url())){

			if($_SESSION['prev_link'] == current_url()){
				if($_SESSION['current_index'] == 0){
					$_SESSION['current_index'] = 11;
					$_SESSION['current_page']--;
				}
				else{
					$_SESSION['current_index']--;
					if($_SESSION['current_index'] == 10)
						$_SESSION['next_page']--;
				}
			}
			elseif($_SESSION['next_link'] == current_url()){

				if($_SESSION['current_index'] == $this->per_page - 1){
					$_SESSION['current_index'] = 0;
					$_SESSION['current_page']++;
				}
				else{
					$_SESSION['current_index']++;
					if($_SESSION['current_index'] == 1)
						$_SESSION['prev_page']++;
				}

			}
			if($_SESSION['current_index'] == $this->per_page - 1 && $_SESSION['next_link'] == current_url()){
				$_SESSION['next_page']++;
			}
			
			if($_SESSION['current_index'] == 0 && $_SESSION['prev_link'] == current_url()){
				$_SESSION['prev_page']--;
			}
			
			$parameters = array(
			'prev_page' => $_SESSION['prev_page'],
			'next_page' => $_SESSION['next_page'],
			'cur_page' => $_SESSION['current_page'],
			'current_index' => $_SESSION['current_index']
			);
			$url_parameters = array();
			if(isset($_SESSION['is_album']) && isset($image->album_id))
				$this->set_history_image_album($parameters,$image->album_id);
			else
				$this->set_history_image($parameters);
			$prev_link = $_SESSION['prev_link'];
			$next_link = $_SESSION['next_link'];		

		}
		else{
			
			if(isset($_SESSION['from_gallery']) || isset($_SESSION['from_gallery_album'])){
				$prev_link = $_SESSION['prev_link'];
				$next_link = $_SESSION['next_link'];
			}
			else{
				if(!$is_big_image):
				
					if($image->torrent_id){
						$prev_link = $this->my_files->get_link_for_navigation_seedoff($image,'prev');
						$next_link = $this->my_files->get_link_for_navigation_seedoff($image,'next');
						$from_seedoff = 1;
					}
					else{
						$prev_link = $this->my_files->get_link_for_navigation($image,'prev',$authorized);
						$next_link = $this->my_files->get_link_for_navigation($image,'next',$authorized);
					}
				endif;
				
			}
		}

		if(isset($_SESSION['from_gallery']))
			unset($_SESSION['from_gallery']);
			
		if(isset($_SESSION['from_gallery_album']))
			unset($_SESSION['from_gallery_album']);
		
			
		if(!file_exists($filename)){
			$this->template->assign('content',$this->error_404());
			if(isset($_POST['is_ajax'])){
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
		}
		else{
			$file_width = $image->width;
			$file_height = $image->height;
			$image_proportion = $file_height / $file_width;
			if($file_width <= ImageHelper::$width_main){
				$width = $file_width;
				$is_big_image = false;
			}
			else{
				$width = ImageHelper::$width_main;
				$is_big_image = true;

			}
			
			$height = round($width * $image_proportion);

			if($image->exif){
				$buffer_exif = $this->exif->parse($image->exif);
				if(count($buffer_exif) > 0)
					$exif = $this->get_widget('exif',array('exif' => $buffer_exif));
				else
					$exif = '';
			}
			else{
				$exif = '';
			}
			
			$image->show_filename = stripslashes($image->show_filename);
			
			$image_proportion = $image->height / $image->width;
			
			$preview_width = round(ImageHelper::$size_fast_upload*2.5);
			$preview_height = round((ImageHelper::$size_fast_upload*2.5)*$image_proportion);
			
			$data = array(
			'filename' => IMGURL.$image->url,
			'filename_big' => ImageHelper::get_big_main_url($image->main_url),
			'filename_main' => SITE_URL.$image->main_url,
			'filename_preview' => $image->preview_url,
			'imglink_preview_html' => $image->preview_url_html,
			'imglink_preview_bb' => $image->preview_url_bb,
			'width' => $width,
			'height' => $height,
			'preview_width' => $preview_width,
			'preview_height' => $preview_height,
			'real_width' => $image->width,
			'real_height' => $image->height,
			'ext' => pathinfo($image->url, PATHINFO_EXTENSION),
			'show_filename' => $image->show_filename,
			'data' => $image->added,
			'size' => $image->size,
			'prev_link' => $prev_link,
			'next_link' => $next_link,
			'THEME' => $this->theme_path.'/',
			'language' => $language_image,
			'lang_upload' => $lang_upload,
			'lang_imagelist' => $lang_imagelist,
			'lang_auth' => $lang_auth,
			'owner' => $owner,
			'is_ajax' => $is_ajax,
			'maxlength_show_filename' => $this->my_upload->maxlength_show_filename,
			'tag_name' => $image->tag_name,
			'tag_id' => $image->tag_id,
			'id' => $image->id,
			'exif' => $exif,
			'relative_url' => $image->main_url,
			'user_id' => $image->user_id,
			'from_seedoff' => $from_seedoff,
			'tiny_url' => $image->tiny_url,
			'is_big_image' => $is_big_image
			);
			
			
			if($this->my_files->show_actions && $this->my_files->is_owner_image($image))
				$data['image_actions'] = 1;
			else
				$data['image_actions'] = 0;
				
			
			if($this->my_files->browse_mode){
				$data['browse_mode'] = 1;
				$data['browse_gallery'] = browse_gallery($this->my_files->list_for_browse,$is_tiny);
			}
			else
				$data['browse_mode'] = 0;
			
						
			if(isset($image->block_genres)){
				$data['block_genres'] = $image->block_genres;
			}
			
			if($image->cover){
				$data['cover'] = $image->cover;
			}
			
			if($uriSegments[2] == 'big'){
				$data['view_zoom'] = 0;
			}
			else{
				$data['view_zoom'] = 1;

			}
			

			if($this->my_auth->role != 'guest'){
				
				$data_comment = array(
				'language' => $lang_comments,
				'image_id' => $image->id
				);
				$data['comments'] = $this->get_widget('comments',$data_comment);
				$data['access_role'] = $image->access_role;
			}
			else
				$data['comments'] = '';
			
			if(isset($image->torrent_id)){
				$data['torrent_id'] = $image->torrent_id;
				$data['seedoff_link'] = $this->seedoff_sync->domain.'/torrent/'.$image->torrent_id;
				if($image->cover){
					$data['screen'] = splitterWord($image->show_filename,40).' - '.$language_image['COVER'];
					if($image->tag_name){
						$seo_name = str_replace('%show_filename%',$image->show_filename,$language_image['SEO_POSTER_NAME']);
						$seo_name = str_replace('%category%',$image->tag_name,$seo_name);
						$this->site_description = $seo_name.' | '.$this->site_description;
						$this->site_title = $this->site_description;
					}
					else{
						$seo_name = str_replace('%show_filename%',$image->show_filename,$language_image['SEO_SIMPLE_NAME']);
						$this->site_description = $seo_name.' - '.$language_image['COVER'].' | '.$this->site_description;
						$this->site_title = $this->site_description;

					}
				}
				else{
					$number_screen = $this->my_files->get_number_screen_by_torrent_id($image);
					$data['screen'] = splitterWord($image->show_filename,40).' - '.$language_image['SCREEN'].' '.$number_screen;
					if($image->tag_name){
						$seo_name = str_replace('%show_filename%',$image->show_filename,$language_image['SEO_SCREEN_NAME']);
						$seo_name = str_replace('%category%',$image->tag_name,$seo_name);
						$this->site_description = $seo_name.' | '.$this->site_description;
						$this->site_title = $this->site_description;
					}
					else{
						$seo_name = str_replace('%show_filename%',$image->show_filename,$language_image['SEO_SIMPLE_NAME']);
						$this->site_description = $seo_name.' | '.$this->site_description;
						$this->site_title = $this->site_description;

					}

				}
				if(!$data['screen'])
					unset($data['screen']);
			}
			else{
				$this->site_description = $image->show_filename.' | '.$this->site_description;

			}
			
			if($image->access == 'public'){
				if($type == 'user'){
					$data['rating_bar'] = $this->poll->rating_bar($image->id,$type,$image->user_id);
					$this->statistic->set_view($image->id,'user',$image->user_id);
					$data['type'] = 'user';
					if($this->my_auth->role != 'guest'){
						if($image->fvid)
							$data['is_favourite'] = 1;
						else
							$data['is_favourite'] = 0;
					}
					else{
						
					}
				}
				else{
					$data['rating_bar'] = $this->poll->rating_bar($image->id,$type);
					$data['type'] = 'guest';
					$this->statistic->set_view($image->id,'guest');
					
					if($this->my_auth->role != 'guest'){
						if($this->my_files->is_favourite('guest',$image->id))
							$data['is_favourite'] = 1;
						else
							$data['is_favourite'] = 0;
					}

				}
				$data['show_views'] = 1;
				$data['views'] = $image->views;

			}
			else{
				$data['rating_bar'] = '';
				$data['show_views'] = 0;
			}
			
			
			if(!$this->site_title)
				$this->site_title = $image->show_filename;
			
			if($image->album_id){
				$data['album_id'] = $image->album_id;
				$data['album_name'] = $image->album_name;
				$data['lang_album'] = $lang_album;
			}
			if($this->my_auth->role == 'admin'){
				$data['show_account'] = 1;
			}
			elseif($this->my_auth->role == 'user'){
				if($image->access_role == 'user' || $image->access_role == 'guest' || $image->user_id == $this->my_auth->user_id){
					$data['show_account'] = 1;
				}
				else{
					$data['show_account'] = 0;
				}
			}
			
			
			if($this->my_auth->role == 'guest')
				$data['is_user'] = 0;
			else
				$data['is_user'] = 1;
				
			if(!$image->user_id)
				$data['from_user'] = 0;
			else
				$data['from_user'] = 1;
				
			
			if(isset($_POST['is_ajax'])){
				$response['answer'] = 1;
				$response['content'] = $this->get_page('image',$data);
				$response['title'] = $this->site_title;
				echo json_encode($response);
				exit;
			}
			$this->template->assign('content',$this->get_page('image',$data));
			$this->template->assign('is_image',1);

		}
		$this->site_description = '';
		$this->site_keywords = '';
		$this->display_layout();		

	}
	
	function images_delete(){
		$uriSegments = $this->uri->segment_array();
		$lang_main = Language::get_languages('main');
		
		if(isset($_REQUEST['token'])){
			$token = $_REQUEST['token'];
			$this->seedoff_sync->set_user($token);
		}

		if(!$uriSegments[3])
			exit;
		if($uriSegments[1] == 'images_guest'){
			if($this->my_auth->role != 'guest' && $this->members->seedoff_token){
				$guest_key = $this->members->seedoff_token;
			}
			else
				$guest_key = $this->guests->key;

			
			if($this->my_files->delete_guest_file($uriSegments[3],$guest_key)){
				$response['answer'] = 1;
			}
			else{
				$response['answer'] = 0;
				$response['content'] = $lang_main['ACCESS_DENIED_DELETE'];
			}
			echo json_encode($response);
			exit;
		}
		else{
			if($this->my_files->delete_file($uriSegments[3],$this->members->user_id)){
				$response['answer'] = 1;
			}
			else{
				$response['answer'] = 0;
				$response['content'] = $lang_main['ACCESS_DENIED_DELETE'];
			}
			echo json_encode($response);
			exit;
		}
		
	}
	
	function images_edit(){
		$uriSegments = $this->uri->segment_array();
		Language::load_language('albums');
		$lang_upload = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$lang_albums = Language::get_languages('albums');
		$this->load->model('bitly');
		if(!$uriSegments[3])
			exit;
		if($uriSegments[1] == 'images_guest'){
			if($this->my_auth->role != 'guest' && $this->members->seedoff_token){
				$guest_key = $this->members->seedoff_token;
			}
			else
				$guest_key = $this->guests->key;
			if(isset($_POST['FROM_UPLOAD'])){
				$res = $this->my_files->update_file_guest($uriSegments[3],$guest_key,$modify_url);
				
				if($res){
					$image = $this->my_files->get_file_guest($uriSegments[3],$guest_key);
					if($image){
						$image_preview = str_ireplace('big','preview',$image->url);
						$image_proportion = $image->height / $image->width;
						$response['image'] = '<a href="'.$image->url.'?'.ImageHelper::random_hash().'" onclick="show_image(this);return false;"><img src="'.$image_preview.'?'.ImageHelper::random_hash().'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
						$response['imglink'] = $image->url;
						$response['imglink_html'] = $image->main_url;
						$response['error'] = '';
						$response['form_number'] = $_POST['current_form'];
						$response['id'] = $image->id;
						$response['width'] = $image->width;
						$response['height'] = $image->height;
						$response['role'] = 'guest';
						
					}
					else{
						$response['error'] = 'Ошибка';
					}
				}
				echo json_encode($response);
				exit;
				
			}
			
			if(isset($_POST['is_update'])){
				$modify_url = '';
				$tags = $this->my_tags->get_main_tags();
				$options['0'] = $lang_main['ALL'];
				foreach($tags as $tag){
					$options[$tag['id']] = $tag['value'];
				}
				$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="TAGS"');
				
				$res = $this->my_files->update_file_guest($uriSegments[3],$guest_key,$modify_url);

				if($res){
					$image = $this->my_files->get_file_guest($uriSegments[3],$guest_key);
					if($image){
						$image_preview = str_ireplace('big','preview',$image->url);
						if($modify_url)
							$image_preview .= '?'.$modify_url;
						$image_proportion = $image->height / $image->width;
						$response['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
						$response['show_filename'] = $image->show_filename;
						$response['comment'] = $image->comment;
						$response['size'] = formatFileSize($image->size);
						$response['ext'] = pathinfo($image->url, PATHINFO_EXTENSION);
						$response['answer'] = 1;
						if($image->tag_name)
							$response['tag_name'] = '<a href="'.site_url('gallery/tags').'/'.$image->tag_id.'">'.$image->tag_name.'</a>';
						else
							$response['tag_name'] = '';
						if($image->access == 'public')
							$response['access_text'] = '<img src="'.$this->theme_path.'/images/access_'.$image->access.'.png" width="15" height="15" title="'.$lang_albums['ALBUM_PUBLIC'].'" />';								
						elseif($image->access == 'protected')
							$response['access_text'] = '<img src="'.$this->theme_path.'/images/access_'.$image->access.'.png" width="15" height="15" title="'.$lang_albums['ALBUM_PROTECTED'].'" />';		
						else
							$response['access_text'] = '<img src="'.$this->theme_path.'/images/access_'.$image->access.'.png" width="15" height="15" title="'.$lang_albums['ALBUM_PRIVATE'].'" />';		
					}
					else{
						$response['answer'] = 0;
					}
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			if($_POST['width'] > $_POST['height'])
				$max_size = $_POST['width'];
			else
				$max_size = $_POST['height'];
			$image = $this->my_files->get_file_guest($uriSegments[3],$guest_key);
			
			if(!$image){
				$response['answer'] = 0;
				$response['content'] = $lang_main['ACCESS_DENIED_EDIT'];
				echo json_encode($response);
				exit;
			}
			$tags = $this->my_tags->get_main_tags();
				$options['0'] = $lang_main['ALL'];
				foreach($tags as $tag){
					$options[$tag['id']] = $tag['value'];
				}

				$tags_box = form_dropdown('TAGS',$options,$selected,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="TAGS"');	
				$access_box = form_dropdown('ACCESS',array('private' => $lang_albums['ALBUM_PRIVATE'],'public' => $lang_albums['ALBUM_PUBLIC']),$image->access,'class="combobox" style="width:110px;" id="ACCESS"');
				$proportion = round($image->height / $image->width, 3);
				$proportion = str_replace(',','.',$proportion);
			$data = array(
			'src' => $_POST['src'],
			'width' => round($_POST['width']/1.5),
			'height' => round($_POST['height']/1.5),
			'proportion' => $proportion,
			'full_width' => $image->width,
			'full_height' => $image->height,
			'id' => $uriSegments[3],
			'language' => $lang_upload,
			'lang_albums' => $lang_albums,
			'is_guest' => 1,
			'max_size' => $max_size,
			'tags' => $tags_box,
			'access' => $access_box
			);
			if($image->tiny_url)
				$data['tiny_url'] = $image->tiny_url;
			$response['answer'] = 1;
			$response['content'] = $this->get_widget('image_edit',$data);
			echo json_encode($response);
			exit;
		}
		else{
			if(isset($_POST['FROM_UPLOAD'])){
				if($this->guests->key)
					$res = $this->my_files->update_file_guest($uriSegments[3],$this->guests->key,$modify_url);
				
				else
					$res = $this->my_files->update_file($uriSegments[3],$this->members->user_id,$modify_url);
			
				if($res){
					if($this->guests->key)
						$image = $this->my_files->get_file_guest($uriSegments[3],$this->guests->key);
					else
						$image = $this->my_files->get_file($uriSegments[3],$this->members->user_id);
						
					if($image){
						$image_preview = str_ireplace('big','preview',$image->url);
						$image_proportion = $image->height / $image->width;
						$response['image'] = '<a href="'.$image->url.'" onclick="show_image(this);return false;"><img src="'.$image_preview.'?'.ImageHelper::random_hash().'" width="'.ImageHelper::$size_fast_upload.'" height="'.round(ImageHelper::$size_fast_upload*$image_proportion).'"></a>';
						$response['imglink'] = $image->url;
						$response['imglink_html'] = $image->main_url;
						$response['error'] = '';
						$response['form_number'] = $_POST['current_form'];
						$response['id'] = $image->id;
						$response['width'] = $image->width;
						$response['height'] = $image->height;
						if($this->guests->key)
							$response['role'] = 'guest';


					}
					else{
						$response['error'] = 'Ошибка';
					}
				}
				echo json_encode($response);
				exit;
				
			}
			
			if(isset($_POST['is_update'])){
				$modify_url = '';
				
				$res = $this->my_files->update_file($uriSegments[3],$this->members->user_id,$modify_url);

				if($res){
					$image = $this->my_files->get_file($uriSegments[3],$this->members->user_id);
					if($image){
						$image_preview = str_ireplace('big','preview',$image->url);
						if($modify_url)
							$image_preview .= '?'.$modify_url;
						$image_proportion = $image->height / $image->width;
						$response['preview'] = '<img src="'.$image_preview.'" width="'.(round(ImageHelper::$size_fast_upload/2)).'" height="'.round((ImageHelper::$size_fast_upload/2)*$image_proportion).'">';
						$response['show_filename'] = $image->show_filename;
						$response['comment'] = $image->comment;
						$response['size'] = formatFileSize($image->size);
						$response['ext'] = pathinfo($image->url, PATHINFO_EXTENSION);
						$response['answer'] = 1;
						if($image->access == 'public')
							$response['access_text'] = '<img src="'.$this->theme_path.'/images/access_'.$image->access.'.png" width="15" height="15" title="'.$lang_albums['ALBUM_PUBLIC'].'" />';								
						elseif($image->access == 'protected')
							$response['access_text'] = '<img src="'.$this->theme_path.'/images/access_'.$image->access.'.png" width="15" height="15" title="'.$lang_albums['ALBUM_PROTECTED'].'" />';		
						else
							$response['access_text'] = '<img src="'.$this->theme_path.'/images/access_'.$image->access.'.png" width="15" height="15" title="'.$lang_albums['ALBUM_PRIVATE'].'" />';		
						if($image->tag_name)
							$response['tag_name'] = '<a href="'.site_url('gallery/tags').'/'.$image->tag_id.'">'.$image->tag_name.'</a>';
						else
							$response['tag_name'] = '';
						if($image->album_name)
							$response['album_name'] = '<a href="'.site_url('albums').'/'.$image->album_id.'">'.$image->album_name.'</a>';
						else
							$response['album_name'] = '';
					}
					else{
						$response['answer'] = 0;
					}
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			if($_POST['width'] > $_POST['height'])
				$max_size = $_POST['width'];
			else
				$max_size = $_POST['height'];
			$tags = $this->my_tags->get_main_tags();
			$buffer_arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr_albums = array('0' => '----');
			if($buffer_arr_albums){
				foreach($buffer_arr_albums as $album)
					$arr_albums[$album['id']] = $album['name'];
			}

			$image = $this->my_files->get_file($uriSegments[3],$this->members->user_id);

			if(!$image){
				$response['answer'] = 0;
				$response['content'] = $lang_main['ACCESS_DENIED_EDIT'];
				echo json_encode($response);
				exit;
			}
			if($image->album_id)
				$selected = $image->album_id;
			else
				$selected = 0;
				
			
			if(count($arr_albums) > 0)
				$albums_box = form_dropdown('ALBUMS',$arr_albums,$selected,'class="tags combobox" style="width:110px;" id="ALBUMS" onchange="block_access(this);return false;"');
			else
				$albums_box = '<select name="ALBUMS" style="width:110px;" id="ALBUMS" class="tags combobox"></select>';

				$options['0'] = $lang_main['ALL'];
				foreach($tags as $tag){
					$options[$tag['id']] = $tag['value'];
				}
			if($image->tag_id){

				if($image->tag_parent_id == 0){
					$tags_box = form_dropdown('TAGS',$options,$image->tag_id,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="TAGS"');
					$children_tags_box = '';

				}
				else{
					$tags_box = form_dropdown('TAGS',$options,$image->tag_parent_id,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="TAGS"');
					$children_tags = $this->my_tags->get_by_parent_tag($image->tag_parent_id);
					unset($options);
					$options['0'] = $lang_main['ALL'];
					foreach($children_tags as $tag){
						$options[$tag['id']] = $tag['value'];
					}
					$children_tags_box = form_dropdown('CHILDREN_TAGS',$options,$image->tag_id,'class="tags combobox" style="width:110px;" id="TAGS_CHILDREN"');

				}
			}
			else
				$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="TAGS"');
				
				$proportion = round($image->height / $image->width, 3);
				$proportion = str_replace(',','.',$proportion);
			$data = array(
			'src' => $_POST['src'],
			'width' => round($_POST['width']/1.5),
			'height' => round($_POST['height']/1.5),
			'proportion' => $proportion,
			'full_width' => $image->width,
			'full_height' => $image->height,
			'id' => $uriSegments[3],
			'language' => $lang_upload,
			'lang_albums' => $lang_albums,
			'is_guest' => 0,
			'max_size' => $max_size,
			'tags' => $tags_box,
			'children_tags' => $children_tags_box,
			'albums' => $albums_box
			);
			if($image->album_id)
				$data['current_album'] = $image->album_id;
				
			if($image->tiny_url)
				$data['tiny_url'] = $image->tiny_url;

			$response['content'] = $this->get_widget('image_edit',$data);
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
	}
	
	function torrent_file_delete(){
		
		$uriSegments = $this->uri->segment_array();
		$file_id = (int)$uriSegments[4];
		if(!$file_id)
			$file_id = (int)$this->input->post('file_id');
		$torrent_id = (int)$this->input->post('album_id');
		Language::load_language('albums');
		$lang_albums = Language::get_languages('albums');
		
		if(!$file_id)
			exit;
			
		if(!$this->members->seedoff_token)
			exit;
		$res = $this->my_files->delete_guest_file($file_id,$this->members->seedoff_token);
		if($res){
			$num_files = $this->seedoff_sync->get_count_files_in_torrent($torrent_id);
			if($num_files < 1)
				$response['content'] = $lang_albums['NO_FILES'];
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
	}
	
	function album_file_delete(){
		
		$uriSegments = $this->uri->segment_array();
		$file_id = (int)$uriSegments[4];
		if(!$file_id)
			$file_id = (int)$this->input->post('file_id');
		
		$album_id = (int)$this->input->post('album_id');
		Language::load_language('albums');
		$lang_albums = Language::get_languages('albums');
		
		if(!$file_id)
			exit;
		$res = $this->my_albums->delete_file($file_id,$this->my_auth->user_id);
		if($res){
			$num_files = $this->my_albums->get_count_file_in_album($album_id,$this->my_auth->user_id);
			if($num_files < 1)
				$response['content'] = $lang_albums['NO_FILES'];
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
	}
	
	function album_file_exclude(){
		
		$file_id = (int)$this->input->post('file_id');
		$album_id = (int)$this->input->post('album_id');
		Language::load_language('albums');
		$lang_albums = Language::get_languages('albums');
		
		if(!$file_id)
			exit;
			
		if(!$album_id)
			exit;
			
		$res = $this->my_albums->exclude_file($album_id,$file_id,$this->my_auth->user_id);
		if($res){
			$num_files = $this->my_albums->get_count_file_in_album($album_id,$this->my_auth->user_id);
			if($num_files < 1)
				$response['content'] = $lang_albums['NO_FILES'];
			$response['num_files'] = $num_files;
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
	}
	
	function album_file_add(){
		
		$file_id = (int)$this->input->post('file_id');
		$album_id = (int)$this->input->post('album_id');			
		$type = $this->input->post('type');			

		if(!$file_id)
			exit;
			
		if(!$album_id)
			exit;
			
		if($type == 'torrent'){
			
			if($this->seedoff_sync->add_file_to_torrent($file_id,$album_id)){
			$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();

			if($arr_albums){
				
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr);
				
			}
			else{
				$tree = $lang_albums['NO_FOLDERS'];
			}
			$response['content'] = $tree;
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		}
		
		else{
			if($this->my_albums->add_file_to_album($file_id,$album_id)){
			$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();
			if($arr_albums){
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr);
				
			}
			else{
				$tree = $lang_albums['NO_FOLDERS'];
			}
			$response['content'] = $tree;
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		}
		

	}
	
	function albums(){
		
		$this->load->model('socialnet/vk');
		$this->load->model('socialnet/fb');
		$this->load->model('socialnet/ok');
		$this->load->model('socialnet/pic');
		$this->per_page = 15;
		Language::load_language('albums');
		Language::load_language('imagelist');
		Language::load_language('sync');
		Language::load_language('imagelist');
		$lang_auth = Language::get_languages('auth');
		$lang_albums = Language::get_languages('albums');
		$lang_images = Language::get_languages('imagelist');
		$lang_upload = Language::get_languages('upload');
		$lang_sync = Language::get_languages('sync');
		$language = Language::get_languages('main');
		$lang_upload['ADD_PHOTO'] = str_ireplace('%num%',$this->my_upload->fast_fields_count,$lang_upload['ADD_PHOTO']);

		if($this->my_auth->role == 'guest'){
			$this->template->assign('content',$this->get_page('unauthorized',array('msg' => $lang_auth['ACCESS_AUTHORIZED'])));
			$this->display_layout();
			exit;

		}
		$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();
			if($arr_albums){
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr,$language);
				
			}
			else{
				$tree = $lang_albums['NO_FOLDERS'];
			}
		$tree = $this->get_widget('albums_tree',array('tree' => $tree));
		$config['base_url'] = site_url('albums/files');
		$config['total_rows'] = $this->my_files->count_files_by_userid($this->my_auth->user_id,"album_id IS NULL");

		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 3;
		$config['callback_ajax'] = 'paginate_link_list_files';
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$files = $this->my_files->get_files_by_userid_simple($this->members->user_id,0,$this->per_page);
		$data_list_files = array(
		'files' => $files,
		'language' => $lang_albums,
		'paginator' => $paginator,
		'lang_images' => $lang_images,
		'lang_main' => $language
		);
		
		$list_files = $this->get_widget('list_files',$data_list_files);
		if($this->vk->num_albums)
			$num_albums_vk = $this->vk->num_albums;
		else
			$num_albums_vk = 0;
			
		if($this->fb->num_albums)
			$num_albums_fb = $this->fb->num_albums;
		else
			$num_albums_fb = 0;
			
		if($this->ok->num_albums)
			$num_albums_ok = $this->ok->num_albums;
		else
			$num_albums_ok = 0;
			
		if($this->pic->num_albums)
			$num_albums_pic = $this->pic->num_albums;
		else
			$num_albums_pic = 0;
		
		$data = array(
		'lang_auth' => $lang_auth,
		'lang_sync' => $lang_sync,
		'language' => $lang_albums,
		'num_files' => $this->my_files->count_images,
		'num_folders' => $this->my_files->count_albums,
		'tree' => $tree,
		'list_files' => $list_files,
		'fast_form' => '',
		'num_albums_vk' => $num_albums_vk,
		'num_albums_fb' => $num_albums_fb,
		'num_albums_ok' => $num_albums_ok,
		'num_albums_pic' => $num_albums_pic
		);
		$buffer = $this->seedoff_sync->count_torrents_by_token($this->members->seedoff_token);
	
		$this->template->assign('is_albums',1);
		$this->site_title = $lang_auth['ALBUMS'];
		$this->template->assign('content',$this->get_page('albums',$data));
		$this->display_layout();

	}
	
	function album_files(){
		
		$uriSegments = $this->uri->segment_array();
		$this->per_page = 15;
		if(count($uriSegments) == 2)
			$cur_page = 0;
		else
			$cur_page = ($uriSegments[3] - 1) * $this->per_page;
		Language::load_language('albums');
		$lang_albums = Language::get_languages('albums');
		Language::load_language('imagelist');
		$lang_images = Language::get_languages('imagelist');
		$config['base_url'] = site_url('albums/files');
		$config['total_rows'] = $this->my_files->count_files_by_userid($this->my_auth->user_id,"album_id IS NULL");
		$config['per_page'] = $this->per_page;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 3;
		$config['callback_ajax'] = 'paginate_link_list_files';
		$this->pagination->initialize($config);
		$paginator = $this->pagination->create_links_modal();
		$files = $this->my_files->get_files_by_userid_simple($this->members->user_id,$cur_page,$this->per_page);
		$data = array(
		'files' => $files,
		'language' => $lang_albums,
		'lang_images' => $lang_images,
		'paginator' => $paginator
		);
		if(isset($_POST['is_ajax'])){
			$response['content'] = $this->get_widget('list_files',$data);
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		
	}
	
	function upload_to_net(){

		if($this->my_auth->role == 'guest')
			exit;
		$uriSegments = $this->uri->segment_array();
		$url_server = $this->input->get_post('upload_url');
		Language::load_language('sync');
		$language = Language::get_languages('sync');
		if(!$url_server)
			exit;
		if(isset($_GET['local_album_id'])){
			$local_album_id = $this->input->get('local_album_id');
			$this->db->select('id');
			$this->db->from($this->members->images_table);
			$this->db->where('album_id',$local_album_id);
			$res = $this->db->get();
			if(!$res)
				exit;
			$buffer = array();
			foreach($res->result_array() as $item){
				$buffer[] = $item['id'];
			}
			$photos = implode(',',$buffer);
		}
		else{
			$photos = $this->input->post('photos');
		}
		if($uriSegments[2] == 'vk'){
			$this->layout = 'vk_sync';
			$this->load->model('socialnet/vk');
			$result = $this->vk->upload_server($url_server,$photos);
			if(isset($_POST['is_simple'])){
				echo $result;
				exit;
			}
			$js = "function photos_save(){ VK.Api.call('photos.save',";	
			$js .= $result;
			$js .= ", function(r) {alert('Success!');}); }";
			$this->template->assign('language',$language);
			$this->template->assign('result',$result);
			ob_start();
			$this->display_layout();
			$html = ob_get_contents();
			ob_end_clean();
//			$response['js'] = $result;
		}
		
		echo $html;
		exit;
		
	}
	
	function show_net(){
		
		$uriSegments = $this->uri->segment_array();
		$lang_main = Language::get_languages('main');
		if($uriSegments[2] == 'vk'){
			$this->load->model('socialnet/vk');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if($this->dx_auth->get_role_name() == 'user' && $this->vk->owner_id != $owner_id)
				exit;
			$this->vk->set_current_photos($album_id);
			$files = $this->vk->get_photos_by_album_id($album_id);
			$data = array(
			'files' => $files,
			'THEME' => $this->theme_path.'/',
			'lang_main' => $lang_main,
			'net' => 'vk',
			'net_album_id' => $album_id,
			'net_owner_id' => $owner_id
			);
			$response['content'] = $this->get_widget('album_files_net',$data);
			echo json_encode($response);
			exit;
			
		}
		elseif($uriSegments[2] == 'fb'){
			$this->load->model('socialnet/fb');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if($this->dx_auth->get_role_name() == 'user' && $this->fb->owner_id != $owner_id)
				exit;
			if(isset($_POST['enable_show_album']))	{
				if(!$this->fb->is_connected() || $this->fb->is_empty_album($this->owner_id))
					$response['answer'] = 0;
				else
					$response['answer'] = 1;
				echo json_encode($response);
				exit;
				}
				$files = $this->fb->get_photos_by_album_id($album_id);
				$data = array(
				'files' => $files,
				'THEME' => $this->theme_path.'/',
				'lang_main' => $lang_main,
				'net' => 'fb'
				);
				$response['content'] = $this->get_widget('album_files_net',$data);
				echo json_encode($response);
				exit;
				
			}
		elseif($uriSegments[2] == 'ok'){
			$this->load->model('socialnet/ok');
			
			$this->ok->get_object();
			$ok = $this->ok->instance;
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if($this->dx_auth->get_role_name() == 'user' && $this->ok->owner_id != $owner_id)
				exit;
			if(mktime() < $_SESSION['ok']['token_expires']){
				$token = '{"token_type":"session","refresh_token":"'.$_SESSION['ok']['refresh_token'].'","access_token":"'.$_SESSION['ok']['access_token'].'","expires":'.$_SESSION['ok']['token_expires'].'}';
				$ok->setToken($token);
				$this->ok->set_photos_by_album($ok,$album_id);
			}
					
			$files = $this->ok->get_photos_by_album_id($album_id);
			$data = array(
			'files' => $files,
			'THEME' => $this->theme_path.'/',
			'lang_main' => $lang_main,
			'net' => 'ok'
			);
			$response['content'] = $this->get_widget('album_files_net',$data);
			echo json_encode($response);
			exit;
		}
		elseif($uriSegments[2] == 'pic'){
			$this->load->model('socialnet/pic');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if($this->dx_auth->get_role_name() == 'user' && $this->pic->owner_id != $owner_id)
				exit;
			$this->pic->set_photos_by_album($album_id);
					
			$files = $this->pic->get_photos_by_album_id($album_id);
			$data = array(
			'files' => $files,
			'THEME' => $this->theme_path.'/',
			'lang_main' => $lang_main,
			'net' => 'pic'
			);
			$response['content'] = $this->get_widget('album_files_net',$data);
			echo json_encode($response);
			exit;
		}
							
	}
	
	function copy_local(){
		$uriSegments = $this->uri->segment_array();
		if($uriSegments[2] == 'vk'){
			$this->load->model('socialnet/vk');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if(isset($_POST['photo_id'])){
				$local_album_id = $this->input->post('local_album_id');
				$photo_id = $this->input->post('photo_id');
				if(!$owner_id || !$album_id || !$photo_id || !$local_album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->vk->owner_id != $owner_id)
					exit;
				$res = $this->vk->copy_photo($photo_id,$owner_id,$album_id,$local_album_id);
			}
			else{
				if(!$owner_id || !$album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->vk->owner_id != $owner_id)
					exit;
		
				$res = $this->vk->copy_photo(null,$owner_id,$album_id,null);
				if($res){
					$data_local_panel = array(
					'albums' => $this->my_albums->get_albums_by_userid($this->my_auth->user_id),
					'THEME' => $this->theme_path.'/'
					);
					$response['answer'] = 1;
					$response['content'] = $this->get_widget('sync_local',$data_local_panel);
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			
			if($res)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			echo json_encode($response);
			exit;
							
		}
	}
	
	function copy_net(){
		$uriSegments = $this->uri->segment_array();
		if($uriSegments[2] == 'vk'){
			$this->load->model('socialnet/vk');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if(isset($_POST['photo_id'])){
				$local_album_id = $this->input->post('local_album_id');
				$photo_id = $this->input->post('photo_id');
				if(!$owner_id || !$album_id || !$photo_id || !$local_album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->vk->owner_id != $owner_id)
					exit;
				$res = $this->vk->copy_photo($photo_id,$owner_id,$album_id,$local_album_id);
			}
			else{
				if(!$owner_id || !$album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->vk->owner_id != $owner_id)
					exit;
		
				$res = $this->vk->copy_photo(null,$owner_id,$album_id,null);
				if($res){
					$data_local_panel = array(
					'albums' => $this->my_albums->get_albums_by_userid($this->my_auth->user_id),
					'THEME' => $this->theme_path.'/'
					);
					$response['answer'] = 1;
					$response['content'] = $this->get_widget('sync_local',$data_local_panel);
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			
			if($res)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			echo json_encode($response);
			exit;
							
		}
		elseif($uriSegments[2] == 'fb'){
			$this->load->model('socialnet/fb');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if(isset($_POST['photo_id'])){
				$local_album_id = $this->input->post('local_album_id');
				$photo_id = $this->input->post('photo_id');
				if(!$owner_id || !$album_id || !$photo_id || !$local_album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->fb->owner_id != $owner_id)
					exit;
				$res = $this->fb->copy_photo($photo_id,$owner_id,$album_id,$local_album_id);
			}
			else{
				if(!$owner_id || !$album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->fb->owner_id != $owner_id)
					exit;
		
				$res = $this->fb->copy_photo(null,$owner_id,$album_id,null);
				if($res){
					$data_local_panel = array(
					'albums' => $this->my_albums->get_albums_by_userid($this->my_auth->user_id),
					'THEME' => $this->theme_path.'/'
					);
					$response['answer'] = 1;
					$response['content'] = $this->get_widget('sync_local',$data_local_panel);
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			
			if($res)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		elseif($uriSegments[2] == 'ok'){
			$this->load->model('socialnet/ok');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if(isset($_POST['photo_id'])){
				$local_album_id = $this->input->post('local_album_id');
				$photo_id = $this->input->post('photo_id');
				if(!$owner_id || !$album_id || !$photo_id || !$local_album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->ok->owner_id != $owner_id)
					exit;
				$res = $this->ok->copy_photo($photo_id,$owner_id,$album_id,$local_album_id);
			}
			else{
				if(!$owner_id || !$album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->ok->owner_id != $owner_id)
					exit;
		
				$res = $this->ok->copy_photo(null,$owner_id,$album_id,null);
				if($res){
					$data_local_panel = array(
					'albums' => $this->my_albums->get_albums_by_userid($this->my_auth->user_id),
					'THEME' => $this->theme_path.'/'
					);
					$response['answer'] = 1;
					$response['content'] = $this->get_widget('sync_local',$data_local_panel);
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			
			if($res)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		elseif($uriSegments[2] == 'pic'){
			$this->load->model('socialnet/pic');
			$owner_id = $uriSegments[4];
			$album_id = $uriSegments[5];
			if(isset($_POST['photo_id'])){
				$local_album_id = $this->input->post('local_album_id');
				$photo_id = $this->input->post('photo_id');
				if(!$owner_id || !$album_id || !$photo_id || !$local_album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->pic->owner_id != $owner_id)
					exit;
				$res = $this->pic->copy_photo($photo_id,$owner_id,$album_id,$local_album_id);
			}
			else{
				if(!$owner_id || !$album_id)
					exit;
				if($this->dx_auth->get_role_name() == 'user' && $this->pic->owner_id != $owner_id)
					exit;
		
				$res = $this->pic->copy_photo(null,$owner_id,$album_id,null);
				if($res){
					$data_local_panel = array(
					'albums' => $this->my_albums->get_albums_by_userid($this->my_auth->user_id),
					'THEME' => $this->theme_path.'/'
					);
					$response['answer'] = 1;
					$response['content'] = $this->get_widget('sync_local',$data_local_panel);
				}
				else{
					$response['answer'] = 0;
				}
				echo json_encode($response);
				exit;
			}
			
			if($res)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		
	}
	
	function torrent_show(){
		
		$uriSegments = $this->uri->segment_array();
		$torrent_id = $uriSegments[3];
		if(!$torrent_id){
			$response['content'] = 'Access denied!!';
			exit;
		}
		if(!$this->members->seedoff_token){
			$response['content'] = 'Access denied!!';
			exit;
		}
		if(!$this->seedoff_sync->is_owner_torrent_id($torrent_id,$this->members->seedoff_token)){
			$response['content'] = 'Access denied!!';
			exit;
		}
		Language::load_language('albums');
		$language = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');

		if(isset($_POST['is_sync'])){
			$files = $this->my_albums->get_files_by_album($album_id,$this->my_auth->user_id);
			$data = array(
			'files' => $files,
			'THEME' => $this->theme_path.'/',
			'lang_main' => $lang_main
			);
			$response['content'] = $this->get_widget('album_files',$data);
			echo json_encode($response);
			exit;
		}
		$branch = $this->seedoff_sync->get_branch($torrent_id,$lang_main,$language);
//		echo 'branch '.$branch.'<br>';
		if($branch){
			$response['content'] = $branch;
			echo json_encode($response);
			exit;
		}
		else{
			$response['content'] = $language['NO_FILES'];
			echo json_encode($response);
			exit;
		}
	}
	
	function album_show(){
		
		$uriSegments = $this->uri->segment_array();
		$album_id = $uriSegments[3];
		Language::load_language('albums');
		$language = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		if(!$album_id){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		if(isset($_POST['is_sync'])){
			$files = $this->my_albums->get_files_by_album($album_id,$this->my_auth->user_id);
			$data = array(
			'files' => $files,
			'THEME' => $this->theme_path.'/',
			'lang_main' => $lang_main
			);
			$response['content'] = $this->get_widget('album_files',$data);
			echo json_encode($response);
			exit;
		}
		$branch = $this->my_albums->get_branch($album_id,$this->my_auth->user_id,$lang_main,$language);
		if($branch){
			$response['content'] = $branch;
			echo json_encode($response);
			exit;
		}
		else{
			$response['content'] = $language['NO_FILES'];
			echo json_encode($response);
			exit;
		}
	}
	
	function create_album_net(){
		$uriSegments = $this->uri->segment_array();
		$local_album = $uriSegments[count($uriSegments)];

		if($uriSegments[2] == 'vk'){
			$this->load->model('socialnet/vk');
			if($this->vk->owner_id != $this->input->post('owner_id'))
				exit;

			$res = $this->vk->create_album();
			if($res){
				$response['answer'] = 1;
			}
			else{
				$response['answer'] = 0;
			}
			echo json_encode($response);
			exit;
		}
	}
	
	function album_settings(){
		
		$uriSegments = $this->uri->segment_array();
		Language::load_language('albums');
		$language = Language::get_languages('albums');
		Language::load_language('sync');
		$lang_sync = Language::get_languages('sync');
		if($uriSegments[count($uriSegments)] == 'reverse')
			$is_reverse = 1;
		else
			$is_reverse = 0;
		if($uriSegments[2] == 'net'){
			if(count($uriSegments) < 4)
				return false;
			if($uriSegments[3] == 'vk')	{
				$this->load->model('socialnet/vk');
				if($is_reverse)
					$settings = $this->my_albums->get_album_by_id($uriSegments[4],$this->members->user_id);
				else
					$settings = $this->vk->get_album_by_id($uriSegments[4]);
				if(empty($settings['owner_id']))
					$settings['owner_id'] = $this->vk->owner_id;
				$lang_sync['CREATE_ALBUM_NET'] = str_replace('%net%',$this->net_names['vk'],$lang_sync['CREATE_ALBUM_NET']);
				$lang_sync['ERROR_CREATE_ALBUM'] = str_replace('%net%',$this->net_names['vk'],$lang_sync['ERROR_CREATE_ALBUM']);
				$settings['access'] = 'private';
			}
			elseif($uriSegments[3] == 'fb'){
				$this->load->model('socialnet/fb');
				$settings = $this->fb->get_album_by_id($uriSegments[4]);
				$settings['access'] = 'private';
			}
			elseif($uriSegments[3] == 'ok'){
				$this->load->model('socialnet/ok');
				$settings = $this->ok->get_album_by_id($uriSegments[4]);
				$settings['access'] = 'private';
			}
			elseif($uriSegments[3] == 'pic'){
				$this->load->model('socialnet/pic');
				$settings = $this->pic->get_album_by_id($uriSegments[4]);
				$settings['access'] = 'private';
			}		
			$data = array(
			'language' => $language,
			'lang_sync' => $lang_sync,
			'settings' => $settings,
			'is_net' => 1,
			'action' => '/sync/'.$uriSegments[3].'/photos/'.$settings['owner_id'].'/'.$settings['id']
			);
			if($is_reverse)
				$response['content'] = $this->get_widget('edit_album_net',$data);
			else
				$response['content'] = $this->get_widget('edit_album',$data);
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		$album_id = $uriSegments[3];

		$lang_main = Language::get_languages('main');
		if(!$album_id){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		if(isset($_POST['is_update'])){
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$access = $this->input->post('access');
			if(isset($_POST['password'])){
				$password = md5($_POST['password']);
			}
			else{
				$password = null;
			}
			$data = array(
			'name' => $name,
			'description' => $description,
			'access' => $access
			);
			if($password || (!$password && $access != 'protected'))
				$data['password'] = $password;

			$this->db->where('id',$album_id);
			$this->db->where('user_id',$this->my_auth->user_id);
			$res = $this->db->update($this->my_albums->tablename,$data);
			if($res){	
			$this->my_albums->update_file_access($album_id,$access);
			$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();
			if($arr_albums){
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr,$lang_main);
				
			}
			else{
				$tree = $language['NO_FOLDERS'];
			}
			$tree = $this->get_widget('albums_tree',array('tree' => $tree));
			$response['content'] = $tree;
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
			}
		}
		$settings = $this->my_albums->get_album_by_id($album_id,$this->my_auth->user_id);
		if($settings){
			$data = array(
			'language' => $language,
			'settings' => $settings
			);
			$response['content'] = $this->get_widget('edit_album',$data);
			$response['answer'] = 1;
			echo json_encode($response);
			exit;
		}
		else{
			$response['content'] = $language['NO_FILES'];
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
	}
	
	function torrent_delete(){
		
		Language::load_language('albums');
		$language = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		$uriSegments = $this->uri->segment_array();
		if(!$uriSegments[3])
			exit;
		$torrent_id = $uriSegments[3];
		if(!$this->members->seedoff_token)
			exit;
		if(!$this->seedoff_sync->is_owner_torrent_id($torrent_id,$this->members->seedoff_token))
			exit;
		
		$res = $this->seedoff_sync->delete_images_by_torrent_id($torrent_id,$this->members->seedoff_token);
		if($res){
			$response['answer'] = 1;
			$response['num_folders'] = $this->my_files->count_albums + $this->seedoff_sync->count_torrents_by_token($this->members->seedoff_token);
			$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();
			if($arr_albums){
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr,$lang_main);
				
			}
			else{
				$tree = $lang_albums['NO_FOLDERS'];
			}
			$tree = $this->get_widget('albums_tree',array('tree' => $tree));
			$response['content'] = $tree;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			$response['content'] = $language['ALBUM_ERROR'];
			echo json_encode($response);
			exit;
		}
	}
	
	
	function album_delete(){
		
		Language::load_language('albums');
		$language = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		$uriSegments = $this->uri->segment_array();
		if(!$uriSegments[3])
			exit;
		$res = $this->my_albums->delete_album_by_id($uriSegments[3],$this->my_auth->user_id);
		if($res){
			$response['answer'] = 1;
			$response['num_folders'] = $this->my_files->count_albums_by_userid($this->my_auth->user_id);
			$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();
			if($arr_albums){
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr,$lang_main);
				
			}
			else{
				$tree = $lang_albums['NO_FOLDERS'];
			}
			$tree = $this->get_widget('albums_tree',array('tree' => $tree));
			$response['content'] = $tree;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			$response['content'] = $language['ALBUM_ERROR'];
			echo json_encode($response);
			exit;
		}

	}
	
	function album_add(){
		
		Language::load_language('albums');
		$lang_albums = Language::get_languages('albums');
		$language = Language::get_languages('main');
		$name = $this->input->post('name');
		$name = htmlspecialchars($name);
		$description = $this->input->post('description');
		$access = $this->input->post('access');
		if(!in_array($access,$this->my_albums->accesses))
			$access = 'public';
			
		if(!$name)
			exit;
			
		if(isset($_POST['password'])){
			$password = md5($_POST['password']);
		}
		else{
			$password = null;
		}
			
		$data = array(
		'id' => null,
		'name' => $name,
		'description' => $description,
		'added' => date('Y-m-d H:i:s'),
		'access' => $access,
		'user_id' => $this->my_auth->user_id,
		'password' => $password
		);
		
		$res = $this->db->insert($this->my_albums->tablename,$data);
		if($res){
			$response['answer'] = 1;
			$response['num_folders'] = $this->my_files->count_albums_by_userid($this->my_auth->user_id);
			$arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr = array();
			if($arr_albums){
				foreach($arr_albums as $album){
					$arr[$album['id']] = $album;
				}
				$tree = $this->my_albums->get_tree_albums($arr,$language);
				
			}
			else{
				$tree = $lang_albums['NO_FOLDERS'];
			}
			$tree = $this->get_widget('albums_tree',array('tree' => $tree));
			$response['content'] = $tree;
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			$response['content'] = '';
			echo json_encode($response);
			exit;
		}
		
	}
	
	function userdetails(){
		
		Language::load_language('imagelist');
		Language::load_language('profile');
		$uriSegments = $this->uri->segment_array();
		$this->per_page = 11;
		if(count($uriSegments) == 3)
			$cur_page = ($uriSegments[3] - 1) * $this->per_page;
		else
			$cur_page = 0;
		if(!$uriSegments[2])
			redirect(site_url(''));
		if($this->my_auth->role == 'guest')
			redirect(site_url(''));
		$uid = $uriSegments[2];
	if($this->dx_auth->is_admin())
		$this->my_files->admin_mode = true;
		$user = $this->users->get_user_by_id($uid);
		if($user->row()->access_role == 'admin' && !$this->my_files->admin_mode)
			redirect(site_url(''));
			
		$config['base_url'] = site_url('user/'.$uid);
			$config['total_rows'] = $this->my_files->count_files_by_userid($uid);
			$config['per_page'] = $this->per_page;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);
			$paginator = $this->pagination->create_links_modal();
			$buffer = $this->my_files->get_files_by_userid($uid,$cur_page,$this->per_page);
			foreach($buffer as $key=>$value){
				if($value['access'] == 'public')
					$buffer[$key]['access_text'] = $lang_albums['ALBUM_PUBLIC'];
				else
					$buffer[$key]['access_text'] = $lang_albums['ALBUM_PRIVATE'];
			}
			$lang_main = Language::get_languages('main');
			$lang_imagelist = Language::get_languages('imagelist');
			$lang_upload = Language::get_languages('upload');
			$lang_profile = Language::get_languages('profile');
			$this->site_title = $lang_profile['PROFILE'].' '.$user->row()->username;

			$user_avatar = $user->row()->avatar;
			if($user_avatar && file_exists(ImageHelper::url_to_realpath($user_avatar)))
				$avatar = $user_avatar;
			else
				$avatar = $this->theme_path.'/'.$this->my_upload->default_avatar;
			$data_profile = array(
			'user' => $user->row_array(),
			'THEME' => $this->theme_path.'/',
			'language' => $lang_profile,
			'avatar_src' => $avatar,
			'num_images' => $this->my_files->count_images,
			'num_albums' => $this->my_files->count_albums
			);
			if($this->dx_auth->is_admin())
				$data_profile['is_admin'] = 1;
			$profile = $this->get_widget('profile_public', $data_profile);
			$data = array(
			'language' => $lang_imagelist,
			'lang_main' => $lang_main,
			'lang_upload' => $lang_upload,
			'paginator' => $paginator,
			'files' => $buffer,
			'THEME' => $this->theme_path.'/',
			'message_confirm_delete' => $lang_imagelist['CONFIRM_DELETE'],
			'is_guest' => 0,
			'user' => $user->result_array()
			);
			if($this->dx_auth->is_admin())
				$data['is_admin'] = 1;
			
			$image_list = $this->get_widget('image_list_public',$data);
			if(isset($_POST['is_ajax'])){
				if(count($buffer) > 0)
					$response['answer'] = 1;
				else
					$response['answer'] = 0;
				$response['content'] = $image_list;
				$response['title'] = $this->site_title;
				echo json_encode($response);
				exit;
			}
			
			$this->template->assign('content',$this->get_page('profile',array('image_list' => $image_list, 'role' => 'user', 'profile' => $profile)));
			$this->template->assign('with_main_banner',0);
			$this->template->assign('with_lightbox',1);
			
			$this->display_layout();

	}
	
	function delete_favourite(){
		
		$uriSegments = $this->uri->segment_array();
		Language::load_language('image');
		$language = Language::get_languages('image');
		$type = $uriSegments[2];
		$image_id = $uriSegments[3];
		if(!$image_id){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		if($this->my_files->delete_favourite($type,$image_id)){
			$response['answer'] = 1;
			$response['content'] = '<a href="'.site_url('favourite').'/'.$type.'/'.$image_id.'" onclick="set_favourite(this);return false;">'.$language['FAVORITES'].'</a>';
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		
	}
	
	function add_favourite(){
		
		$uriSegments = $this->uri->segment_array();
		Language::load_language('image');
		$language = Language::get_languages('image');
		$type = $uriSegments[2];
		$image_id = $uriSegments[3];
		if(!$image_id){
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}
		if($this->my_files->add_favourite($type,$image_id)){
			$response['answer'] = 1;
			$response['content'] = '<a href="'.site_url('remove_favourite').'/'.$type.'/'.$image_id.'" onclick="set_favourite(this);return false;">'.$language['DELETE_FROM_FAVORITES'].'</a>';
			echo json_encode($response);
			exit;
		}
		else{
			$response['answer'] = 0;
			echo json_encode($response);
			exit;
		}

	}
	
	
	function profile_statistic(){
		
		Language::load_language('image');
		Language::load_language('poll');
		Language::load_language('profile');
		$lang_image = Language::get_languages('image');
		$lang_poll = Language::get_languages('poll');
		$lang_profile = Language::get_languages('profile');
		if($this->my_auth->role == 'guest')
			exit;
		$data = array(
		'num_images' => $this->my_files->count_images,
		'num_albums' => $this->my_files->count_albums,
		'num_views' => $this->statistic->get_num_views_by_user_id($this->my_auth->user_id),
		'avg_rating' => $this->statistic->get_avg_rating_by_user_id($this->my_auth->user_id),
		'lang_image' => $lang_image,
		'lang_poll' => $lang_poll,
		'lang_profile' => $lang_profile
		);
		$response['content'] = $this->get_widget('detailed_statistic',$data);
		$response['title'] = $lang_profile['STAT'];
		echo json_encode($response);
		exit;
	}
	
	function upload_templates(){
		
		$language = Language::get_languages('upload');
		$lang_main = Language::get_languages('main');
		$lang_albums = Language::get_languages('albums');
		$uriSegments = $this->uri->segment_array();
		if(count($this->guests->usertokeninfo) > 0)
			$user_id = $this->guests->usertokeninfo['id'];
		else
			$user_id = $this->my_auth->user_id;
		if(count($uriSegments) >= 4){
			if($uriSegments[4] == 'add' || $uriSegments[4] == 'edit'){
				
				if($uriSegments[4] == 'edit' && $uriSegments[5])
					$template = $this->my_upload->get_template_by_id($uriSegments[5]);
				$tags = $this->my_tags->get_main_tags();
				$options['0'] = $lang_main['ALL'];
				foreach($tags as $tag){
					$options[$tag['id']] = $tag['value'];
				}
				if(isset($template['TAGS']))
					$tags_box = form_dropdown('TAGS',$options,$template['TAGS'],'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="tags"');
				else
					$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="tags"');
				
				$buffer_arr_albums = $this->my_albums->get_albums_by_userid($user_id);
				$arr_albums = array('0' => '----');
				if($buffer_arr_albums){
					foreach($buffer_arr_albums as $album)
						$arr_albums[$album['id']] = $album['name'];
				}
			if($buffer_arr_albums){
				$albums_box = form_dropdown('ALBUMS',$arr_albums,0,'class="tags combobox" style="width:110px;" id="albums" onchange="block_access_fast(this);return false;"');
				
			}
			else{
				$albums_box = '';
			}
			
				$compression_jpeg_options = array();
				for($i = 100; $i > 45; $i = $i - 5){
					$compression_jpeg_options[$i] = $i;
				}
				if(isset($template['JPEG_QUALITY']))
					$compression_jpeg_box = form_dropdown('JPEG_QUALITY',$compression_jpeg_options,$template['JPEG_QUALITY'],'class="combobox" id="jpeg_quality"');
				else
					$compression_jpeg_box = form_dropdown('JPEG_QUALITY',$compression_jpeg_options,100,'class="combobox" id="jpeg_quality"');
				
				$data = array(
				'language' =>$language,
				'lang_albums' => $lang_albums,
				'THEME' => $this->theme_path.'/',
				'tags' => $tags_box,
				'albums' => $albums_box
				);
				if($uriSegments[4] == 'edit')
					$data['is_edit'] = 1;
				else
					$data['is_edit'] = 0;
				if($uriSegments[5])
					$data['template_id'] = $uriSegments[5];
				if(isset($template))
					$data['template'] = $template;
				if(ImageHelper::$enable_compression){
					$data['enable_compression'] = 1;
					$data['compression_jpeg_box'] = $compression_jpeg_box;
				}
				else{
					$data['enable_compression'] = 0;

				}
				if(isset($_REQUEST['torrent_id']) && isset($_REQUEST['token'])){
					$data['with_token'] = '?torrent_id='.$_REQUEST['torrent_id'].'&token='.$_REQUEST['token'];
				}
				else{
					$data['with_token'] = '';
				}
				
				$response['content'] = $this->get_widget('upload_add_template',$data);
				echo json_encode($response);
				exit;
			}	
			
			elseif($uriSegments[4] == 'set'){
				if(!$_POST['TEMPLATE_NAME']){
					$response['answer'] = 0;
					echo json_encode($response);
					exit;
				}

				if(empty($_POST['TEMPLATE_ID'])){
					if($this->my_upload->is_exists_template($_POST['TEMPLATE_NAME'],$user_id)){
					$response['answer'] = 0;
					$response['message'] = $language['EXISTS_TEMPLATE'];
					echo json_encode($response);
					exit;
					}
				}
				
				if(isset($_POST['TEMPLATE_ID']))
					$res = $this->my_upload->set_template($user_id,$_POST['TEMPLATE_ID']);
				else
					$res = $this->my_upload->set_template($user_id);
				if($res)
					$response['answer'] = 1;
				else
					$response['answer'] = 0;
				if($res){
					if(isset($_POST['from_upload']) && $_POST['from_upload']){
						$templates = $this->my_upload->list_templates($user_id,$lang_upload,true);
						$arr_templates = array('0' => '--------');
						foreach($templates as $item)
							$arr_templates[$item['id']] = $item['show_name'];
							$templates_box = form_dropdown('templates',$arr_templates,0,'style="width:110px;" id="list_templates" onchange="select_template(this);return false;" disabled');
							$response['content'] = $templates_box;
							
					}
					else{
						$templates = $this->my_upload->list_templates($user_id,$language);
						$data = array(
						'templates' => $templates,
						'language' =>$language,
						'lang_main' => $lang_main,
						'THEME' => $this->theme_path.'/',
						'type_show' => 'set'
						);
						
						$response['content'] = $this->get_widget('upload_settings',$data);
						$response['num'] = $this->my_upload->num_templates($user_id);
					}
					

				}
				echo json_encode($response);
				exit;
			}
			
		elseif($uriSegments[4] == 'delete'){
			if(empty($uriSegments[5]) || !$uriSegments[5]){
				$response['answer'] = 0;
				echo json_encode($response);
				exit;
			}
			$res = $this->my_upload->delete_template($uriSegments[5],$user_id);
			if($res)
				$response['answer'] = 1;
			else
				$response['answer'] = 0;
			$response['num'] = $this->my_upload->num_templates($user_id);
			echo json_encode($response);
			exit;
		}
		}
		else{
			$templates = $this->my_upload->list_templates($user_id,$language);
			$data = array(
			'templates' => $templates,
			'language' =>$language,
			'lang_main' => $lang_main,
			'THEME' => $this->theme_path.'/',
			'type_show' => 'list'
			);
			$response['content'] = $this->get_widget('upload_settings',$data);
			echo json_encode($response);
			exit;
		}
		
	}
	
	function profile(){
		
		Language::load_language('imagelist');
		Language::load_language('profile');
		$lang_upload = Language::get_languages('upload');
		$lang_auth = Language::get_languages('auth');
		$lang_albums = Language::get_languages('albums');
		$lang_main = Language::get_languages('main');
		$lang_imagelist = Language::get_languages('imagelist');
		$uriSegments = $this->uri->segment_array();
		if(isset($_POST['is_ajax']) && isset($_POST['search_pictures'])){
			$tags = $this->my_tags->get_main_tags();
			$options['0'] = $lang_main['ALL'];
			foreach($tags as $tag){
				$options[$tag['id']] = $tag['value'];
			}
			if(isset($template['TAGS']))
				$tags_box = form_dropdown('TAGS',$options,$template['TAGS'],'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="tags"');
			else
				$tags_box = form_dropdown('TAGS',$options,0,'class="tags combobox" onchange="get_categories(this);" style="width:110px;" id="tags"');
			if($this->my_auth->role == 'guest')
				$buffer_arr_albums = $this->seedoff_sync->get_torrents_by_key($this->guests->key);
			else
				$buffer_arr_albums = $this->my_albums->get_albums_by_userid($this->my_auth->user_id);
			$arr_albums['type-0'] = '----';
			if($buffer_arr_albums){
				$albums_box = '<select id="albums" class="tags combobox" style="width:110px;" name="ALBUMS">';
				$albums_box .= '<option value="0" selected>----</option>';
				foreach($buffer_arr_albums as $album)
					$albums_box .= '<option value="'.$album['type'].'/'.$album['id'].'">'.$album['name'].'</option>';
				$albums_box .= '</select>';
	
			}
			else{
				$albums_box = '';
			}
				
			$response['content'] = $this->get_widget('search_images', array('lang_main' => $lang_main, 'language' => $lang_upload, 'lang_albums' => $lang_albums, 'lang_auth' => $lang_auth, 'tags' => $tags_box, 'albums' => $albums_box));
			$response['title'] = $lang_imagelist['SEARCH_BY_IMAGES'];
			echo json_encode($response);
			exit;
		}
		
		///////////////////////////////////// Ветка для получения последнего и первого элемента на следующей или предыдущей странице профиля
		if(isset($uriSegments[3]) && ($uriSegments[3] == 'first_element' || $uriSegments[3] == 'last_element')){
			if($uriSegments[3] == 'first_element'){
			$cur_page = ($uriSegments[2] - 1) * $this->per_page;
			if($this->members->seedoff_token)
				$buffer = $this->my_files->get_files_by_userid($this->members->user_id,$cur_page,1,$this->members->seedoff_token);
			else
				$buffer = $this->my_files->get_files_by_userid($this->members->user_id,$cur_page,1);
			}
			else{
				$cur_page = ($uriSegments[2] - 1) * $this->per_page + ($this->per_page - 1);
				if($this->members->seedoff_token)
					$buffer = $this->my_files->get_files_by_userid($this->members->user_id,$cur_page,1,$this->members->seedoff_token);
				else
					$buffer = $this->my_files->get_files_by_userid($this->members->user_id,$cur_page,1);

			}
			
		}
		$this->per_page = 15;
		if(count($uriSegments) == 2)
			$cur_page = ($uriSegments[2] - 1) * $this->per_page;
		else
			$cur_page = 0;
			

		if($this->my_auth->role == 'guest' && $this->guests->key){
			if(!$this->my_files->count_images)
				redirect(site_url(''));
				
			$config['base_url'] = site_url('profile');
			if(isset($_REQUEST['IS_SEARCH']))
				$config['total_rows'] = $this->my_files->count_files_by_key($this->guests->key);
			else
				$config['total_rows'] = $this->my_files->count_images;
			$config['per_page'] = $this->per_page;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 2;
			$config['query_string'] = '';
			
			
			if(isset($_REQUEST['order'])){
				if(!$config['query_string'])
					$config['query_string'] .= '?order='.$_REQUEST['order'];
				else
					$config['query_string'] .= 'order='.$_REQUEST['order'];

			}
			
			$this->pagination->initialize($config);
			
			$paginator = $this->pagination->create_links_modal();
			$buffer = $this->my_files->get_files_by_key($this->guests->key,$cur_page,$this->per_page);

			foreach($buffer as $key=>$value){
				if($value['access'] == 'public')
					$buffer[$key]['access_text'] = $lang_albums['ALBUM_PUBLIC'];
				else
					$buffer[$key]['access_text'] = $lang_albums['ALBUM_PRIVATE'];
			}
			
			$this->site_title = $lang_imagelist['MY_UPLOADS'];
			$data = array(
			'language' => $lang_imagelist,
			'lang_upload' => $lang_upload,
			'lang_main' => $lang_main,
			'paginator' => $paginator,
			'files' => $buffer,
			'THEME' => $this->theme_path.'/',
			'guest_key' => $this->guests->key,
			'message_confirm_delete' => $lang_imagelist['CONFIRM_DELETE'],
			'is_guest' => 1,
			'transit_parameters' => $this->my_files->transit_parameters()
			);
			
			if($cur_page)
				$data['order_link'] = '/profile/'.$cur_page;
			else
				$data['order_link'] = '/profile';

			
			$image_list = $this->get_widget('image_list',$data);
			if(isset($_POST['is_ajax'])){
				if(count($buffer) > 0)
					$response['answer'] = 1;
				else
					$response['answer'] = 0;
				$response['content'] = $image_list;
				$response['title'] = $this->site_title;
				echo json_encode($response);
				exit;
			}
			
			$this->template->assign('content',$this->get_page('profile',array('image_list' => $image_list, 'role' => 'guest')));
			$this->template->assign('with_main_banner',0);
			$this->template->assign('with_lightbox',1);


		}
		else{
			
			$config['base_url'] = site_url('profile');
			if(isset($_REQUEST['IS_SEARCH']))
				$config['total_rows'] = $this->my_files->count_files_by_userid($this->members->user_id);
			else
				$config['total_rows'] = $this->my_files->count_images;
			$config['per_page'] = $this->per_page;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 2;
			$config['query_string'] = '';
			
			
			if(isset($_REQUEST['order'])){
				if(!$config['query_string'])
					$config['query_string'] .= '?order='.$_REQUEST['order'];
				else
					$config['query_string'] .= 'order='.$_REQUEST['order'];

			}
			
			$this->pagination->initialize($config);
			$paginator = $this->pagination->create_links_modal();
			if($this->members->seedoff_token)
				$buffer = $this->my_files->get_files_by_userid($this->members->user_id,$cur_page,$this->per_page,$this->members->seedoff_token);
			else
				$buffer = $this->my_files->get_files_by_userid($this->members->user_id,$cur_page,$this->per_page);

			foreach($buffer as $key=>$value){
				if($value['access'] == 'public')
					$buffer[$key]['access_text'] = $lang_albums['ALBUM_PUBLIC'];
				else
					$buffer[$key]['access_text'] = $lang_albums['ALBUM_PRIVATE'];
			}
			$lang_main = Language::get_languages('main');
			$lang_imagelist = Language::get_languages('imagelist');
			$lang_profile = Language::get_languages('profile');
			$user = $this->users->get_user_by_id($this->members->user_id);
			$this->site_title = $lang_profile['YOUR_PROFILE'];
		
			$user_avatar = $user->row()->avatar;
			
			if($user_avatar && file_exists(ImageHelper::url_to_realpath($user_avatar)))
				$avatar = IMGURL.$user_avatar;
			else
				$avatar = $this->theme_path.'/'.$this->my_upload->default_avatar;
			
			$data_profile = array(
			'user' => $user->row_array(),
			'THEME' => $this->theme_path.'/',
			'language' => $lang_profile,
			'lang_main' =>$lang_main,
			'lang_auth' =>$lang_auth,
			'avatar_src' => $avatar,
			'num_images' => $this->my_files->count_images,
			'num_albums' => $this->my_files->count_albums,
			'favourites_images' => $this->my_files->get_num_favourite_by_user_id($this->my_auth->user_id,'image'),
			'favourites_albums' => $this->my_files->get_num_favourite_by_user_id($this->my_auth->user_id,'album'),
			'num_templates' => $this->my_upload->num_templates($this->my_auth->user_id)
			);
			$profile = $this->get_widget('profile', $data_profile);
			$data = array(
			'language' => $lang_imagelist,
			'lang_main' => $lang_main,
			'lang_upload' => $lang_upload,
			'paginator' => $paginator,
			'files' => $buffer,
			'THEME' => $this->theme_path.'/',
			'message_confirm_delete' => $lang_imagelist['CONFIRM_DELETE'],
			'is_guest' => 0,
			'user' => $user->row_array(),
			'transit_parameters' => $this->my_files->transit_parameters()
			);
			
			$image_list = $this->get_widget('image_list',$data);
			if(isset($_POST['is_ajax'])){
				if(isset($_POST['IS_SEARCH'])){
					$response['answer'] = 1;
				}
				else{
					if(count($buffer) > 0)
						$response['answer'] = 1;
					else
						$response['answer'] = 0;
				}
				
				$response['content'] = $image_list;
				$response['title'] = $this->site_title;
				echo json_encode($response);
				exit;
			}
			
			$this->template->assign('content',$this->get_page('profile',array('image_list' => $image_list, 'role' => 'user', 'profile' => $profile)));
			$this->template->assign('with_main_banner',0);
			$this->template->assign('with_lightbox',1);
		}
		
		$this->display_layout();

	}
	
	function set_avatar(){
		$response = array();
		$this->my_upload->set_avatar($response);
		echo json_encode($response);
		exit;
	}
	
	function capture(){
		
		$language = Language::get_languages('upload');

		$this->layout = 'canvas';
		$data = array('language' => $language);
		$this->template->assign('content',$this->get_widget('upload_screenshot',$data));
		$this->template->assign('with_main_banner',1);
		
		$this->display_layout();
	}
	
	function upload(){

		$uri_segemnts = $this->uri->segment_array();
		$this->load->model('bitly');
		$response = array();
		Language::load_language('imagelist');
		$language = Language::get_languages('upload');
		$lang_albums = Language::get_languages('albums');
		$lang_image = Language::get_languages('imagelist');
		$lang_main = Language::get_languages('main');
		if($this->my_auth->role != 'guest'){
			$user = $this->users->get_user_by_id($this->my_auth->user_id);
			$user_profile = $user->row_array();
		}
		else{
			if(isset($_REQUEST['token'])){
				$user_profile = $this->my_auth->get_user_by_token($_REQUEST['token']);
				if(!$user_profile)
					unset($user_profile);
			}
			
		}
		
		if($uri_segemnts[2] == 'fast'){
			$this->my_upload->fast($response);
			if($response['error'] && empty($response['imglink'])){
				echo json_encode($response);
				exit;
			}
			$imglink_preview = str_replace('big','preview',$response['imglink']);
				
			
			$imglink_preview_html = htmlspecialchars('<a href="'.$response['imglink_html'].'" target="_blank"><img src="'.$imglink_preview.'" border="0" /></a>');
			$imglink_preview_bb = '[URL='.$response['imglink_html'].'][IMG]'.$imglink_preview.'[/IMG][/URL]';
			
			
			$file = array(
			'imglink' => $response['imglink'],
			'imglink_preview' => $imglink_preview,
			'imglink_preview_html' => $imglink_preview_html,
			'imglink_preview_bb' => $imglink_preview_bb,
			'imglink_html' => $response['imglink_html'],
			'url' => $response['imglink'],
			'id' => $response['id']
			);
			
			$data = array(
			'imglink' => $response['imglink'],
			'imglink_preview' => $imglink_preview,
			'imglink_preview_html' => $imglink_preview_html,
			'imglink_preview_bb' => $imglink_preview_bb,
			'imglink_html' => $response['imglink_html']
			);
			
			$data['file'] = $file;
			
			if(isset($user_profile) && $user_profile['tiny_static'])
				$data['tiny_static'] = 1;
			else
				$data['tiny_static'] = 0;

			
			if($response['tiny_url'])
				$data['tiny_url'] = $response['tiny_url'];
			if(isset($response['language']))
				$data['language'] = $response['language'];
			$response['content'] = $this->get_widget('upload_fast_success',$data);
			if(isset($response['language']))
				unset($response['language']);
			echo json_encode($response);
		}
		elseif($uri_segemnts[2] == 'multiple'){
			
			$this->my_upload->multiple($response);
			if(isset($user_profile) && $user_profile['tiny_static']){
				if(isset($response[0]))
					$response[0]['tiny_static'] = 1;
				else
					$response['tiny_static'] = 1;

			}
			else{
				$response['tiny_static'] = 0;

			}
			
			$files['files'][0] = $response;
			$files['form_number'] = 'upload-multi-links';
//			$files['files'][0]['links'] = block_links($response,$language,$response['tiny_static']);
			if(isset($response['language']))
				$language = $response['language'];
			unset($response['language']);
			if(isset($response[0])){
				unset($response['error']);
				unset($response['success']);
				if($this->my_upload->upload_by_one){
					$files['wrapper'] = $this->get_widget('upload_multiple_internet_wrapper', array('language' => $language));
					$data_content = array(
					'language' => $language,
					'file' => $response[0],
					'lang_main' => $lang_main,
					'lang_image' => $lang_image,
					'tiny_static' => $response[0]['tiny_static']
					);
					$files['content'] = $this->get_widget('upload_multiple_internet_by_one', $data_content);

				}
				else{
					$files['content'] = $this->get_widget('upload_multiple_internet_success',array('files' => $response, 'language' => $language, 'tiny_static' => $response['tiny_static']));
				}
			}
			echo json_encode($files);
		}
		
		elseif($uri_segemnts[2] == 'api'){
			
			$this->my_upload->api($response);

			$urls = serialize($response['imglink']);
			echo $urls;
		}
		elseif($uri_segemnts[2] == 'capture'){
			
			$this->my_upload->capture($response);
			if($response['image']){
				echo $response['image'];
				exit;
			}
		}
		elseif($uri_segemnts[2] == 'apply_template'){
			if(count($this->guests->usertokeninfo) > 0)
				$user_id = $this->guests->usertokeninfo['id'];
			else
				$user_id = $this->my_auth->user_id;
			$buffer = $this->my_upload->get_template($user_id,$uri_segemnts[3]);
			$options = $this->my_upload->get_template_options($user_id,$uri_segemnts[3],$language,true);
			$content = $this->get_widget('template_options',array('options' => $options, 'language' => $language, 'lang_albums' => $lang_albums));
			if($buffer){
				$temp = unserialize($buffer['options']);
				$temp2 = array('answer' => 1, 'content' => $content);
				$response = array_merge($temp,$temp2);
			}
			else{
				$response['answer'] = 0;

			}
				$json = json_encode($response);
				echo $json;
				exit;
			
		}
	}
	
	
//	function get_links
	
	
}

?>