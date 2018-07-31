<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Testimoni extends MY_Controller
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
		$this->mod->set_table_name('testimoni');
		$data['list'] = $this->db->query('SELECT * FROM testimoni')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/testimoni/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('testimoni');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('testimoni_name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('testimoni_region', 'Region', 'required|xss_clean');
			$this->form_validation->set_rules('testimoni_desc', 'Description', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$testimoni_image='';
		        $config['upload_path'] = "./upload/images/testimoni/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'testimony_'.time();
		        $this->upload->initialize($config);

		        $array_data=array(
		        	'testimoni_name'=>$this->input->post('testimoni_name'),
		        	'testimoni_region'=>$this->input->post('testimoni_region'),
		        	'testimoni_desc'=>$this->input->post('testimoni_desc'),
		        	'testimoni_date'=>date('Y-m-d')
		        );

		        if (!$this->upload->do_upload('testimoni_image')) {
				
				}else{
					$testimoni_image = $this->upload->file_name;
					$config['source_image']	= './upload/images/testimoni/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/testimoni/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 200;
					$config['height'] = 200;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($testimoni_image!=''){
					$array_data['testimoni_image'] = $testimoni_image;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah testimoni baru<br></div>');
				redirect ('dashboard/testimoni');
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/testimoni/add');
			$this->load->view('admin/layout/footer');
		} else{
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/testimoni/add');
			$this->load->view('admin/layout/footer');
		}
			
	} // end function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('testimoni');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('testimoni_name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('testimoni_region', 'Region', 'required|xss_clean');
			$this->form_validation->set_rules('testimoni_desc', 'Description', 'required|xss_clean');
			$config = array();
				$testimoni_image='';
		        $config['upload_path'] = "./upload/images/testimoni/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'testimony_'.time();
		        $this->upload->initialize($config);

		        $array_data=array(
		        	'testimoni_name'=>$this->input->post('testimoni_name'),
		        	'testimoni_region'=>$this->input->post('testimoni_region'),
		        	'testimoni_desc'=>$this->input->post('testimoni_desc'),
		        	'testimoni_date'=>date('Y-m-d')
		        );

		        if (!$this->upload->do_upload('testimoni_image')) {
				
				}else{
					$testimoni_image = $this->upload->file_name;
					$config['source_image']	= './upload/images/testimoni/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/testimoni/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 200;
					$config['height'] = 200;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($testimoni_image!=''){
					$array_data['testimoni_image'] = $testimoni_image;
				}

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses ubah testimoni<br></div>');
				redirect ('dashboard/testimoni');

		} else {
			$this->mod->set_table_name('testimoni');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/testimoni/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // end function

	public function delete($id)
	{
		$this->mod->set_table_name('testimoni');
		$this->db->query('DELETE FROM testimoni WHERE testimoni_id='.$id);
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus testimoni<br></div>');
		redirect ('dashboard/testimoni');
	}


}