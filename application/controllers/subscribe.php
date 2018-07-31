<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Subscribe extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function add()
	{		
		$email=$this->input->get('email');
		$array_data=array(
			'subscribe_email'=>$email,
			'subscribe_source'=>'1'
		);
		$this->mod->set_table_name('subscribe');
		$this->mod->insert($array_data);
		echo json_encode($array_data);
	}

} // End class