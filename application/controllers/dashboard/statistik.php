<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Statistik extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{	
		// $data['graph'] = $this->db->query('SELECT DISTINCT date_format(invoice_date_confirm, "%m") as bulan FROM invoice ORDER BY invoice_date_confirm ASC')->result();
		$data['graph'] = $this->db->query('SELECT DISTINCT product_id FROM summary_order')->result();
		echo json_encode($data['graph']);

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/statistik/data', $data);
		$this->load->view('admin/layout/footer');		
			
	} // End function

} // End class