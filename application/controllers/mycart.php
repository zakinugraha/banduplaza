<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Mycart extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		if (isset($_SESSION['order'])) {
			$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
			$data['count_order'] = count($get_session_arr);
			if (!empty($_SESSION['order'])) {
				$data['list'] = $_SESSION['order'];
				$sub_total_price_order = 0;
				foreach ($data['list'] AS $jumlah) {
					$sub_total_price_order+=$jumlah['product_price_total'];
				}
				$data['total_price_order'] = $sub_total_price_order;
			} else {
				$data['total_price_order'] = "000";
			}

			$this->load->view('layout/header_addtocart');
			$this->load->view('mycart', $data);
			$this->load->view('layout/footer');
		} else {
			$this->load->view('layout/header');
			$this->load->view('mycart');
			$this->load->view('layout/footer');
		}

	}

	public function delete($current_product_id)
	{
		$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
		unset($_SESSION['order'][$current_product_id]);
		redirect ('mycart');
	}

}