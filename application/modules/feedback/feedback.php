<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Image CMS
 *
 * Feedback module
 */
class Feedback extends MY_Controller {

    public $username_max_len = 30;
    public $message_max_len = 600;
    public $theme_max_len = 150;
    public $admin_mail;
    public $message = '';
    protected $formErrors = array();

    public function __construct() {
        parent::__construct();
        $this->load->module('core');
        $this->load_settings();

        $this->formErrors = array(
            'required' => lang('Field is required'),
            'min_length' => lang('Length is less than the minimum'),
            'valid_email' => lang('Email is not valid'),
            'max_length' => lang('Length greater than the maximum')
        );
		Language::load_language('sync');
        $lang = new MY_Lang();
        $lang->load('feedback');
		$this->setUserRole();
		$this->beforeFilter();
    }

    public function autoload() {
        
    }

    function captcha_check($code) {
        if (!$this->dx_auth->captcha_check($code))
            return FALSE;
        else
            return TRUE;
    }

    function recaptcha_check() {
        $result = $this->dx_auth->is_recaptcha_match();
        if (!$result) {
            $this->form_validation->set_message('recaptcha_check', lang("Improper protection code", 'feedback'));
        }

        return $result;
    }

    // Index function
    public function index() {
        
        $this->core->set_meta_tags(lang('Feedback', 'feedback'));
		$language = Language::get_languages('main');
		$lang_sync = Language::get_languages('sync');
		$this->site_title = $language['FEEDBACK'];
        $this->load->library('form_validation');
		$this->load->model('bitly');

        // Create captcha
        $this->dx_auth->captcha();
//        $tpl_data['cap_image'] = $this->dx_auth->get_captcha_image();

        $this->template->add_array($tpl_data);

        if (count($_POST) > 0) {
            $this->form_validation->set_rules('name', lang('Name', 'feedback'), 'trim|required|min_length[3]|max_length[' . $this->username_max_len . ']|xss_clean');
            $this->form_validation->set_rules('email', lang('E-Mail', 'feedback'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('theme', lang('Theme', 'feedback'), 'trim|required|max_length[' . $this->theme_max_len . ']|xss_clean');

            if ($this->dx_auth->use_recaptcha)
                $this->form_validation->set_rules('recaptcha_response_field', lang("Code protection", 'feedback') . 'RECAPTCHA', 'trim|xss_clean|required|callback_recaptcha_check');
            else
                $this->form_validation->set_rules('captcha', lang("Code protection", 'feedback') . 'RECAPTCHA', 'trim|required|xss_clean|callback_captcha_check');

            $this->form_validation->set_rules('message', lang('Message', 'feedback'), 'trim|required|max_length[' . $this->message_max_len . ']|xss_clean');

            if ($this->form_validation->run($this) == FALSE) { // there are errors
                $fields = array(
                    'theme' => lang('Theme', 'feedback'),
                    'name' => lang('Name', 'feedback'),
                    'email' => lang('E-mail', 'feedback'),
                    'message' => lang('Message', 'feedback'),
                    'captcha' => lang('Captcha', 'feedback')
                );
                $errors = "";
                $this->form_validation->set_error_delimiters("", "");
                foreach ($fields as $field => $name) {
                    $error = $this->form_validation->error($field);
                    if (!empty($error)) {
                        $error_ = isset($this->formErrors[$error]) ? $this->formErrors[$error] : lang('Error', 'feedback');
                        $errors .= "<div style=\"color:red\">{$name} - {$error_}</div>";
                    }
                }
                $this->template->assign('form_errors', $errors);
            } else { // form is validate
				
				if(isset($_REQUEST['image_id'])){
		  			$image = $this->my_files->get_file_guest_by_id($_REQUEST['image_id'],true);
					$_POST['message'] = strip_tags($this->input->post('message'));
					$message = '<a href="'.SITE_URL.$image['main_url'].'" target="_blank"><b>'.SITE_URL.$image['main_url'].'</b></a><br>'.$this->input->post('message');
					$_POST['message'] = $message;
		  		}

				$this->message = nl2br($this->input->post('message'));
                $this->_send_message();
            }
        }

		  $data = array(
		  'form_erros' => $errors,
		  'language' => $language,
		  'cap_image' => $this->dx_auth->get_captcha_image(),
		  'captcha_type' => 'captcha',
		  'lang_sync' => $lang_sync
		  );
		  if($this->my_auth->role != 'guest'){
		  	if(empty($_POST['email']))
		  		$data['user_email'] = $this->dx_auth->get_user_email();
		  		$data['username'] = $this->dx_auth->get_username();
		  }
		  else{
		  	$data['user_email'] = $_POST['email'];
		  	$data['username'] = '';
		  }
		  if(isset($_POST['email'])){
		  	$data['message'] = strip_tags($_POST['message']);
		  }
		  else{
		  	$data['message'] = '';
		  }
		 
		  if(isset($_REQUEST['type_feedback']) && $_REQUEST['type_feedback'] == 'complaint')
		  		$data['type_feedback'] = $language['COMPLAINT_IMAGE'];
		  
		  $this->template->assign('content',$this->get_page('feedback', $data));
		  $this->display_layout();
    }

    // Send e-mail
    private function _send_message() {
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = FALSE;

        $this->load->library('email');
        $this->email->initialize($config);
		$this->email->_safe_mode = true;
		
        $this->email->from($this->input->post('email'), $this->input->post('name'));
        $this->email->to($this->admin_mail);

        $this->email->subject($this->input->post('theme'));
        $this->email->message($this->message);
        $this->email->send();

        $this->template->assign('message_sent', TRUE);
    }

    private function load_settings() {
        $this->db->limit(1);
        $this->db->where('name', 'feedback');
        $query = $this->db->get('components')->row_array();
        $settings = unserialize($query['settings']);
		
        if (is_int($settings['message_max_len'])) {
            $this->message_max_len = $settings['message_max_len'];
        }

        if ($settings['email']) {
            $this->admin_mail = $settings['email'];
        }
		
		if(!$this->admin_mail){
			$buffer_admin_mail = $this->my_auth->get_admin_email();
			if($buffer_admin_mail)
				$this->admin_mail = $buffer_admin_mail;
		}


    }

    /**
     * Display template file
     */
    private function display_tpl($file = '') {
        $file = realpath(dirname(__FILE__)) . '/templates/' . $file;
        $this->template->show('file:' . $file);
    }

}

/* End of file sample_module.php */
