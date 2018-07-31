<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Employees extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
    $this->load->helper('indonesia_date');
    $this->load->library('pagination');
    $this->limit = 10;
  }

  public function index()
  {
    redirect ('admin/employees/all');
  }

  public function all()
  {    
    $offset = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;
    $data['list'] = $this->db->query('SELECT * FROM employees LIMIT '.$this->limit.' offset '.$offset)->result();
    $data['count'] = $this->db->query('SELECT * FROM employees')->num_rows();

    $config['base_url'] = base_url().'admin/employees/all/page/';
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
    $this->load->view('admin/employees/list', $data);
    $this->load->view('admin/layout/footer');    
        
  } // end function

  public function tambah()
  {
    if ($this->input->post('submit')) {
      $this->form_validation->set_message('required', '%s harus diisi');
      $this->form_validation->set_message('is_unique', '%s sudah ada yang pakai');
      $this->form_validation->set_rules('name', 'Nama Pengguna', 'required|xss_clean');
      $this->form_validation->set_rules('username', 'Username', 'required|is_unique[employees.username]|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
      $this->form_validation->set_rules('email', 'Email Pengguna', 'required|is_unique[employees.email]|valid_email|xss_clean');
      if ($this->form_validation->run()==TRUE) {
        $array_data=array(
          'name'=>$this->input->post('name'),
          'username'=>$this->input->post('username'),
          'password'=>base64_encode($this->input->post('password')),
          'email'=>$this->input->post('email'),
          'status_user'=>'Admin',
          'registration_date'=>date('Y-m-d')
        );
        $this->mod->set_table_name('employees');
        $this->mod->insert($array_data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Pengguna berhasil ditambah..</div>');
        redirect ('admin/employees');

      } // end validation
      // Jika validasi gagal
      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/employees/add');
      $this->load->view('admin/layout/footer');
    } else {
      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/employees/add');
      $this->load->view('admin/layout/footer'); 
    }

  } // end function

  public function ubah($id)
  {
    if ($this->input->post('submit')) {
      $this->form_validation->set_message('required', '%s harus diisi');
      $this->form_validation->set_rules('name', 'Nama Pengguna', 'required|xss_clean');
      $this->form_validation->set_rules('username', 'Username', 'required|xss_clean|callback_is_username_exist|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
      $this->form_validation->set_rules('email', 'Email Pengguna', 'required|xss_clean|callback_is_email_exist|valid_email|xss_clean');
      if ($this->form_validation->run()==TRUE) {
        $array_data=array(
          'name'=>$this->input->post('name'),
          'username'=>$this->input->post('username'),
          'password'=>base64_encode($this->input->post('password')),
          'email'=>$this->input->post('email'),
          'status_user'=>'Admin',
          'update_date'=>date('Y-m-d')
        );
        $this->mod->set_table_name('employees');
        $this->mod->update($id,$array_data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Pengguna berhasil dirubah..</div>');
        redirect ('admin/employees');
      } // end validation
      // jika validasi gagal
      $this->mod->set_table_name('employees');
      $data['edit'] = $this->mod->get_by_id($id);

      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/employees/edit', $data);
      $this->load->view('admin/layout/footer'); 
    } else {
      $this->mod->set_table_name('employees');
      $data['edit'] = $this->mod->get_by_id($id);

      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/employees/edit', $data);
      $this->load->view('admin/layout/footer'); 
    }

  } // end function

  function is_username_exist()
  {
      $username_sekarang = $this->input->post('username_hide');
      $username_baru   = $this->input->post('username');

      if ($username_baru === $username_sekarang) {
          return TRUE;
      } else {
          $query = $this->db->get_where('employees', array('username' => $username_baru));

          if($query->num_rows() > 0)  {
              $this->form_validation->set_message('is_username_exist',  "Username sudah terdaftar");
              return FALSE;
          } else {
              return TRUE;
          }
      }
  }

  function is_email_exist()
  {
      $email_sekarang = $this->input->post('email_hide');
      $email_baru   = $this->input->post('email');

      if ($email_baru === $email_sekarang) {
          return TRUE;
      } else {
          $query = $this->db->get_where('employees', array('email' => $email_baru));

          if($query->num_rows() > 0)  {
              $this->form_validation->set_message('is_email_exist',  "Email sudah terdaftar");
              return FALSE;
          } else {
              return TRUE;
          }
      }
  }

  public function hapus($id)
  {
    $this->mod->set_table_name('employees');
    $cek_attr = $this->mod->get_by_id($id);
    $this->mod->delete($id);
    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Pengguna berhasil dihapus..</div>');
    redirect ('admin/employees');
  }

}