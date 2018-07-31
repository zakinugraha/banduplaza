<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Dashboard extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
    $this->load->helper('indonesia_date');
  }

  public function index()
  {
    $this->load->view('admin/layout/header');
    $this->load->view('admin/layout/aside');
    $this->load->view('admin/dashboard');
    $this->load->view('admin/layout/footer');
  } // end function

  public function total()
  {    
    $tahun = date("Y");

    // Total Omzet
    $get_omzet = $this->db->query('SELECT invoice_total_price, invoice_date_order, invoice_status_id FROM invoice WHERE date_format(invoice_date_order, "%Y") = "'.$tahun.'" && invoice_status_id>="3" && invoice_status_id<="5"')->result();
    $sub_omzet = 0;
    foreach ($get_omzet AS $omzet) {
      $sub_omzet+=$omzet->invoice_total_price;
    }
    $total_omzet = number_format($sub_omzet);

    // Total Profit
    $get_profit = $this->mod->custom_fetch_query('select i.invoice_number, i.invoice_status_id, s.invoice_number, s.product_price_base from invoice i inner join summary_order s on (i.invoice_number=s.invoice_number) where date_format(invoice_date_order, "%Y") = "'.$tahun.'" && invoice_status_id>="3" && invoice_status_id<="5"');
    $sub_profit = 0;
    foreach ($get_profit AS $row) {
      $sub_profit+=$row->product_price_base;
    }
    $profit = number_format($sub_profit);
    $total_profit = number_format($sub_omzet-$sub_profit);

    // Total Product Terjual
    $count_sell = $this->mod->custom_fetch_query('select i.invoice_number, i.invoice_status_id, s.invoice_number, s.product_price_base from invoice i inner join summary_order s on (i.invoice_number=s.invoice_number) where date_format(invoice_date_order, "%Y") = "'.$tahun.'" && invoice_status_id>="3" && invoice_status_id<="5"');
    $sub_count = 0;
    foreach ($count_sell AS $c) {
      $sub_count+=1;
    }
    $count = $sub_count;

    // Buat array untuk dikirim ke form
    $array_total = array();
    $array_total=array('omzet'=>$total_omzet,'profit'=>$total_profit,'count'=>$count,'target'=>'50,000,000');

    echo json_encode($array_total);
  }

  
}