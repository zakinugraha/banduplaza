<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Customers extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->mod->set_table_name('customer');
		$data['list'] = $this->db->query('SELECT * FROM customer')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/customers/list', $data);
		$this->load->view('admin/layout/footer');
	}

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('customer');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('customer_name', 'Customer Name', 'required|xss_clean');
			$this->form_validation->set_rules('customer_email', 'Email Address', 'required|xss_clean|valid_email');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'customer_title'=>$this->input->post('customer_title'),
					'customer_name'=>$this->input->post('customer_name'),
					'customer_email'=>$this->input->post('customer_email'),
					'customer_newsletter'=>$this->input->post('customer_newsletter'),
					'customer_status'=>$this->input->post('customer_status')
				);
				$this->mod->update($id,$array_data);
				redirect ('dashboard/customers');
			} // End If Validation

			$this->mod->set_table_name('customer');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/customers/edit', $data);
			$this->load->view('admin/layout/footer');

		} else {
			$this->mod->set_table_name('customer');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/customers/edit', $data);
			$this->load->view('admin/layout/footer');
		} // End If
		
	} // End Function

	public function view($id)
	{
		$this->mod->set_table_name('customer');
		$data['view'] = $this->mod->get_by_id($id);
		$data['address'] = $this->db->query('SELECT * FROM address WHERE customer_id='.$id)->row();
		$data['customer'] = $this->db->query('SELECT customer_phone FROM customer WHERE customer_id='.$id)->row();
		$data['province'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="0" && area_api_id='.$data['address']->province)->row();
		$data['city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['address']->province.'" && area_api_id='.$data['address']->city)->row();

		$data['history'] = $this->db->query('SELECT * FROM invoice WHERE customer_id='.$id.' LIMIT 5')->result();
		$data['history_complete'] = $this->db->query('SELECT * FROM invoice WHERE customer_id='.$id)->result();
		$data['count_history'] = $this->db->query('SELECT * FROM invoice WHERE customer_id='.$id)->num_rows();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/customers/view', $data);
		$this->load->view('admin/layout/footer');
	}

	public function active($id)
	{
		$this->mod->set_table_name('customer');
		$array_data=array(
			'customer_status'=>'active'
		);
		$this->mod->update($id,$array_data);
		redirect ('dashboard/customers/view/'.$id);
	}

	public function suspend($id)
	{
		$this->mod->set_table_name('customer');
		$array_data=array(
			'customer_status'=>'suspend'
		);
		$this->mod->update($id,$array_data);
		redirect ('dashboard/customers/view/'.$id);
	}

	public function delete($id) {
		$this->mod->set_table_name('address');
		$this->mod->delete($id);
		$this->mod->set_table_name('customer');
		$this->mod->delete($id);
		redirect ('dashboard/customers');
	}

	public function generate_code($id)
	{
		$panjangacak = 10;
		$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		$max=strlen($base)-1;
		$acak='';
		mt_srand((double)microtime()*1000000);
		while (strlen($acak)<$panjangacak)
			$acak.=$base{mt_rand(0,$max)};
			$this->mod->set_table_name('customer');
			$reg=date('Y-m-d');
			$exp=date('Y-m-d', strtotime('+30 days', strtotime($reg)));
			$array_data=array(
				'customer_member_code'=>$acak,
				'customer_member_code_register'=>$reg,
				'customer_member_code_expired'=>$exp
			);
			$this->mod->update($id,$array_data);
			redirect ('dashboard/customers');
	}

} // End Class
