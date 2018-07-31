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

	public function view($id)
	{
		$uri = $this->uri->segment(4);
		$param = explode("-", $uri);
		$id = end($param);
		$this->mod->set_table_name('product');
		$cart = $this->mod->get_by_id($id);
		$qty = $this->input->post('quant');
		$size = $this->input->post('size');

		if ($this->uri->segment(3)=='shoes' || $this->uri->segment(3)=='bag') {
			if ($this->input->post('submit')) { // Jika di klik submit

				$cek = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$id.'" && stock_management_id="'.$size.'" LIMIT 1')->row();
				$get_size_qty = $cek->stock_management_value; // Jika stock berasal dari database	
				$price_now = $cart->product_price_discount>'0' ? $cart->product_price_discount : $cart->product_price_sell;	

				$get_id = $this->db->query('SELECT * FROM product WHERE product_id="'.$id.'" LIMIT 1')->row();
				$data['nav_name'] = $this->db->query('SELECT * FROM type_nav_page WHERE type_nav_page_id="'.$get_id->type_nav_page_id.'" LIMIT 1')->row();	

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
					redirect (base_url().'product/view/'.strtolower($data['nav_name']->type_nav_page_name).'/'.url_title(strtolower($cart->product_name.'-'.$cart->product_code)).'-'.$cart->product_id.'?attention=warning');
				} else { // Jika stock barang tidak mencukupi
					redirect (base_url().'product/view/'.strtolower($data['nav_name']->type_nav_page_name).'/'.url_title(strtolower($cart->product_name.'-'.$cart->product_code)).'-'.$cart->product_id.'?message=warning');
				}
				
			} else { // Pertama kali muncul

				$this->mod->set_table_name('product');
				$data['view'] = $this->mod->get_by_id($id);

				$id = $data['view']->product_id;
				$total_view = $data['view']->product_total_view;
				$array_data=array(
					'product_total_view'=>$total_view+1
				);
				$this->mod->update($id,$array_data);	

				// tambah point_view untuk tabel grafik
				$this->mod->set_table_name('grafik_view');
				$count_view = $this->db->query('SELECT * FROM grafik_view WHERE product_id="'.$id.'" && grafik_view_date="'.date('Y-m-d').'"')->num_rows();
				if ($count_view>0){
					$get_view = $this->db->query('SELECT * FROM grafik_view WHERE product_id="'.$id.'" && grafik_view_date="'.date('Y-m-d').'"')->row();
					// echo $get_view->grafik_view_point+1;
					// exit;
					$array_grafik=array(
						'product_id'=>$id,
						'grafik_view_point'=>$get_view->grafik_view_point+1,
						'grafik_view_date'=>date('Y-m-d')
					);	
					$this->mod->update($get_view->grafik_view_id,$array_grafik);
				} else {					
					$array_grafik=array(
						'product_id'=>$id,
						'grafik_view_point'=>'1',
						'grafik_view_date'=>date('Y-m-d')
					);	
					$this->mod->insert($array_grafik);
				}
				

				$get_id = $this->db->query('SELECT * FROM product WHERE product_id="'.$id.'" LIMIT 1')->row();
				$data['nav_name'] = $this->db->query('SELECT * FROM type_nav_page WHERE type_nav_page_id="'.$get_id->type_nav_page_id.'" LIMIT 1')->row();
				$data['category'] = $this->db->query('SELECT * FROM type_category WHERE type_category_id="'.$get_id->type_category_id.'" LIMIT 1')->row();

				// Breadcrumb
				$data['breadcrumb'] = $this->uri->segment(4);
				$data['breadcrumb_category'] = $data['nav_name'];

				// Informasi Stock
				$data['stock'] = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where m.product_id="'.$data['view']->product_id.'" order by m.size_attributes_id asc');

				$data['brand'] = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$data['view']->brand_id.'"')->row();
				$data['related'] = $this->db->query('SELECT * FROM product WHERE type_category_id="'.$data['view']->type_category_id.'" && product_id!="'.$data['view']->product_id.'" && product_status="publish" ORDER BY product_total_view DESC LIMIT 10')->result();
				$data['like'] = $this->db->query('SELECT * FROM product WHERE type_category_id!="'.$data['view']->type_category_id.'" && product_id!="'.$data['view']->product_id.'" ORDER BY product_total_view DESC LIMIT 1')->row();

				$nav_alias = $data['nav_name']->type_nav_page_name=='Shoes' ? 'Sepatu' : 'Tas';
				$data['title'] = 'Jual '.$nav_alias.' '.$data['brand']->brand_name.' type '.$data['view']->product_name.' - Pusat Sepatu dan Tas Terlengkap';

				$this->load->view('layout/header_content', $data);
				$this->load->view('view', $data);
				$this->load->view('layout/footer');
			} // End if input post submit / End first time loaded
		} else {
			redirect (base_url());
		}

			
		
	} // End function

	public function add_to_cart($id=0)
	{
		$id = $this->input->get('product_id');
		$qty = $this->input->get('qty');
		$size = $this->input->get('size');

		$cart = $this->db->query('SELECT * FROM product WHERE product_id="'.$id.'" limit 1')->row();
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
					'product_size'=>$size,
					'product_price_base'=>$cart->product_price_base, // harga dasar
					'product_price_sell'=>$cart->product_price_sell, // harga jual
					'product_price_discount'=>$cart->product_price_discount, // harga discount
					'product_price'=>$price_now, // harga saat ini
					'product_price_total'=>$price_now*$qty, //  sub total harga setelah dikali qty
					'product_weight'=>$cart->product_weight*$qty
				);
			}
			$_SESSION['order'][$id] = $session_order; // Buat session session_order
			$cart_status = array('val'=>'1','text'=>'Produk berhasil ditambahkan ke keranjang belanja','img'=>'add-to-cart-success.png'); // Status "1", add to cart sukses, array berhasil dibuat
			echo json_encode($cart_status);
		} else {
			$cart_status = array('val'=>'0','text'=>'Stok produk tidak mencukupi','img'=>'add-to-cart-fail.png'); // Status "0", stok produk tidak mencukupi
			echo json_encode($cart_status);
		}
	}


	public function delete()
	{
		unset($_SESSION['order']);
	}

	public function print_sess()
	{
		echo "<pre>";
		print_r($_SESSION['order']);
		echo "</pre>";
		exit;
	}

	public function related($product_id=0,$category_id=0)
	{
		$id = $this->input->get('id');
		$category_id = $this->input->get('category_id');
		$list = $this->mod->custom_fetch_query('select p.product_id, p.product_name, p.product_price_sell, p.product_price_discount, p.product_status, p.type_nav_page_id, p.brand_id, p.type_category_id, t.type_nav_page_id, t.type_nav_page_name, b.brand_id, b.brand_name, i.product_id, i.image_product_file_name, i.image_product_status from product p inner join type_nav_page t on (p.type_nav_page_id=t.type_nav_page_id) inner join brand b on (p.brand_id=b.brand_id) inner join image_product i on(p.product_id=i.product_id) where p.product_id!="'.$id.'" && p.product_status="publish" && p.type_category_id="'.$category_id.'" && i.image_product_status="default" limit 10');
		echo json_encode($list);
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