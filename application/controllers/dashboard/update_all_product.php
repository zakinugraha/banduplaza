<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Update_all_product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->model('api_stock_mdl', 'scr');
	}

	public function index()
	{
		$product = $this->db->query('SELECT * FROM product WHERE brand_id!="10" && product_source_size="1"')->result();
		$get_api = $this->db->query('SELECT * FROM configuration WHERE configuration_id="1"')->row();
		$apikey = $get_api->configuration_value;
		foreach ($product AS $data) {
			$kode_api = str_replace(" ", "%20", strtolower($data->product_code));
			$url = trim($this->scr->grab_page('http://bandros.id/stok_api/produk/search/?apikey='.$apikey.'&kode='.$kode_api));
			$json = $url;
			$json = json_decode($json);
			$stock = $json->result[0]->stok;

			$get_id = $this->db->query('SELECT * FROM product WHERE product_code="'.$data->product_code.'"')->row();
			$product_id = $get_id->product_id;
			
			$list = $stock;
			foreach ($list AS $row) {
				$ukuran = $row->ukuran=="AS" ? "ALL SIZE" : $row->ukuran;				
				$size_value = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_value="'.$ukuran.'"')->row();
				$sm_id = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$product_id.'" && size_attributes_id="'.$size_value->size_attributes_id.'"')->row();
				$this->db->query('UPDATE stock_management SET product_id = '.$product_id.', size_attributes_id = '.$size_value->size_attributes_id.', stock_management_value = '.$row->stok.' WHERE stock_management_id ='.$sm_id->stock_management_id);
				echo $data->product_id.' - '.$data->product_code.'<br>';
			}
		}

		// Send mail after updating
		$body = 'Updating process successful.<br>Last Update '.date('Y-m-d H:i:s').'<br><br>Send by System';
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply@banduplaza.com', 'Banduplaza');
		$this->email->to('zaki@banduplaza.com');
		$this->email->subject('Updating Management Stock');
		$this->email->message($body);
		$this->email->set_mailtype("html");
		$this->email->send();

	} // End function

} // End class