<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		echo $this->session->userdata('status_user');
		echo $this->session->userdata('brand_id');
	}

}