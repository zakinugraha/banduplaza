<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
		$this->load->helper('sendpulseInterface');
		$this->load->helper('sendpulse');
		// Initial Midtrans Payment Gateway
		$params = array('server_key' => 'VT-server-YvIiWWkWtfGMgVDlQ-K_9Y01', 'production' => true);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
	}

	public function index()
	{	
		$this->mod->set_table_name('invoice');
		// $data['list'] = $this->db->query('SELECT * FROM invoice ORDER BY invoice_id DESC')->result();
		$data['list'] = $this->mod->custom_fetch_query('select i.invoice_id, i.invoice_number, i.invoice_name, i.invoice_grand_total, i.invoice_status_id, s.invoice_status_name, s.invoice_status_color, i.invoice_date_order from invoice i inner join invoice_status s on(i.invoice_status_id=s.invoice_status_id) order by i.invoice_id desc');
		// $data['list'] = $this->mod->custom_fetch_query('select i.*,c.customer_id, c.customer_name, s.invoice_status_id, s.invoice_status_color, s.invoice_status_name from customer c inner join invoice i on (i.customer_id = c.customer_id) inner join invoice_status s on (i.invoice_status_id = s.invoice_status_id) order by invoice_id DESC');

		unset($_SESSION['list_invoice']);

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/order/list', $data);
		$this->load->view('admin/layout/footer');		
			
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

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/order/view', $data);
		$this->load->view('admin/layout/footer');
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
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/order/pay', $data);
		$this->load->view('admin/layout/footer');
	}

	public function update($id)
	{
		$invoice_status = $this->input->post('invoice_status');
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
		redirect ('dashboard/order/view/'.$id);
	}

	public function update_resi($id)
	{
		$this->mod->set_table_name('invoice');
		$array_data=array(
			'invoice_resi_number'=>$this->input->post('no_resi')
		);
		$this->mod->update($id,$array_data);
		redirect('dashboard/order/view/'.$id);
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
		redirect ('dashboard/order/view/'.$id);
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
				redirect('dashboard/order/view/'.$data['mail']->invoice_id);
			} // End Validation
			$id = $this->uri->segment(4);
			$data['mail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_id="'.$id.'" LIMIT 1')->row();
			$data['customer'] = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$data['mail']->customer_id.'" LIMIT 1')->row();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/order/send_mail', $data);
			$this->load->view('admin/layout/footer');
		} else {
			$id = $this->uri->segment(4);
			$data['mail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_id="'.$id.'" LIMIT 1')->row();
			$data['customer'] = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$data['mail']->customer_id.'" LIMIT 1')->row();

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/sidebar');
			$this->load->view('admin/order/send_mail', $data);
			$this->load->view('admin/layout/footer');
		}
			
		// echo $data['mail']->customer_email;
		// exit;

		
	}

} // End Class

