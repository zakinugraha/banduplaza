<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Trace extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$now = date('Y-m-d H:i:s');
		$cek_invoice = $this->db->query('SELECT * FROM invoice WHERE invoice_date_expired<"'.$now.'" && invoice_status_id="1"')->result();		
		foreach ($cek_invoice AS $exp) {
			$id = $exp->invoice_id;
			$invoice_number = $this->db->query('SELECT * FROM summary_order WHERE invoice_number="'.$exp->invoice_number.'"')->result();
			foreach ($invoice_number AS $data) {
				$cek_type_size = $this->db->query('SELECT * FROM product WHERE product_id="'.$data->product_id.'" LIMIT 1')->row();
				$get_size_type = $cek_type_size->size_type_id;
				if ($get_size_type!="4") {
					$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$data->product_id.'" && stock_management_id="'.$data->product_size.'" LIMIT 1')->row();
					$stock_now = $get_stock->stock_management_value;
					$total_stock = $stock_now+$data->product_qty;
					$this->db->query('UPDATE stock_management SET stock_management_value='.$total_stock.' WHERE product_id="'.$data->product_id.'" && stock_management_id="'.$data->product_size.'"');
				} else { // Jika size type id berasal dari CURL
					// do nothing
				} // end if
				
			} // end foreach
			
			// Delete summary order
			$this->mod->set_table_name('summary_order');
			$this->db->query('DELETE FROM summary_order WHERE invoice_number="'.$exp->invoice_number.'"');
			
			// Update invoice_status_id
			$array_data=array(
				'invoice_status_id'=>'6'
			);
			$this->mod->set_table_name('invoice');
			$this->mod->update($id,$array_data);
			
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

			$body = 'Order dengan Invoice #'.$exp->invoice_number.' telah expired karena sudah melewati batas tempo pembayaran.<br>Apabila anda telah melakukan pembayaran, harap melakukan konfirmasi order <a href="'.base_url().'confirm">disini</a> atau hubungi administrator.';
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('zakinugraha001@gmail.com', 'Banduplaza');
			$this->email->to($get_email->customer_email);
			$this->email->subject('Order '.$exp->invoice_number.' - jatuh tempo');
			$this->email->message($body);
			$this->email->send();

		} // end foreach

	} // end function

}