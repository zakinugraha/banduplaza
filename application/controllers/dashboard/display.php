<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Display extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib'));
	}

	public function hot_products()
	{
		$data['list'] = $this->db->query('SELECT * FROM display')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/display/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add_hot_products()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('display');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('display_link', 'Link', 'required|xss_clean');
			$this->form_validation->set_rules('display_title', 'Title', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$display_image='';
		        $config['upload_path'] = "./upload/images/display/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'display_'.time();
		        $this->upload->initialize($config);

				$array_data=array(
					'display_position'=>"hot",
					'display_link'=>$this->input->post('display_link'),
					'display_title'=>$this->input->post('display_title')
				);

				if (!$this->upload->do_upload('display_image')) {
					
				}else{
					$display_image = $this->upload->file_name;
					$config['source_image']	= './upload/images/display/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/display/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 505;
					$config['height'] = 303;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($display_image!=''){
					$array_data['display_image'] = $display_image;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update banner<br></div>');
				redirect ('dashboard/display/hot_products');
			} // End validation

			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/display/add_hot_products');
			$this->load->view('admin/layout/footer');

		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/display/add_hot_products');
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function edit_hot_products($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('display');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('display_link', 'Link', 'required|xss_clean');
			$this->form_validation->set_rules('display_title', 'Title', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$display_image='';
		        $config['upload_path'] = "./upload/images/display/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'display_'.time();
		        $this->upload->initialize($config);

				$array_data=array(
					'display_position'=>"hot",
					'display_link'=>$this->input->post('display_link'),
					'display_title'=>$this->input->post('display_title')
				);

				if (!$this->upload->do_upload('display_image')) {
					
				}else{
					$display_image = $this->upload->file_name;
					$config['source_image']	= './upload/images/display/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/display/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 505;
					$config['height'] = 303;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($display_image!=''){
					$array_data['display_image'] = $display_image;
				}

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update banner<br></div>');
				redirect ('dashboard/display/hot_products');
			} // End validation

			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/display/edit_hot_products');
			$this->load->view('admin/layout/footer');

		} else {
			$this->mod->set_table_name('display');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/display/edit_hot_products', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete_hot_products($id)
	{
		$this->mod->set_table_name('display');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus display<br></div>');
		redirect('dashboard/display/hot_products');
	} // End function


} // End class