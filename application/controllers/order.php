<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('all_model_mdl', 'mod');
        // Initial Midtrans Payment Gateway
        $params = array('server_key' => 'VT-server-YvIiWWkWtfGMgVDlQ-K_9Y01', 'production' => true);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
        $this->load->helper('url'); 
    }

    public function review()
    {
        // Data Customer
        // $customer = $this->db->query('select c.customer_id, c.customer_phone, c.customer_email, a.customer_id, a.name, a.address, a.postcode, a.province, a.city from customer c inner join address a on(c.customer_id=a.customer_id) where c.customer_id="'.$_SESSION['invoice_data']['customer_id'].'"')->row();
        $data['customer_name'] = $_SESSION['invoice_data']['invoice_name'];
        $data['customer_phone'] = $_SESSION['invoice_data']['invoice_phone'];
        $data['customer_email'] = $_SESSION['invoice_data']['invoice_email'];
        $data['customer_address'] = $_SESSION['invoice_data']['invoice_address'];
        $data['customer_postcode'] = $_SESSION['invoice_data']['invoice_postcode'];
        $data['customer_note'] = $_SESSION['invoice_data']['invoice_note'];
        // Billing
        $data['grand_total'] = $_SESSION['invoice_data']['invoice_grand_total'];
        $data['invoice_discount'] = $_SESSION['invoice_data']['invoice_discount'];
        $data['shipping_cost'] = $_SESSION['invoice_data']['invoice_shipping'];
        // Shipping
        $get_province = $this->db->query('SELECT * FROM tbl_area WHERE area_api_id="'.$_SESSION['invoice_data']['invoice_province'].'" && area_par_id="0"')->row();
        $get_city = $this->db->query('SELECT * FROM tbl_area WHERE area_api_id="'.$_SESSION['invoice_data']['invoice_city'].'" && area_par_id="'.$_SESSION['invoice_data']['invoice_province'].'"')->row();
        $data['province'] = $get_province->area_name;
        $data['city'] = $get_city->area_name;

        // Item Details
        $data['list_order'] = $_SESSION['order'];

        // Mandatory for Mandiri bill payment and BCA KlikPay
        // Optional for other payment methods
        $get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
        if (!empty($_SESSION['order'])) {
            $product = $_SESSION['order'];
            $n=0;
            foreach($product as $i => $item) {
                $product_order[] = array(   
                    'id' => $product[$i]['product_id'],
                    'price' => $product[$i]['product_price'],
                    'quantity' => $product[$i]['product_qty'],
                    'name' => $product[$i]['product_name']                          
                );
                $item = $product_order;                     
            }  
        }

        $item[] = array(
            'id' => 'Voucher',
            'price' => ($data['invoice_discount'])*-1,
            'quantity' => 1,
            'name' => "Voucher Discount"
        );

        $item[] = array(
            'id' => 'ship',
            'price' => $data['shipping_cost'],
            'quantity' => 1,
            'name' => "Shipping"
        );

        $item_details = $item;

        $transaction_details = array(           
            'order_id' => $_SESSION['invoice_data']['invoice_number'],
            'gross_amount' => $data['grand_total'] // no decimal allowed
        );

        // Optional
        $billing_address = array(
            'first_name'    => $data['customer_name'],
            'last_name'     => "",
            'address'       => strip_tags($data['customer_address']),
            'city'          => $data['city'],
            'postal_code'   => $data['customer_postcode'],
            'phone'         => $data['customer_phone'],
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => $data['customer_name'],
            'last_name'     => "",
            'address'       => strip_tags($data['customer_address']),
            'city'          => $data['city'],
            'postal_code'   => $data['customer_postcode'],
            'phone'         => $data['customer_phone'],
            'country_code'  => 'IDN'
        );

        $customer_details = array(
            'first_name'    => $data['customer_name'], //optional
            'last_name'     => "", //optional
            'email'         => $data['customer_email'], //mandatory
            'phone'         => $data['customer_phone'], //mandatory
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

        $this->load->view('layout/header_checkout');
        $this->load->view('order_review', $data);
        $this->load->view('layout/footer');
    }

    public function success() 
    {
        $get = isset($_GET['order_id']) && $_GET['order_id']!='';
        if (isset($_SESSION['order'])) {
            if ($get) {

                // Hapus session invoice dan summary order dan session lainnya
                unset($_SESSION['invoice_data']);
                unset($_SESSION['order']);
                unset($_SESSION['discount']);

                $this->load->view('layout/header_finish');
                $this->load->view('order_unfinish');
                $this->load->view('layout/footer');
            }
        } else {
            redirect(base_url());
        }
    }

}