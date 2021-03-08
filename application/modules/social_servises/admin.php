<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Image CMS
 * Comments admin
 */
class Admin extends BaseAdminController {

    function __construct() {
        parent::__construct();
        $lang = new MY_Lang();
            $lang->load('social_servises');

        $this->load->library('DX_Auth');
		$this->setUserRole();
		Language::load_language('sync');
		$this->load->model('socialnet');
		
        //cp_check_perm('module_admin');
    }

    public function index() {
		
		$language = Language::get_languages('sync');
		$language_ok = $language;
		$language_pic = $language;
		$ok_settings = $this->socialnet->get_settings('ok');
		$pic_settings = $this->socialnet->get_settings('pic');
		if(empty($_REQUEST['net']))
			$net = 'vk';
		else
			$net = $_REQUEST['net'];
		$settings = $this->socialnet->get_settings($net);
		$language_ok['SWITCH_ON_INTEGRATION'] = str_replace('%net%',$ok_settings['name'],$language_ok['SWITCH_ON_INTEGRATION']);
		$language_pic['SWITCH_ON_INTEGRATION'] = str_replace('%net%',$pic_settings['name'],$language_pic['SWITCH_ON_INTEGRATION']);
		$data = array(
		'net' => $net,
		'vk' => $this->render_widget('vk',array('settings' => $this->socialnet->get_settings('vk'),'language' =>$language,'net' => $net),true),
		'fb' => $this->render_widget('fb',array('settings' => $this->socialnet->get_settings('fb'),'language' =>$language, 'net' => $net),true),
		'ok' => $this->render_widget('ok',array('settings' => $this->socialnet->get_settings('ok'),'language' =>$language_ok, 'net' => $net),true),
		'pic' => $this->render_widget('pic',array('settings' => $this->socialnet->get_settings('pic'),'language' =>$language_pic, 'net' => $net),true),
		'ok_settings' => $ok_settings,
		'pic_settings' => $pic_settings
		);
		
        $this->render('settings', $data);
    }
	

    public function update_settings() {
        $fb = $_POST['fb'];
        $vk = $_POST['vk'];
        $ok = $_POST['ok'];
        $pic = $_POST['pic'];
		$this->socialnet->set_settings('fb',$fb);
		$this->socialnet->set_settings('vk',$vk);
		$this->socialnet->set_settings('ok',$ok);
		$this->socialnet->set_settings('pic',$pic);
//        $string = serialize($data);
//        $vstring = serialize($vdata);
//        ShopCore::app()->SSettings->set('facebook_int', $string);
//        ShopCore::app()->SSettings->set('vk_int', $vstring);
        showMessage(lang('Settings successfully saved', 'social_servises'));
    }

    public function get_fsettings() {
		if(!class_exists('ShopCore'))
			return '';
        $settings = ShopCore::app()->SSettings->__get('facebook_int');
        $settings = unserialize($settings);
        return $settings;
    }

    public function get_vsettings() {
        if(!class_exists('ShopCore'))
			return '';
        $settings = unserialize($settings);
        return $settings;
    }

    function _get_templates() {
        $new_arr = array();
        if ($handle = opendir(TEMPLATES_PATH)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != 'administrator' && $file != 'modules') {
                    if (!is_file(TEMPLATES_PATH . $file)) {
                        $new_arr[$file] = $file;
                    }
                }
            }
            closedir($handle);
        } else {
            return FALSE;
        }
        return $new_arr;
    }
	
	public function render_widget($viewName, array $data = array(), $return = false){
		if (!empty($data))
            $this->template->add_array($data);

        if ($return === false)
            $this->template->show('file:' . 'application/modules/social_servises/templates/admin/widgets/' . $viewName);
        else
            return $this->template->fetch('file:' . 'application/modules/social_servises/templates/admin/widgets/' . $viewName);
	}

    public function render($viewName, array $data = array(), $return = false) {
        if (!empty($data))
            $this->template->add_array($data);

        $this->template->show('file:' . 'application/modules/social_servises/templates/admin/' . $viewName);
        exit;

        if ($return === false)
            $this->template->show('file:' . 'application/modules/social_servises/templates/admin/' . $viewName);
        else
            return $this->template->fetch('file:' . 'application/modules/social_servises/templates/admin/' . $viewName);
    }

}