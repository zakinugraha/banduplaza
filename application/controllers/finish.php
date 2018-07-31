<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Finish extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('sendpulseInterface');
		$this->load->helper('sendpulse');
	}

	public function index()
	{
		if ($this->input->get('invoice')!='') {

			if (!isset($_SESSION['order'])) {
				redirect (base_url());
			}
				
			/** 
	        Insert list order to summary_order
	        */
	        // Ambil data summary_order
	        $get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();          
	        $list_order = $get_session_arr;
	        foreach ($list_order AS $order_item) {
	            $array_order=array(
	                'invoice_number'=>$_SESSION['invoice_data']['invoice_number'],
	                'customer_id'=>'0',
	                'product_id'=>$order_item['product_id'],
	                'brand_id'=>$order_item['brand_id'],
	                'type_nav_page_id'=>$order_item['type_nav_page_id'],
	                'type_category_id'=>$order_item['type_category_id'],
	                'product_qty'=>$order_item['product_qty'],
	                'product_size'=>$order_item['product_size'],
	                'product_price_base'=>$order_item['product_price_base'],
	                'product_price_sell'=>$order_item['product_price_sell'],
	                'product_price'=>$order_item['product_price'],
	                'product_price_discount'=>$order_item['product_price_discount'],
	                'product_price_total'=>$order_item['product_price_total'],
	                'summary_order_date'=>date('Y-m-d H:i:s')
	            );                      
	            $this->mod->set_table_name('summary_order');	            
	            $this->mod->insert($array_order);
	        }

			/** 
			Create Invoice Data
			*/			
			$array_invoice=array(
				'invoice_number'=>$_SESSION['invoice_data']['invoice_number'],
				'invoice_name'=>$_SESSION['invoice_data']['invoice_name'],
				'invoice_email'=>$_SESSION['invoice_data']['invoice_email'],
				'invoice_phone'=>$_SESSION['invoice_data']['invoice_phone'],
				'invoice_province'=>$_SESSION['invoice_data']['invoice_province'],
				'invoice_city'=>$_SESSION['invoice_data']['invoice_city'],
				'invoice_address'=>$_SESSION['invoice_data']['invoice_address'],
				'invoice_postcode'=>$_SESSION['invoice_data']['invoice_postcode'],
				'invoice_total_weight'=>$_SESSION['invoice_data']['invoice_total_weight'],
				'bank_id'=>$_SESSION['invoice_data']['bank_id'],
				'invoice_shipping'=>$_SESSION['invoice_data']['invoice_shipping'],
				'invoice_discount'=>$_SESSION['invoice_data']['invoice_discount'],
				'invoice_total_price'=>$_SESSION['invoice_data']['invoice_total_price'],
				'invoice_grand_total'=>$_SESSION['invoice_data']['invoice_grand_total'],
				'invoice_note'=>$_SESSION['invoice_data']['invoice_note'],
				'invoice_date_order'=>$_SESSION['invoice_data']['invoice_date_order'],
				'invoice_date_expired'=>$_SESSION['invoice_data']['invoice_date_expired'],
				'invoice_status_id'=>$_SESSION['invoice_data']['invoice_status_id'],
				'invoice_status_read'=>$_SESSION['invoice_data']['invoice_status_read']
			);
			$this->mod->set_table_name('invoice');
			$this->mod->insert($array_invoice);

			$data['invoice'] = $_SESSION['invoice_data']['invoice_number'];
			$get_bank = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$_SESSION['invoice_data']['bank_id'].'" LIMIT 1')->row();
			// $data['detail'] = $this->db->query('SELECT * FROM invoice WHERE invoice_number="'.$invoice.'" LIMIT 1')->row();


			/** 
				Kirim email konfirmasi suruh tunggu disini
			*/

			$name_to = $_SESSION['invoice_data']['invoice_name'];
			$email_to = $_SESSION['invoice_data']['invoice_email'];
			$text = '<style>body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;font-family:"Franklin Gothic"}h1{font-size:18px}a,p{font-size:14px;margin:0}a{color:#d89906}</style><center><img src="http://www.banduplaza.com/assets/front/images/logo.png"></center><p>Horrayyy!!<p><p>Halo '.$name_to.', terima kasih telah melakukan order di banduplaza</p><br><center><label style="font-weight:bold;margin-bottom:20px;border:1px solid #ff6c00;padding:5px 25px;background-color:#ff6c00;color:#fff;">Order ID : '.$data['invoice'].'</label></center><br><br><p>Tinggal satu langkah lagi untuk mendapatkan barang yang anda inginkan.<p><p>Silahkan selesaikan pembayaran anda ke rekening berikut:</p><br><br><div style="font-size:12px;font-weight:600;padding:5px 15px;border:1px solid #2dd00d;border-bottom:2px solid #2dd00d;"><img src="http://www.banduplaza.com/upload/images/bank/'.$get_bank->bank_logo.'"><br><p>'.$get_bank->bank_name.'</p><p>No Rek : '.$get_bank->bank_rek.'</p><p>Atas Nama : '.$get_bank->bank_an.'</p><hr><p>Total : Rp. '.number_format($_SESSION['invoice_data']['invoice_grand_total'],0).'</p></div><br><br><p>Silahkan selesaikan pembayaran anda sebelum tanggan '.$_SESSION['invoice_data']['invoice_date_expired'].'</p><p>Lalu konfirmasi pembayaran anda <a href="http://www.banduplaza.com/confirm">disini</a>, lalu kami akan langsung memproses order anda dan mengirimkan barang pesanan anda.</p><br><p>Terima kasih telah melakukan order di banduplaza</p><p>Salam, banduplaza</p>';
			$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
			$data = array(
			  'html'    => $text, // Deskripsi
			  'text'    => '', // Kosongkan jika isi email pakai html
			  'subject' => 'Terima kasih telah berbelanja di Banduplaza',
			  'from'    => array(
				'name'  => 'Banduplaza',
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
				  'email' => 'bandunetwork@gmail.com'
				)
			  )
			);
			$result = $SPApiProxy->smtpSendMail($data);

			// Unset Session Order
			unset($_SESSION['order']);
			unset($_SESSION['discount']);
			// unset($_SESSION['invoice_data']);

			$this->load->view('layout/header_finish');
			$this->load->view('finish', $data);
			$this->load->view('layout/footer');							
		
		} else {
			redirect (base_url());
		}
		
	}

}