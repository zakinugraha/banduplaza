<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Email extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		if ($this->input->post('submit')) {

		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/email/send');
			$this->load->view('admin/layout/footer');
		} // End if

		
	} // End function


} // End class