<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Confirm extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->model('api_raja_ongkir');
		$this->load->helper('indonesia_date');
		$this->load->helper(array('sendpulseInterface', 'sendpulse'));
	}

	public function index()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('invoice_number', 'No Invoice', 'required|xss_clean');
			$this->form_validation->set_rules('nominal', 'Nominal transfer', 'required|numeric|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$invoice_number = $this->input->post('invoice_number');
				$id = $this->db->query('SELECT * FROM invoice WHERE invoice_number="'.$invoice_number.'" LIMIT 1')->row();
				$count_invoice_number = $this->db->query('SELECT * FROM invoice WHERE invoice_number="'.$invoice_number.'" && invoice_status_id="1"')->num_rows();
				if ($count_invoice_number==1) {
					$array_data=array(
						'invoice_status_id'=>"2",
						'invoice_confirm_nominal'=>$this->input->post('nominal'),
						'invoice_date_confirm'=>date('Y-m-d H:i:s'),
						'invoice_status_read'=>"not"
					);
					$this->mod->set_table_name('invoice');
					$this->mod->update($id->invoice_id,$array_data);

					// Klo udah bayar, kirim notifikasi email ke sales@banduplaza.com
					$get_customer = $this->db->query('SELECT * FROM invoice WHERE invoice_number="'.$invoice_number.'" LIMIT 1')->row();
					$cid = $get_customer->customer_id;
					$customer = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$cid.'" LIMIT 1')->row();
					$email = $customer->customer_email;
					$get_bank = $this->db->query('SELECT * FROM bank WHERE bank_id="'.$this->input->post('bank').'" LIMIT 1')->row();

					$text='Konfirmasi Pembayaran Invoice no '.$invoice_number.'<br>Rp. '.$this->input->post('nominal').'<br>Lakukan pengecekan!';
					$SPApiProxy = new SendpulseApi( 'ac67c5669e2fa008d5427b244ef618b7', '478ea2cef37085d5abadc9108b023ce4', 'file' );
					$data = array(
					  'html'    => $text, // Deskripsi
					  'text'    => '', // Kosongkan jika isi email pakai html
					  'subject' => 'Konfirmasi Pembayaran No '.$invoice_number,
					  'from'    => array(
						'name'  => 'Banduplaza',
						'email' => 'zaki@banduplaza.com'
					  ),
					  'to'      => array(
						array(
						  'name'  => 'Zaki',
						  'email' => 'bandunetwork@gmail.com'
						)
					  )
					);
					$result = $SPApiProxy->smtpSendMail($data);
					
					redirect('confirm/success?invoice_id='.$invoice_number);
				} else { // Jika number invoice tidak ada
					$this->session->set_flashdata('message', '<div class="attention-warning"><span> Invoice yang anda masukan tidak terdaftar atau sudah terkonfirmasi.</span></div>');
					redirect ('confirm?id='.$invoice_number);
				}

			} // End validation

			$data['bank'] = $this->db->query('SELECT * FROM bank');

			$this->load->view('layout/header');
			$this->load->view('confirm', $data);
			$this->load->view('layout/footer');

		} else {
			$data['bank'] = $this->db->query('SELECT * FROM bank');

			$this->load->view('layout/header');
			$this->load->view('confirm', $data);
			$this->load->view('layout/footer');
		}
			
	} // End function

	public function success()
	{
		$this->load->view('layout/header_complete');
		$this->load->view('confirm_success');
		$this->load->view('layout/footer');
	}

}