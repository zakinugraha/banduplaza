<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Member_code extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$cek = $this->db->query('SELECT * FROM configuration WHERE configuration_id="2" LIMIT 1')->row();
		$data['status'] = $cek->configuration_value;

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/member_code/list', $data);
		$this->load->view('admin/layout/footer');
	}

	public function update()
	{
		$this->mod->set_table_name('configuration');
		$array_data=array(
			'configuration_value'=>$this->input->post('member_code')
		);
		$this->mod->update('2',$array_data);
		redirect ('dashboard/member_code');
	}

}