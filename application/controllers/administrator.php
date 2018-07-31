<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Administrator extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
  }

  public function index()
  {
    if ($this->input->post('submit')) {
      $username=$this->input->post('username');
      $password=base64_encode($this->input->post('password'));

      $cek=$this->db->query('SELECT * FROM employees WHERE username="'.$username.'" && password="'.$password.'"')->num_rows();
      if ($cek==1) {
        $user=$this->db->query('SELECT * FROM employees WHERE username="'.$username.'" && password="'.$password.'" LIMIT 1')->row();
        $array_session=array(
          'name'=>$user->name,
          'username'=>$user->username,
          'email'=>$user->email,
          'status_user'=>$user->status_user,
          'login' => TRUE
        );
        $_SESSION['user_account'] = $array_session;
        redirect ('admin/dashboard');
        
      } else {
        redirect('administrator?message=error');
      }
    } else {
      // $this->session->set_flashdata('error', '<p class="text-danger text-center">Username or Password not match</p>');
      $this->load->view('administrator');
    }   

  } // End function

  public function logout()
  {
    unset($_SESSION['user_account']);
    $this->session->sess_destroy();
    redirect ('administrator');
  } // End function

  public function set_cookie()
  {
    if ($this->input->post('chk_remember')) {
      $name = 'remember_me_token';
      $value = $this->input->post('username').' - '.MD5($this->input->post('password'));
      $expire = time() - 86500;

      $this->input->set_cookie($name, $value, $expire); 
      redirect('administrator/get_cookie');
    } else {
      echo 'not checked';
    }
    exit;
  }

  public function get_cookie()
  {
    $cookieData = $this->input->cookie('remember_me_token', TRUE);
    if ($cookieData == "") {
      $data["msg"] = "No more cookie! :("; 
    } else { 
      $data["msg"] = $cookieData;
    }
    $this->load->view('get_cookie', $data);
  }


}