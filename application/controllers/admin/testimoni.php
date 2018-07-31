<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Testimoni extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib','pagination'));
		$this->load->helper('indonesia_date');
		$this->limit = 10;
	}

	public function index()
	{
		redirect('admin/testimoni/all');
	}

	public function all()
	{
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
		$data['list'] = $this->db->query('SELECT * FROM testimoni LIMIT '.$this->limit.' offset '.$offset)->result();
		$data['count'] = $this->db->query('SELECT * FROM testimoni')->num_rows();

		$config['base_url'] = base_url().'admin/testimoni/all/page/';
	    $config['total_rows'] = $data['count'];
	    $config['uri_segment'] = 5;
	    $config['per_page'] = $this->limit;
	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['first_link'] = '&laquo';
	    $config['last_link'] = '&raquo';
	    $config['prev_link'] = '&lsaquo;';
	    $config['prev_tag_open'] = '<li class="prev">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '&rsaquo;';
	    $config['next_tag_open'] = '<li>';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li>';
	    $config['last_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active"><a href="#">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';

	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/aside');
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
				redirect ('admin/testimoni');
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/testimoni/add');
			$this->load->view('admin/layout/footer');
		} else{
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
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
				redirect ('admin/testimoni');

		} else {
			$this->mod->set_table_name('testimoni');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
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
		redirect ('admin/testimoni');
	}


}