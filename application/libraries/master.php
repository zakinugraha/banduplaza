<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Master
	{		
		public function merchant()
		{
			$this->load->library('session');
			$ci =& get_instance();
			$brand_id = $this->session->userdata('brand_id');
			$sql = $ci->db->where('brand', $brand_id)
                        ->get('brand')
                        ->row();	        

            return $sql->brand_id;
		}

	}