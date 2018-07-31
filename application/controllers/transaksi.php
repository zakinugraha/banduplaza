<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Transaksi extends CI_Controller
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
		$cek_customer = isset($_SESSION['user_customer']);
		if ($cek_customer) {
			if ($this->uri->segment(2)!="detail" || $this->uri->segment(2)=="") {
				$c_id = base64_decode($_SESSION['user_customer']['customer_id']);
				$offset = ($this->uri->segment(2)!='')?$this->uri->segment(2):0;
				$data['list'] = $query = $this->db->query('select i .*, i.invoice_number, i.invoice_shipping, i.invoice_grand_total, i.invoice_date_order, i.invoice_status_id, i.invoice_resi_number, s.invoice_status_id, s.invoice_status_name from invoice i inner join invoice_status s on (i.invoice_status_id=s.invoice_status_id) where i.customer_id="'.$c_id.'" order by i.invoice_date_order DESC LIMIT '.$this->limit.' offset '.$offset)->result();
				$data['count'] = $query = $this->db->query('select i .*, i.invoice_number, i.invoice_shipping, i.invoice_grand_total, i.invoice_date_order, i.invoice_status_id, i.invoice_resi_number, s.invoice_status_id, s.invoice_status_name from invoice i inner join invoice_status s on (i.invoice_status_id=s.invoice_status_id) where i.customer_id="'.$c_id.'"')->num_rows();

				$config['base_url'] = base_url().'transaksi/';
				$config['total_rows'] = $data['count'];
				$config['uri_segment'] = 2;
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

				$this->load->view('layout/header');
				$this->load->view('transaksi', $data);
				$this->load->view('layout/footer');
			} else {
				$invoice = $this->input->get('invoice');
				$data['list'] = $this->db->query('select s .*, s.product_id, s.invoice_number, s.product_size, s.product_qty, s.product_size, s.product_price, s.product_price_discount, p.product_id, p.product_name, p.product_code from summary_order s inner join product p on (s.product_id=p.product_id) where s.invoice_number="'.$invoice.'" order by s.summary_order_id ASC')->result();
				$data['detail'] = $this->db->query('select i.*, i.invoice_id, i.customer_id, i.invoice_number, i.invoice_shipping, i.invoice_status_id, i.invoice_discount, i.invoice_grand_total, i.invoice_date_order, i.invoice_date_expired, invoice_status_id, c.customer_id, c.customer_name, c.customer_phone from invoice i inner join customer c on (i.customer_id=c.customer_id) where i.invoice_number="'.$invoice.'"')->row();
				$data['status'] = $this->db->query('SELECT * FROM invoice_status WHERE invoice_status_id="'.$data['detail']->invoice_status_id.'" LIMIT 1')->row();
				$data['address'] = $this->db->query('SELECT * FROM address WHERE customer_id="'.$data['detail']->customer_id.'" LIMIT 1')->row();
				$data['province'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="0" && area_api_id="'.$data['address']->province.'" LIMIT 1')->row();
				$data['city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['province']->area_api_id.'" && area_api_id="'.$data['address']->city.'" LIMIT 1')->row();

				$this->load->view('layout/header');
				$this->load->view('detail_transaksi', $data);
				$this->load->view('layout/footer');
			}
		} else {
			redirect(base_url());
		}
		
	}


} // End Class