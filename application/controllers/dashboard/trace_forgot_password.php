<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Trace_forgot_password extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$now = date('Y-m-d H:i:s');
		$cek = $this->db->query('SELECT * FROM customer WHERE customer_date_reset_expired<"'.$now.'" && customer_unicode!=""')->result();
		foreach ($cek AS $row) {
			$array_data=array(
				'customer_unicode'=>"",
				'customer_date_reset'=>"",
				'customer_date_reset_expired'=>""
			);
			$this->mod->set_table_name('customer');
			$this->mod->update($row->customer_id,$array_data);
		} // End foreach

	} // End function


} // End class