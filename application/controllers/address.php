<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Address extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('all_model_mdl', 'mod');
		$this->load->model('api_raja_ongkir');
		$this->origin_id=22; // Kota Pengiriman, default = 'Bandung'
	}

	public function get_city($province_id=0)
	{
		$sql='SELECT * FROM tbl_area WHERE area_par_id='.intval($province_id);
		$exec=$this->db->query($sql);
		$results=$exec->result_array();
		echo json_encode($results);
	}

	public function index()
	{
		$cek = $this->db->query('SELECT * FROM address WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'"')->num_rows();
		if ($cek==0) {
			$this->load->view('layout/header');
			$this->load->view('address');
			$this->load->view('layout/footer');
		} else {
			$data['config'] = $this->db->query('SELECT * FROM address WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'" LIMIT 1')->row();
			$data['provinsi'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="0" && area_api_id="'.$data['config']->province.'" LIMIT 1')->row();
			$data['city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['config']->province.'" && area_api_id="'.$data['config']->city.'" LIMIT 1')->row();

			$this->load->view('layout/header');
			$this->load->view('address', $data);
			$this->load->view('layout/footer');
		}
		
	}

	public function add()
	{
		if (!empty($_SESSION['user_customer'])) {
			if ($this->input->post('submit')) {
				$this->form_validation->set_message('required', '%s harus diisi.');
				$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
				$this->form_validation->set_rules('name', 'Nama', 'required|xss_clean');
				$this->form_validation->set_rules('province', 'Provinsi', 'required|xss_clean');
				$this->form_validation->set_rules('city', 'Kota', 'required|xss_clean');
				$this->form_validation->set_rules('address', 'Alamat', 'required|xss_clean');
				if ($this->form_validation->run()==TRUE) {
					$array_data=array(
						'customer_id'=>base64_decode($_SESSION['user_customer']['customer_id']),
						'title'=>$this->input->post('title'),
						'name'=>$this->input->post('name'),
						'province'=>$this->input->post('province'),
						'city'=>$this->input->post('city'),
						'address'=>$this->input->post('address'),
						'postcode'=>$this->input->post('postcode'),
						'date_add'=>date('y-m-d H:i:s'),
						'date_update'=>date('y-m-d H:i:s'),
					);
					$this->mod->set_table_name('address');
					$this->mod->insert($array_data);

					$this->session->set_flashdata('message', '<div class="attention-success"><span> Alamat telah berhasil ditambahkan.</span></div>');
					redirect ('configuration/address');
				}

				$this->mod->set_table_name('tbl_area');
				$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
				$data['origin_id']=$this->origin_id;

				$this->load->view('layout/header');
				$this->load->view('layout/sidebar-conf');
				$this->load->view('add_address', $data);
				$this->load->view('layout/footer');

			} else { // pertama kali di load
				$this->mod->set_table_name('tbl_area');
				$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
				$data['origin_id']=$this->origin_id;

				$data['config'] = $this->db->query('SELECT * FROM address WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'" LIMIT 1')->row();

				$this->load->view('layout/header');
				$this->load->view('layout/sidebar-conf');
				$this->load->view('add_address', $data);
				$this->load->view('layout/footer');
			} // end if
		} else { // Jika tidak ada session user_customer
			redirect ('login');
		}
		

	} // End function

	public function edit()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_message('required', '%s harus diisi.');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('name', 'Nama', 'required|xss_clean');
			$this->form_validation->set_rules('province', 'Provinsi', 'required|xss_clean');
			$this->form_validation->set_rules('city', 'Kota', 'required|xss_clean');
			$this->form_validation->set_rules('address', 'Alamat', 'required|xss_clean');
			if ($this->form_validation->run()==TRUE) {
				$array_data=array(
					'customer_id'=>base64_decode($_SESSION['user_customer']['customer_id']),
					'title'=>$this->input->post('title'),
					'name'=>$this->input->post('name'),
					'province'=>$this->input->post('province'),
					'city'=>$this->input->post('city'),
					'address'=>$this->input->post('address'),
					'postcode'=>$this->input->post('postcode'),
					'date_add'=>date('y-m-d H:i:s'),
					'date_update'=>date('y-m-d H:i:s'),
				);
				$this->mod->set_table_name('address');
				$this->mod->update(base64_decode($_SESSION['user_customer']['customer_id']),$array_data);

				$this->session->set_flashdata('message', '<div class="attention-success"><span> Alamat telah berhasil dirubah.</span></div>');
				redirect ('configuration/address');
			}

			$this->mod->set_table_name('tbl_area');
			$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
			$data['origin_id']=$this->origin_id;

			$this->load->view('layout/header');
			$this->load->view('layout/sidebar-conf');
			$this->load->view('edit_address', $data);
			$this->load->view('layout/footer');

		} else { // pertama kali di load
			$data['config'] = $this->db->query('SELECT * FROM address WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'" LIMIT 1')->row();

			$this->mod->set_table_name('tbl_area');
			$data['province'] = $this->db->query("SELECT * FROM tbl_area WHERE area_par_id='0'")->result();
			$data['city'] = $this->db->query('SELECT * FROM tbl_area WHERE area_par_id="'.$data['config']->province.'"')->result();
			$data['origin_id']=$this->origin_id;

			$this->load->view('layout/header');
			$this->load->view('layout/sidebar-conf');
			$this->load->view('edit_address', $data);
			$this->load->view('layout/footer');
		} // end if

	}


} // End class