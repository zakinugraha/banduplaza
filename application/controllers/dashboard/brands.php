<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Brands extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib'));
	}

	public function index()
	{
		$this->mod->set_table_name('brand');
		$data['list'] = $this->db->query('SELECT * FROM brand')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/brands/list', $data);
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
					$config['width'] = 290;
					$config['height'] = 81;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($brand_logo!=''){
					$array_data['brand_logo'] = $brand_logo;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah brand suplier baru<br></div>');
				redirect ('dashboard/brands');
				
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/brands/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/brands/add');
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
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update brand suplier<br></div>');
				redirect ('dashboard/brands');
				
			}
		} else {
			$this->mod->set_table_name('brand');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/brands/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('brand');
		$this->db->query('DELETE FROM product WHERE brand_id='.$id);
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus brand suplier<br></div>');
		redirect ('dashboard/brands');
	}

} // End Class