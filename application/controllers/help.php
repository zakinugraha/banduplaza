<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Help extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$param = $this->uri->segment(2);
		if ($param=='') {
			$data['get'] = $this->db->query('SELECT * FROM support ORDER BY support_id ASC LIMIT 1')->row();
			redirect (base_url().'help/'.$data['get']->support_sess.'/'.url_title(strtolower($data['get']->support_title)));
		} else {
			$data['get'] = $this->db->query('SELECT * FROM support WHERE support_sess="'.$param.'" LIMIT 1')->row();
			$data['title'] = 'Pusat Bantuan - Pusat Sepatu dan Tas Terlengkap';

			$this->load->view('layout/header', $data);
			$this->load->view('help', $data);
			$this->load->view('layout/footer');
		}
			
		
			
	} // end function

}