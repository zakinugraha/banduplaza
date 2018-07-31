<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Report extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib', 'pagination'));
		$this->load->helper('indonesia_date');
		$this->limit = 10;
	}

	public function index()
	{
		redirect ('admin/report/sell');
	}

	public function sell()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('invoice');
			$data['month_now'] = $this->input->post('cmb_month');
			$data['year_now'] = $this->input->post('cmb_year');
			
			if (empty($data['month_now'])) {
				$data['count'] = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
				$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
				$data['list'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y-%m-%d") AS tahun FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->result();
			} else {
				$data['count'] = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
				$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
				$data['list'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y-%m-%d") AS tahun FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->result();
			}

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/report/sell', $data);
			$this->load->view('admin/layout/footer');

		} else {
			$this->mod->set_table_name('invoice');
			$data['year_now'] = date('Y');
			$data['month_now'] = date('m');

			$data['count'] = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
			$data['list'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y-%m-%d") AS tahun FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->result();
			$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/report/sell', $data);
			$this->load->view('admin/layout/footer');
		} // End IF
			
	
			
	}


}