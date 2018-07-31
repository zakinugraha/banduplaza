<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Delete_expired extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$now = date('Y-m-d H:i:s');
		$cek_invoice = $this->db->query('SELECT * FROM invoice WHERE invoice_date_expired<"'.$now.'" && invoice_status_id="1"')->result(); // Cari invoice yang sudah expired
		foreach ($cek_invoice AS $exp) {
			$sum_order = $this->db->query('SELECT * FROM summary_order WHERE invoice_number="'.$exp->invoice_number.'"')->result();
			foreach ($sum_order AS $so) {
				$product_id = $so->product_id;
				$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$product_id.'" && stock_management_id="'.$so->product_size.'"')->row();
				$stock_now = $get_stock->stock_management_value;
				$total_stock_after = $stock_now+$so->product_qty;
				$this->db->query('UPDATE stock_management SET stock_management_value='.$total_stock_after.' WHERE product_id="'.$so->product_id.'" && stock_management_id="'.$so->product_size.'"');
			} // End foreach $sum_order

			// Delete expired product from summary order
			$this->mod->set_table_name('summary_order');
			$this->db->query('DELETE FROM summary_order WHERE invoice_number="'.$exp->invoice_number.'"');

			// Update invoice_status_id
			$array_data=array(
				'invoice_status_id'=>'6'
			);
			$this->mod->set_table_name('invoice');
			$this->mod->update($exp->invoice_id,$array_data);

			// Send email order expired
			$get_email = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$exp->customer_id.'" LIMIT 1')->row();
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

			$body = 'Order dengan Invoice #'.$exp->invoice_number.' telah melewati batas tempo pembayaran.<br>Apabila anda telah melakukan pembayaran, silahkan hubungi administrator.';
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('zakinugraha001@gmail.com', 'BanduPlaza');
			$this->email->to($get_email->customer_email);
			$this->email->subject('Your order expired');
			$this->email->message($body);
			$this->email->send();
		} // End foreach $cek_invoice

	} // End function


} // End class