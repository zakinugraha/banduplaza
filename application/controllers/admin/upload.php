<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Upload extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->helper('resize');
		$this->load->library(array('upload', 'image_lib', 'pagination'));
		$this->limit = 20;
	}

	public function index()
	{
 		
		//Config utama, folder target dan folder tujuan / hasil resize
		$folderImages    = './upload/images/new_product/'; //folder target, diakhiri dengan slash
		$folderTarget    = './upload/images/new_product/thumbnail/'; //folder tujuan, diakhiri dengan slash
		$lebarImageBaru      = 350; //lebar images hasil resize
		$tinggiImageBaru     = 350; // tinggi images hasil resize
		$kualitasImage        = 80; //kualitas images 0 - 100
		 
		//buka folder target, lakukan loop ke semua images dan proses resize
		if($dir = opendir($folderImages)){
		    while(($file = readdir($dir))!== false){
		 
		        $imagePath = $folderImages.$file;
		        $targetPath = $folderTarget.$file;
		        $checkValidImage = @getimagesize($imagePath);
		 		
		 		if (!file_exists($targetPath)) { // Cek jika file belum di resize
		 			
			        if (file_exists($imagePath) && $checkValidImage) { //lanjutkan jika 2 parameter yg dicek TRUE
			        
			            //Image valid, proses resize.
			            if (resizeImage($imagePath,$targetPath,$lebarImageBaru,$tinggiImageBaru,$kualitasImage)) {
			            	
					    		echo $file.' resize Berhasil!<br />';
					    	
			                
			                /*
			                Image sudah berhasil diresize disini,
							Kalau mau menyimpan informasi di database bisa lakukan di scope ini
			                */
			 
			            } else {
			                redirect (base_url().'admin/product?status=resize_failed');
			            }
			        }

			    }
			    
		    }
		    closedir($dir);
		}
			
	}

	

	public function tambah()
	{
		if ($this->input->post('submit')) {

			// Start upload product
			$get_last_id = $this->db->query('SELECT * FROM product ORDER BY product_id DESC LIMIT 1')->row(); // Get las product ID
			$number_of_files = sizeof($_FILES['product_image']['tmp_name']);
			for ($i=0; $i < $number_of_files; $i++) {
				// Upload large image
				$files = $_FILES['product_image'];				
		        if (!$files['name'][$i]=='') {
		        	// upload large image
		        	$alias = $i.time().'_'.$files['name'][$i];
			        $config['upload_path'] = "./upload/images/new_product/";
			        $config['allowed_types'] = 'gif|jpg|png|JPEG|jpeg';
			        $config['file_name'] = $alias;
			        $this->upload->initialize($config);
			        move_uploaded_file($_FILES['product_image']['tmp_name'][$i], './upload/images/new_product/'.$this->upload->file_name);
			        $config['source_image']	= './upload/images/new_product/'.$this->upload->file_name;
					$config['new_image'] = './upload/images/new_product/'.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 1100;
					$config['height'] = 1100;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
					
					echo 'sukses upload gambar '.$this->upload->file_name.'<br />';

		        } else {
		        	// do nothing
		        }

		        //resize
				//Config utama, folder target dan folder tujuan / hasil resize
				$folderImages    = './upload/images/new_product/'; //folder target, diakhiri dengan slash
				$folderTarget    = './upload/images/new_product/thumbnail/'; //folder tujuan, diakhiri dengan slash
				$lebarImageBaru      = 350; //lebar images hasil resize
				$tinggiImageBaru     = 350; // tinggi images hasil resize
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
					            	if (file_exists($file)) {
							    		echo 'File '.$file.' sudah di resize<br />';
							    	} else {
							    		echo $file.' resize Berhasil!<br />';
							    	}
					                
					                /*
					                Image sudah berhasil diresize disini,
									Kalau mau menyimpan informasi di database bisa lakukan di scope ini
					                */
					 
					            } else {
					                redirect (base_url().'admin/product?status=resize_failed');
					            }
					        }

					    }
					    
				    }
				    closedir($dir);
				}

			} // End Looping Upload Image
			

			// End upload product
			// $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Produk baru berhasil ditambah..</div>');
			// redirect ('admin/upload/tambah');
		} else {
			$this->load->view('admin/layout/header');
			$this->load->view('admin/layout/aside');
			$this->load->view('admin/product/upload');
			$this->load->view('admin/layout/footer');
		}

	} // end function


} // end class