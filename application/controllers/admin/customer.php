<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Customer extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
    $this->load->helper('indonesia_date');
    $this->load->library('pagination');
    $this->limit = 20;
  }

  public function index()
  {
    redirect ('admin/customer/all');
  }

  public function all()
  {    
    $offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
    $data['list'] = $this->db->query('SELECT * FROM customer LIMIT '.$this->limit.' offset '.$offset)->result();
    $data['count'] = $this->db->query('SELECT * FROM customer')->num_rows();

    $config['base_url'] = base_url().'admin/customer/all/page/';
    $config['total_rows'] = $data['count'];
    $config['uri_segment'] = 5;
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
    $this->load->view('admin/customer/list', $data);
    $this->load->view('admin/layout/footer');    
        
  } // end function

  public function ubah($id)
  {
    if ($this->input->post('submit')) {
      $this->mod->set_table_name('customer');
      $this->form_validation->set_message('required', '%s is required');
      $this->form_validation->set_message('required', '%s is required');
      $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|xss_clean');
      $this->form_validation->set_rules('customer_email', 'Email Address', 'required|xss_clean|valid_email');
      if ($this->form_validation->run()==TRUE) {
        $array_data=array(
          'customer_title'=>$this->input->post('customer_title'),
          'customer_name'=>$this->input->post('customer_name'),
          'customer_email'=>$this->input->post('customer_email'),
          'customer_newsletter'=>$this->input->post('customer_newsletter'),
          'customer_status'=>$this->input->post('customer_status')
        );
        // echo "<pre>";
        // print_r($array_data);
        // echo "</pre>";
        // exit;
        $this->mod->set_table_name('customer');
        $this->mod->update($id,$array_data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Pengguna berhasil dirubah..</div>');
        redirect ('admin/customer');
      } // end validation
      // jika validasi gagal
      $this->mod->set_table_name('customer');
      $data['edit'] = $this->mod->get_by_id($id);

      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/customer/edit', $data);
      $this->load->view('admin/layout/footer'); 
    } else {
      $this->mod->set_table_name('customer');
      $data['edit'] = $this->mod->get_by_id($id);

      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/customer/edit', $data);
      $this->load->view('admin/layout/footer'); 
    }

  } // end function

  public function hapus($id)
  {
    $this->mod->set_table_name('customer');
    $cek_attr = $this->mod->get_by_id($id);
    $this->mod->delete($id);
    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Pengguna berhasil dihapus..</div>');
    redirect ('admin/customer');
  }

}