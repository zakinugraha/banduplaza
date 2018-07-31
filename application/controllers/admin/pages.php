<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Pages extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib', 'pagination'));
		$this->load->helper('indonesia_date');
		$this->limit = 5;
	}

	public function index(){
		redirect ('admin/pages/all');
	}

	public function all()
	{
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
		$data['list'] = $this->db->query('SELECT * FROM pages LIMIT '.$this->limit.' offset '.$offset)->result();
		$data['count'] = $this->db->query('SELECT * FROM pages')->num_rows();

		$config['base_url'] = base_url().'admin/pages/all/page/';
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
		$this->load->view('admin/pages/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('pages_title', 'Title', 'required|xss_clean');
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
				redirect('admin/pages');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/pages/add');
			$this->load->view('admin/layout/footer');
		} else { // Pertama kali dibuka
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/pages/add');
			$this->load->view('admin/layout/footer');
		}
			
	} // End function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('pages_title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('pages_content', 'Content', 'required|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$array_data=array(
					'pages_title'=>$this->input->post('pages_title'),
					'pages_content'=>$this->input->post('pages_content'),
				);
				$this->mod->set_table_name('pages');
				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses edit halaman<br></div>');
				redirect('admin/pages');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/pages/edit');
			$this->load->view('admin/layout/footer');
		} else {
			$this->mod->set_table_name('pages');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/pages/edit', $data);
			$this->load->view('admin/layout/footer');
		}
			
	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('pages');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus halaman<br></div>');
		redirect('admin/pages');
	}

} // End class