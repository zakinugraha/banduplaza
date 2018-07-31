<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Email extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('sendpulseinterface', 'sendpulse'));
	}

	public function index()
	{
		if ($this->input->post('submit')) {
			// $css = '<style>.callout a,a{color:#2BA6CB}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;font-family:"Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif}.content table,table.body-wrap,table.head-wrap{width:100%}.collapse{margin:0;padding:0}h3,p.callout{margin-bottom:15px}.header.container table td.logo,p.callout{padding:15px}p.callout{background-color:#ECF8FF;text-align:center}.callout a{font-weight:700;font-size:18px}.header.container table td.label{padding:15px 15px 15px 0}h3{font-weight:500;font-size:27px;line-height:1.1;color:#000}p{margin-bottom:10px;font-weight:400;font-size:14px;line-height:1.6}.container{display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important}.content{padding:15px;max-width:600px;margin:0 auto;display:block}.clear{display:block;clear:both}@media only screen and (max-width:600px){a[class=btn]{display:block!important;margin-bottom:10px!important;background-image:none!important;margin-right:0!important}}</style>';
			$text = '<style>body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;font-family:"Franklin Gothic"}h1{font-size:18px}a,p{font-size:14px}p{margin:0}a{color:#d89906}</style><p>Horrayyy!!<p><p>Terima kasih telah melakukan order di banduplaza</p><br><center><label style="font-weight: bold;margin-bottom: 20px; border: 1px solid #ff6c00;padding: 5px 25px;background-color: #ff6c00;color: #fff;">Order ID : BP-1532913938</label></center><br><br><p>Tinggal satu langkah lagi untuk mendapatkan barang yang anda inginkan.<p><p>Silahkan selesaikan pembayaran anda ke rekening berikut:</p><br><br><div style="font-size: 12px;font-weight: 600; padding: 5px 15px;border: 1px solid #2dd00d;border-bottom: 2px solid #2dd00d;"><img src="http://www.banduplaza.com/upload/images/bank/'.$get_bank->bank_logo.'"><br><p>Mandiri</p><p>No Rek : 765220012200111</p><p>Atas Nama : Muhammad Zakinudin Nugraha</p><hr><p>Total : 265,000</p></div><br><br><p>Silahkan selesaikan pembayaran anda sebelum tanggan 11-11-2018 01:43:44</p><p>Lalu konfirmasi pembayaran anda <a href="http://www.banduplaza.com/confirm">disini</a>, lalu kami akan langsung memproses order anda dan mengirimkan barang pesanan anda.</p><br><p>Terima kasih telah melakukan order di banduplaza</p><p>Salam, banduplaza</p>';
			$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
			$data = array(
			  'html'    => $text,
			  'text'    => 'tes text', // Deskripsi
			  'subject' => 'Tes: Selamat datang di banduplaza',
			  'from'    => array(
				'name'  => 'Banduplaza',
				'email' => 'zaki@banduplaza.com'
			  ),
			  'to'      => array(
				array(
				  'name'  => 'zaki',
				  'email' => 'bandunetwork@gmail.com'
				)
			  )
			);
			$result = $SPApiProxy->smtpSendMail($data);
			echo "<pre>";
			print_r($result);
			echo "</pre>";



			// $config = Array(
			// 	'protocol' => 'smtp',
			// 	'smtp_host' => 'ssl://mail.banduplaza.com',
			// 	'smtp_port' => '465',
			// 	'smtp_user' => 'customerservice@banduplaza.com',
			// 	'smtp_pass' => 'banducs5150'
			// );

			// $this->load->library('email', $config);
			// $this->email->set_newline("\r\n");
			// $this->email->from('customerservice@banduplaza.com', 'Zaki');
			// $this->email->to('bandunetwork@gmail.com');
			// $this->email->subject('Tes SMTP Email - Terakhir');
			// $this->email->message('Ini adalah tes email menggunakan SMTP banduplaza ke banduplaza@yahoo.com');
			// $this->email->send();

			// if ($this->email->send()) {
			// 	echo "Sukses";
			// } else {
			// 	echo "Gagal";
			// }

		} else {
			$this->load->view('email');
		}
			
	}


	public function mail()
	{
		$this->load->view('email_confirm_register');
	}

}