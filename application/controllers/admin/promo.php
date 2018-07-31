<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Promo extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library('pagination');
		$this->limit = 5;
	}

	public function index()
	{
		redirect ('admin/promo/all');
	}

	public function all()
	{
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
		$data['list'] = $this->db->query('SELECT * FROM promo WHERE promo_id!=1 ORDER BY promo_id DESC LIMIT '.$this->limit.' offset '.$offset)->result();
		$data['count'] = $this->db->query('SELECT * FROM promo')->num_rows();

		$config['base_url'] = base_url().'admin/promo/all/page/';
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
		$this->load->view('admin/promo/list', $data);
		$this->load->view('admin/layout/footer');
	} // End Function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya boleh diisi angka.');
			$this->form_validation->set_rules('promo_label', 'Label', 'required|xss_clean');
			$this->form_validation->set_rules('promo_discount_type', 'Type Diskon', 'required|xss_clean');
			$this->form_validation->set_rules('promo_value', 'Value', 'required|numeric|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'promo_label'=>$this->input->post('promo_label'),
					'promo_discount_type'=>$this->input->post('promo_discount_type'),
					'promo_value'=>$this->input->post('promo_value')
				);
				$this->mod->set_table_name('promo');
				$this->mod->insert($array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah promo baru<br></div>');
				redirect('admin/promo');
			}
			// Jika validasi gagal, maka...
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/promo/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/promo/add');
			$this->load->view('admin/layout/footer');
		}
			
	} // End Function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya boleh diisi angka.');
			$this->form_validation->set_rules('promo_label', 'Label', 'required|xss_clean');
			$this->form_validation->set_rules('promo_discount_type', 'Type Diskon', 'required|xss_clean');
			$this->form_validation->set_rules('promo_value', 'Value', 'required|numeric|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'promo_label'=>$this->input->post('promo_label'),
					'promo_discount_type'=>$this->input->post('promo_discount_type'),
					'promo_value'=>$this->input->post('promo_value')
				);
				$this->mod->set_table_name('promo');
				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Ubah promo<br></div>');
				redirect('admin/promo');
			}
			// Jika validasi gagal, maka...
			$this->mod->set_table_name('promo');
			$data['promo'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/promo/edit', $data);
			$this->load->view('admin/layout/footer');
		} else {
			$this->mod->set_table_name('promo');
			$data['promo'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/promo/edit', $data);
			$this->load->view('admin/layout/footer');
		}
			
	} // End Function

	public function delete($id)
	{
		$this->mod->set_table_name('promo');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Hapus Promo<br></div>');
		redirect('admin/promo');
	}

} // End Class