<main id="main-content" class="main-content">
    <section id="finish" class="finish">
        <div class="container">

            <?php
                if ($this->input->get('invoice')!='') {
            ?>

            <div class="content">
                <div class="detail">
                    <div class="detail-header">
                        <div class="col-md-8">
                            <h5>Invoice No</h5>
                            <h3><?php echo $this->input->get('invoice');?></h3>
                            <p class="status" style="background-color:<?php echo $status->invoice_status_color;?>"><?php echo $status->invoice_status_name;?></p>
                            <p>Tanggal Order : <?php echo $detail->invoice_date_order;?></p>
                            <p>Tanggal Expired : <?php echo $detail->invoice_date_expired;?></p>
                            <p>Metode Pembayaran : Transfer Bank</p>
                        </div>
                        <div class="col-md-4">
                            <p>Penerima : <?php echo $address->name;?></p>
                            <p>No Telp : <?php echo $detail->customer_phone;?></p>
                            <p>Alamat</p>
                            <p><?php echo $address->address;?></p>
                            <p><?php echo $city->area_name;?></p>
                            <p><?php echo $province->area_name;?></p>
                        </div>                        
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Size</th>              
                                        <th>Price</th>              
                                        <th>Discount</th>              
                                        <th>Total</th>              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($list AS $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row->product_name.' ('.$row->product_code.') * '.$row->product_qty;?></td>
                                        <td>
                                        <?php 
                                            $stock = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$row->product_size.'" LIMIT 1')->row();
                                            $size = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_id="'.$stock->size_attributes_id.'" LIMIT 1')->row();
                                            echo $size->size_attributes_value; 
                                        ?> 
                                        </td>
                                        <td>Rp. <?php echo number_format($row->product_price_sell,0);?></td>
                                        <td>Rp. <?php echo number_format($row->product_price_discount,0);?></td>
                                        <td>Rp. <?php echo number_format($row->product_price_sell-$row->product_price_discount,0);?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4">Discount Voucher</td>
                                        <td>Rp. <?php echo number_format($detail->invoice_discount,0);?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Shipping</td>                                        
                   <?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Customers extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('indonesia_date');
	}

	public function index()
	{
		$this->mod->set_table_name('customer');
		$data['list'] = $this->db->query('SELECT * FROM customer')->result();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/customers/list', $data);
		$this->load->view('admin/layout/footer');
	}

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('customer');
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_rules('customer_name', 'Customer Name', 'required|xss_clean');
			$this->form_validation->set_rules('c