<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Update extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->model('api_stock_mdl', 'scr');
	}

	/**
		Insert stock
		Penting! Sebelum melakukan insert stock, kosongkan dahulu tabel stock_management
	*/
	public function index() // Add
	{
		$product = $this->db->query('SELECT * FROM product WHERE brand_id!="10"')->result();
		$get_api = $this->db->query('SELECT * FROM configuration WHERE configuration_id="1"')->row();
		$apikey = $get_api->configuration_value;
		foreach ($product AS $data) {
			$kode_api = str_replace(" ", "%20", $data->product_code);
			$url = trim($this->scr->grab_page('http://bandros.id/stok_api/produk/search/?apikey='.$apikey.'&kode='.$kode_api));
			$json = $url;
			$json = json_decode($json);
			$stock = $json->result[0]->stok;

			$get_id = $this->db->query('SELECT * FROM product WHERE product_code="'.$data->product_code.'"')->row();
			$product_id = $get_id->product_id;
			
			$list = $stock;
			foreach ($list AS $row) {
				$ukuran = $row->ukuran=="ALL SIZE" || $row->ukuran=="AS" ? "ALL SIZE" : $row->ukuran;
				$size_value = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_value="'.$ukuran.'"')->row();
				$cek_id = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$product_id.'" && size_attributes_id="'.$size_value->size_attributes_id.'"')->num_rows();
				if ($cek_id>0) {
					// Do nothing
				} else {
					$this->mod->set_table_name('stock_management');
					$array_data=array(
						'product_id'=>$product_id,
						'size_attributes_id'=>$size_value->size_attributes_id,
						'stock_management_value'=>$row->stok
					);
					$this->mod->insert($array_data);
					echo $product_id.' - '.$data->product_code.'<br>';
				}				
			} // End 

		} // End foreach		
	
	} // End function

	public function allproduct() // Edit
	{
		if ($this->input->post('submit')) {
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

			$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses update all product<br></div>');
			redirect('dashboard/update/percode');

		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/curl/all_products');
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function perbrand()
	{
		if ($this->input->post('submit')) {
			$brand = $this->input->post('update_brand'); // Change brand_id here...
			$brand_name = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$brand.'" && product_source_size="1" LIMIT 1')->row();
			$product = $this->db->query('SELECT * FROM product WHERE brand_id="'.$brand.'"')->result();
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
					echo "<pre>";
					print_r($data->product_id.' - '.$data->product_code.'<br>');
					echo "</pre>";
				} // End foreach
			} // End foreach

			$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses update stock brand '.$brand_name->brand_name.'<br></div>');
			//redirect('dashboard/update/perbrand');

		} else {
			$this->mod->set_table_name('brand');
			$data['brand'] = $this->db->query('SELECT * FROM brand WHERE brand_id!="10"')->result();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/curl/per_brand', $data);
			$this->load->view('admin/layout/footer');
		}
			

	} // End function

	public function percode()
	{
		if ($this->input->post('submit')) {
			$kode = $this->input->post('update_code');
			$get = $this->db->query('SELECT * FROM product WHERE product_code="'.$kode.'" && product_source_size="1" LIMIT 1')->row(); // Get initial product
			$product_id = $get->product_id; // Get product_id
			$get_api = $this->db->query('SELECT * FROM configuration WHERE configuration_id="1"')->row();
			$apikey = $get_api->configuration_value;

			$kode_api = str_replace(" ", "%20", strtolower($kode));
			$url = trim($this->scr->grab_page('http://bandros.id/stok_api/produk/search/?apikey='.$apikey.'&kode='.$kode_api));
			$json = $url;
			$json = json_decode($json);
			$stock = $json->result[0]->stok;

			foreach ($stock AS $row) {		
				$ukuran = $row->ukuran=="AS" ? "ALL SIZE" : $row->ukuran;
				$size_attributes = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_value="'.$ukuran.'"')->row(); // Initial size_attributes
				$size_attributes_id = $size_attributes->size_attributes_id; // Size attributes_id
				$stok_management = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$product_id.'" && size_attributes_id="'.$size_attributes_id.'" LIMIT 1')->row();
				$sm_id = $stok_management->stock_management_id; // Stock_management_id
				$this->db->query('UPDATE stock_management SET stock_management_value = '.$row->stok.' WHERE stock_management_id = "'.$sm_id.'"');
				echo 'Update for sm_id : '.$sm_id.' - product id : '.$product_id.' - Size attributes id : '.$size_attributes_id.' success!<br>';
				echo 'Size : '.$row->ukuran.', Stock - '.$row->stok.'<br>';
				// echo $stok_management->stock_management_id;
			}	
			$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses update product per code<br></div>');
			// redirect('dashboard/update/percode');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/curl/per_code');
			$this->load->view('admin/layout/footer');
		}

	} // End function

	public function apikey()
	{
		if ($this->input->post('submit')) {
			$array_data=array(
				'configuration_value'=>$this->input->post('apikey')
			);
			$this->mod->set_table_name('configuration');
			$this->mod->update("1",$array_data);
			$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses update API Key<br></div>');
			redirect('dashboard/update/apikey');
		} else {
			$data['view'] = $this->db->query('SELECT * FROM configuration WHERE configuration_id="1"')->row();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/curl/apikey', $data);
			$this->load->view('admin/layout/footer');
		}
	}

	public function test()
	{
		$get_api = $this->db->query('SELECT * FROM configuration WHERE configuration_id="1"')->row();
		$apikey = $get_api->configuration_value; // Kode API
		// $kode_api = str_replace(" ", "%20", strtolower($view->product_code)); // Kode Produk
		$kode_api = str_replace(" ", "%20", strtolower("TMS 097")); // Kode Produk
		$url = trim($this->scr->grab_page('http://bandros.id/stok_api/produk/search/?apikey='.$apikey.'&kode='.$kode_api));
		$json = $url;
		$json = json_decode($json);
		$stock = $json->result[0]->stok;
		foreach ($stock AS $row) {
			echo $row->ukuran.' - '.$row->stok.'<br>';
		}
		// echo "<pre>";
		// print_r($json);
		// echo "</pre>";
		// exit;
	}

}