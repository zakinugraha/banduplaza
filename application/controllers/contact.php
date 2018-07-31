<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Contact extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus disi');
			$this->form_validation->set_rules('name', 'Nama', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
			$this->form_validation->set_rules('judul', 'Judul', 'required|xss_clean');
			$this->form_validation->set_rules('pesan', 'Pesan', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'contact_name'=>$this->input->post('name'),
					'contact_email'=>$this->input->post('email'),
					'contact_judul'=>$this->input->post('judul'),
					'contact_pesan'=>$this->input->post('pesan'),
					'contact_status'=>"check",
					'contact_date'=>date("Y-m-d H:i:i")
				);
				$this->mod->set_table_name('contact');
				$this->mod->insert($array_data);

				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'zakinugraha001@gmail.com',
					'smtp_pass' => 'zakinugraha5150',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
				);

				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from($this->input->post('email'), $this->input->post('name'));
				$this->email->to('customerservice@banduplaza.com');
				$this->email->subject('Ask : '.$this->input->post('judul'));
				$this->email->message($this->input->post('pesan'));
				$this->email->set_mailtype("html");
				$this->email->send();

				$this->session->set_flashdata('success', '<div class="attention-success"><i class="fa fa-check-circle"></i> Pesan/pertanyaan anda berhasil dikirim.</div>');
				redirect ('contact');
			}
			// Jika validasi gagal
			$this->load->view('layout/header');
			$this->load->view('contact');
			$this->load->view('layout/footer');
		} else { // pertama kali di load
			$this->load->view('layout/header');
			$this->load->view('contact');
			$this->load->view('layout/footer');
		} // end if
			
	} // end function

}