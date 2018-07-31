<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Banner extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib'));
	}

	public function index()
	{
		$this->mod->set_table_name('banner');
		$data['list'] = $this->db->query('SELECT * FROM banner')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/banner/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('banner');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('banner_title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('banner_permalink', 'Permalink', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$banner_image='';
		        $config['upload_path'] = "./upload/images/banner/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'banner_'.time();
		        $this->upload->initialize($config);

				$array_data=array(
					'banner_title'=>$this->input->post('banner_title'),
					'banner_permalink'=>$this->input->post('banner_permalink')
				);

				if (!$this->upload->do_upload('banner_image')) {
					
				}else{
					$banner_image = $this->upload->file_name;
					$config['source_image']	= './upload/images/banner/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/banner/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 1920;
					$config['height'] = 786;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($banner_image!=''){
					$array_data['banner_image'] = $banner_image;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update banner<br></div>');
				redirect ('dashboard/banner');				
			} // End validation

			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/banner/add');
			$this->load->view('admin/layout/footer');

		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/banner/add');
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('banner');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('banner_title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('banner_permalink', 'Permalink', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$banner_image='';
		        $config['upload_path'] = "./upload/images/banner/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'banner_'.time();
		        $this->upload->initialize($config);

				$array_data=array(
					'banner_title'=>$this->input->post('banner_title'),
					'banner_permalink'=>$this->input->post('banner_permalink')
				);

				if (!$this->upload->do_upload('banner_image')) {
					
				}else{
					$banner_image = $this->upload->file_name;
					$config['source_image']	= './upload/images/banner/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/banner/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 1920;
					$config['height'] = 786;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($banner_image!=''){
					$array_data['banner_image'] = $banner_image;
				}

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update banner<br></div>');
				redirect ('dashboard/banner');				
			} // End validation

			// Jika validasi gagal
			$this->mod->set_table_name('banner');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/banner/edit', $data);
			$this->load->view('admin/layout/footer');

		} else {
			$this->mod->set_table_name('banner');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/banner/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('banner');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus banner<br></div>');
		redirect('dashboard/banner');
	} // End function


} // End class