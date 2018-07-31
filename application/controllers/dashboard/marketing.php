<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Marketing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function email()
	{
		$this->load->view('admin/marketing/email');
	}

	public function send()
	{
		$email = $this->db->query('SELECT * FROM list_email')->result();
		foreach ($email AS $row) {
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

			$body=$this->load->view('admin/marketing/email',TRUE);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('zakinugraha001@gmail.com', 'Banduplaza');
			$this->email->to('gis_zaki@ymail.com');
			// $this->email->to($row->list_email_value);
			$this->email->subject('Mumpung lagi diskon!');
			$this->email->message($body);
			$this->email->set_mailtype("html");
			$this->email->send();
		} // End foreach
			
	}


} // End class