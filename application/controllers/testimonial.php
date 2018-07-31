<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Testimonial extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('testimonial');
		$this->load->view('layout/footer');
	}

} // end class