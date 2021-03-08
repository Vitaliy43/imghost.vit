<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Admin extends BaseAdminController {
	
	private $per_page = 12;
	
	function __construct() {
        parent::__construct();
		$this->load->model('my_files');
		$this->load->library('DX_Auth');
		$this->setUserRole();
		$this->load->model('my_albums');
		$this->load->model('socialnet');
		$this->my_files->admin_mode = true;
		$this->load->library('template');
		$this->load->helper('image');
		$this->load->helper('time');

    }
	
	
	function index(){
		
		$uriSegments = $this->uri->segment_array();
		$off_set = (int)$uriSegments[count($uriSegments)];
		$segs = $this->uri->uri_to_assoc(6);
		$total = $this->my_files->count_all_files();
		$total_user = $this->my_files->count_all_files_user();
		$total_tag = $this->my_files->count_all_files_tag();

		if(!$off_set)
			$off_set = 0;
		if(isset($segs['tags']))
			$this->my_files->show_type = 'tags';
		elseif(isset($segs['users']))
			$this->my_files->show_type = 'users';

		$images = $this->my_files->get_files($this->per_page, $off_set);

		Language::load_language('imagelist');
		Language::load_language('gallery');
		$language = Language::get_languages('imagelist');
		$lang_auth = Language::get_languages('auth');
		$lang_main = Language::get_languages('main');
		$lang_upload = Language::get_languages('upload');
		$lang_gallery = Language::get_languages('gallery');
		$lang_albums = Language::get_languages('albums');
		
		foreach($images as $key=>$value){
				if($value['access'] == 'public')
					$images[$key]['access_text'] = $lang_albums['ALBUM_PUBLIC'];
				else
					$images[$key]['access_text'] = $lang_albums['ALBUM_PRIVATE'];
			}
			
		 $data = array(
            'images' => $images,
			'total_all' => $total,
            'total_user' => $total_user,
            'total_tag' => $total_tag,
			'language' => $language,
			'lang_upload' =>$lang_upload,
			'lang_auth' => $lang_auth,
			'lang_main' =>$lang_main
         );
		
		 if ($total > $this->per_page) {
                $this->load->library('Pagination');
				
				if(isset($segs['tags'])){
					$config['total_rows'] = $total_tag;
                	$config['base_url'] = site_url('admin/components/cp/imghost/index/tags/page/');
					$data['selected'] = 'tags';
				}
				elseif(isset($segs['users'])){
					$config['total_rows'] = $total_tag;
                	$config['base_url'] = site_url('admin/components/cp/imghost/index/users/page/');
					$data['selected'] = 'users';
				}
				else{
					$config['total_rows'] = $total;
                	$config['base_url'] = site_url('admin/components/cp/imghost/index/page/');
					$data['selected'] = 'all';
				}
                $config['per_page'] = $this->per_page;
                $config['uri_segment'] = $this->uri->total_segments();
//				echo 'segment '.$config['uri_segment'].'<br>';

                $config['separate_controls'] = true;
                $config['full_tag_open'] = '<div class="pagination pull-left"><ul>';
                $config['full_tag_close'] = '</ul></div>';
                $config['controls_tag_open'] = '<div class="pagination pull-right"><ul>';
                $config['controls_tag_close'] = '</ul></div>';
                $config['next_link'] = lang('Next', 'admin') . '&nbsp;&gt;';
                $config['prev_link'] = '&lt;&nbsp;' . lang('Prev', 'admin');
                $config['cur_tag_open'] = '<li class="btn-primary active"><span>';
                $config['cur_tag_close'] = '</span></li>';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['num_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';

                $this->pagination->num_links = 5;
                $this->pagination->initialize($config);
                $this->template->assign('paginator', $this->pagination->create_links_ajax());
            }
	
	
		 $this->render('main_list',$data);
		
		
//		$this->render('test',array('images' => $images,'total_all' => $total,'language' =>$language,'lang_upload' => $lang_upload,'lang_auth' => $lang_auth,'lang_main' => $lang_main,'THEME' => $this->theme_path.'/'));
	}
	
	public function render($viewName, array $data = array(), $return = false) {
        if (!empty($data))
            $this->template->add_array($data);

        $this->template->show('file:' . 'application/modules/imghost/views/admin/' . $viewName);
        exit;

        if ($return === false)
            $this->template->show('file:' . 'application/modules/imghost/views/admin/' . $viewName);
        else
            return $this->template->fetch('file:' . 'application/modules/imghost/views/admin/' . $viewName);
    }
	
}

?>