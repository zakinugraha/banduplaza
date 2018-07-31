<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Product extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->library(array('upload', 'image_lib'));
		$this->imagepath = "./upload/images/product/";
	}

	public function get_category($nav_id=0)
	{
		$sql='SELECT * FROM type_category WHERE type_nav_page_id='.intval($nav_id).' ORDER BY type_category_name ASC';
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

	public function index()
	{
		$this->mod->set_table_name('product');
		// $data['list'] = $this->db->query('SELECT * FROM product')->result();
		$data['list'] = $this->mod->custom_fetch_query('select p.*,b.brand_name, t.type_category_name, n.type_nav_page_name from product p inner join brand b on(p.brand_id=b.brand_id) inner join type_category t on (p.type_category_id=t.type_category_id) inner join type_nav_page n on (p.type_nav_page_id = n.type_nav_page_id) where p.brand_id="'.$this->session->userdata('brand_id').'" order by product_create_date desc');
		// $data['list'] = $this->mod->custom_fetch_query('select p.*,b.brand_name, t.type_nav_page_name from product p inner join brand b on(p.brand_id=b.brand_id) inner join type_nav_page t on(p.type_category_id=t.type_nav_page_id) order by product_create_date desc');

		$this->load->view('merchant/layout/header');
		$this->load->view('merchant/layout/sidebar');
		$this->load->view('merchant/product/list', $data);
		$this->load->view('merchant/layout/footer');
	} // End Function

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya boleh diisi angka.');
			$this->form_validation->set_message('is_unique', '%s sudah terdaftar.');
			$this->form_validation->set_rules('product_name', 'Nama produk', 'required|xss_clean');
			$this->form_validation->set_rules('type_category_id', 'Kategori', 'required|xss_clean');
			$this->form_validation->set_rules('product_code', 'Kode produk', 'required|xss_clean|is_unique[product.product_code]');
			$this->form_validation->set_rules('product_price_base', 'Harga dasar produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_price_sell', 'Harga jual produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_weight', 'Berat produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_size', 'Ukuran produk', 'required|xss_clean');
			$this->form_validation->set_rules('product_description', 'Deskripsi produk', 'required|xss_clean');
			$this->form_validation->set_rules('size_s', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_m', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_l', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_xl', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_36', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_37', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_38', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_39', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_40', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_41', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_42', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_43', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_44', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_45', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_all', 'Size ', 'numeric|xss_clean');

			if ($this->form_validation->run()==TRUE) {

				// $category_page_id = $this->db->query('SELECT * FROM type_category WHERE type_category_id="'.$this->input->post('type_category_id').'" LIMIT 1')->row();
				$array_data=array(
					'brand_id'=>$this->input->post('brand_id'),
					'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'brand_id'=>$this->session->userdata('brand_id'),
					'type_category_id'=>$this->input->post('type_category_id'),
					'size_type_id'=>$this->input->post('product_size'),
					'product_name'=>$this->input->post('product_name'),
					'product_code'=>$this->input->post('product_code'),
					'product_price_base'=>$this->input->post('product_price_base'),
					'product_price_sell'=>$this->input->post('product_price_sell'),
					'product_price_discount'=>$this->input->post('product_price_discount'),
					'product_weight'=>$this->input->post('product_weight'),
					'product_permalink'=>$this->input->post('product_permalink'),
					'product_description'=>$this->input->post('product_description'),
					'product_status'=>$this->input->post('product_status'),
					'product_create_date'=>date('Y-m-d H:i:s'),
					'product_update_date'=>date('Y-m-d H:i:s')
				);

				// echo "<pre>";
				// print_r($array_data);
				// exit;

				$this->mod->set_table_name('product');
				$this->mod->insert($array_data);
				// End insert product

				// Declaration variable size attribute
				$size = $this->input->post('product_size');
				$get_last_id = $this->db->query('SELECT * FROM product ORDER BY product_id DESC LIMIT 1')->row(); // Get las product ID
				$array_size=array(
					'size_type_id'=>$this->input->post('product_size'),
					'product_id'=>$get_last_id->product_id
				);

				if ($size=="1") { // Jika $size = 1 / size
					$array_size['size_s'] = $this->input->post('size_s')==""?"0":$this->input->post('size_s');
					$array_size['size_m'] = $this->input->post('size_m')==""?"0":$this->input->post('size_m');
					$array_size['size_l'] = $this->input->post('size_l')==""?"0":$this->input->post('size_l');
					$array_size['size_xl'] = $this->input->post('size_xl')==""?"0":$this->input->post('size_xl');
				} else if ($size=="2") { // Jika $size = 2 / shoes
					$array_size['size_36'] = $this->input->post('size_36')==""?"0":$this->input->post('size_36');
					$array_size['size_37'] = $this->input->post('size_37')==""?"0":$this->input->post('size_37');
					$array_size['size_38'] = $this->input->post('size_38')==""?"0":$this->input->post('size_38');
					$array_size['size_39'] = $this->input->post('size_39')==""?"0":$this->input->post('size_39');
					$array_size['size_40'] = $this->input->post('size_40')==""?"0":$this->input->post('size_40');
					$array_size['size_41'] = $this->input->post('size_41')==""?"0":$this->input->post('size_41');
					$array_size['size_42'] = $this->input->post('size_42')==""?"0":$this->input->post('size_42');
					$array_size['size_43'] = $this->input->post('size_43')==""?"0":$this->input->post('size_43');
					$array_size['size_44'] = $this->input->post('size_44')==""?"0":$this->input->post('size_44');
					$array_size['size_45'] = $this->input->post('size_45')==""?"0":$this->input->post('size_45');
				} else { // Jika $size = 3 / all
					$array_size['size_all'] = $this->input->post('size_all')==""?"0":$this->input->post('size_all');
				}		
				$this->mod->set_table_name('size_attribute'); // Insert size attribute
				$this->mod->insert($array_size);		
				// End Declaration variable size attribute

				// Start upload product
				$get_last_id = $this->db->query('SELECT * FROM product ORDER BY product_id DESC LIMIT 1')->row(); // Get las product ID
				$number_of_files = sizeof($_FILES['product_image']['tmp_name']);
				for ($i=0; $i < $number_of_files; $i++) {
					$files = $_FILES['product_image'];
					$alias = time().$i.'_'.$files['name'][$i];

			        $config['upload_path'] = "./upload/images/product/";
			        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
			        $config['file_name'] = $alias;
			        $this->upload->initialize($config);
			        if (!$files['name'][$i]=='') {
			        	 move_uploaded_file($_FILES['product_image']['tmp_name'][$i], './upload/images/product/'.$this->upload->file_name);

				        $config['source_image']	= './upload/images/product/'.$this->upload->file_name;
						$config['new_image'] = './upload/images/product/'.$this->upload->file_name;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 600;
						$config['height'] = 798;
						$this->image_lib->initialize($config); 
						$this->image_lib->resize();
						
						$array_image=array(
							'product_id'=>$get_last_id->product_id,
							'image_product_file_name'=>$this->upload->file_name
						);
						$this->mod->set_table_name('image_product');
						$this->mod->insert($array_image);
			        } else {
			        	
			        }			       
				} // End Looping
				// End upload product
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses tambah produk baru<br></div>');
				redirect ('merchant/product');

			} // End IF Validation

			$this->load->view('merchant/layout/header');
			$this->load->view('merchant/layout/sidebar');
			$this->load->view('merchant/product/add');
			$this->load->view('merchant/layout/footer');
		} else { // Pertama kali dibuka
			$this->load->view('merchant/layout/header');
			$this->load->view('merchant/layout/sidebar');
			$this->load->view('merchant/product/add');
			$this->load->view('merchant/layout/footer');
		}
	} // End Function

	public function edit($id)
	{
		if ($this->input->post('submit')) {
			$this->mod->set_table_name('product');
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_message('numeric', '%s hanya berisi angka.');
			$this->form_validation->set_rules('type_category_id', 'Kategori', 'required|xss_clean');
			$this->form_validation->set_rules('product_name', 'Nama produk', 'required|xss_clean');
			$this->form_validation->set_rules('product_code', 'Kode produk', 'required|xss_clean');
			$this->form_validation->set_rules('product_price_base', 'Harga dasar produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_price_sell', 'Harga jual produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_weight', 'Berat produk', 'required|numeric|xss_clean');
			$this->form_validation->set_rules('product_size', 'Ukuran produk', 'required|xss_clean');
			$this->form_validation->set_rules('product_description', 'Deskripsi produk', 'required|xss_clean');
			$this->form_validation->set_rules('size_s', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_m', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_l', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_xl', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_36', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_37', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_38', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_39', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_40', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_41', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_42', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_43', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_44', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_45', 'Size ', 'numeric|xss_clean');
			$this->form_validation->set_rules('size_all', 'Size ', 'numeric|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'brand_id'=>$this->input->post('brand_id'),
					'type_nav_page_id'=>$this->input->post('type_nav_page_id'),
					'brand_id'=>$this->session->userdata('brand_id'),
					'type_category_id'=>$this->input->post('type_category_id'),
					'size_type_id'=>$this->input->post('product_size'),
					'product_name'=>$this->input->post('product_name'),
					'product_code'=>$this->input->post('product_code'),
					'product_price_base'=>$this->input->post('product_price_base'),
					'product_price_sell'=>$this->input->post('product_price_sell'),
					'product_price_discount'=>$this->input->post('product_price_discount'),
					'product_weight'=>$this->input->post('product_weight'),
					'product_permalink'=>$this->input->post('product_permalink'),
					'product_description'=>$this->input->post('product_description'),
					'product_status'=>$this->input->post('product_status'),
					'product_update_date'=>date('Y-m-d H:i:s')
				);
				$data['product'] = $this->mod->get_by_id($id);
				$this->mod->update($id,$array_data);
				$size_prod_id = $data['product']->product_id;
				// End edit product tabel

				// Start edit size
				$size = $this->input->post('product_size');
				$data['product_id'] = $this->mod->get_by_id($id);
				$array_size=array(
					'size_type_id'=>$this->input->post('product_size'),
					'product_id'=>$data['product_id']->product_id
				);

				if ($size=="1") { // Jika $size = 1 / size
					$array_size['size_s'] = $this->input->post('size_s')==""?"0":$this->input->post('size_s');
					$array_size['size_m'] = $this->input->post('size_m')==""?"0":$this->input->post('size_m');
					$array_size['size_l'] = $this->input->post('size_l')==""?"0":$this->input->post('size_l');
					$array_size['size_xl'] = $this->input->post('size_xl')==""?"0":$this->input->post('size_xl');
				} else if ($size=="2") { // Jika $size = 2 / shoes
					$array_size['size_36'] = $this->input->post('size_36')==""?"0":$this->input->post('size_36');
					$array_size['size_37'] = $this->input->post('size_37')==""?"0":$this->input->post('size_37');
					$array_size['size_38'] = $this->input->post('size_38')==""?"0":$this->input->post('size_38');
					$array_size['size_39'] = $this->input->post('size_39')==""?"0":$this->input->post('size_39');
					$array_size['size_40'] = $this->input->post('size_40')==""?"0":$this->input->post('size_40');
					$array_size['size_41'] = $this->input->post('size_41')==""?"0":$this->input->post('size_41');
					$array_size['size_42'] = $this->input->post('size_42')==""?"0":$this->input->post('size_42');
					$array_size['size_43'] = $this->input->post('size_43')==""?"0":$this->input->post('size_43');
					$array_size['size_44'] = $this->input->post('size_44')==""?"0":$this->input->post('size_44');
					$array_size['size_45'] = $this->input->post('size_45')==""?"0":$this->input->post('size_45');
				} else { // Jika $size = 3 / all
					$array_size['size_all'] = $this->input->post('size_all')==""?"0":$this->input->post('size_all');
				}
				
				$this->mod->set_table_name('size_attribute');
				$get_id_size = $this->db->query('SELECT * FROM size_attribute WHERE product_id="'.$size_prod_id.'" LIMIT 1')->row();

				$this->mod->update($get_id_size->size_attribute_id,$array_size);
				// End Edit Size

				// Start upload product
				$number_of_files = sizeof($_FILES['product_image']['tmp_name']);
				for ($i=0; $i < $number_of_files; $i++) {
					$files = $_FILES['product_image'];
					$alias = time().$i.$files['name'][$i];
			        $config['upload_path'] = "./upload/images/product/";
			        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
			        $config['file_name'] = $alias;
			        $this->upload->initialize($config);
			        if (!$files['name'][$i]=='') {
			        	move_uploaded_file($_FILES['product_image']['tmp_name'][$i], './upload/images/product/'.$this->upload->file_name);

				        $config['source_image']	= './upload/images/product/'.$this->upload->file_name;
						$config['new_image'] = './upload/images/product/'.$this->upload->file_name;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 600;
						$config['height'] = 798;
						$this->image_lib->initialize($config); 
						$this->image_lib->resize();
						
						$array_image=array(
							'product_id'=>$id,
							'image_product_file_name'=>$this->upload->file_name
						);
						$this->mod->set_table_name('image_product');
						$this->mod->update($this->input->post('image_id_'.$i),$array_image);
			        } else {
			        	
			        }			       
				} // End Looping
				
				$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses Edit produk<br></div>');
				redirect ('merchant/product');
			} // End IF Validation
			$this->mod->set_table_name('product');
			$data['product'] = $this->mod->get_by_id($id);
			$data['get_last_id'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'"')->result();

			$this->load->view('merchant/layout/header');
			$this->load->view('merchant/layout/sidebar');
			$this->load->view('merchant/product/edit', $data);
			$this->load->view('merchant/layout/footer');
		} else {
			$this->mod->set_table_name('product');
			$data['product'] = $this->mod->get_by_id($id);
			$data['get_size_type'] = $this->db->query('SELECT * FROM size_attribute WHERE product_id="'.$data['product']->product_id.'" LIMIT 1')->row();
			$data['get_last_id'] = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$id.'"')->result();

			$this->load->view('merchant/layout/header');
			$this->load->view('merchant/layout/sidebar');
			$this->load->view('merchant/product/edit', $data);
			$this->load->view('merchant/layout/footer');
		}
		
	} // End Function	

	public function delete($id)
	{
		$this->mod->set_table_name('product');
		$cek_attr = $this->mod->get_by_id($id);
		$this->mod->delete($id);

		$this->db->query('DELETE FROM size_attribute WHERE product_id="'.$cek_attr->product_id.'"');

		$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus produk<br></div>');
		redirect ('merchant/product');
	} // End Function


}