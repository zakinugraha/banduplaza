<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Brand extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib', 'pagination'));
		$this->limit = 10;
	}

	public function index()
	{
		redirect ('admin/brand/all');
	}

	public function all()
	{
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
		$data['list'] = $this->db->query('SELECT * FROM brand LIMIT '.$this->limit.' offset '.$offset)->result();
		$data['count'] = $this->db->query('SELECT * FROM brand')->num_rows();

		$config['base_url'] = base_url().'admin/brand/all/page/';
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
		$this->load->view('admin/brand/list', $data);
		$this->load->view('admin/layout/footer');
	}

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('brand');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('brand_name', 'Name', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$brand_logo='';
		        $config['upload_path'] = "./upload/images/brands/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'brands_'.time();
		        $this->upload->initialize($config); 

				$array_data=array(
					// 'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'type_brand_stock'=>"2",
					'brand_name'=>$this->input->post('brand_name'),
					'brand_api'=>$this->input->post('brand_api'),
					'brand_status'=>$this->input->post('brand_status'),
					'brand_description'=>$this->input->post('brand_description'),
					'brand_privacy_return'=>$this->input->post('brand_privacy_return'),
					'brand_registration'=>date('Y-m-d'),
				);

				if (!$this->upload->do_upload('brand_logo')) {
				
				}else{
					$brand_logo = $this->upload->file_name;
					$config['source_image']	= './upload/images/brands/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/brands/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 100;
					$config['height'] = 17;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($brand_logo!=''){
					$array_data['brand_logo'] = $brand_logo;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah brand suplier baru<br></div>');
				redirect ('admin/brand');
				
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/brand/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/brand/add');
			$this->load->view('admin/layout/footer');
		} // End If
		
	} 

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('brand');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('brand_name', 'Name', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$brand_logo='';
		        $config['upload_path'] = "./upload/images/brands/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'brands_'.time();
		        $this->upload->initialize($config);

				$array_data=array(
					// 'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'type_brand_stock'=>"2",
					'brand_name'=>$this->input->post('brand_name'),
					'brand_api'=>$this->input->post('brand_api'),
					'brand_status'=>$this->input->post('brand_status'),
					'brand_description'=>$this->input->post('brand_description'),
					'brand_privacy_return'=>$this->input->post('brand_privacy_return'),
					'brand_registration'=>date('Y-m-d'),
				);

				if (!$this->upload->do_upload('brand_logo')) {
					
				}else{
					$brand_logo = $this->upload->file_name;
					$config['source_image']	= './upload/images/brands/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/brands/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 290;
					$config['height'] = 81;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize(); 
				}

				if($brand_logo!=''){
					$array_data['brand_logo'] = $brand_logo;
				}

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Artikel berhasil dirubah..</div>');
				redirect ('admin/brand');
				
			}
		} else {
			$this->mod->set_table_name('brand');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/brand/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('brand');
		$this->db->query('DELETE FROM product WHERE brand_id='.$id);
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus brand suplier<br></div>');
		redirect ('admin/brand');
	}

} // End Class