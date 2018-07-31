<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class List_email extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$this->mod->set_table_name('list_email');
		$list = $this->db->query('SELECT * FROM list_email')->result();
		foreach ($list AS $row) {
			echo $row->list_email_id.' - '.$row->list_email_value.'<br>';
		}
	}

	public function insert()
	{
		$lines = file(base_url().'assets/email.txt'); 
		$json=json_encode($lines);
		$parser=explode(",", $json);
		$this->mod->set_table_name('list_email');
		for($no=0; $no<=590; $no++) {
			$array_data=array(
				'list_email_value'=>$parser[$no]
			);
			$this->mod->insert($array_data);
		}
		
	}

}