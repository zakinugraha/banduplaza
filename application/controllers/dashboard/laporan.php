<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Laporan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function penjualan()
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
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/laporan/penjualan', $data);
			$this->load->view('admin/layout/footer');

		} else {
			$this->mod->set_table_name('invoice');
			$data['year_now'] = date('Y');
			$data['month_now'] = date('m');

			$data['count'] = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
			$data['list'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y-%m-%d") AS tahun FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->result();
			$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/laporan/penjualan', $data);
			$this->load->view('admin/layout/footer');
		} // End IF
		
	} // End function

	public function keuangan()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('invoice');
			$data['month_now'] = $this->input->post('cmb_month');
			$data['year_now'] = $this->input->post('cmb_year');
			
			if (empty($data['month_now'])) {
				$data['count'] = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
				$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
				$data['list'] = $this->mod->custom_fetch_query('select s.*, s.invoice_number, s.product_id, s.product_price_base, s.product_price_sell, s.product_price_discount, s.product_price, s.product_qty, p.product_id, p.product_name, p.product_code, i.invoice_number, i.invoice_status_id from summary_order s inner join product p on (s.product_id=p.product_id) inner join invoice i on (i.invoice_number=s.invoice_number) WHERE DATE_FORMAT(invoice_date_confirm,"%Y")='.$data['year_now'].' && invoice_status_id>="3" && invoice_status_id<="5" ORDER BY summary_order_id ASC');
			} else {
				$data['count'] = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_order,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
				$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
				$data['list'] = $this->mod->custom_fetch_query('select s.*, s.invoice_number, s.product_id, s.product_price_base, s.product_price_sell, s.product_price_discount, s.product_price, s.product_qty, p.product_id, p.product_name, p.product_code, i.invoice_number, i.invoice_status_id from summary_order s inner join product p on (s.product_id=p.product_id) inner join invoice i on (i.invoice_number=s.invoice_number) WHERE DATE_FORMAT(invoice_date_confirm,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_confirm,"%m")='.$data['month_now'].' && invoice_status_id>="3" && invoice_status_id<="5" ORDER BY summary_order_id ASC');
			}

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/laporan/keuangan', $data);
			$this->load->view('admin/layout/footer');

		} else {
			$this->mod->set_table_name('invoice');
			$data['year_now'] = date('Y');
			$data['month_now'] = date('m');
			$data['list_year'] = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order,"%Y") AS tahun FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
			$data['count'] = $this->db->query('SELECT * FROM summary_order')->num_rows();

			// $data['list'] = $this->db->query('SELECT * FROM summary_order WHERE DATE_FORMAT(summary_order_date,"%Y")='.$data['year_now'].' && DATE_FORMAT(summary_order_date,"%m")='.$data['month_now'].' ORDER BY summary_order_id ASC')->result();
			$data['list'] = $this->mod->custom_fetch_query('select s.*, s.invoice_number, s.product_id, s.product_price_base, s.product_price_sell, s.product_price_discount, s.product_price, s.product_qty, p.product_id, p.product_name, p.product_code, i.invoice_number, i.invoice_status_id from summary_order s inner join product p on (s.product_id=p.product_id) inner join invoice i on (i.invoice_number=s.invoice_number) WHERE DATE_FORMAT(invoice_date_confirm,"%Y")='.$data['year_now'].' && DATE_FORMAT(invoice_date_confirm,"%m")='.$data['month_now'].'&& invoice_status_id>="3" && invoice_status_id<="5" ORDER BY summary_order_id ASC');
			
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/laporan/keuangan', $data);
			$this->load->view('admin/layout/footer');
		} // End IF

	} // End function

}