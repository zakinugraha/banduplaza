<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Blogcategory extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->mod->set_table_name('blogcategory');
		$data['list'] = $this->db->query('SELECT * FROM blogcategory')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/blogcategory/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('blogcategory_value', 'Nama Category', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$this->mod->set_table_name('blogcategory');
				$array_data=array(
					'blogcategory_value'=>$this->input->post('blogcategory_value'),
					'blogcategory_date'=>date('Y-m-d H:i:s')
				);
				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Tambah Blog Kategori baru<br></div>');
				redirect('dashboard/blogcategory');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/blogcategory/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/blogcategory/add');
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('blogcategory');
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Hapus Blog Category<br></div>');
		redirect ('dashboard/blogcategory');
	}

}