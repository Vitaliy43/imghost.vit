<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Advertisement extends MY_Controller{

function __construct(){
		parent::__construct();
		$this->load->module('core');
		$this->setUserRole();
		$this->beforeFilter();
		
	}
	
	function index(){
		$this->template->assign('content',$this->get_page('advertisement'));	
		$this->site_title = 'Рекламодателям';
		$this->display_layout();
	}
	
	function antiaddblock(){
		$this->template->assign('content',$this->get_page('antiaddblock'));
		$this->template->assign('with_main_banner',0);
	
		$this->display_layout();
	}
	
	function rules(){
		$this->site_title = 'Правила хостинга картинок и изображений ImgHost.pro';
		$this->template->assign('content',$this->get_page('rules'));
		$this->display_layout();
	}

	function terms_use(){
		$this->template->assign('content',$this->get_page('advertisement'));	
		$this->display_layout();
	}
	
	function user_agreement(){
		$this->template->assign('content',$this->get_page('advertisement'));	
		$this->display_layout();
	}

}

?>