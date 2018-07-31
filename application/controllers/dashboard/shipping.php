<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Shipping extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		// $this->load->model('api_raja_ongkir');
	}

	public function index()
	{
		if ($this->input->post('submit')) {
			$id="1";
			$this->mod->set_table_name('shipping');
			$array_data=array(
				'shipping_name'=>$this->input->post('name'),
				'shipping_province'=>$this->input->post('province'),
				'shipping_city'=>$this->input->post('city'),
				'shipping_address'=>$this->input->post('address'),
				'shipping_postcode'=>$this->input->post('postcode'),
				'shipping_phone'=>$this->input->post('phone')
			);
			// echo "<pre>";
			// print_r($array_data);
			// exit;
			$this->mod->update($id,$array_data);
			redirect ('dashboard/shipping');

		} else {
			$data['shipping'] = $this->db->query('SELECT * FROM shipping WHERE shipping_id="1" LIMIT 1')->row();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/shipping/list', $data);
			$this->load->view('admin/layout/footer');
		}
		
	} // End function

	public function get_city($province_id=0)
	{
		$sql='SELECT * FROM tbl_area WHERE area_par_id='.intval($province_id);
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

}