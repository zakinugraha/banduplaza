<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Blog extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('blog');
		$this->load->view('layout/footer');
	}

	public function content($id)
	{
		$data['content'] = $this->db->query('SELECT * FROM blogcontent WHERE blogcontent_sess="'.$this->uri->segment(3).'" LIMIT 1')->row();
		$data['title'] = $data['content']->blogcontent_title.' - Blog Banduplaza Pusat Sepatu dan Tas Terlengkap';
		// Initial artikel populer dan artikel terkail
		$data['most_popular'] = $this->db->query('SELECT * FROM blogcontent WHERE blogcontent_status="publish" && blogcontent_sess!="'.$this->uri->segment(3).'" ORDER BY blogcontent_view DESC LIMIT 1')->row();
		$data['popular'] = $this->db->query('SELECT * FROM blogcontent WHERE blogcontent_status="publish" && blogcontent_id!="'.$data['most_popular']->blogcontent_id.'" && blogcontent_sess!="'.$this->uri->segment(3).'" ORDER BY blogcontent_view DESC LIMIT 4')->result();

		// Update total view
		$view_now=$data['content']->blogcontent_view+1;
		$this->db->query('UPDATE blogcontent SET blogcontent_view="'.$view_now.'" WHERE blogcontent_sess='.$this->uri->segment(3));

		$this->load->view('layout/header_blog', $data);
		$this->load->view('blog_content', $data);
		$this->load->view('layout/footer');
	}

}