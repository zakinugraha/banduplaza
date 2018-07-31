<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Image extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
	}

	public function index()
	{
		$get = $this->db->query('SELECT * FROM product')->result();
		foreach ($get AS $row) {
			$image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'" LIMIT 1')->row();
			$this->db->query('UPDATE image_product SET image_product_status="default" WHERE image_product_id="'.$image_default->image_product_id.'"');
			// echo '<img src="'.base_url().'upload/images/product/thumbs/'.$image_default->image_product_file_name.'">';
			echo $image_default->image_product_id.' : '.$image_default->image_product_file_name.'<br>';
		}

	} // End function

}