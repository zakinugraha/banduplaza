<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->model('api_stock_mdl', 'scr');
		$this->load->library(array('pagination', 'session'));
		$this->load->helper('indonesia_date');
		$this->limit = 24;
	}

	public function index()
	{
		redirect (base_url());
	}

	public function like()
	{
		$id = $this->uri->segment(3);
		$get = $this->db->query('SELECT * FROM product WHERE product_id='.$id.' LIMIT 1')->row();
		$total_before = $get->product_like;
		$total_after = $total_before+1;
		// echo $total_before;
		$this->mod->set_table_name('product');
		$array_data=array(
			'product_like'=>$total_after
		);
		$this->mod->update($id,$array_data);
		redirect(base_url().'product/view/'.url_title(strtolower($get->product_name.'-'.$get->product_code.'-'.$get->product_id)));
	}


	public function view($id)
	{
		$uri = $this->uri->segment(3);
		$param = explode("-", $uri);
		$id = end($param);
		$this->mod->set_table_name('product');
		$cart = $this->mod->get_by_id($id);
		$qty = $this->input->post('quant');
		$size = $this->input->post('size');

		if ($this->input->post('submit')) { // Jika di klik submit

			$cek = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$id.'" && stock_management_id="'.$size.'" LIMIT 1')->row();
			$get_size_qty = $cek->stock_management_value; // Jika stock berasal dari database	
			$price_now = $cart->product_price_discount>'0' ? $cart->product_price_discount : $cart->product_price_sell;		

			if ($get_size_qty>=$qty) { // Jika stock produk mencukupi

				$session_order=array();
				$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
				if(isset($get_session_arr[$id])) {
					foreach ($get_session_arr as $row) {
						foreach($row AS $variable=>$value) {
							${$variable}=$value;
						}

						$new_qty=$qty; //case jika ada product yang sama update
						if($product_id==$id) {
							$new_qty=$product_qty+$qty;
						}

						$session_order=array(
							'product_id'=>$id,
							'brand_id'=>$cart->brand_id,
							'type_nav_page_id'=>$cart->type_nav_page_id,
							'type_category_id'=>$cart->type_category_id,
							'product_name'=>$cart->product_name,
							'product_code'=>$cart->product_code,
							'product_qty'=>$new_qty,
							'product_size'=>$size,
							'product_price_base'=>$cart->product_price_base, // harga dasar
							'product_price_sell'=>$cart->product_price_sell, // harga jual
							'product_price_discount'=>$cart->product_price_discount, // harga discount
							'product_price'=>$price_now, // harga jual dikurangi harga discount (jika ada)
							'product_price_total'=>$price_now*$new_qty, //  sub total harga setelah dikali qty
							'product_weight'=>$cart->product_weight*$new_qty
						);
					}
				} else {
					$session_order=array(
						'product_id'=>$id,
						'brand_id'=>$cart->brand_id,
						'type_nav_page_id'=>$cart->type_nav_page_id,
						'type_category_id'=>$cart->type_category_id,
						'product_name'=>$cart->product_name,
						'product_code'=>$cart->product_code,
						'product_qty'=>$qty,
						'product_size'=>$this->input->post('size'),
						'product_price_base'=>$cart->product_price_base, // harga dasar
						'product_price_sell'=>$cart->product_price_sell, // harga jual
						'product_price_discount'=>$cart->product_price_discount, // harga discount
						'product_price'=>$price_now, // harga saat ini
						'product_price_total'=>$price_now*$qty, //  sub total harga setelah dikali qty
						'product_weight'=>$cart->product_weight*$qty
					);
				}
			
				$_SESSION['order'][$id] = $session_order; // Buat session session_order
				redirect ('mycart');

			} else if ($this->input->post('size')=="") {
				redirect (base_url().'product/view/'.url_title(strtolower($cart->product_name.'-'.$cart->product_code)).'-'.$cart->product_id.'?attention=warning');
			} else { // Jika stock barang tidak mencukupi
				redirect (base_url().'product/view/'.url_title(strtolower($cart->product_name.'-'.$cart->product_code)).'-'.$cart->product_id.'?message=warning');
			}
				
		} else if ($this->input->post('sm-wish')) { // Jika di klik tambah ke wishlist
			$param = explode("-", $this->uri->segment(3));
			$id = end($param);
			$get_product = $this->db->query('SELECT * FROM product WHERE product_id="'.$id.'" LIMIT 1')->row();
			$name = $get_product->product_name;
			$code = $get_product->product_code;

			$get = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$size.'" LIMIT 1')->row();
			$value = $get->stock_management_value;
			
			if (isset($_SESSION['user_customer'])) {
				if ($this->input->post('size')=="") {
					redirect (base_url().'product/view/'.url_title(strtolower($cart->product_name.'-'.$cart->product_code)).'-'.$cart->product_id.'?attention=warning');
				} else {
					$cek = $this->db->query('SELECT * FROM mywishlist WHERE product_id="'.$id.'" && customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'"')->num_rows();
					if ($cek>0) { // Jika produk tersebut sudah ada di mywishlist
						redirect (base_url().'product/view/'.url_title(strtolower($name.'-'.$code)).'-'.$id.'?mywishlist=ready');
					} else { // Jika produk tersebut belum ada di mywishlist
						$wishlist=array(
							'customer_id'=>base64_decode($_SESSION['user_customer']['customer_id']),
							'product_id'=>$id,
							'mywishlist_qty'=>$this->input->post('quant'),
							'stock_management_id'=>$get->stock_management_id
						);
						$this->mod->set_table_name('mywishlist');
						$this->mod->insert($wishlist);
						redirect('mywishlist');
					}
				}
					
					
			} else {
				redirect ('login?token='.base64_encode('wishlist-'.$id));
			}
				
			// }
		} else { // Pertama kali muncul

			$this->mod->set_table_name('product');
			$data['view'] = $this->mod->get_by_id($id);

			$id = $data['view']->product_id;
			$total_view = $data['view']->product_total_view;
			$array_data=array(
				'product_total_view'=>$total_view+1
			);
			$this->mod->update($id,$array_data);

			$get_id = $this->db->query('SELECT * FROM product WHERE product_id="'.$id.'" LIMIT 1')->row();
			$data['nav_name'] = $this->db->query('SELECT * FROM type_nav_page WHERE type_nav_page_id="'.$get_id->type_nav_page_id.'" LIMIT 1')->row();
			$data['category'] = $this->db->query('SELECT * FROM type_category WHERE type_category_id="'.$get_id->type_category_id.'" LIMIT 1')->row();
			
			// Breadcrumb
			$data['breadcrumb'] = $this->uri->segment(3);
			$data['breadcrumb_category'] = $data['nav_name'];

			// Informasi Stock
			$data['stock'] = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where m.product_id="'.$data['view']->product_id.'" order by m.size_attributes_id asc');

			$data['brand'] = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$data['view']->brand_id.'"')->row();
			$data['related'] = $this->db->query('SELECT * FROM product WHERE type_category_id="'.$data['view']->type_category_id.'" && product_id!="'.$data['view']->product_id.'" && product_status="publish" ORDER BY product_total_view DESC LIMIT 10')->result();
			$data['like'] = $this->db->query('SELECT * FROM product WHERE type_category_id!="'.$data['view']->type_category_id.'" && product_id!="'.$data['view']->product_id.'" ORDER BY product_total_view DESC LIMIT 1')->row();

			$nav_alias = $data['nav_name']->type_nav_page_name=='Shoes' ? 'Sepatu' : 'Tas';
			$data['title'] = 'Jual '.$nav_alias.' '.$data['brand']->brand_name.' type '.$data['view']->product_name.' - Pusat Sepatu dan Tas Terlengkap';

			$this->load->view('layout/header', $data);
			$this->load->view('view', $data);
			$this->load->view('layout/footer');
		} // End if input post submit / End first time loaded
		
	} // End function

	public function review()
	{
		$param = explode("-", $this->uri->segment(3));
		$product_id = end($param);
		$customer_id = base64_decode($_SESSION['user_customer']['customer_id']);
		$cek_sum = $this->db->query('SELECT * FROM summary_order WHERE customer_id="'.$customer_id.'" && product_id="'.$product_id.'"')->num_rows();
		if ($cek_sum==1) {
			$array_data=array(
				'customer_id'=>$customer_id,
				'product_id'=>$product_id,
				'review_description'=>$this->input->post('review_description'),
				'review_create_date'=>date('Y-m-d H:i:s'),
			);
			$this->mod->set_table_name('review');
			$this->mod->insert($array_data);
			$after = $this->db->query('SELECT * FROM product WHERE product_id="'.$product_id.'" LIMIT 1')->row();
			redirect(base_url().'product/view/'.url_title(strtolower($after->product_name.'-'.$after->product_code.'-'.$product_id)));
		} else if ($cek_sum>1) {
			$after = $this->db->query('SELECT * FROM product WHERE product_id="'.$product_id.'" LIMIT 1')->row();
			redirect(base_url().'product/view/'.url_title(strtolower($after->product_name.'-'.$after->product_code.'-'.$product_id)).'?full-order=warning');
		} else {
			$after = $this->db->query('SELECT * FROM product WHERE product_id="'.$product_id.'" LIMIT 1')->row();
			redirect(base_url().'product/view/'.url_title(strtolower($after->product_name.'-'.$after->product_code.'-'.$product_id)).'?empty-order=warning');
		}
	}



}