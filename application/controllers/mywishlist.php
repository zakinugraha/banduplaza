<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Mywishlist extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library('session');
	}

	public function index()
	{
		$data['count'] = $this->db->query('SELECT * FROM mywishlist WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'"')->num_rows();
		// $data['list'] = $this->db->query('SELECT * FROM mywishlist WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'"')->result();
		$data['list'] = $this->mod->custom_fetch_query('select w.*, p.product_id, p.product_name, p.product_code, p.brand_id, w.stock_management_id, w.mywishlist_qty, w.product_id from product p inner join mywishlist w on (p.product_id=w.product_id) where customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'" order by w.mywishlist_id ASC');
		// $count = $this->mod->custom_fetch_query('select mywishlist.product_id, mywishlist.stock_management_id from mywishlist inner join (select count(*) as total, stock_management.stock_management_id, stock_management.stock_management_value from stock_management) stock_management on mywishlist.stock_management_id=stock_management.stock_management_id');
		
		$this->load->view('layout/header');
		$this->load->view('mywishlist', $data);
		$this->load->view('layout/footer');
	}

	public function delete($id)
	{
		$this->mod->set_table_name('mywishlist');
		$this->mod->delete($id);
		redirect ('mywishlist');
	}

	public function buy($id)
	{
		$get = $this->db->query('SELECT * FROM mywishlist WHERE mywishlist_id="'.$id.'" LIMIT 1')->row();
		$stock = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$get->stock_management_id.'" LIMIT 1')->row();
		$get_size = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_id="'.$stock->size_attributes_id.'" LIMIT 1')->row();
		$cart = $this->db->query('SELECT * FROM product WHERE product_id="'.$get->product_id.'" LIMIT 1')->row();
		// Definition
		$delete_id = $get->mywishlist_id;
		$id = $get->product_id;
		$qty = $get->mywishlist_qty;
		$size = $get->stock_management_id;

		$session_order=array();
		$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
		if(isset($get_session_arr[$id])) {
			foreach ($get_session_arr as $row) {
				foreach($row AS $variable=>$value) {
					${$variable}=$value;
				}

				$session_order=array(
					'product_id'=>$id,
					'brand_id'=>$cart->brand_id,
					'type_nav_page_id'=>$cart->type_nav_page_id,
					'type_category_id'=>$cart->type_category_id,
					'product_name'=>$cart->product_name,
					'product_code'=>$cart->product_code,
					'product_qty'=>$qty,
					'product_size'=>$size,
					'product_price_base'=>$cart->product_price_base, // harga dasar
					'product_price_sell'=>$cart->product_price_sell, // harga jual
					'product_price_discount'=>$cart->product_price_discount, // harga discount
					'product_price'=>$cart->product_price_sell-$cart->product_price_discount, // harga jual dikurangi harga discount (jika ada)
					'product_price_total'=>($cart->product_price_sell-$cart->product_price_discount)*$qty, //  sub total harga setelah dikali qty
					'product_weight'=>$cart->product_weight*$qty
				);
			} // End foreach
		} else {
			$session_order=array(
				'product_id'=>$id,
				'brand_id'=>$cart->brand_id,
				'type_nav_page_id'=>$cart->type_nav_page_id,
				'type_category_id'=>$cart->type_category_id,
				'product_name'=>$cart->product_name,
				'product_code'=>$cart->product_code,
				'product_qty'=>$qty,
				'product_size'=>$size,
				'product_price_base'=>$cart->product_price_base, // harga dasar
				'product_price_sell'=>$cart->product_price_sell, // harga jual
				'product_price_discount'=>$cart->product_price_discount, // harga discount
				'product_price'=>$cart->product_price_sell-$cart->product_price_discount, // harga jual dikurangi harga discount (jika ada)
				'product_price_total'=>($cart->product_price_sell-$cart->product_price_discount)*$qty, //  sub total harga setelah dikali qty
				'product_weight'=>$cart->product_weight*$qty
			);
		}

		// setelah beli, delete produk dari tabel mywishlist
		$this->db->query('DELETE FROM mywishlist WHERE mywishlist_id="'.$delete_id.'"');

		// Buat session order
		$_SESSION['order'][$id] = $session_order;
		redirect('mycart');

	} // End function

} //End Class