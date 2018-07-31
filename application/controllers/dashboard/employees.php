<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Employees extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->mod->set_table_name('employees');
		$data['list'] = $this->db->query('SELECT * FROM employees')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/employees/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s is exist');
			$this->form_validation->set_message('valid_email', '%s not valid');
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean|is_unique[employees.username]');
			$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Address', 'required|xss_clean|valid_email|is_unique[employees.email]');
			if ($this->form_validation->run()==TRUE) {
				$this->mod->set_table_name('employees');
				$array_data=array(
					'brand_id'=>$this->input->post('brand_id'),
					'title'=>$this->input->post('title'),
					'name'=>$this->input->post('name'),
					'username'=>$this->input->post('username'),
					'password'=>$this->input->post('password'),
					'email'=>$this->input->post('email'),
					'registration_date'=>date('Y-m-d')
				);
				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah employees baru<br></div>');
				redirect('dashboard/employees');
			} // End If Validation
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/employees/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/employees/add');
			$this->load->view('admin/layout/footer');
		}		
	} // End function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s is exist');
			$this->form_validation->set_message('valid_email', '%s not valid');
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean|callback_is_username_exist');
			$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email Address', 'required|xss_clean|valid_email|callback_is_email_exist');
			if ($this->form_validation->run()==TRUE) {
				$this->mod->set_table_name('employees');
				$array_data=array(
					'brand_id'=>$this->input->post('brand_id'),
					'title'=>$this->input->post('title'),
					'name'=>$this->input->post('name'),
					'username'=>$this->input->post('username'),
					'password'=>$this->input->post('password'),
					'email'=>$this->input->post('email'),
					'update_date'=>date('Y-m-d')
				);
				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses edit employees<br></div>');
				redirect('dashboard/employees');
			} // End If Validation
			$this->mod->set_table_name('employees');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/employees/edit', $data);
			$this->load->view('admin/layout/footer');
		} else {
			$this->mod->set_table_name('employees');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/employees/edit', $data);
			$this->load->view('admin/layout/footer');
		}		
	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('employees');
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus employees<br></div>');
		redirect ('dashboard/employees');
	}

	function is_username_exist()
	    {
	        $username_sekarang 	= $this->input->post('userhide');
	        $username_baru		= $this->input->post('username');
	        if ($username_baru === $username_sekarang) {
	            return TRUE;
	        } else {
	            $query = $this->db->get_where('employees', array('username' => $username_baru));
	            if($query->num_rows() > 0)  {
	                $this->form_validation->set_message('is_username_exist', "Username is exist");
	                return FALSE;
	            } else { // id_user_kelas belum dipakai, OK
	                return TRUE;
	            }
	        }
	    }
		
		function is_email_exist()
	    {
	        $email_sekarang = $this->input->post('emailhide');
	        $email_baru		= $this->input->post('email');

	        if ($email_baru === $email_sekarang) {
	            return TRUE;
	        } else {
	            $query = $this->db->get_where('employees', array('email' => $email_baru));

	            if($query->num_rows() > 0)  {
	                $this->form_validation->set_message('is_email_exist',  "Email is exist");
	                return FALSE;
	            } else {
	                return TRUE;
	            }
	        }
	    }

} // End Class
