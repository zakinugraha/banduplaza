<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Whatnew extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library('pagination');
		$this->limit = 18;
	}

	public function index()
	{
		$param = $this->uri->segment(1);
		$param_type = $this->uri->segment(2);
		$data['title'] = 'Whats New on Banduplaza - Pusat Sepatu dan Tas Terlengkap';

		if ($param!='') {
			if ($param_type=='' || is_numeric($param_type)) {
				$data['category'] = $this->db->query('SELECT * FROM type_nav_page')->result();
				$data['gender'] = $this->db->query('SELECT * FROM type_gender WHERE type_gender_id!="3"')->result();
				$data['brand'] = $this->db->query('SELECT brand_id, brand_name FROM brand WHERE brand_status="enabled" ORDER BY brand_name ASC')->result();

				// Initial for Product sort_by
				$cek = isset($_GET['sort_by']);
				$array_filter=array(
					'filter'=>isset($data['filter']['filter']) ? $data['filter']['filter'] : 'n',
					'sort_by'=>isset($data['filter']['sort_by']) ? $data['filter']['sort_by'] : 'n'
				);
				if ($cek) {
					switch($_GET['sort_by']) {
						case '':
					        $sort = ' ORDER BY product_update_date DESC';
					        $data['select'] = "Default";
					        break;
					    case 'default':
					        $sort = ' ORDER BY product_update_date DESC';
					        $data['select'] = "Default";
					        break;
					    case 'n':
					        $sort = ' ORDER BY product_update_date DESC';
					        $data['select'] = "Default";
					        break;
					    case 'newest':
					        $sort = ' ORDER BY product_update_date DESC';
					        $data['select'] = "Terbaru";
					        break;
					    case 'most-popular':
					        $sort = ' ORDER BY product_total_view DESC';
					        $data['select'] = "Terpopuler";
					        break;
					    case 'price-high':
					        $sort =' ORDER BY product_price_sell DESC';
					        $data['select'] = "Harga Tertinggi";
					        break;
					    case 'price-low':
					        $sort =' ORDER BY product_price_sell ASC';
					        $data['select'] = "Harga Terendah";
					        break;
					} // End switch
				} else {
					$array_filter['sort_by'] = '';
					$sort = ' ORDER BY product_update_date DESC';
				}

				// Initial Filter by Price	
				$array_filter=array(
					'price'=>isset($_GET['price']) ? $_GET['price'] : 'n',
					'sort_by'=>isset($_GET['sort_by']) ? $_GET['sort_by'] : 'n'
				);

				if (isset($_GET['price'])) {
					if ($array_filter['price']=="300000") {
						$price = ' && product_price_sell >= 300000';
						$data['check'] = "300000";
					} else if ($array_filter['price']=="200000,300000") {
						$price = ' && product_price_sell >= 200000 && product_price_sell < 300000';
						$data['check'] = "200000,300000";
					} else if ($array_filter['price']=="100000,200000") {
						$price = ' && product_price_sell >= 100000 && product_price_sell < 200000';
						$data['check'] = "100000,200000";
					} else if ($array_filter['price']=="100000") {
						$price = ' && product_price_sell < 100000';
						$data['check'] = "100000";
					} else if ($array_filter['price']=="" || $array_filter['price']=="n") {
						$price = '';
						$data['check'] = "";
					}
				} else {
					$price = '';
					$data['check'] = '0';
				}
				// Array
				$data['filter'] = $array_filter;

				// List Product
				$offset = ($this->uri->segment(2)!='')?$this->uri->segment(2):0;
				$date_now = date("Y-m-d H:i:s");
				$date_last = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($date_now)));
				$data['list'] = $this->db->query('SELECT * FROM product WHERE product_create_date BETWEEN "'.$date_last.'" AND "'.$date_now.'" && product_status="publish"'.$price.' '.$sort.' LIMIT '.$this->limit.' offset '.$offset)->result();
				$data['count'] = $this->db->query('SELECT * FROM product WHERE product_create_date BETWEEN "'.$date_last.'" AND "'.$date_now.'" && product_status="publish"'.$price)->num_rows();
				if ($data['count']==0) {
					$data['empty'] = '<div class="no-products"><span class="no_available_products">No product available in this category</span></div>';
				} else {
					$data['empty'] = "";
				}

				// Show total product pagination
				if ($data['count'] <= $this->limit && $data['count'] > 0) {
					$data['from'] = '1';
					$data['to'] = $data['count'];
				} else if ($data['count'] > $this->limit) {
					if ($offset=='') {
						$data['from'] = '1';
						$data['to'] = $this->limit;
					} else {
						$data['from'] = $offset+1;
						if (($data['from']+$this->limit) < $data['count']) {
							$data['to'] = $offset+($this->limit);
						} else {
							$data['to'] = $data['count'];
						}
					}
				} else if ($data['count'] == 0) {
					$data['from'] = '0';
					$data['to'] = '0';
				}

				$config['base_url'] = base_url().'whatnew/';
				$config['total_rows'] = $data['count'];
				$config['uri_segment'] = 2;
				$config['per_page'] = $this->limit;
				$config['addtional_params'] = isset($data['filter']) ? '?price='.$data['filter']['price'].'&sort_by='.$data['filter']['sort_by'] : '';
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

				$this->load->view('layout/header_content', $data);
				$this->load->view('whatnew', $data);
				$this->load->view('layout/footer');	
			} else {
				/**
					Jika $param_type / uri_segment(3) tidak koson
				*/
				
				$data['category'] = $this->db->query('SELECT * FROM type_nav_page')->result();
				$data['gender'] = $this->db->query('SELECT * FROM type_gender WHERE type_gender_id!="3"')->result();
				$data['brand'] = $this->db->query('SELECT brand_id, brand_name FROM brand WHERE brand_status="enabled" ORDER BY brand_name ASC')->result();

				// Initial for Product sort_by
				$cek = isset($_GET['sort_by']);
				$array_filter=array(
					'filter'=>isset($data['filter']['filter']) ? $data['filter']['filter'] : 'n',
					'sort_by'=>isset($data['filter']['sort_by']) ? $data['filter']['sort_by'] : 'n'
				);
				if ($cek) {
					switch($_GET['sort_by']) {
						case '':
					        $sort = ' ORDER BY product_id DESC';
					        $data['select'] = "Default";
					        break;
					    case 'default':
					        $sort = ' ORDER BY product_id DESC';
					        $data['select'] = "Default";
					        break;
					    case 'n':
					        $sort = ' ORDER BY product_id DESC';
					        $data['select'] = "Default";
					        break;
					    case 'newest':
					        $sort = ' ORDER BY product_update_date DESC';
					        $data['select'] = "Terbaru";
					        break;
					    case 'most-popular':
					        $sort = ' ORDER BY product_total_view DESC';
					        $data['select'] = "Terpopuler";
					        break;
					    case 'price-high':
					        $sort =' ORDER BY product_price_sell DESC';
					        $data['select'] = "Harga Tertinggi";
					        break;
					    case 'price-low':
					        $sort =' ORDER BY product_price_sell ASC';
					        $data['select'] = "Harga Terendah";
					        break;
					} // End switch
				} else {
					$array_filter['sort_by'] = '';
					$sort = ' ORDER BY product_update_date DESC';
				}

				// Initial Filter by Price	
				$array_filter=array(
					'price'=>isset($_GET['price']) ? $_GET['price'] : 'n',
					'sort_by'=>isset($_GET['sort_by']) ? $_GET['sort_by'] : 'n'
				);

				if (isset($_GET['price'])) {
					if ($array_filter['price']=="300000") {
						$price = ' && product_price_sell >= 300000';
						$data['check'] = "300000";
					} else if ($array_filter['price']=="200000,300000") {
						$price = ' && product_price_sell >= 200000 && product_price_sell < 300000';
						$data['check'] = "200000,300000";
					} else if ($array_filter['price']=="100000,200000") {
						$price = ' && product_price_sell >= 100000 && product_price_sell < 200000';
						$data['check'] = "100000,200000";
					} else if ($array_filter['price']=="100000") {
						$price = ' && product_price_sell < 100000';
						$data['check'] = "100000";
					} else if ($array_filter['price']=="" || $array_filter['price']=="n") {
						$price = '';
						$data['check'] = "";
					}
				} else {
					$price = '';
					$data['check'] = '0';
				}
				// Array
				$data['filter'] = $array_filter;

				// Get type_gender_id
				$get_gender = $this->db->query('SELECT * FROM type_gender WHERE type_gender_name="'.$param_type.'" LIMIT 1')->row();
				$gender_id = $get_gender->type_gender_id;

				// List Product
				$offset = ($this->uri->segment(3)!='')?$this->uri->segment(3):0;
				$date_now = date("Y-m-d H:i:s");
				$date_last = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($date_now)));
				$data['list'] = $this->db->query('SELECT * FROM product WHERE product_create_date BETWEEN "'.$date_last.'" AND "'.$date_now.'" && (type_gender_id="'.$gender_id.'" || type_gender_id="3") && product_status="publish"'.$price.' '.$sort.' LIMIT '.$this->limit.' offset '.$offset)->result();
				$data['count'] = $this->db->query('SELECT * FROM product WHERE product_create_date BETWEEN "'.$date_last.'" AND "'.$date_now.'" && (type_gender_id="'.$gender_id.'" || type_gender_id="3") && product_status="publish"'.$price)->num_rows();
				if ($data['count']==0) {
					$data['empty'] = '<div class="no-products"><span class="no_available_products">No product available in this category</span></div>';
				} else {
					$data['empty'] = "";
				}

				// Show total product pagination
				if ($data['count'] <= $this->limit && $data['count'] > 0) {
					$data['from'] = '1';
					$data['to'] = $data['count'];
				} else if ($data['count'] > $this->limit) {
					if ($offset=='') {
						$data['from'] = '1';
						$data['to'] = $this->limit;
					} else {
						$data['from'] = $offset+1;
						if (($data['from']+$this->limit) < $data['count']) {
							$data['to'] = $offset+($this->limit);
						} else {
							$data['to'] = $data['count'];
						}
					}
				} else if ($data['count'] == 0) {
					$data['from'] = '0';
					$data['to'] = '0';
				}

				$config['base_url'] = base_url().'whatnew/'.$param_type.'/';
				$config['total_rows'] = $data['count'];
				$config['uri_segment'] = 3;
				$config['per_page'] = $this->limit;
				$config['addtional_params'] = isset($data['filter']) ? '?price='.$data['filter']['price'].'&sort_by='.$data['filter']['sort_by'] : '';
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

				$this->load->view('layout/header_content', $data);
				$this->load->view('whatnew', $data);
				$this->load->view('layout/footer');	
			}
		} else {
			redirect (base_url());
		}
	} // End function
	

}