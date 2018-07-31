<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Size_chart extends MY_Controller
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
		redirect ('admin/size_chart/all');
	}

	public function all()
	{
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
		$data['list'] = $this->db->query('select s.*, s.size_chart_id, s.size_chart_content, s.brand_id, s.type_nav_page_id, b.brand_id, b.brand_name, t.type_nav_page_id, t.type_nav_page_name from size_chart s inner join brand b on (s.brand_id=b.brand_id) inner join type_nav_page t on (s.type_nav_page_id=t.type_nav_page_id) order by t.type_nav_page_name DESC LIMIT '.$this->limit.' offset '.$offset)->result();
		$data['count'] = $this->db->query('SELECT * FROM size_chart')->num_rows();

		$config['base_url'] = base_url().'admin/size_chart/all/page/';
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
		$this->load->view('admin/size_chart/list', $data);
		$this->load->view('admin/layout/footer');
	}

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('size_chart');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('brand_id', 'Brand', 'required|xss_clean');
			$this->form_validation->set_rules('type_nav_page_id', 'Item', 'required|xss_clean');
			$this->form_validation->set_rules('size_chart_content', 'Size Chart Content', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {

				$array_data=array(
					'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'brand_id'=>$this->input->post('brand_id'),
					'size_chart_content'=>$this->input->post('size_chart_content')
				);

				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah size chart<br></div>');
				redirect ('admin/size_chart');
				
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/size_chart/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/size_chart/add');
			$this->load->view('admin/layout/footer');
		} // End If
		
	} 

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('size_chart');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('brand_id', 'Brand', 'required|xss_clean');
			$this->form_validation->set_rules('type_nav_page_id', 'Item', 'required|xss_clean');
			$this->form_validation->set_rules('size_chart_content', 'Size Chart Content', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {

				$array_data=array(
					'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'brand_id'=>$this->input->post('brand_id'),
					'size_chart_content'=>$this->input->post('size_chart_content')
				);

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update Size Chart<br></div>');
				redirect ('admin/size_chart');
				
			}
		} else {
			$this->mod->set_table_name('size_chart');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/size_chart/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('size_chart');
		$this->db->query('DELETE FROM size_chart WHERE size_chart_id='.$id);
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus size_chart<br></div>');
		redirect ('admin/size_chart');
	}

} // End Class