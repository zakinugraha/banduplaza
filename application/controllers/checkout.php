<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Checkout extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->model('api_raja_ongkir');
		$this->load->helper('indonesia_date');
		$this->load->helper('sendpulseInterface');
		$this->load->helper('sendpulse');
		$params = array('server_key' => 'VT-server-Rf92aeHsCNN8vArCIIFk3nbT', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
		$this->origin_id=22; // Kota Pengiriman, default = 'Bandung'
	}

	public function get_cost($destination_id=0,$total_weight=0,$courier='jne')
	{
		$result=$this->api_raja_ongkir->get_cost($this->origin_id,$destination_id,$total_weight,$courier);
		$response=json_decode($result);
		$response_value=isset($response->rajaongkir->results)?$response->rajaongkir->results:null;
		$response_value=isset($response_value)?$response_value[0]:null;
		$response_value=(isset($response_value->costs) AND $response_value->costs!=null)?$response_value->costs:array(
			0=>array(
				'service'=>'n/a',
				'description'=>'Tidak ada pengiriman ke kota tersebut'.'<br>'.'Silahkan hubungi admin untuk informasi lebih lanjut.',
				'cost'=>array()
				)
			);
		echo json_encode($response_value);
		//echo '<pre>';
		//print_r($response);
	}

	public function get_city($province_id=0)
	{
		$sql='SELECT * FROM tbl_area WHERE area_par_id='.intval($province_id);
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

	public function index()
	{
		if ($this->input->post('submit')) {
			
			if (empty($_SESSION['order'])) { // Jika tidak ada session order
				redirect ('checkout?message=warning');
				} else { // Kalau ada session order

					// Validation Start
					$this->form_validation->set_message('required', ' %s harus diisi');
					$this->form_validation->set_message('is_natural_no_zero', ' %s belum dipilih.');
					$this->form_validation->set_message('valid_email', ' %s format tidak valid.');
					$this->form_validation->set_rules('name', 'Nama ', 'required|xss_clean');
					$this->form_validation->set_rules('email', 'Email ', 'required|valid_email|xss_clean');
					$this->form_validation->set_rules('phone', 'Telepon ', 'required|xss_clean');
					$this->form_validation->set_rules('address', 'Alamat ', 'required|xss_clean');
					$this->form_validation->set_rules('province', 'Provinsi ', 'required|xss_clean');
					$this->form_validation->set_rules('city', 'Kota ', 'required|xss_clean');
					// $this->form_validation->set_rules('shipping_cost', 'Paket pengiriman ', 'is_natural_no_zero|xss_clean');
					if ($this->form_validation->run()==TRUE) {
						// Dapatkan total order keseluruhan
						$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
						// if (isset($get_session_arr)) {
							$data['list'] = $_SESSION['order'];
							$sub_total_price_order = 0;
							foreach ($data['list'] AS $jumlah) {
								$sub_total_price_order+=$jumlah['product_price_total'];
							}							
							$data['total_price_order'] = $sub_total_price_order;
						// }

						// Get weight product
						$data['weight_item'] = $_SESSION['order'];
						$weight = 0;
						foreach ($data['weight_item'] as $row) {
							$weight+=$row['product_weight'];
						}
						$data['weight'] = $weight;

						// Generate date order dan expired
						$order_date = date('Y-m-d H:i:s');
						$expired_date = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($order_date)));
						
						// Shipping FREE ONGKIR up to 25,000
						$shipping_cost = $this->input->post('shipping_cost'); // Ongkos kirim asli (tanpa promo)
						$shipping_total = $shipping_cost<=25000 ? '0' : ($shipping_cost-25000); // Ongkos kirim dengan promo

						$discount = isset($_SESSION['discount']) ? $_SESSION['discount']['discount_total'] : '0';
						$invoice_total = ($data['total_price_order']-$discount)+($shipping_total);						
						
						/** 
						Create Invoice Data
						*/
						$array_invoice=array(
							'invoice_number'=>$this->input->post('invoice_number'),
							'invoice_name'=>$this->input->post('name'),
							'invoice_email'=>$this->input->post('email'),
							'invoice_phone'=>$this->input->post('phone'),
							'invoice_province'=>$this->input->post('province'),
							'invoice_city'=>$this->input->post('city'),
							'invoice_address'=>$this->input->post('address'),
							'invoice_postcode'=>$this->input->post('postcode'),
							'invoice_total_weight'=>$this->input->post('weight_total'),
							'bank_id'=>$this->input->post('bank_id'),
							'invoice_shipping'=>$shipping_cost,
							'invoice_discount'=>$discount,
							'invoice_total_price'=>$data['total_price_order'],
							'invoice_grand_total'=>$invoice_total,
							'invoice_note'=>$this->input->post('note')!=""?$this->input->post('note'):'Tidak ada catatan',
							'invoice_date_order'=>$order_date,
							'invoice_date_expired'=>$expired_date,
							'invoice_status_id'=>"1",
							'invoice_status_read'=>"not"
						);
						
						$_SESSION['invoice_data'] = $array_invoice;

						// insert to summary checkout & summary checkout item
						$this->mod->set_table_name('summary_checkout');
						$array_sc=array(
							'summary_checkout_invoice_number'=>$this->input->post('invoice_number'),
							'summary_checkout_name'=>$this->input->post('name'),
							'summary_checkout_email'=>$this->input->post('email'),
							'summary_checkout_phone'=>$this->input->post('phone'),
							'summary_checkout_phone'=>$this->input->post('phone'),
							'summary_checkout_address'=>$this->input->post('address'),
							'summary_checkout_city'=>$this->input->post('city'),
							'summary_checkout_date'=>date("y-m-d")
						);
						$this->mod->insert($array_sc);

						$this->mod->set_table_name("summary_checkout_item");
						$sum_ci = $_SESSION['order'];
						foreach ($sum_ci AS $ci) {
							$array_sum =array(
		                        'summary_checkout_invoice_number'=>$this->input->post('invoice_number'),
		                        'summary_checkout_item_product_id'=>$row['product_id'],
		                        'summary_checkout_item_size'=>$row['product_size'],
		                        'summary_checkout_item_qty'=>$row['product_qty']
		                    ); 
						}
						$this->mod->insert($array_sum);
						// end insert to summary checkout & summary checkout item

						/**
						kirim email tagihan dan metode pembayaran
						*/
						$email = $_SESSION['user_customer']['customer_email'];
						$body=$this->load->view('email_invoice',$data,TRUE);

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

						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('zakinugraha001@gmail.com', 'Banduplaza');
						$this->email->to(base64_decode($_SESSION['user_customer']['customer_email']));
						$this->email->subject('Detail order Banduplaza');
						$this->email->message($body);
						$this->email->set_mailtype("html");
						$this->email->send();
						// End kirim email

						redirect('finish?invoice='.$this->input->post('invoice_number'));
					} // Validation End

					// Jika validation == FALSE
					if (isset($_SESSION['order'])) { // Jika session order ada
						// Get total product
						$data['total_item'] = $_SESSION['order'];
						$gt = 0;
						foreach ($data['total_item'] as $row) {
							$gt+=$row['product_price_total'];
						}
						if (isset($_SESSION['discount'])) {
							$discount = $_SESSION['discount']['discount_total'];
						} else {
							$discount = '0';
						}

						// Get weight product
						$data['weight_item'] = $_SESSION['order'];
						$weight = 0;
						foreach ($data['weight_item'] as $row) {
							$weight+=$row['product_weight'];
						}
						$data['weight'] = $weight;
						$data['pembelian'] = $gt;
						$data['grand_total'] = $gt-$discount;
					} else {
						unset($_SESSION['discount']);					
						$data['grand_total'] = "0'";
						$data['weight'] = "0'";
					}

					// Jika ada session discount / sudah memasukan kode voucher yang sesuai
					if (isset($_SESSION['discount'])) {
						$data['discount'] = $_SESSION['discount']['discount_total'];
					} else {
						$data['discount'] = '0';
					}

					$this->mod->set_table_name('tbl_area');
					$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
					$data['origin_id']=$this->origin_id;
					$data['invoice_number'] = 'BP-'.time();

					$this->load->view('layout/header_content');
					$this->load->view('checkout', $data);
					$this->load->view('layout/footer');
						
				} // End $_SESSION['order']

		/**
			Pertama kali halaman checkout di load
		*/
		} else { /*   */
			
			if (isset($_SESSION['order'])) { // Jika session order ada
				// Get total product
				$data['total_item'] = $_SESSION['order'];
				$gt = 0;
				foreach ($data['total_item'] as $row) {
					$gt+=$row['product_price_total'];
				}
				if (isset($_SESSION['discount'])) {
					$discount = $_SESSION['discount']['discount_total'];
				} else {
					$discount = '0';
				}

				// Get weight product
				$data['weight_item'] = $_SESSION['order'];
				$weight = 0;
				foreach ($data['weight_item'] as $row) {
					$weight+=$row['product_weight'];
				}
				$data['weight'] = $weight;
				$data['pembelian'] = $gt;
				$data['grand_total'] = $gt-$discount;
			} else {
				unset($_SESSION['discount']);					
				$data['grand_total'] = "0'";
				$data['weight'] = "0'";
			}

			// Jika ada session discount / sudah memasukan kode voucher yang sesuai
			if (isset($_SESSION['discount'])) {
				$data['discount'] = $_SESSION['discount']['discount_total'];
			} else {
				$data['discount'] = '0';
			}

			$this->mod->set_table_name('tbl_area');
			$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
			$data['origin_id']=$this->origin_id;
			$data['invoice_number'] = 'BP-'.time();

			// echo "<pre>";
			// print_r($_SESSION['order']);
			// echo "</pre>";
			// exit;

			$this->load->view('layout/header_content');
			$this->load->view('checkout', $data);
			$this->load->view('layout/footer');
			
			
		} // End if submit
			
			
	} // End function

	public function cek_code() // Cek voucher diskon
	{
		$get_code = $this->db->query('SELECT * FROM configuration WHERE configuration_id="2"')->row();
		$input_code = $this->input->post('discount_code');
		$cek_code = $this->db->query('SELECT * FROM configuration WHERE configuration_id="2" && configuration_value="'.$get_code->configuration_value.'"')->num_rows();
		if ($input_code==$get_code->configuration_value) {
			if (isset($_SESSION['order'])) { // kalau ada session order
				// Get total product
				$data['total_item'] = $_SESSION['order'];
				$gt = 0;
				foreach ($data['total_item'] as $row) {
					$gt+=$row['product_price_total'];
				}
				$data['total'] = $gt;
				$get_discount = $data['total'] * (10/100);
				$data['besar_discount'] = $get_discount;
				$array_discount=array(
					'discount_total'=>$data['besar_discount']
				);
				$_SESSION['discount'] = $array_discount;
			} else {
				$data['total'] = '0';
				$_SESSION['discount'] = "0'";
			}
			redirect ('checkout');			
		} else {
			redirect('checkout?message=no_voucher');
		}
	}

	public function email()
	{
		$count_invoice = $this->db->query('SELECT * FROM invoice ORDER BY invoice_id LIMIT 1')->num_rows();
		if ($count_invoice==0) {
			$invoice_number = '61001';
		} else {
			$get_last_invoice = $this->db->query('SELECT * FROM invoice ORDER BY invoice_id DESC LIMIT 1')->row();
			$invoice_number = $get_last_invoice->invoice_number+1;
		}

		$data['invoice_detail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_number="'.$invoice_number.'" LIMIT 1')->row();
		$data['invoice_product'] = $this->db->query('SELECT * FROM summary_order WHERE invoice_number="'.$invoice_number.'"')->result();

		$this->load->view('email_invoice', $data);
	}

} // End class