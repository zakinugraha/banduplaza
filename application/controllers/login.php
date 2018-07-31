<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('cookie');
		$this->load->helper(array('sendpulseInterface', 'sendpulse'));
	}

	public function index()
	{
		if ($this->input->post('submit')) {
			$email = $this->input->post('email');
			$password = MD5($this->input->post('password'));
			$remember = $this->input->post('chk_remember_me');
			$cek = $this->db->query('SELECT * FROM customer WHERE customer_email="'.$email.'" && customer_password="'.$password.'" LIMIT 1')->num_rows();
			if ($cek==1) {
				$user = $this->db->query('SELECT * FROM customer WHERE customer_email="'.$email.'" && customer_password="'.$password.'" LIMIT 1')->row();
				if ($user->customer_status=="active") { // Jika customer_status == active					
					$array_data=array(
						'customer_id'=>base64_encode($user->customer_id),
						'customer_title'=>base64_encode($user->customer_title),
						'customer_number_identify'=>base64_encode($user->customer_number_identify),
						'customer_name'=>base64_encode($user->customer_name),
						'customer_username'=>base64_encode($user->customer_username),
						'customer_email'=>base64_encode($user->customer_email),
						'customer_status'=>base64_encode("login")
					);
					$_SESSION['user_customer'] = $array_data;
					$tokenurl = base64_decode($this->input->post('token'));
					$t_param = explode("-", $tokenurl);
					$c_id = end($t_param);
					$token = $t_param[0];
					// echo $tokenurl;
					// exit;


					if ($remember) { // Jika remember me == checked
						// Create Cookie
						$id = base64_encode($user->customer_id);
						$title = base64_encode($user->customer_title);
						$number_identify = base64_encode($user->customer_number_identify);
						$name = base64_encode($user->customer_name);
						$username = base64_encode($user->customer_username);
						$email = base64_encode($user->customer_email);
						$status = base64_encode('login');
						$value = $id.'&'.$number_identify.'&'.$title.'&'.$name.'&'.$username.'&'.$email.'&'.$status;
						$expire = 86500*30;						

						set_cookie("_acc", $value, $expire);
					} // End remember
					if ($token=='wishlist') {
						$get_product = $this->db->query('SELECT * FROM product WHERE product_id="'.$c_id.'"')->row();
						redirect('product/view/'.url_title(strtolower($get_product->product_name.'-'.$get_product->product_code.'-'.$c_id)));
					} else if ($token=='checkout') {
						redirect ('checkout');
					} else {
						redirect (base_url());	
					}
								

				} else { // Jika status customer == suspend
					$this->session->set_flashdata('warning', '<div class="attention-warning">Akun anda tidak aktif. Hubungi administrator.</div>');
					redirect ('login');
				}

			} else { // Jika password atau username tidak sesuai
				$this->session->set_flashdata('warning', '<div class="attention-warning">Email atau Password anda salah.</div>');
				redirect ('login');
			}
		} else { // Pertama kali di load
			$data['success'] = $this->input->get('from');

			$this->load->view('layout/header');
			$this->load->view('login', $data);
			$this->load->view('layout/footer');
		}

	} // End function

	public function register()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('username_reg', 'Username', 'required|xss_clean|is_unique[customer.customer_username]');
			$this->form_validation->set_rules('password_reg', 'Password', 'required|xss_clean');
			$this->form_validation->set_rules('email_reg', 'Email', 'required|xss_clean|is_unique[customer.customer_email]');
			$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
			if ($this->form_validation->run() == TRUE) {

				// Generate customer_number_identify				
				$cek = $this->db->query('SELECT * FROM customer ORDER BY customer_number_identify DESC LIMIT 1')->num_rows();
				if ($cek==0) {
					$number_identify = "333001";
				} else {
					$get_last_identify = $this->db->query('SELECT * FROM customer ORDER BY customer_number_identify DESC LIMIT 1')->row();
					$number_identify = $get_last_identify->customer_number_identify+1;
				}				

				$array_data=array(
					'customer_number_identify'=>$number_identify,
					'customer_title'=>$this->input->post('title'),
					'customer_name'=>$this->input->post('name'),
					'customer_username'=>$this->input->post('username_reg'),
					'customer_password'=>MD5($this->input->post('password_reg')),
					'customer_email'=>$this->input->post('email_reg'),
					'customer_phone'=>$this->input->post('phone'),
					'customer_newsletter'=>'yes',
					'customer_registration_date'=>date('Y-m-d H:i:s'),
					'customer_status'=>"active"
				);				
				$this->mod->set_table_name('customer');
				$this->mod->insert($array_data);

				/**
					Jika member code aktif / =="active"
				*/
				$cek_member_code = $this->db->query('SELECT * FROM configuration WHERE configuration_id="3" LIMIT 1')->row();
				$result = $cek_member_code->configuration_value;
				if ($result=='active') {
					$panjangacak = 10;
					$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
					$max=strlen($base)-1;
					$acak='';
					mt_srand((double)microtime()*1000000);
					while (strlen($acak)<$panjangacak)
						$acak.=$base{mt_rand(0,$max)};
						$this->mod->set_table_name('customer');
						$reg=date('Y-m-d');
						$exp=date('Y-m-d', strtotime('+30 days', strtotime($reg)));
						// Update
						$this->db->query('UPDATE customer SET customer_member_code="'.$acak.'", customer_member_code_register="'.$reg.'", customer_member_code_expired="'.$exp.'" WHERE customer_number_identify="'.$number_identify.'"');
				}


				/**
					Kirim Email ke Customer Via SendPulse
				*/
				$data['name'] = $this->input->post('name');
				$email['email_reg'] = $this->input->post('email_reg');
				$text = '<style>.callout a,a{color:#2BA6CB}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;font-family:"Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif}.content table,table.body-wrap,table.head-wrap{width:100%}.collapse{margin:0;padding:0}h3,p.callout{margin:15px}.header.container table td.logo,p.callout{padding:15px}p.callout{background-color:#ECF8FF;text-align:center}.callout a{font-weight:700;font-size:18px}.header.container table td.label{padding:15px 15px 15px 0}h3{font-weight:500;font-size:27px;line-height:1.1;color:#000}p{margin-bottom:10px;font-weight:400;font-size:14px;line-height:1.6}.container{display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important}.content{padding:15px;max-width:600px;margin:0 auto;display:block}.clear{display:block;clear:both}@media only screen and (max-width:600px){a[class=btn]{display:block!important;margin-bottom:10px!important;background-image:none!important;margin-right:0!important}}</style><body bgcolor="#FFFFFF"><table class="body-wrap"><tr><td></td><td class="container" bgcolor="#FFFFFF"><div class="content"><table><tr><td><h3>Hi, '.$data['name'].'</h3><p>Terima kasih telah bergabung bersama kami di banduplaza.com.</p><p></p>Nikmati berbagai macam produk menarik dan keren dari berbagai macam brand-brand ternama. Tidak perlu khawatir soal kualitas,<br>bekerjasama dengan berbagai pihak untuk keamanan transaksi.<br>So, Happy shopping..</p><p class="callout"><a href="http://banduplaza.com">Start Shopping &raquo;</a></p></td></tr></table></div></td><td></td></tr></table></body>';
				$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
				$data = array(
				  'html'    => $text, // Deskripsi
				  'text'    => '', // Kosongkan jika isi email pakai html
				  'subject' => 'Selamat datang di banduplaza',
				  'from'    => array(
					'name'  => 'Banduplaza',
					'email' => 'zaki@banduplaza.com'
				  ),
				  'to'      => array(
					array(
					  'name'  => $data['name'],
					  'email' => $email['email_reg']
					)
				  )
				);
				$result = $SPApiProxy->smtpSendMail($data);

				/**
					Kirim Email ke zaki@banduplaza.com Via SendPulse
				*/
				$data['name'] = $this->input->post('name');
				$email['email_reg'] = $this->input->post('email_reg');
				$text = 'Ada yang daftar baru';
				$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
				$data = array(
				  'html'    => $text, // Deskripsi
				  'text'    => '', // Kosongkan jika isi email pakai html
				  'subject' => 'Pemberitahuan Pendaftaran',
				  'from'    => array(
					'name'  => 'Banduplaza',
					'email' => 'look@banduplaza.com'
				  ),
				  'to'      => array(
					array(
					  'name'  => 'Zaki - Banduplaza',
					  'email' => 'zaki@banduplaza.com'
					)
				  )
				);
				$result = $SPApiProxy->smtpSendMail($data);
				

				// Jika saat proses registrasi terdapat session user_customer,
				// Maka unset session user_customer, lalu buat session user_customer baru
				if (!empty($_SESSION['user_customer'])) {
					unset($_SESSION['user_customer']);
				}				

				$cek_user = $this->db->query('SELECT * FROM customer WHERE customer_username="'.$this->input->post('username_reg').'" && customer_password="'.MD5($this->input->post('password_reg')).'" LIMIT 1')->row();
				$create_user=array(
					'customer_id'=>base64_encode($cek_user->customer_id),
					'customer_number_identify'=>base64_encode($cek_user->customer_number_identify),
					'customer_title'=>base64_encode($cek_user->customer_title),
					'customer_name'=>base64_encode($cek_user->customer_name),
					'customer_username'=>base64_encode($cek_user->customer_username),
					'customer_email'=>base64_encode($cek_user->customer_email),
					'customer_status'=>base64_encode("login")
				);
				$_SESSION['user_customer'] = $create_user;

				redirect (base_url());
			}

			// Jika validasi gagal
			// $this->session->set_flashdata('warning', '<div class="attention-warning">Pendaftaran akun gagal!. Periksa kembali data anda.</div>');
			$this->load->view('layout/header');
			$this->load->view('login');
			$this->load->view('layout/footer');
		} else { // First time load
			$this->load->view('layout/header');
			$this->load->view('login');
			$this->load->view('layout/footer');
		} // End submit
			
	} // End function

	public function logout()
	{
		// Delete cookie
		$value = '';
		$status = '';
		$expire = -1;

		set_cookie("_acc", $id, $expire);

		unset($_SESSION['user_customer']);
		$this->session->sess_destroy();

		redirect (base_url());
	}

	public function forgot()
	{
		$email = $this->input->post('email');
		if ($this->input->post('submit')) {
			$cek = $this->db->query('SELECT * FROM customer WHERE customer_email="'.$email.'"')->num_rows();
			if ($cek==1) {
				$unicode = MD5(time());
				$get_row = $this->db->query('SELECT * FROM customer WHERE customer_email="'.$email.'" LIMIT 1')->row();
				$id = $get_row->customer_id;

				// Create generate code and insert to customer table
				$array_data=array(
					'customer_unicode'=>$unicode,
					'customer_date_reset'=>date('Y-m-d H:i:s'),
					'customer_date_reset_expired'=>date('Y-m-d H:i:s', strtotime('+1 hours', strtotime(date('Y-m-d H:i:s')))),
				);
				$this->mod->set_table_name('customer');
				$this->mod->update($id,$array_data);

				/**
					Send link forgot password to email customer
				*/
				$data['get_email'] = $get_row->customer_email;
				$get_code = $this->db->query('SELECT * FROM customer WHERE customer_email="'.$email.'" LIMIT 1')->row();
				$data['unicode'] = $get_code->customer_unicode;
				$data['username'] = $get_code->customer_username;
				$body=$this->load->view('email_forgot',$data,TRUE);

				$text = '<style>h3,p{color:#333}a,span{display:block;color:#fff}a,h1,span{color:#fff}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;height:100%;font-family:Helvetica,Arial,"Lucida Grande",sans-serif}.box,.container{width:760px!important;margin:0 auto}.container{padding:10px;background-color:#333;text-align:center}h1{font-size:28px;font-weight:100}h3{font-size:20px;font-weight:100}a,p,span{font-size:14px;font-weight:100}a{padding-bottom:20px}span{padding:20px 0}.box{padding:20px 0 0;background-color:#fff}.container-reset{margin:0 auto;padding:10px;text-align:center}.container-reset a{font-size:20px;color:#333;padding-bottom:20px;margin:0}</style><body><div class="box"><div class="container"><h1>Reset Password</h1></div><div class="box"><h3>Hai, Zakinudin</h3><p>Anda akan melakukan reset password. Klik link dibawah apabila anda akan melanjutkan proses. Demi menjaga kerahasiaan password anda, disarankan untuk menggunakan kombinasi huruf dan angka.</p><p>Klik link berikut untuk membuat</p></div><div class="container-reset"><a href="'.base_url().'login/reset/'.$unicode.'">Reset Password</a></div><div class="container"><span>Copyright &#169; 2016 </span><a href="<?php echo base_url();?>">Banduplaza</a></div></div></body>';
				$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
				$data = array(
				  'html'    => $text, // Deskripsi
				  'text'    => '', // Kosongkan jika isi email pakai html
				  'subject' => 'Reset Password',
				  'from'    => array(
					'name'  => 'Banduplaza',
					'email' => 'zaki@banduplaza.com'
				  ),
				  'to'      => array(
					array(
					  'name'  => $data['get_email'],
					  'email' => $data['get_email']
					)
				  )
				);
				$result = $SPApiProxy->smtpSendMail($data);

				// $config = Array(
				// 	'protocol' => 'smtp',
				// 	'smtp_host' => 'ssl://smtp.googlemail.com',
				// 	'smtp_port' => 465,
				// 	'smtp_user' => 'zakinugraha001@gmail.com', // change it to yours
				// 	'smtp_pass' => 'zakinugraha5150', // change it to yours
				// 	'mailtype' => 'html',
				// 	'charset' => 'iso-8859-1',
				// 	'wordwrap' => TRUE
				// );

				// $this->load->library('email', $config);
				// $this->email->set_newline("\r\n");
				// $this->email->from('halo@banduplaza', 'Banduplaza');
				// $this->email->to($data['get_email']);
				// $this->email->subject('Reset Password');
				// $this->email->message($body);
				// $this->email->set_mailtype("html");
				// $this->email->send();

				$this->session->set_flashdata('message', '<div class="attention-success"><span> Link forgot password sudah dikirim ke email anda. Silahkan cek email anda.</span></div>');
				redirect ('login/forgot');

			} else {
				$this->session->set_flashdata('message', '<div class="attention-warning"><span> Email yang anda masukan tidak terdaftar.</span></div>');
				redirect ('login/forgot');
			}

		} else { // Pertama kali di load
			$this->load->view('layout/header');
			$this->load->view('forgot_password');
			$this->load->view('layout/footer');
		}
		
	} // End function

	public function reset()
	{
		$code = $this->uri->segment(3);
		if ($this->input->post('submit')) {		
			
			$cek = $this->db->query('SELECT * FROM customer WHERE customer_unicode="'.$code.'"')->num_rows();
			if ($cek==1) {
				$get_row = $this->db->query('SELECT * FROM customer WHERE customer_unicode="'.$code.'"')->row();
				$id = $get_row->customer_id;
				$password = $this->input->post('password');
				$array_data=array(
					'customer_password'=>MD5($password),
					'customer_unicode'=>''
				);
				$this->mod->set_table_name('customer');
				$this->mod->update($id,$array_data);

				$this->session->set_flashdata('message', '<div class="attention-success"><span> Reset password berhasil.</span></div>');
				redirect ('login/reset/');

			} else {
				$this->session->set_flashdata('message', '<div class="attention-warning"><span> Email yang anda masukan tidak terdaftar. Hubungi administrator.</span></div>');
				redirect ('login/reset/'.$code);
			}

		} else {
			$code = $this->uri->segment(3);
			$get = $this->db->query('SELECT * FROM customer WHERE customer_unicode="'.$code.'" LIMIT 1')->row();
			$data['unicode'] = $get->customer_unicode;
			// echo $data['unicode'];
			// exit;

			$this->load->view('layout/header');
			$this->load->view('reset_password', $data);
			$this->load->view('layout/footer');
		}
			
	} // End function


} // End class