<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Blogcontent extends MY_Controller
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
		$this->mod->set_table_name('blogcontent');
		$data['list'] = $this->mod->custom_fetch_query('select a.*,o.blogcategory_id, o.blogcontent_sess, o.blogcontent_id, o.blogcontent_thumb, o.blogcontent_title, o.blogcontent_short_desc, o.blogcontent_description, o.blogcontent_date, o.blogcontent_status, a.blogcategory_id from blogcontent o inner join blogcategory a on (o.blogcategory_id=a.blogcategory_id) order by blogcontent_date desc');

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/blogcontent/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('blogcontent');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('blogcategory_id', 'Kategori Artikel', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_title', 'Judul Artikel', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_short_desc', 'Deskripsi Singkat', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_description', 'Isi Artikel', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_permalink', 'Permalink', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_status', 'Status', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
		        $config['upload_path'] = "./upload/images/artikel/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'artikel_'.time();
		        $this->upload->initialize($config); 

				$array_data=array(
					'blogcategory_id'=>$this->input->post('blogcategory_id'),
					'blogcontent_sess'=>time(),
					'blogcontent_title'=>$this->input->post('blogcontent_title'),
					'blogcontent_short_desc'=>$this->input->post('blogcontent_short_desc'),
					'blogcontent_description'=>$this->input->post('blogcontent_description'),
					'blogcontent_permalink'=>$this->input->post('blogcontent_permalink'),
					'blogcontent_status'=>$this->input->post('blogcontent_status'),
					'blogcontent_date'=>date('Y-m-d H:i:s')
				);

				if (!$this->upload->do_upload('blogcontent_thumb')) {
				
				}else{
					$blogcontent_thumb = $this->upload->file_name;
					$config['source_image']	= './upload/images/artikel/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/artikel/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 400;
					$config['height'] = 400;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($blogcontent_thumb!=''){
					$array_data['blogcontent_thumb'] = $blogcontent_thumb;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Tambah Artikel baru<br></div>');
				redirect('dashboard/blogcontent');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/blogcontent/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/blogcontent/add');
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('blogcontent');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('blogcategory_id', 'Kategori Artikel', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_title', 'Judul Artikel', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_description', 'Isi Artikel', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_short_desc', 'Deskripsi Singkat', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_permalink', 'Permalink', 'required|xss_clean');
			$this->form_validation->set_rules('blogcontent_status', 'Status', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
		        $config['upload_path'] = "./upload/images/artikel/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'artikel_'.time();
		        $this->upload->initialize($config); 
		        
				$config['source_image']	= './upload/images/artikel/'.$this->upload->file_name;
				$config['new_image'] = './upload/images/artikel/'.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 400;
				$config['height'] = 400;
				$this->image_lib->initialize($config); 
				$this->image_lib->resize(); 

				$array_data=array(
					'blogcategory_id'=>$this->input->post('blogcategory_id'),
					'blogcontent_title'=>$this->input->post('blogcontent_title'),
					'blogcontent_short_desc'=>$this->input->post('blogcontent_short_desc'),
					'blogcontent_description'=>$this->input->post('blogcontent_description'),
					'blogcontent_permalink'=>$this->input->post('blogcontent_permalink'),
					'blogcontent_status'=>$this->input->post('blogcontent_status'),
					'blogcontent_date'=>date('Y-m-d H:i:s')
				);

				if (!$this->upload->do_upload('blogcontent_thumb')) {
					
				}else{
					$blogcontent_thumb = $this->upload->file_name;
					$config['source_image']	= './upload/images/artikel/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/artikel/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 400;
					$config['height'] = 400;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($blogcontent_thumb!=''){
					$array_data['blogcontent_thumb'] = $blogcontent_thumb;
				}

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update Artikel<br></div>');
				redirect ('dashboard/blogcontent');
				
			}
		} else {
			$this->mod->set_table_name('blogcontent');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/blogcontent/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('blogcontent');
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Hapus Artikel<br></div>');
		redirect ('dashboard/blogcontent');
	}

}