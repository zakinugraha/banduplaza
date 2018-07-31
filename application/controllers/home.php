<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$data['title'] = 'Pusat Sepatu dan Tas Terlengkap';
		if (!empty($_POST)) {
			$email=$this->input->get('email_subs_home');
			$array_data=array(
				'subscribe_email'=>$email,
				'subscribe_source'=>'1'
			);
			$this->mod->set_table_name('subscribe');
			$this->mod->insert($array_data);
			echo json_encode($array_data);
		} else {
			$data['blog'] = $this->db->query('SELECT blogcontent_id, blogcontent_sess, blogcontent_thumb, blogcontent_label, blogcontent_title, blogcontent_short_desc, blogcontent_status FROM blogcontent WHERE blogcontent_status="publish" ORDER BY blogcontent_date DESC')->result();
			$this->load->view('layout/header', $data);
			$this->load->view('home', $data);
			$this->load->view('layout/footer');
		}
	} // End Function

	public function get()
	{
		$from = $this->input->get('from');
		echo $from;
	}

} // End Class