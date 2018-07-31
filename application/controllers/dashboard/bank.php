<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Bank extends MY_Controller
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
		$this->mod->set_table_name('bank');
		$data['list'] = $this->db->query('SELECT * FROM bank')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/bank/list', $data);
		$this->load->view('admin/layout/footer');
	} // End function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('bank');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('bank_name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('bank_rek', 'No Rekening', 'required|xss_clean');
			$this->form_validation->set_rules('bank_an', 'Atas nama', 'required|xss_clean');
			$this->form_validation->set_rules('bank_note', 'Note', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
		        $config['upload_path'] = "./upload/images/bank/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'bank_'.time();
		        $this->upload->initialize($config); 

				$array_data=array(
					'bank_name'=>$this->input->post('bank_name'),
					'bank_status'=>$this->input->post('bank_status'),
					'bank_rek'=>$this->input->post('bank_rek'),
					'bank_an'=>$this->input->post('bank_an'),
					'bank_note'=>$this->input->post('bank_note'),
					'bank_registration_date'=>date('Y-m-d')
				);

				if (!$this->upload->do_upload('bank_logo')) {
				
				}else{
					$bank_logo = $this->upload->file_name;
					$config['source_image']	= './upload/images/bank/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/bank/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($bank_logo!=''){
					$array_data['bank_logo'] = $bank_logo;
				}

				$this->mod->insert($array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah bank baru<br></div>');
				redirect ('dashboard/bank');
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/bank/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/bank/add');
			$this->load->view('admin/layout/footer');
		}
	} // End function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('bank');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('bank_name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('bank_rek', 'No Rekening', 'required|xss_clean');
			$this->form_validation->set_rules('bank_an', 'Atas nama', 'required|xss_clean');
			$this->form_validation->set_rules('bank_note', 'Note', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$config = array();
				$banklogo='';
		        $config['upload_path'] = "./upload/images/bank/";
		        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
		        $config['file_name'] = 'bank_'.time();
		        $this->upload->initialize($config);
		        
				$config['source_image']	= './upload/images/bank/'.$this->upload->file_name;
				$config['new_image'] = './upload/images/bank/'.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$this->image_lib->initialize($config); 
				$this->image_lib->resize(); 

				$array_data=array(
					'bank_name'=>$this->input->post('bank_name'),
					'bank_status'=>$this->input->post('bank_status'),
					'bank_rek'=>$this->input->post('bank_rek'),
					'bank_an'=>$this->input->post('bank_an'),
					'bank_note'=>$this->input->post('bank_note'),
					'bank_registration_date'=>date('Y-m-d')
				);

				if (!$this->upload->do_upload('bank_logo')) {
					
				}else{
					$bank_logo = $this->upload->file_name;
					$config['source_image']	= './upload/images/bank/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/bank/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
				}

				if($bank_logo!=''){
					$array_data['bank_logo'] = $bank_logo;
				}

				$this->mod->update($id,$array_data);
				$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Update bank<br></div>');
				redirect ('dashboard/bank');
				
			}
		} else {
			$this->mod->set_table_name('bank');
			$data['edit'] = $this->mod->get_by_id($id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/bank/edit', $data);
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function delete($id)
	{
		$this->mod->set_table_name('bank');
		$this->mod->delete($id);
		$this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus bank<br></div>');
		redirect('dashboard/bank');
	} // End function

} // End Class