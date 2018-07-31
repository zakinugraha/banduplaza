<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Invoice extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
		$this->load->helper('sendpulseInterface');
		$this->load->helper('sendpulse');
		// Initial Midtrans Payment Gateway
		$params = array('server_key' => 'VT-server-YvIiWWkWtfGMgVDlQ-K_9Y01', 'production' => true);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
	}

	public function get_product($nav_id=0)
	{
		$nav_id = $this->input->get('nav_id');
		$brand_id = $this->input->get('brand_id');
		$sql='SELECT * FROM product WHERE type_nav_page_id='.$nav_id.' && brand_id='.$brand_id.' ORDER BY product_name ASC';
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

	public function get_size($nav_id=0)
	{
		$nav_id = $this->input->get('nav_id');
		// if ($nav_id=="1") {
		// 	$nav_alias = "2";
		// } else {
		// 	$nav_alias = "1";
		// }
		// $size_id = $this->input->get('brand_id');
		$sql='SELECT * FROM size_attributes WHERE size_attributes_type='.$nav_id.' ORDER BY size_attributes_value ASC';
		$exe=$this->db->query($sql);
		$result=$exe->result_array();
		echo json_encode($result);
	}

	public function input()
	{
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/invoice/input');
		$this->load->view('admin/layout/footer');
	}

	public function generate()
	{

	}


}