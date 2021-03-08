<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */

/**
 * @property Core $core
 * @property CI_DB_active_record $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      Provides a mechanism to extend the base system without hacking.
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Model $model                      CodeIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Sha1 $sha1                        Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Validation $validation            //dead
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 * @property DX_Auth $dx_auth                     I know about dx_auth and don't need to write abouth them
 * @property Lib_csrf $lib_csrf
 * @property Template $template Description
 * @property Console $console Description
 * @property CI_DB_Cache $cache
 */
class MY_Controller extends MX_Controller {

    public $pjaxRequest = false;
    public $ajaxRequest = false;
	public $settings = array(); // Site settings
	public $iframe_width = 800;
	public $branding_mode = 0;

    public static $currentLocale = null;
    public static $detect_load_admin = array();
    public static $detect_load = array();
	public $layout = 'main.tpl';
	public $theme_path;
	protected $site_title;
	protected $site_keywords;
	protected $site_description;
	protected $period_sync = 600;
	protected $module_name;
	public $net_names = array(
	'vk' => 'Vkontakte',
	'fb' => 'Facebook',
	'ok' => 'Однооклассники',
	'pic' => 'Google+'
	);

    public function __construct() {
        parent::__construct();
		$this->set_domain();
		$uriSegments = $this->uri->segment_array();
		$this->config->load('trusted');
		
        if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == true) {
            $this->pjaxRequest = true;
            header('X-PJAX: true');
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            $this->ajaxRequest = true;
        defined('SHOP_INSTALLED') OR define('SHOP_INSTALLED', $this->checkForShop());
		$this->settings = $this->cms_base->get_settings();

		if($uriSegments[1] == 'admin')
			return;
		$this->load->model('my_files');
		$this->load->library('DX_Auth');
		$this->setUserRole();
		$this->load->model('my_albums');
		$this->load->model('socialnet');
		$this->load->model('seedoff_sync');
		$this->load->model('statistic');
		$this->load->model('advert');
		$this->load->library('template');
		$this->load->helper('image');
		$this->load->helper('time');
		if(isset($_POST['is_gallery_history'])){
			return;
		}
		$ci = get_instance();
		$charset = $ci->config->item('charset');
		mb_internal_encoding($charset);
		Language::load_language('main');
		Language::load_language('auth');
		Language::load_language('upload');
		Language::load_language('statistic');
		Language::load_language('advert');

    }
	
	protected function set_domain(){
		$sp = $_SERVER['SERVER_PORT']; $ss = $_SERVER['HTTPS']; if ( $sp =='443' || $ss == 'on' || $ss == '1') $p = 's';
		$domain = 'http'.$p.'://'.$_SERVER['HTTP_HOST'];
		$uriSegments = $this->uri->segment_array();


		if(stristr($_SERVER['HTTP_HOST'],'www.') != ''){
			if(count($uriSegments) >= 1)
				$action = implode('/',$uriSegments);
			else
				$action = '';
			$domain = str_replace('index.php/', '', $domain);
			$domain = str_replace('www.','',$domain);
			$domain .= '/'.$action;
			if($_SERVER['QUERY_STRING'])
				$domain .= '?'.$_SERVER['QUERY_STRING'];
			redirect($domain,'location',301);

		}
		
	}
	
	protected function error_404(){
		$language = Language::get_languages('main');
		$content = $this->get_page('404',array('error_text' => $language['ERROR_404']));
		header('HTTP/1.1 404 Not Found');
		return $content;
	}
	
	protected function fb_init($language){
		if(!$this->config->item('is_work'))
			return '';
		$data = array(
		'api_id' => $this->fb->api_id,
		'language' => $language
		);
		return $this->get_block('fb_init',$data);
	}
	
	protected function vk_sync(){
		if(!$this->members->vk_profile)
			return false;
		if(!$this->vk->owner_id)
			return false;
		if(!$this->config->item('is_work'))
			return false;
		////////////////////////////////// Обновляем инфу с контакта ///////////////////////////////
		if($this->vk->sync_to_local || $this->checkSync('vk')){
			$this->vk->set_current_user_albums();
			$album_ids = $this->vk->get_current_albums_ids();
			if($album_ids){
				foreach($album_ids as $album_id){
					$this->vk->set_current_photos($album_id);
				}
			}
			$_SESSION['sync']['vk'] = time();

		}

	}
	
	protected function profiler(){
		$this->output->enable_profiler(true);
		$sections = array(
    	'config'  => TRUE,
    	'queries' => TRUE,
		'benchmarks' => TRUE
    	);

		$this->output->set_profiler_sections($sections);
	}
	
	protected function accessDenied($type,$language,$parameters){
		if($type == 'private'){
			if(isset($parameters['type']) && $parameters['type'] == 'image')
				$this->template->assign('msg',$language['ACCESS_IMAGE_DENIED_PRIVATE']);
			else
				$this->template->assign('msg',$language['ACCESS_DENIED_PRIVATE']);
			
			$this->template->assign('msg_title',$language['ACCESS_DENIED']);
			$this->template->assign('type','private');

		}
		elseif($type == 'protected'){
			$lang_auth = Language::get_languages('auth');
			$language = array_merge($language,$lang_auth);
			$data = array(
			'language' => $language
			);
			if(isset($parameters['album_id'])){
				$data['album_id'] = $parameters['album_id'];
				$buffer_msg = $language['ACCESS_DENIED_PROTECTED'];
				$data['msg'] = str_replace('%album%',$parameters['album_name'],$buffer_msg);
				$this->template->assign('content',$this->get_widget('enter_form',$data));
				$this->template->assign('msg_title',$language['ACCESS_DENIED']);
				$this->template->assign('type','protected');

			}
		}
		
			$this->layout = 'msg.tpl';
			$this->display_layout();
			exit;

	}
	
	protected function beforeFilter(){
		
		$this->theme_path = '/templates/' . $this->settings['site_template'];
		$this->template->assign('THEME',$this->theme_path.'/');
		$this->template->assign('site_title','IMGHost.pro');
		if(DIRECTORY_SEPARATOR != '/')
			ImageHelper::$theme = str_replace('/',DIRECTORY_SEPARATOR,$this->theme_path);
		else
			ImageHelper::$theme = $this->theme_path;
		$lang_main = Language::get_languages('main');
		$this->template->assign('lang_main',$lang_main);
		$uriSegments = $this->uri->segment_array();
		$this->my_files->use_main_table_mode = $this->seedoff_sync->set_use_main_table_mode();
//		$this->statistic->init();
		$this->set_branding();
		if($this->my_files->use_main_table_mode == 2)
			$this->seedoff_sync->images_table = $this->seedoff_sync->dbase.'.new_image_screens';
		if(extension_loaded('imagick'))
			ImageHelper::$enable_compression = true;
		if($this->my_auth->role != 'guest')
			ImageHelper::$max_number_of_files = $this->my_upload->multiple_user_fields_count;
		else
			ImageHelper::$max_number_of_files = 20;

		if($uriSegments[1] == 'seedoff_upload' || $uriSegments[1] == 'seedoff_edit'){
			$max_number_of_files = ImageHelper::$max_number_of_files_iframe;
		}
		else{
			$max_number_of_files = ImageHelper::$max_number_of_files;

		}
		if($uriSegments[1] == 'antiaddblock')
			$this->template->assign('with_main_banner',0);
		else
			$this->template->assign('with_main_banner',1);

		
		if(isset($_REQUEST['from_edit_fast']) || $uriSegments[1] == 'seedoff_edit')
			$this->template->assign('from_edit_fast',1);
		else
			$this->template->assign('from_edit_fast',0);
			
		if($uriSegments[1] == 'seedoff_edit')
			$this->template->assign('is_cover',1);
			
		if(!$max_number_of_files)
			$max_number_of_files = 20;
		
		$this->template->assign('max_number_of_files',$max_number_of_files);
		if($this->my_upload->upload_by_one)
			$this->template->assign('upload_by_one',1);	
		else
			$this->template->assign('upload_by_one',0);	

		if(isset($_REQUEST['display']) && $_REQUEST['display'] == 'table')
			$this->template->assign('display_torrent_edit','table');
		else
			$this->template->assign('display_torrent_edit','block');

		/////////////////////////////////////// Вписываем доступы сетей для синхронизации ///////////////////////
		$vk_id = $this->socialnet->get_api_id('vk');

		if(!$vk_id)
			$vk_id = $this->config->item('vk_id');
		if($this->config->item('is_work'))
			$this->template->assign('vk_init','VK.init({ apiId: '.$vk_id.' });');
		else
			$this->template->assign('vk_init','');

		if(empty($_POST['is_ajax']))
			$this->loadBlocks();
		if($this->my_auth->role == 'guest'){
			$this->my_files->count_images = $this->my_files->count_files_by_key($this->guests->key);
		}
		else{
			$this->my_files->count_images = $this->my_files->count_files_by_userid($this->members->user_id);
			$this->my_files->count_albums = $this->my_files->count_albums_by_userid($this->members->user_id);
		}
		if($this->guests->key &&  $this->my_files->count_images > 0){
			$link_images_list = 1;
		}
		else{
			$link_images_list = 0;
			
		}
		if(empty($_POST['is_ajax'])){
			$this->template->assign('link_images_list',$link_images_list);
		}
		$this->statistic->set_visit();
		$this->site_description = $this->settings['site_description'];
		$this->site_keywords = $this->settings['site_keywords'];
	
	}
	
	protected function set_branding(){
		
		if(isset($_REQUEST['branding'])){
			$this->layout = 'branding';
			$this->branding_mode = $_REQUEST['branding'];
			$this->template->assign('branding1',1);
		}
	}
	
	protected function checkSync($type){
		
		if(isset($_SESSION['sync'])){
			$syncs = $_SESSION['sync'];
			if(isset($syncs['vk']) && $syncs['vk'] < time()){
				return true;
			}
		}
		else{
			$_SESSION['sync'][$type] = time() + $this->period_sync;
			return true;
		}
		return false;
	}
	
	protected function setUserRole(){
			$this->load->model('my_auth');
			$this->load->model('dx_auth/users');
			$this->load->model('guests');
			$this->load->model('members');		
			if(isset($_SESSION['DX_role_name']) && isset($_SESSION['DX_role_id'])){
			$_SESSION['DX_role_name'] = $this->my_auth->roles[$_SESSION['DX_role_id']]['name'];
			}

		if($this->dx_auth->is_admin()){
			if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id'])){
				$this->my_auth->role = 'guest';
				$this->guests->init();
			}
			else{
				$this->my_auth->role = 'admin';
				if(!$this->ajaxRequest)
					$this->profiler();
				$this->my_auth->user_id = $this->dx_auth->get_user_id();
				$this->my_auth->login = $this->dx_auth->get_username();
				$this->members->init();
			}	

			return;
		}
		if(!$this->dx_auth->is_logged_in()){
				$this->my_auth->role = 'guest';
				$this->guests->init();

		}
		elseif($this->dx_auth->is_logged_in() && ($this->dx_auth->get_role_name() == 'user' || $this->dx_auth->get_role_name() == 'moderator')){
			if(isset($_REQUEST['token']) && isset($_REQUEST['torrent_id'])){
				$this->my_auth->role = 'guest';
				$this->guests->init();
			}
			else{
				$this->my_auth->role = 'user';
				$this->my_auth->login = $this->dx_auth->get_username();
				$this->my_auth->user_id = $this->dx_auth->get_user_id();
				$this->members->init();
			}
			
		}
		
	}
	
	protected function loadBlocks(){
		
		$lang_statistic = Language::get_languages('statistic');
		$lang_main = Language::get_languages('main');
		$lang_advert = Language::get_languages('advert');

		//////////////////////////////// Блок авторизации ////////////////////////////
		$data = array(
		'language' => Language::get_languages('auth')
		);

		if($this->my_auth->role != 'guest'){
			$data['is_authorized'] = 1;
			$data['login'] = $this->my_auth->login;
			if($this->members->user_avatar){
				if(strpos($this->members->user_avatar,'seedoff.net'))
					$data['avatar'] = $this->members->user_avatar;
				else
					$data['avatar'] = IMGURL.$this->members->user_avatar;

			}
		}
		if($this->my_auth->role == 'admin'){
			$data['is_admin'] = 1;
			$this->template->assign('is_admin',1);
		}
		$this->template->assign('auth',$this->get_block('auth',$data));
		
		/////////////////////////////// Подвал сайта ////////////////////////////////
		$data = array(
		'year' => date('Y'),
		'statistic' => $this->statistic->footer_statistic($lang_statistic),
		'lang_advert' => $lang_advert,
		'branding_mode' => $this->branding_mode
		);
		$this->template->assign('footer',$this->get_block('footer',$data));
			
		$this->template->assign('search',$this->get_block('search',array('lang_main' => $lang_main,'THEME' => $this->theme_path.'/')));
		$this->template->assign('advert_header',$this->advert->get_block('header'));
		$this->template->assign('advert_sidebar_left',$this->advert->get_block('sidebar_left'));
		
	}
	

    private function checkForShop() {
        if ($this->db) {
            $this->db->cache_on();
            $res = $this->db->where('identif', 'shop')
                    ->get('components')
                    ->result_array();
            $this->db->cache_off();

            return (bool) count($res);
        }
        else
            return false;
    }

    /**
     * get current locale
     * @return type
     */
    public static function getCurrentLocale() {

        if (self::$currentLocale)
            return self::$currentLocale;

        if (strstr($_SERVER['PATH_INFO'], 'install'))
            return;

        $ci = get_instance();
        $lang_id = $ci->config->item('cur_lang');

        if ($lang_id) {
            $query = $ci->db
                    ->query("SELECT `identif` FROM `languages` WHERE `id`=$lang_id")
                    ->result();
            if ($query) {
                self::$currentLocale = $query[0]->identif;
            } else {
                $defaultLanguage = self::getDefaultLanguage();
                self::$currentLocale = $defaultLanguage['identif'];
            }
        }
        else
            self::$currentLocale = chose_language();

        return self::$currentLocale;
    }

    public static function defaultLocale() {
        $lang = self::getDefaultLanguage();
        return $lang['identif'];
    }

    /**
     * Get default language
     */
    private function getDefaultLanguage() {
        $ci = get_instance();
        $languages = $ci->db
                ->where('default', 1)
                ->get('languages');

        if ($languages)
            $languages = $languages->row_array();

        return $languages;
    }

    /**
     * Admin Autoload empty method
     * @return boolean
     */
    public static function adminAutoload() {
        /** Must be an empty */
    }
	
	protected function get_page($file = '', $data = array(), $type_file = 'tpl'){
		$module = $file;
		if($type_file == 'tpl'){
			$file = SITE_DIR . DIRECTORY_SEPARATOR. 'templates' .DIRECTORY_SEPARATOR . $this->settings['site_template'] . DIRECTORY_SEPARATOR. 'pages'. DIRECTORY_SEPARATOR. $file.'.tpl';
			if(!file_exists($file))
				$file = SITE_DIR . DIRECTORY_SEPARATOR. 'application' .DIRECTORY_SEPARATOR . 'modules'.DIRECTORY_SEPARATOR.$module . DIRECTORY_SEPARATOR. 'templates'. DIRECTORY_SEPARATOR. $module.'.tpl';
			return $this->template->fetch('file:' . $file, $data);
		}
		else{
			return $this->load->view($file,$data,true);
		}
	}
	
	protected function get_widget($file = '', $data = array(),$type_file = 'tpl'){
		if($type_file == 'tpl'){
			
			$file = SITE_DIR . DIRECTORY_SEPARATOR. 'templates' .DIRECTORY_SEPARATOR . $this->settings['site_template'] . DIRECTORY_SEPARATOR. 'widgets'. DIRECTORY_SEPARATOR. $file.'.tpl';
			return $this->template->fetch('file:' . $file, $data);
		}
		else{
			return $this->load->view($file,$data,true);

		}
	}
	
	protected function get_template($file = '', $data = array()){
		$file = realpath(dirname(__FILE__)) . '/templates/public/' . $file . '.tpl';
		return $this->template->fetch('file:' . $file, $data);
	}
	
	protected function get_block($file = '', $data = array()){
		$file = SITE_DIR . DIRECTORY_SEPARATOR. 'templates' .DIRECTORY_SEPARATOR . $this->settings['site_template'] . DIRECTORY_SEPARATOR. 'blocks'. DIRECTORY_SEPARATOR. $file.'.tpl';
		return $this->template->fetch('file:' . $file, $data);
	}
	
	protected function display_layout($index=false){
		
		if($this->site_title){
			if($index)
				$this->template->assign('site_title',SITE_NAME.' '.$this->site_title);
			else
				$this->template->assign('site_title',$this->site_title);

		}
		else
			$this->template->assign('site_title',SITE_NAME);
		if($this->site_description)
			$this->template->assign('site_description',$this->site_description);
			
		if($this->site_keywords)
			$this->template->assign('site_keywords',$this->site_keywords);
				
		$file = SITE_DIR . DIRECTORY_SEPARATOR. 'templates' .DIRECTORY_SEPARATOR . $this->settings['site_template'] . DIRECTORY_SEPARATOR. 'layouts'. DIRECTORY_SEPARATOR. $this->layout;
		$this->template->display('file:' . $file);
	}
	
	protected function set_history_image_album($parameters,$album_id){
		
		$cur_page = $parameters['cur_page'];
		$next_page = $parameters['next_page'];
		$prev_page = $parameters['prev_page'];
		
		if($cur_page < 0)
			return false;
		$current_index = $parameters['current_index'];
			
		$images = $this->my_albums->get_files_history($this->per_page,$cur_page * $this->per_page,$album_id);
		$add = 1;
		if(count($images) < 1)
			return false;
		
		if($prev_page != $cur_page){
			$images_prev = $this->my_albums->get_files_history($this->per_page,$prev_page * $this->per_page,$album_id);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		if($next_page != $cur_page){
			$images_next = $this->my_albums->get_files_history($this->per_page,$next_page * $this->per_page,$album_id);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		
		if(empty($images_prev) && empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
			$next_link = $images[$current_index + $add]['main_url'];
			foreach($images as $key=>$value)
				$current_arr[$key] = $value['id'];
		}
		elseif(empty($images_prev) && !empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link = $images_next[0]['main_url'];

		}
		else{
			$prev_link = $images_prev[count($images_prev) - 1]['main_url'];
			$next_link = $images[$current_index + $add]['main_url'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
		}
		$_SESSION['current_index'] = $current_index;
		$_SESSION['prev_link'] = $prev_link;
		$_SESSION['next_link'] = $next_link;
		$_SESSION['current_page'] = $cur_page;
		$_SESSION['next_page'] = $next_page;
		$_SESSION['prev_page'] = $prev_page;
		
		return true;
	}
	
	protected function set_history_image($parameters,$url_parameters = array()){
		
		$cur_page = $parameters['cur_page'];
		$next_page = $parameters['next_page'];
		$prev_page = $parameters['prev_page'];
		
		if($cur_page < 0)
			return false;
		$current_index = $parameters['current_index'];
		
		if(isset($_SESSION['url_parameters'])){
			$url_parameters = $_SESSION['url_parameters'];
			if(isset($_SESSION['url_parameters']['tags']))
				$this->my_tags->children = $this->my_tags->get_by_parent_tag($_SESSION['url_parameters']['tags']);
		}
		else{
			$url_parameters = array();
		}
		
		$images = $this->my_files->get_files_history($this->per_page,$cur_page * $this->per_page,$url_parameters);
		$add = 1;
		if(count($images) < 1)
			return false;
		
		if($prev_page != $cur_page){
			$images_prev = $this->my_files->get_files_history($this->per_page,$prev_page * $this->per_page,$url_parameters);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		if($next_page != $cur_page){
			$images_next = $this->my_files->get_files_history($this->per_page,$next_page * $this->per_page,$url_parameters);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		
		if(empty($images_prev) && empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
			$next_link = $images[$current_index + $add]['main_url'];
			foreach($images as $key=>$value)
				$current_arr[$key] = $value['id'];
		}
		elseif(empty($images_prev) && !empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link = $images_next[0]['main_url'];

		}
		else{
			$prev_link = $images_prev[count($images_prev) - 1]['main_url'];
			$next_link = $images[$current_index + $add]['main_url'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
		}
		$_SESSION['current_index'] = $current_index;
		$_SESSION['prev_link'] = $prev_link;
		$_SESSION['next_link'] = $next_link;
		$_SESSION['current_page'] = $cur_page;
		$_SESSION['next_page'] = $next_page;
		$_SESSION['prev_page'] = $prev_page;
		
		return true;
	}
	
	protected function set_history_album($parameters,$album_id){
		
		if(isset($_SESSION['from_gallery_album'])){
			$prev_page = $parameters['prev_page'] - 1;
			$next_page = $parameters['next_page'] - 1;
		}
		else{
			$next_page = $parameters['next_page'];
			$prev_page = $parameters['prev_page'];
		}
		
		if(count($url_parameters) > 0){
			$_SESSION['url_parameters'] = $url_parameters;
		}
		$cur_page = $parameters['cur_page'];
		
		if($cur_page < 0)
			return false;
		$current_index = $parameters['current_index'];
		$images = $this->my_albums->get_files_history($this->per_page,$cur_page * $this->per_page,$album_id);
		$add = 1;
		if(count($images) < 1)
			return false;
		
		if($prev_page != $cur_page){
			$images_prev = $this->my_albums->get_files_history($this->per_page,$prev_page * $this->per_page,$album_id);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		if($next_page != $cur_page){
			$images_next = $this->my_albums->get_files_history($this->per_page,$next_page * $this->per_page,$album_id);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		if(empty($images_prev) && empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
			$next_link = $images[$current_index + $add]['main_url'];
			foreach($images as $key=>$value)
				$current_arr[$key] = $value['id'];
		}
		elseif(empty($images_prev) && !empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link = $images_next[0]['main_url'];

		}
		else{
			$prev_link = $images_prev[count($images_prev) - 1]['main_url'];
			$next_link = $images[$current_index + $add]['main_url'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
		}
		$_SESSION['current_index'] = $current_index;
		$_SESSION['prev_link'] = $prev_link;
		$_SESSION['next_link'] = $next_link;
		$_SESSION['current_page'] = $cur_page;
		$_SESSION['next_page'] = $next_page;
		$_SESSION['prev_page'] = $prev_page;
		$_SESSION['type_set'] = 'gallery';
		
		return true;
	}
	
	protected function admin_render($viewName, array $data = array(), $return = false) {
        if (!empty($data))
            $this->template->add_array($data);

        $this->template->show('file:' . 'application/modules/'.$this->module_name.'/views/admin/' . $viewName);
        exit;

        if ($return === false){
			 $this->template->show('file:' . 'application/modules/'.$this->module_name.'/views/admin/' . $viewName);

		}
        else{
			return $this->template->fetch('file:' . 'application/modules/'.$this->module_name.'/views/admin/' . $viewName);

		}
    }
	
	protected function set_history($parameters,$url_parameters = array()){
		
		if(isset($_SESSION['from_gallery'])){
			$prev_page = $parameters['prev_page'] - 1;
			$next_page = $parameters['next_page'] - 1;
		}
		else{
			$next_page = $parameters['next_page'];
			$prev_page = $parameters['prev_page'];
		}
		
		if(count($url_parameters) > 0){
			$_SESSION['url_parameters'] = $url_parameters;
		}
		$cur_page = $parameters['cur_page'];
		
		if($cur_page < 0)
			return false;
		$current_index = $parameters['current_index'];
		$images = $this->my_files->get_files_history($this->per_page,$cur_page * $this->per_page,$url_parameters);
		$add = 1;
		if(count($images) < 1)
			return false;
		
		if($prev_page != $cur_page){
			$images_prev = $this->my_files->get_files_history($this->per_page,$prev_page * $this->per_page,$url_parameters);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		if($next_page != $cur_page){
			$images_next = $this->my_files->get_files_history($this->per_page,$next_page * $this->per_page,$url_parameters);
			foreach($images_prev as $key=>$value)
				$prev_arr[$key] = $value['id'];
		}
		if(empty($images_prev) && empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
			$next_link = $images[$current_index + $add]['main_url'];
			foreach($images as $key=>$value)
				$current_arr[$key] = $value['id'];
		}
		elseif(empty($images_prev) && !empty($images_next)){
			$prev_link = $images[$current_index - $add]['main_url'];
			$prev_link_id = $images[$current_index - $add]['type'].'-'.$images[$current_index - 1]['id'];
			$next_link = $images_next[0]['main_url'];

		}
		else{
			$prev_link = $images_prev[count($images_prev) - 1]['main_url'];
			$next_link = $images[$current_index + $add]['main_url'];
			$next_link_id = $images[$current_index + $add]['type'].'-'.$images[$current_index + 1]['id'];
		}
		$_SESSION['current_index'] = $current_index;
		$_SESSION['prev_link'] = $prev_link;
		$_SESSION['next_link'] = $next_link;
		$_SESSION['current_page'] = $cur_page;
		$_SESSION['next_page'] = $next_page;
		$_SESSION['prev_page'] = $prev_page;
		$_SESSION['type_set'] = 'gallery';
		
		return true;
	}
	


}


