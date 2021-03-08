<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class Admin extends BaseAdminController {

	
	function __construct() {
        parent::__construct();
		$this->module_name = 'advertisement';
		$this->load->model('my_files');
		$this->load->library('DX_Auth');
		$this->setUserRole();
		$this->load->model('advert');
		$this->module_name = 'advertisement';

    }
	
	
	function index(){
		$language = Language::get_languages('advert');
		if(isset($_POST['position'])){
			$blocks = $this->advert->get_blocks(array('position' => $_POST['position']));
			$data = array(
			'language' => $language,
			'blocks' => $blocks,
			'positions_names' => $this->advert->positions_names
			);

			if(count($blocks) > 0){
				echo $this->admin_render('blocks_list_ajax', $data, true);
				exit;

			}
			else{
				echo '';
				exit;

			}

		}
		$blocks = $this->advert->get_blocks();
		$data = array(
		'language' => $language,
		'blocks' => $blocks,
		'positions_names' => $this->advert->positions_names
		);
		if(isset($_REQUEST['position']) && in_array($_REQUEST['position'],$this->advert->positions))
			$data['position'] = $_REQUEST['position'];
		else
			$data['position'] = '';

//			$this->admin_render('blocks_list', $data);
			$this->admin_render('blocks_list', $data);
	}
	
	function set_position(){
		
	}
	
}


?>