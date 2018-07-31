<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Error404 extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$this->load->view('error404');
	}

}