<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Pages extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib'));
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->mod->set_table_name('pages');
		$data['list'] = $this->db->query('SELECT * FROM pages')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('pages_title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('pages_position', 'Posisi', 'required|xss_clean');
			$this->form_validation->set_rules('pages_content', 'Content', 'required|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$array_data=array(
					'pages_title'=>$this->input->post('pages_title'),
					'pages_position'=>$this->input->post('pages_position'),
					'pages_content'=>$this->input->post('pages_content'),
				);
				$this->mod->set_table_name('pages');
				$this->mod->insert($array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah halaman baru<br></div>');
				redirect('dashboard/pages');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/pages/add');
			$this->load->view('admin/layout/footer');
		} else { // Pertama kali dibuka
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/pages/add');
			$this->load->view('admin/layout/footer');
		}
			
	} // End function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('pages_title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('pages_position', 'Posisi', 'required|xss_clean');
			$this->form_validation->set_rules('pages_content', 'Content', 'required|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$array_data=array(
					'pages_title'=>$this->input->post('pages_title'),
					'pages_position'=>$this->input->post('pages_position'),
					'pages_content'=>$this->input->post('pages_content'),
				);
				$this->mod->set_table_name('pages');
				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses edit halaman<br></div>');
				redirect('dashboard/pages');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/pages/edit');
			$this->load->view('admin/layout/footer');
		} else {
			$this->mod->set_table_name('pages');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/pages/edit', $data);
			$this->load->view('admin/layout/footer');
		}
			
	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('pages');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus halaman<br></div>');
		redirect('dashboard/pages');
	}

} // End class