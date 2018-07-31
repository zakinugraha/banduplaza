<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Product extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper(array('indonesia_date', 'resize'));
		$this->load->library(array('upload', 'image_lib', 'pagination'));
		$this->imagepath = "./upload/images/product/";
		$this->limit = 20;
	}

	public function index()
	{
		redirect ('admin/product/all');
	}

	public function get_category($nav_id=0)
	{
		$sql='SELECT * FROM type_category WHERE type_nav_page_id='.intval($nav_id).' ORDER BY type_category_name ASC';
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

	public function all()
	{		
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;

		$urut = isset($_GET['sort_by']);
		if ($urut) {
			switch($_GET['sort_by']) {
				case 'newest';
					$sort = 'order by product_create_date desc';
					$data['select'] = 'Produk Terbaru';
					break;
				case 'best-seller';
					$sort = 'order by product_total_point desc';
					$data['select'] = 'Produk Terlaris';
					break;
				case 'popular';
					$sort = 'order by product_total_view desc';
					$data['select'] = 'Paling banyak dilihat';
					break;
			} // end switch
		} else {
			$array_sort['sort_by'] = '';
			$sort = 'order by product_create_date desc';
			$data['select'] = 'Produk Terbaru';
		}

		$data['list'] = $this->mod->custom_fetch_query('select p.*,b.brand_name, t.type_category_name, n.type_nav_page_name, r.promo_id, r.promo_discount_type, r.promo_value from product p inner join brand b on(p.brand_id=b.brand_id) inner join type_category t on (p.type_category_id=t.type_category_id) inner join type_nav_page n on (p.type_nav_page_id = n.type_nav_page_id) inner join promo r on (p.promo_id=r.promo_id) '.$sort.' limit '.$this->limit.' offset '.$offset); // order by product_total_view
		$data['count'] = $this->db->query('SELECT * FROM product')->num_rows();
		
		$config['base_url'] = base_url().'admin/product/all/page/';
	    $config['total_rows'] = $data['count'];
	    $config['uri_segment'] = 5;
	    $config['per_page'] = $this->limit;
	    $config['addtional_params'] = isset($_GET['sort_by']) ? '?sort_by='.$_GET['sort_by'] : '';
	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['first_link'] = '&laquo';
	    $config['last_link'] = '&raquo';
	    $config['prev_link'] = '&lsaquo;';
	    $config['prev_tag_open'] = '<li class="prev">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '&rsaquo;';
	    $config['next_tag_open'] = '<li>';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li>';
	    $config['last_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active"><a href="#">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';

	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/aside');
		$this->load->view('admin/product/list', $data);
		$this->load->view('admin/layout/footer');		
		
			
	} // End Function


	public function tambah()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya boleh diisi angka.');
			$this->form_validation->set_message('is_unique', '%s sudah terdaftar.');
			$this->form_validation->set_rules('product_name', 'Nama produk', 'required|xss_clean');
			$this->form_validation->set_rules('type_category_id', 'Kategori', 'required|xss_clean');
			$this->form_validation->set_rules('type_gender_id', 'Gender', 'required|xss_clean');
			$this->form_validation->set_rules('product_code', 'Kode produk', 'required|xss_clean|is_unique[product.product_code]');
			$this->form_validation->set_rules('product_price_base', 'Harga dasar produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_price_sell', 'Harga jual produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_weight', 'Berat produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_short_desc', 'Deskripsi singkat', 'required|xss_clean');
			$this->form_validation->set_rules('product_description', 'Deskripsi produk', 'required|xss_clean');
			// $this->form_validation->set_rules('product_meta', 'Meta', 'required|xss_clean');

			if ($this->form_validation->run()==TRUE) {
				$get_discount = $this->db->query('SELECT * FROM promo WHERE promo_id="'.$this->input->post('promo_id').'" LIMIT 1')->row();

				// insert to tabel product
				$price_sell = $this->input->post('product_price_sell');
				if ($get_discount->promo_discount_type==2) { // Jika type discount adalah 2 atau dengan percent, maka...
					$total_discount = $get_discount->promo_value/100;
					$final_price = $price_sell-ceil($price_sell*$total_discount);
				} else if ($get_discount->promo_discount_type==3) {
					$total_discount = $get_discount->promo_value;
					$final_price = $price_sell-$total_discount;
				} else {
					$final_price = '0';
				}

				$array_data=array(
					'brand_id'=>$this->input->post('brand_id'),
					'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'brand_id'=>$this->input->post('brand_id'),
					'type_category_id'=>$this->input->post('type_category_id'),
					'type_gender_id'=>$this->input->post('type_gender_id'),
					'promo_id'=>$this->input->post('promo_id'),
					'product_name'=>$this->input->post('product_name'),
					'product_code'=>$this->input->post('product_code'),
					'product_price_base'=>$this->input->post('product_price_base'),
					'product_price_sell'=>$this->input->post('product_price_sell'),
					'product_price_discount'=>$final_price,
					'product_weight'=>$this->input->post('product_weight'),
					'product_source_size'=>$this->input->post('size_source'),
					'product_tags'=>$this->input->post('product_tags'),
					'product_rating'=>$this->input->post('product_rating'),
					'product_short_desc'=>$this->input->post('product_short_desc'),
					'product_description'=>$this->input->post('product_description'),
					'product_status'=>$this->input->post('product_status'),
					'product_meta'=>$this->input->post('product_meta'),
					'product_create_date'=>date('Y-m-d H:i:s'),
					'product_update_date'=>date('Y-m-d H:i:s')
				);

				$this->mod->set_table_name('product');
				$this->mod->insert($array_data);
				// End insert product

				// Pendefinisian judul gambar
				// Nav / Item
				switch($this->input->post('type_nav_page_id')) {
					case '1':
				        $img_nav = 'sepatu';
				        break;
				    case '2':
				        $img_nav = 'tas';
				        break;
				} // End switch		

				// Start upload product
				$get_last_id = $this->db->query('SELECT * FROM product ORDER BY product_id DESC LIMIT 1')->row(); // Get las product ID
				$number_of_files = sizeof($_FILES['product_image']['tmp_name']);
				for ($i=0; $i < $number_of_files; $i++) {
					// Upload large image
					$files = $_FILES['product_image'];
					$alias = $i.time().'_'.$img_nav.'_'.$files['name'][$i];
			        $config['upload_path'] = "./upload/images/product/";
			        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
			        $config['file_name'] = $alias;
			        $this->upload->initialize($config);
			        if (!$files['name'][$i]=='') {
			        	move_uploaded_file($_FILES['product_image']['tmp_name'][$i], './upload/images/product/'.$this->upload->file_name);
				        $config['source_image']	= './upload/images/product/'.$this->upload->file_name;
						$config['new_image'] = './upload/images/product/'.$this->upload->file_name;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 1100;
						$config['height'] = 1100;
						$this->image_lib->initialize($config); 
						$this->image_lib->resize();

						if ($i=="0") {
							$image_product_status = "default";
						} else {
							$image_product_status = "second";
						}
						

						$array_image=array(
							'product_id'=>$get_last_id->product_id,
							'image_product_file_name'=>$this->upload->file_name,
							'image_product_status'=>$image_product_status
						);
						$this->mod->set_table_name('image_product');
						$this->mod->insert($array_image);
			        } else {
			        	// do nothing
			        }

				} // End Looping Upload Image
				
				//resize
				//Config utama, folder target dan folder tujuan / hasil resize
				$folderImages    = './upload/images/product/'; //folder target, diakhiri dengan slash
				$folderTarget    = './upload/images/product/thumbs/'; //folder tujuan, diakhiri dengan slash
				$lebarImageBaru      = 300; //lebar images hasil resize
				$tinggiImageBaru     = 300; // tinggi images hasil resize
				$kualitasImage        = 80; //kualitas images 0 - 100
				 
				//buka folder target, lakukan loop ke semua images dan proses resize
				if($dir = opendir($folderImages)){
				    while(($file = readdir($dir))!== false){
				 
				        $imagePath = $folderImages.$file;
				        $targetPath = $folderTarget.$file;
				        $checkValidImage = @getimagesize($imagePath);
				 		
				 		if (!file_exists($targetPath)) {
				 			
					        if (file_exists($imagePath) && $checkValidImage) { //lanjutkan jika 2 parameter yg dicek TRUE
					        
					            //Image valid, proses resize.
					            if (resizeImage($imagePath,$targetPath,$lebarImageBaru,$tinggiImageBaru,$kualitasImage)) {
							    	/*
					                Image berhasil di resize
					                */
					 
					            } else {
					                redirect (base_url().'admin/product?status=resize_failed');
					            }
					        }

					    }
					    
				    }
				    closedir($dir);

				}

				// End upload product
				$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Produk baru berhasil ditambah..</div>');
				redirect ('admin/product');

			} // End IF Validation

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/product/add');
			$this->load->view('admin/layout/footer');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/product/add');
			$this->load->view('admin/layout/footer');
		}

	} // end function

	public function ubah($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('product');
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya berisi angka.');
			$this->form_validation->set_rules('brand_id', 'Brand', 'required|xss_clean');
			$this->form_validation->set_rules('type_category_id', 'Kategori', 'required|xss_clean');
			$this->form_validation->set_rules('type_gender_id', 'Gender', 'required|xss_clean');
			$this->form_validation->set_rules('product_name', 'Nama produk', 'required|xss_clean');
			$this->form_validation->set_rules('product_code', 'Kode produk', 'required|xss_clean');
			$this->form_validation->set_rules('product_price_base', 'Harga dasar produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_price_sell', 'Harga jual produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_weight', 'Berat produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_short_desc', 'Deskripsi singkat', 'required|xss_clean');
			$this->form_validation->set_rules('product_description', 'Deskripsi produk', 'required|xss_clean');
			// $this->form_validation->set_rules('product_meta', 'Meta', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$get_discount = $this->db->query('SELECT * FROM promo WHERE promo_id="'.$this->input->post('promo_id').'" LIMIT 1')->row();
				
				// Pendefinisian judul gambar
				// Nav / Item
				switch($this->input->post('type_nav_page_id')) {
					case '1':
				        $img_nav = 'sepatu';
				        break;
				    case '2':
				        $img_nav = 'tas';
				        break;
				} // End switch

				// Start upload product
				$number_of_files = sizeof($_FILES['product_image']['tmp_name']);
				for ($i=0; $i < $number_of_files; $i++) {
					$files = $_FILES['product_image'];
					$alias = $i.time().'_'.$img_nav.'_'.$files['name'][$i];
			        $config['upload_path'] = "./upload/images/product/";
			        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
			        $config['file_name'] = $alias;
			        $this->upload->initialize($config);
			        if (!$files['name'][$i]=='') {			        	
		        		move_uploaded_file($_FILES['product_image']['tmp_name'][$i], './upload/images/product/'.$this->upload->file_name);
				        $config['source_image']	= './upload/images/product/'.$this->upload->file_name;
						$config['new_image'] = './upload/images/product/'.$this->upload->file_name;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 1100;
						$config['height'] = 1100;
						$this->image_lib->initialize($config); 
						$this->image_lib->resize();

						if ($i=="0") {
							$image_product_status = "default";
						} else {
							$image_product_status = "second";
						}
						
						$array_image=array(
							'product_id'=>$id,
							'image_product_file_name'=>$this->upload->file_name,
							'image_product_status'=>$image_product_status
						);
						$this->mod->set_table_name('image_product');
						$this->mod->update($this->input->post('image_id_'.$i),$array_image);

						//resize
						//Config utama, folder target dan folder tujuan / hasil resize
						$folderImages    = './upload/images/product/'; //folder target, diakhiri dengan slash
						$folderTarget    = './upload/images/product/thumbs/'; //folder tujuan, diakhiri dengan slash
						$lebarImageBaru      = 300; //lebar images hasil resize
						$tinggiImageBaru     = 300; // tinggi images hasil resize
						$kualitasImage        = 80; //kualitas images 0 - 100
						 
						//buka folder target, lakukan loop ke semua images dan proses resize

						if($dir = opendir($folderImages)){ // folder images/product
						    while(($file = readdir($dir))!== false){
						 	
						        $imagePath = $folderImages.$this->upload->file_name;
						        $targetPath = $folderTarget.$this->upload->file_name;
						        $checkValidImage = @getimagesize($imagePath);
						 		
						 		if (!file_exists($targetPath)) { // kalau file tidak ada di folder target, maka...
						 			
							        if (file_exists($imagePath) && $checkValidImage) { //lanjutkan jika 2 parameter yg dicek TRUE
							        
							            //Image valid, proses resize.
							            if (resizeImage($imagePath,$targetPath,$lebarImageBaru,$tinggiImageBaru,$kualitasImage)) {
									    	/*
							                Image berhasil di resize
							                */
							 
							            } else {
							                redirect (base_url().'admin/product?status=resize_failed');
							            }
							        }

							    }
							    
						    }
						    closedir($dir);

						}
			        } else {
			        	
			        }
				} // End Looping

				

				// edit to tabel product
				$price_sell = $this->input->post('product_price_sell');
				if ($get_discount->promo_discount_type==2) { // Jika type discount adalah 2 atau dengan percent, maka...
					$total_discount = $get_discount->promo_value/100;
					$final_price = $price_sell-ceil($price_sell*$total_discount);
				} else if ($get_discount->promo_discount_type==3) {
					$total_discount = $get_discount->promo_value;
					$final_price = $price_sell-$total_discount;
				} else {
					$final_price = '0';
				}

				$array_data=array(
					'brand_id'=>$this->input->post('brand_id'),
					'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'brand_id'=>$this->input->post('brand_id'),
					'type_category_id'=>$this->input->post('type_category_id'),
					'type_gender_id'=>$this->input->post('type_gender_id'),
					'promo_id'=>$this->input->post('promo_id'),
					'product_name'=>$this->input->post('product_name'),
					'product_code'=>$this->input->post('product_code'),
					'product_price_base'=>$this->input->post('product_price_base'),
					'product_price_sell'=>$this->input->post('product_price_sell'),
					'product_price_discount'=>$final_price,
					'product_weight'=>$this->input->post('product_weight'),
					'product_source_size'=>$this->input->post('size_source'),
					'product_tags'=>$this->input->post('product_tags'),
					'product_rating'=>$this->input->post('product_rating'),
					'product_short_desc'=>$this->input->post('product_short_desc'),
					'product_description'=>$this->input->post('product_description'),
					'product_status'=>$this->input->post('product_status'),
					'product_meta'=>$this->input->post('product_meta')
					// 'product_create_date'=>date('Y-m-d'),
					// 'product_update_date'=>date('Y-m-d H:i:s')
				);
				$this->mod->set_table_name('product');
				$data['product'] = $this->mod->get_by_id($id);
				$this->mod->update($id,$array_data);
				$size_prod_id = $data['product']->product_id;
				// End edit product tabel
				
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Edit produk<br></div>');
				redirect ('admin/product');
			} // End IF Validation
			$this->mod->set_table_name('product');
			$data['product'] = $this->mod->get_by_id($id);
			$data['count'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'"')->num_rows();
			$data['get_last_id'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'"')->result();
			$data['get_size_type'] = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where product_id='.$data['product']->product_id);

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/product/edit', $data);
			$this->load->view('admin/layout/footer');
		} else { // Pertama kali di load
			$this->mod->set_table_name('product');
			$data['product'] = $this->mod->get_by_id($id);
			$data['count'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'" && image_product_status!="thumb"')->num_rows();
			// $data['get_size_type'] = $this->db->query('SELECT * FROM size_attributes WHERE product_id="'.$data['product']->product_id.'" LIMIT 1')->row();
			$data['get_last_id'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'" && image_product_status!="thumb"')->result();
			$data['thumb'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'" && image_product_status="thumb"')->row();
			// $data['get_size_type'] = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where product_id='.$data['product']->product_id);
			
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/product/edit', $data);
			$this->load->view('admin/layout/footer');
		}
		
	} // End Function

	public function search()
	{		
		$offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;

		$urut = isset($_GET['sort_by']);
		if ($urut) {
			switch($_GET['sort_by']) {
				case 'newest';
					$sort = 'order by product_create_date desc';
					$data['select'] = 'Produk Terbaru';
					break;
				case 'best-seller';
					$sort = 'order by product_total_point desc';
					$data['select'] = 'Produk Terlaris';
					break;
				case 'popular';
					$sort = 'order by product_total_view desc';
					$data['select'] = 'Paling banyak dilihat';
					break;
			} // end switch
		} else {
			$array_sort['sort_by'] = '';
			$sort = 'order by product_create_date desc';
			$data['select'] = 'Produk Terbaru';
		}

		$data['search'] = (isset($_GET['q']))?$_GET['q']:'';
		$data['list'] = $this->mod->custom_fetch_query('select p.*,b.brand_name, t.type_category_name, n.type_nav_page_name, r.promo_id, r.promo_discount_type, r.promo_value from product p inner join brand b on(p.brand_id=b.brand_id) inner join type_category t on (p.type_category_id=t.type_category_id) inner join type_nav_page n on (p.type_nav_page_id = n.type_nav_page_id) inner join promo r on (p.promo_id=r.promo_id) where p.product_name LIKE "%'.$data['search'].'%" '.$sort.' limit '.$this->limit.' offset '.$offset); // order by product_total_view
		$data['count'] = $this->db->query('SELECT * FROM product WHERE product_name LIKE "%'.$data['search'].'%"')->num_rows();
		
		$config['base_url'] = base_url().'admin/product/search/page/';
	    $config['total_rows'] = $data['count'];
	    $config['uri_segment'] = 5;
	    $config['addtional_params'] = isset($_GET['sort_by']) ? '?sort_by='.$_GET['sort_by'] : '';
	    $config['per_page'] = $this->limit;
	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['first_link'] = '&laquo';
	    $config['last_link'] = '&raquo';
	    $config['prev_link'] = '&lsaquo;';
	    $config['prev_tag_open'] = '<li class="prev">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '&rsaquo;';
	    $config['next_tag_open'] = '<li>';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li>';
	    $config['last_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active"><a href="#">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';

	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/aside');
		$this->load->view('admin/product/search', $data);
		$this->load->view('admin/layout/footer');		
		
			
	} // End Function

	public function update_stock () {
		$sm_id = $this->input->get('id');
		$total_stock = $this->input->get('value'); // Total stock now
		$array_stock=array(
			'stock_management_value'=>$total_stock
		);
		$this->mod->set_table_name('stock_management');
		$this->mod->update($sm_id,$array_stock);

		// Update total stock di tabel product
		$get_product_id = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$sm_id.'"')->result();
		foreach ($get_product_id AS $row) {
			$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$row->product_id.'"')->result();
			$stock = 0;
			foreach ($get_stock AS $get) {
				$stock+=$get->stock_management_value;
			}
			$product_total_stock = $stock;
			$array_data=array(
				'product_total_stock'=>$product_total_stock
			);
			$this->mod->set_table_name('product');
			$this->mod->update($row->product_id,$array_data);
		}
		echo json_encode($array_stock);
	} // end function

	public function combination($id)
	{		
		if ($this->input->post('submit')) { // Jika di klik Submit
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya berisi angka.');
			$this->form_validation->set_rules('stock_value', 'Attribut', 'required|xss_clean');
			$this->form_validation->set_rules('size_attributes_id', 'Value', 'required|xss_clean');
			$this->form_validation->set_rules('stock_management_value', 'Quantity', 'required|numeric|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$init = $this->db->query('SELECT * FROM product WHERE product_code="'.$this->input->post('product_code').'" LIMIT 1')->row();
				$product_id = $this->uri->segment(4);
				$size = $this->input->post('stock_management_value');
				$stock = $this->input->post('stock_value');
				$stock_value = $stock==""?"0":$stock;
				// Cek apakah size tersebut sudah ada atau belum
				$cek = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$product_id.'" && size_attributes_id="'.$size.'"')->num_rows();
				if ($cek>0) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Kombinasi Size tersebut sudah ada<br></div>');
					redirect('admin/product/combination/'.$product_id);				
				} else {
					$size_arr=array(
						'product_id'=>$id,
						'size_attributes_id'=>$size,
						'stock_management_value'=>$stock_value
					);
					$this->mod->set_table_name('stock_management');
					$this->mod->insert($size_arr);

					// update total stock di tabel product
					$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$id.'"')->result();
					$stock = 0;
					foreach ($get_stock AS $get) {
						$stock+=$get->stock_management_value;
					}
					$product_total_stock = $stock;	
					$array_update=array(
						'product_total_stock'=>$product_total_stock
					);	
					$this->mod->set_table_name('product');
					$this->mod->update($id,$array_update);
					
					$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah kombinasi baru<br></div>');
					redirect('admin/product/combination/'.$id);
				} // End IF

			} // End Validation

		} else { // Pertama kali ditampilkan
			$this->mod->set_table_name('product');
			$data['init'] = $this->mod->get_by_id($id);
			$data['product_code'] = $data['init']->product_code;
			$data['product_id'] = $data['init']->product_id;
			$data['list_attr'] = $this->mod->custom_fetch_query('select m.*, a.size_attributes_id, a.size_attributes_value from stock_management m inner join size_attributes a on (m.size_attributes_id=a.size_attributes_id) where product_id="'.$id.'" order by a.size_attributes_id asc');

			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/product/add_size', $data);
			$this->load->view('admin/layout/footer');
		} // End if					
		
	}

	public function delete_selected_size($id)
	{
		$this->mod->set_table_name('stock_management');
		$value = $this->input->post('list_attr');
		foreach ($value AS $row) {
			$this->mod->delete($row);			
		}

		$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$id.'"')->result();
		$stock = 0;
		foreach ($get_stock AS $get) {
			$stock+=$get->stock_management_value;
		}
		$product_total_stock = $stock;	
		$array_update=array(
			'product_total_stock'=>$product_total_stock
		);	
		$this->mod->set_table_name('product');
		$this->mod->update($id,$array_update);
		
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus kombinasi baru<br></div>');
		redirect ('admin/product/combination/'.$id);
	}

	public function hapus($id)
	{
		$this->mod->set_table_name('product');
		$cek_attr = $this->mod->get_by_id($id);
		$this->mod->delete($id);

		$this->db->query('DELETE FROM stock_management WHERE product_id="'.$cek_attr->product_id.'"');
		$this->db->query('DELETE FROM image_product WHERE product_id="'.$cek_attr->product_id.'"');

		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus produk<br></div>');
		redirect ('admin/product');
	} // End Function

	public function set_to_first(){
		// $id=$this->uri->segment(4);
		$date_now = date('Y-m-d H:i:s');
		$id = $this->input->get('id');
		$array_data=array(
			'product_id'=>$id,
			'product_update_date'=>$date_now
		);
		$this->mod->set_table_name('product');
		$this->mod->update($id,$array_data);
		echo "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}

	public function set_empty()
	{
		// echo "hahaha";
		// exit;
		$product_id = $this->input->get('id');
		$this->db->query('UPDATE stock_management SET stock_management_value="0" WHERE product_id="'.$product_id.'"');
		$this->db->query('UPDATE product SET product_total_stock="0" WHERE product_id="'.$product_id.'"');
		echo "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}

	public function update_rating()
	{
		$product_id = $this->input->get('id');
		$rating_id = $this->input->get('value');
		// echo $product_id.' - '.$rating_id;
		$array_data=array(
			'product_rating'=>$rating_id
		);
		$this->mod->set_table_name('product');
		$this->mod->update($product_id,$array_data);
		echo json_encode($array_data);
	}

	public function get_combination($size_id=0)
	{
		$sql='SELECT * FROM size_attributes WHERE size_attributes_type='.intval($size_id).' ORDER BY size_attributes_id ASC';
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

	public function delete_size($id)
	{
		$this->mod->set_table_name('stock_management');
		$this->mod->delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus kombinasi size<br></div>');
		redirect ('admin/product');		
	}

	public function update_total_stock()
	{
		$list_id = $this->db->query('SELECT * FROM product ORDER BY product_id ASC')->result();
		foreach ($list_id AS $row) {
			$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$row->product_id.'"')->result();
			$stock = 0;
			foreach ($get_stock AS $get) {
				$stock+=$get->stock_management_value;
			}
			$total_stock = $stock;
			$array_data=array(
				'product_total_stock'=>$total_stock
			);
			$this->mod->set_table_name('product');
			$this->mod->update($row->product_id,$array_data);
			// echo 'Product ID '.$row->product_id.' -> Total Stock '.$total_stock.'<br>';
		}
	}


}