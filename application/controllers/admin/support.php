<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Support extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date_helper');
		$this->load->library('pagination');
		$this->limit = 10;
	}

	public function index()
	{
		redirect ('admin/support/all');
	}

	public function all()
	{
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
		$data['list'] = $this->db->query('SELECT * FROM support LIMIT '.$this->limit.' offset '.$offset)->result();	
		$data['count'] = $this->db->query('SELECT * FROM support')->num_rows();

		$config['base_url'] = base_url().'admin/support/all/page/';
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
		$this->load->view('admin/support/list', $data);
		$this->load->view('admin/layout/footer');
	}
	
	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya boleh diisi angka.');
			$this->form_validation->set_message('is_unique', '%s sudah terdaftar.');
			$this->form_validation->set_rules('support_title', 'Judul Halaman', 'required|xss_clean');
			$this->form_validation->set_rules('support_content', 'Konten Halaman', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'support_sess'=>time(),
					'support_title'=>$this->input->post('support_title'),
					'support_content'=>$this->input->post('support_content'),
					'support_date'=>date('Y-m-d H:i:s')
				);
				$this->mod->set_table_name('support');
				$this->mod->insert($array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Tambah Data<br></div>');
				redirect('admin/support');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/support/add');
			$this->load->view('admin/layout/footer');
		} else {
			// Pertama kali di load
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/support/add');
			$this->load->view('admin/layout/footer');
		}
		
	} // End funtion
	
	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya boleh diisi angka.');
			$this->form_validation->set_message('is_unique', '%s sudah terdaftar.');
			$this->form_validation->set_rules('support_title', 'Judul Halaman', 'required|xss_clean');
			$this->form_validation->set_rules('support_content', 'Konten Halaman', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'support_title'=>$this->input->post('support_title'),
					'support_content'=>$this->input->post('support_content'),
					'support_date'=>date('Y-m-d H:i:s')
				);
				$this->mod->set_table_name('support');
				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Ubah Data<br></div>');
				redirect('admin/support');
			}
			// Jika validasi gagal
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/support/edit', $data);
			$this->load->view('admin/layout/footer');
		} else {
			// Pertama kali di load
			$this->mod->set_table_name('support');
			$data['edit'] = $this->mod->get_by_id($id);
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/support/edit', $data);
			$this->load->view('admin/layout/footer');
		}
		
	} // End funtion
	
	public function delete($id)
	{
		$this->mod->set_table_name('support');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Hapus Data<br></div>');
		redirect ('admin/support');	
	}
	

}