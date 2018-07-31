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
		$data['total_product'] = $this->db->query('SELECT * FROM product WHERE product_status="publish"')->num_rows();
		$data['total_customer'] = $this->db->query('SELECT * FROM customer WHERE customer_status="active"')->num_rows();
		$data['total_invoice'] = $this->db->query('SELECT * FROM invoice')->num_rows();
		$data['total_order'] = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->num_rows();
		$data['total_order_expired'] = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id>="6"')->num_rows();
		$data['total_bank'] = $this->db->query('SELECT * FROM bank WHERE bank_status="enabled"')->num_rows();

		$get_omzet = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
		$total = 0;
		foreach ($get_omzet AS $jumlah) {
			$total+=$jumlah->invoice_grand_total;
		}
		$data['total_omzet'] = $total;

		// Populer product
		$data['populer'] = $this->mod->custom_fetch_query('select distinct s.product_id, p.product_name from summary_order s join product p on s.product_id = p.product_id order by p.product_id asc limit 5');

		// User active
		$data['user'] = $this->db->query('SELECT * FROM customer ORDER BY customer_point DESC')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/layout/footer');
	}
}