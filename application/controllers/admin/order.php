<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
		$this->load->library('pagination');
		$this->load->model('api_raja_ongkir');
		$this->load->helper('sendpulseInterface');
		$this->load->helper('sendpulse');
		// Initial Midtrans Payment Gateway
		$params = array('server_key' => 'VT-server-Rf92aeHsCNN8vArCIIFk3nbT', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->limit = 20;
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

	public function get_product($nav_id=0)
	{
		$psql='SELECT p.*, i.product_id, i.image_product_id, i.image_product_file_name, i.image_product_status FROM product p INNER JOIN image_product i ON (p.product_id = i.product_id) WHERE i.image_product_status="thumb" && type_nav_page_id='.intval($nav_id);
		// $psql='SELECT * FROM product WHERE type_nav_page_id='.intval($nav_id);
		$exe=$this->db->query($psql);
		$presults=$exe->result_array();
		echo json_encode($presults);
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
		redirect ('order/all');
	}

	public function all()
	{	
		if ($this->input->post('submit_resi')) {
			$id = $this->input->post('inv_id');
			$no_resi = $this->input->post('no_resi');
			// echo $id.' - '.$no_resi;
			// exit;
			$this->mod->set_table_name('invoice');
			$array_data=array(
				'invoice_resi_number'=>$no_resi
			);
			$this->mod->update($id,$array_data);
			$inv_no = $this->db->query('SELECT invoice_number FROM invoice WHERE invoice_id="'.$id.'" LIMIT 1')->row();
			$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>No resi untuk invoice no <strong>'.$inv_no->invoice_number.'</strong> berhasil ditambahkan.</div>');
			redirect('admin/order/all/');
		} else {
			$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
			$data['list'] = $this->mod->custom_fetch_query('select i.invoice_id, i.invoice_number, i.invoice_name, i.invoice_grand_total, i.invoice_status_id, s.invoice_status_name, s.invoice_status_color, i.invoice_date_order, i.invoice_date_expired, i.invoice_resi_number from invoice i inner join invoice_status s on(i.invoice_status_id=s.invoice_status_id) order by i.invoice_id desc limit '.$this->limit.' offset '.$offset);
			$data['count'] = $this->db->query('SELECT * FROM invoice')->num_rows();
			$data['status'] = $this->db->query('SELECT * FROM invoice_status')->result();

			unset($_SESSION['list_invoice']);

			$config['base_url'] = base_url().'admin/order/all/page/';
		    $config['total_rows'] = $data['count'];
		    $config['uri_segment'] = 5;
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

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/order/list', $data);
			$this->load->view('admin/layout/footer');	
		}
				
			
	}

	public function view($id)
	{
		$this->mod->set_table_name('invoice');
		$data['view'] = $this->mod->get_by_id($id);
		$array_data=array(
			'invoice_status_read'=>"read"
		);
		$this->mod->update($id,$array_data);

		$data['bank_method'] = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$data['view']->bank_id.'" LIMIT 1')->row();
		$data['status'] = $this->db->query('SELECT * FROM invoice_status')->result();
		$data['get_province'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="0" && area_api_id="'.$data['view']->invoice_province.'" LIMIT 1')->row();
		$data['get_city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['view']->invoice_province.'" && area_api_id="'.$data['view']->invoice_city.'" LIMIT 1')->row();
		$data['get_bank_confirm'] = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$data['view']->bank_id.'" LIMIT 1')->row();

		// Daftar Product
		$data['list'] = $this->mod->custom_fetch_query('select s.*, p.product_id, p.product_name, p.product_code, p.type_category_id from product p inner join summary_order s on (p.product_id = s.product_id) where invoice_number="'.$data['view']->invoice_number.'"');

		// Create Session Invoice for Midtrans
		$array_invoice = array(
			'inv_num'=> $data['view']->invoice_number
		);
		$_SESSION['list_invoice'] = $array_invoice;

		/**
			Midtrans Payment Gateway
		*/
		// Item Details

		// Mandatory for Mandiri bill payment and BCA KlikPay
        // Optional for other payment methods

        if (!empty($data['list'])) {
            $product = $data['list'];
            $n=0;
            foreach($product as $i => $item) {
                $product_order[] = array(   
                    'id' => $product[$i]->product_id,
                    'price' => $product[$i]->product_price,
                    'quantity' => $product[$i]->product_qty,
                    'name' => $product[$i]->product_name                         
                );
                $item = $product_order;
            }  
        }

        $item[] = array(
            'id' => 'Voucher',
            'price' => ($data['view']->invoice_discount)*-1,
            'quantity' => 1,
            'name' => "Voucher Discount"
        );	    
     
    	$item[] = array(
            'id' => 'Ongkir',
            'price' => $data['view']->invoice_shipping,
            'quantity' => 1,
            'name' => "Ongkir"
        );       

        $item_details = $item;

        //Gross Amount Equal
        $count_order = count($item_details)-1;
        // echo $count_order;
        // exit;
        $sub_price=0;
        for ($x=0;$x<=$count_order;$x++) {
            $jumlah[$x] = $item_details[$x]['price']*$item_details[$x]['quantity'];
            $sub_price+=$jumlah[$x];
        }
        $total_gross = $sub_price;

        $transaction_details = array(           
            'order_id' => $_SESSION['list_invoice']['inv_num'],
            'gross_amount' => $total_gross
        );

        // Optional
        $billing_address = array(
            'first_name'    => $data['view']->invoice_name,
            'last_name'     => "",
            'address'       => strip_tags($data['view']->invoice_address),
            'city'          => $data['get_city']->area_name,
            'postal_code'   => $data['view']->invoice_postcode,
            'phone'         => $data['view']->invoice_phone,
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => $data['view']->invoice_name,
            'last_name'     => "",
            'address'       => strip_tags($data['view']->invoice_address),
            'city'          => $data['get_city']->area_name,
            'postal_code'   => $data['view']->invoice_postcode,
            'phone'         => $data['view']->invoice_phone,
            'country_code'  => 'IDN'
        );

        $customer_details = array(
            'first_name'    => $data['view']->invoice_name, //optional
            'last_name'     => "", //optional
            'email'         => $data['view']->invoice_email, //mandatory
            'phone'         => $data['view']->invoice_phone, //mandatory
            'billing_address'  => $billing_address, //optional
            'shipping_address' => $shipping_address //optional
        );

        // Fill transaction details
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        $data['snapToken'] = 'dfsdfsf';
        // $data['snapToken'] = $this->midtrans->getSnapToken($transaction);

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/aside');
		$this->load->view('admin/order/view', $data);
		$this->load->view('admin/layout/footer');
	}

	public function create()
	{
		if ($this->input->post('submit')) {

			$this->form_validation->set_message('required', ' %s harus diisi');
			$this->form_validation->set_message('is_natural_no_zero', ' %s belum dipilih.');
			$this->form_validation->set_rules('customer_name', 'Nama Customer ', 'required|xss_clean');
			$this->form_validation->set_rules('customer_phone', 'Telepon ', 'required|xss_clean');
			$this->form_validation->set_rules('customer_address', 'Alamat ', 'required|xss_clean');
			$this->form_validation->set_rules('province', 'Provinsi ', 'required|xss_clean');
			$this->form_validation->set_rules('city', 'Kota ', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {

				$product = $this->db->query('SELECT * FROM product WHERE product_id = "'.$this->input->post('product_id').'"')->row();
				$discount = $product->product_price_discount;
				$total_price = $product->product_price_sell;
				$shipping_total = $this->input->post('shipping_cost');
				$invoice_total = ($total_price-$discount)+$shipping_total;

				// Generate date order dan expired
				// $order_date = date('Y-m-d H:i:s');
				$order_date = $this->input->post('date_order');
				$expired_date = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($order_date)));

				$array_invoice=array(
					'invoice_number'=>$this->input->post('invoice_number'),
					'invoice_name'=>$this->input->post('customer_name'),
					'invoice_email'=>$this->input->post('customer_email'),
					'invoice_phone'=>$this->input->post('customer_phone'),
					'invoice_province'=>$this->input->post('province'),
					'invoice_city'=>$this->input->post('city'),
					'invoice_address'=>$this->input->post('customer_address'),
					'invoice_postcode'=>$this->input->post('postcode'),
					'invoice_total_weight'=>$this->input->post('total_weight'),
					'bank_id'=>$this->input->post('bank_id'),
					'invoice_shipping'=>$shipping_total,
					'invoice_discount'=>$discount,
					'invoice_total_price'=>$total_price,
					'invoice_grand_total'=>$invoice_total,
					'invoice_date_order'=>$order_date,
					'invoice_date_expired'=>$expired_date,
					'invoice_status_id'=>"1",
					'invoice_status_read'=>"not"
				);

				$this->mod->set_table_name('invoice');
				$this->mod->insert($array_invoice);

				// Insert to Summary Order
				$array_summary = array(
					'invoice_number'=>$this->input->post('invoice_number'),
	                'product_id'=>$product->product_id,
	                'brand_id'=>'20',
	                'type_nav_page_id'=>'1',
	                'type_category_id'=>'0',
	                'product_qty'=>'1',
	                'product_size'=>'0', // dirubah
	                'product_price_base'=>$product->product_price_base,
	                'product_price_sell'=>$product->product_price_sell,
	                'product_price'=>$product->product_price_sell,
	                'product_price_discount'=>$discount,
	                'product_price_total'=>$invoice_total,
	                'summary_order_date'=>date('Y-m-d H:i:s')
				);

				$this->mod->set_table_name('summary_order');
				$this->mod->insert($array_summary);

				$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Invoice telah berhasil dibuat</div>');
				redirect ('admin/order/create');

				// echo "<pre>";
				// print_r($array_summary);
				// echo "</pre>";
			}

		} else {
			$this->mod->set_table_name('tbl_area');
			$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
			$data['origin_id']=$this->origin_id;
			$data['invoice_number'] = 'BP-'.time();

			$data['nav'] = $this->db->query('SELECT * FROM type_nav_page')->result();
			$data['bank'] = $this->db->query('SELECT * FROM bank')->result();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/order/create_order', $data);
			$this->load->view('admin/layout/footer');
		}
			
	}

	public function print_preview($id)
	{
		$this->mod->set_table_name('invoice');
		$data['view'] = $this->mod->get_by_id($id);

		$data['bank_method'] = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$data['view']->bank_id.'" LIMIT 1')->row();
		$data['status'] = $this->db->query('SELECT * FROM invoice_status')->result();
		$data['get_province'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="0" && area_api_id="'.$data['view']->invoice_province.'" LIMIT 1')->row();
		$data['get_city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['view']->invoice_province.'" && area_api_id="'.$data['view']->invoice_city.'" LIMIT 1')->row();
		$data['get_bank_confirm'] = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$data['view']->bank_id.'" LIMIT 1')->row();

		// Daftar Product
		$data['list'] = $this->mod->custom_fetch_query('select s.*, p.product_id, p.product_name, p.product_code, p.type_category_id from product p inner join summary_order s on (p.product_id = s.product_id) where invoice_number="'.$data['view']->invoice_number.'"');

		// Create Session Invoice for Midtrans
		$array_invoice = array(
			'inv_num'=> $data['view']->invoice_number
		);
		$_SESSION['list_invoice'] = $array_invoice;

		$this->load->view('admin/order/print_preview', $data);
	}

	public function pay($id)
	{
		$this->mod->set_table_name('invoice');
		$data['view'] = $this->mod->get_by_id($id);
		$array_data=array(
			'invoice_status_read'=>"read"
		);
		$this->mod->update($id,$array_data);
		// echo $data['view']->invoice_email;
		// exit;

		$data['bank_method'] = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$data['view']->bank_id.'" LIMIT 1')->row();
		$data['status'] = $this->db->query('SELECT * FROM invoice_status')->result();
		$data['get_province'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="0" && area_api_id="'.$data['view']->invoice_province.'" LIMIT 1')->row();
		$data['get_city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['view']->invoice_province.'" && area_api_id="'.$data['view']->invoice_city.'" LIMIT 1')->row();
		$data['get_bank_confirm'] = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$data['view']->bank_id.'" LIMIT 1')->row();

		// Daftar Product
		$data['list'] = $this->mod->custom_fetch_query('select s.*, p.product_id, p.product_name, p.product_code, p.type_category_id from product p inner join summary_order s on (p.product_id = s.product_id) where invoice_number="'.$data['view']->invoice_number.'"');

		/**
			Midtrans Payment Gateway
		*/
		// Item Details

		// Mandatory for Mandiri bill payment and BCA KlikPay
        // Optional for other payment methods

        if (!empty($data['list'])) {
            $product = $data['list'];
            $n=0;
            foreach($product as $i => $item) {
                $product_order[] = array(   
                    'id' => $product[$i]->product_id,
                    'price' => $product[$i]->product_price,
                    'quantity' => $product[$i]->product_qty,
                    'name' => $product[$i]->product_name                         
                );
                $item = $product_order;
            }  
        }

        $item[] = array(
            'id' => 'Voucher',
            'price' => ($data['view']->invoice_discount)*-1,
            'quantity' => 1,
            'name' => "Voucher Discount"
        );	    
     
    	$item[] = array(
            'id' => 'Ongkir',
            'price' => $data['view']->invoice_shipping,
            'quantity' => 1,
            'name' => "Ongkir"
        );       

        $item_details = $item;

        //Gross Amount Equal
        $count_order = count($item_details)-1;
        // echo $count_order;
        // exit;
        $sub_price=0;
        for ($x=0;$x<=$count_order;$x++) {
            $jumlah[$x] = $item_details[$x]['price']*$item_details[$x]['quantity'];
            $sub_price+=$jumlah[$x];
        }
        $total_gross = $sub_price;

        $transaction_details = array(           
            'order_id' => $_SESSION['list_invoice']['inv_num'],
            'gross_amount' => $total_gross
        );

        // Optional
        $billing_address = array(
            'first_name'    => $data['view']->invoice_name,
            'last_name'     => "",
            'address'       => strip_tags($data['view']->invoice_address),
            'city'          => $data['get_city']->area_name,
            'postal_code'   => $data['view']->invoice_postcode,
            'phone'         => $data['view']->invoice_phone,
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => $data['view']->invoice_name,
            'last_name'     => "",
            'address'       => strip_tags($data['view']->invoice_address),
            'city'          => $data['get_city']->area_name,
            'postal_code'   => $data['view']->invoice_postcode,
            'phone'         => $data['view']->invoice_phone,
            'country_code'  => 'IDN'
        );

        $customer_details = array(
            'first_name'    => $data['view']->invoice_name, //optional
            'last_name'     => "", //optional
            'email'         => $data['view']->invoice_email, //mandatory
            'phone'         => $data['view']->invoice_phone, //mandatory
            'billing_address'  => $billing_address, //optional
            'shipping_address' => $shipping_address //optional
        );

        // Fill transaction details
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        $data['snapToken'] = $this->midtrans->getSnapToken($transaction);
        // echo "<pre>";
        // print_r($transaction);
        // echo "</pre>";
        // exit;

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/aside');
		$this->load->view('admin/order/pay', $data);
		$this->load->view('admin/layout/footer');
	}

	public function update()
	{
		$id=$this->input->get('id');
		$invoice_status = $this->input->get('invoice_status');
		// echo $id.'-'.$invoice_status;
		// exit;
		$this->mod->set_table_name('invoice');
		// Update Invoice Status
		$array_data=array(
			'invoice_status_id'=>$invoice_status
		);
		$this->mod->update($id,$array_data);
		$customer = $this->mod->get_by_id($id); // Ambil row customer terpilih
		if ($invoice_status=="3") {
			$name_to = $customer->invoice_name;
			$email_to = $customer->invoice_email;
			$text = '<p>Halo, '.$name_to.'</p><p>Terima kasih telah menyelesaikan transaksi anda.</p><p>Pembayaran anda telah kami terima. Segera kami melakukan pengiriman barang ke alamat yang telah anda lengkapi pada form checkout.</p><br>Terima kasih.';
			$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
			$data = array(
			  'html'    => $text, // Deskripsi
			  'text'    => '', // Kosongkan jika isi email pakai html
			  'subject' => 'Konfirmasi pembayaran Banduplaza',
			  'from'    => array(
				'name'  => 'Banduplaza - Pembayaran diterima',
				'email' => 'zaki@banduplaza.com'
			  ),
			  'to'      => array(
				array(
				  'name'  => $name_to,
				  'email' => $email_to
				)
			  ),
			  'bcc'      => array(
				array(
				  'name'  => 'Zaki',
				  'email' => 'zaki@banduplaza.com'
				)
			  )
			);
			$result = $SPApiProxy->smtpSendMail($data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Update status berhasil<br></div>');
		redirect ('admin/order/all');
	}

	public function update_resi()
	{
		
	}

	public function send_again($id)
	{
		$this->mod->set_table_name('invoice');
		$get_id = $this->mod->get_by_id($id);
		$customer = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$get_id->customer_id.'" LIMIT 1')->row();
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'zakinugraha001@gmail.com', // change it to yours
			'smtp_pass' => 'zakinugraha5150', // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('zakinugraha001@gmail.com', 'Banduplaza'); // change it to yours
		$this->email->to($customer->customer_email);// change it to yours
		$this->email->subject('Konfirmasi pembayaran Banduplaza');
		$this->email->message("Terima kasih telah melakukan konfirmasi. Pembayaran anda telah kami terima.<br>Segera kami melakukan pengiriman barang ke alamat yang telah anda isi.<br>Terima kasih.");
		// echo $customer->customer_email;
		// exit;
		$this->email->send();
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Email konfirmasi pembayaran telah dikirim.<br></div>');
		redirect ('admin/order/view/'.$id);
	}

	/**
		Trace expired order
	*/
	public function trace()
	{
		$now = date('Y-m-d H:i:s');
		$cek_invoice = $this->db->query('SELECT * FROM invoice WHERE invoice_date_expired<"'.$now.'" && invoice_status_id="1"')->result();		
		foreach ($cek_invoice AS $exp) {
			$id = $exp->invoice_id;
			$invoice_number = $this->db->query('SELECT * FROM summary_order WHERE invoice_number="'.$exp->invoice_number.'"')->result();
			foreach ($invoice_number AS $data) {
				echo "<pre>";
				print_r('Product id = '.$data->product_id. ' - Qty = '.$data->product_qty. ' - Size = size_'.$data->product_size);
			}
			
			
			// $array_data=array(
			// 	'invoice_status_id'=>'6'
			// );
			// $this->mod->set_table_name('invoice');
			// $this->mod->update($id,$array_data);
		}
	}

	public function send_mail()
	{
		if ($this->input->post('btn_send_mail')) {
			$id = $this->uri->segment(4);
			$data['mail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_id="'.$id.'" LIMIT 1')->row(); // ambil data invoice
			$data['customer'] = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$data['mail']->customer_id.'" LIMIT 1')->row(); // ambil data invoice

			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('mail_title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('mail_message', 'Message', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {

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
				$this->email->from('sales@banduplaza.com', 'Banduplaza');
				$this->email->to($data['customer']->customer_email);
				$this->email->subject($this->input->post('mail_title'));
				$this->email->message(strip_tags($this->input->post('mail_message')));
				$this->email->send();

				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Email telah dikirim kepada '.$data['customer']->customer_email.'<br></div>');
				redirect('admin/order/view/'.$data['mail']->invoice_id);
			} // End Validation
			$id = $this->uri->segment(4);
			$data['mail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_id="'.$id.'" LIMIT 1')->row();
			$data['customer'] = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$data['mail']->customer_id.'" LIMIT 1')->row();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/order/send_mail', $data);
			$this->load->view('admin/layout/footer');
		} else {
			$id = $this->uri->segment(4);
			$data['mail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_id="'.$id.'" LIMIT 1')->row();
			$data['customer'] = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$data['mail']->customer_id.'" LIMIT 1')->row();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/order/send_mail', $data);
			$this->load->view('admin/layout/footer');
		}
			
		// echo $data['mail']->customer_email;
		// exit;

		
	}

} // End Class

