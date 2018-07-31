<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Pages extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$param = explode("-", $this->uri->segment(2));
		$id = end($param);

		$data['get'] = $this->db->query('SELECT * FROM pages WHERE pages_id="'.$id.'" LIMIT 1')->row();

		$this->load->view('layout/header');
		$this->load->view('pages', $data);
		$this->load->view('layout/footer');
	}

}