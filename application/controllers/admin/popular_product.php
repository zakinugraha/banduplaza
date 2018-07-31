<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Popular_product extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib', 'pagination'));
		$this->load->helper('indonesia_date');
		$this->limit = 10;
	}

	public function index()
	{
		redirect ('admin/popular_product/all');
	}

	public function all()
	{
		if ($this->input->post('apply')) {
			$to = date("Y-m-d", strtotime($this->input->post('to')));
			$from =  date("Y-m-d", strtotime($this->input->post('from')));
			$data['title_stats'] = 'Periode '.full_parsing_date($from).' - '.full_parsing_date($to);
			$data['start'] = $from;
			$data['start_last_month'] = date('Y-m-d', strtotime('-1 month', strtotime($to)));
			$data['end'] = $to;

			$data['nama_product'] = array();
			$data['total'] = array();
			$data['color'] = array();
			$data['list'] = $this->mod->custom_fetch_query('select distinct g.product_id, p.product_id, p.product_name, p.product_code from grafik_view g inner join product p on(g.product_id=p.product_id) where g.grafik_view_date between "'.$from.'" and "'.$to.'"');
			foreach ($data['list'] AS $hasil) {			
				$point = 0;
				$get = $this->db->query('SELECT * FROM grafik_view WHERE product_id="'.$hasil->product_id.'"')->result();
				foreach ($get AS $r) {
					$point += $r->grafik_view_point;
				}
				array_push($data['nama_product'],$hasil->product_name);
				array_push($data['total'],$point);
				array_push($data['color'],'#00a65a');
			}

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/popular_product/list', $data);
			$this->load->view('admin/layout/footer');

		} else {
			$to = date('Y-m-d');
			$from = date('Y-m-d', strtotime('-1 month', strtotime($to)));
			$data['title_stats'] = 'Periode '.parsing_month(date("m"));

			$data['start_last_month'] = date('Y-m-d', strtotime('-1 month', strtotime($to)));

			$data['nama_product'] = array();
			$data['total'] = array();
			$data['color'] = array();
			$data['list'] = $this->mod->custom_fetch_query('select distinct g.product_id, p.product_id, p.product_name, p.product_code from grafik_view g inner join product p on(g.product_id=p.product_id) where g.grafik_view_date between "'.$from.'" and "'.$to.'"');
			foreach ($data['list'] AS $hasil) {			
				$point = 0;
				$get = $this->db->query('SELECT * FROM grafik_view WHERE product_id="'.$hasil->product_id.'"')->result();
				foreach ($get AS $r) {
					$point += $r->grafik_view_point;
				}
				array_push($data['nama_product'],$hasil->product_name);
				array_push($data['total'],$point);
				array_push($data['color'],'#00a65a');
			}

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/popular_product/list', $data);
			$this->load->view('admin/layout/footer');
		}
			
	}

	public function stats()
	{
		$to = date("Y-m-d",strtotime($this->input->get('end')));
		$from = date("Y-m-d",strtotime($this->input->get('start')));

		// $to = "2018-05-04";
		// $from = "2018-05-7";

		$data['nama_product'] = array();
		$data['total'] = array();
		$data['color'] = array();
		$data['list_filter'] = $this->mod->custom_fetch_query('select distinct g.product_id, p.product_id, p.product_name, p.product_code from grafik_view g inner join product p on(g.product_id=p.product_id) where g.grafik_view_date between "'.$from.'" and "'.$to.'"');
		foreach ($data['list_filter'] AS $h) {			
			$point = 0;
			$g = $this->db->query('SELECT * FROM grafik_view WHERE product_id="'.$h->product_id.'"')->result();
			foreach ($g AS $rs) {
				$point += $rs->grafik_view_point;
			}
			array_push($data['nama_product'],$h->product_name);
			array_push($data['total'],$point);
			array_push($data['color'],'#00a65a');
		}

		$result = array_merge(array('nama'=>$data['nama_product'],'total'=>$data['total'],'color'=>$data['color']));
		// $result = array('from'=>$from,'to'=>$to);

		echo json_encode($result);
		// echo json_encode($data['total']);
		// echo json_encode($data['color']);


	}


}