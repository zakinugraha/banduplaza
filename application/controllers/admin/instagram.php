<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Instagram extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
    $this->load->library('session');
    $this->load->helper('instaClass');
  }

  public function index()
  {
    $obj_insta = new instaClass();
    $obj_insta->authInstagram();
    
    $this->load->view('admin/layout/header');
    $this->load->view('admin/layout/aside');
    $this->load->view('admin/instagram/list');
    $this->load->view('admin/layout/footer');     
        
  }

  public function home()
  {
    session_start();
    if(!isset($_SESSION['insta_login'])){
      redirect ('admin/instagram?message=session-not-found');
    }

    $this->load->view('admin/layout/header');
    $this->load->view('admin/layout/aside');
    $this->load->view('admin/instagram/home');
    $this->load->view('admin/layout/footer');

  }

  public function callback()
  {
    session_start();
    if(!isset($_GET['code'])){
     redirect ('admin/instagram');
    }
    $obj_insta = new instaClass();
    // Set access token
    $obj_insta->setAccess_token($_GET['code']);
    // Get user details
    $result = $obj_insta->getUserDetails();
    $_SESSION['insta_login'] = $result;

    redirect ('admin/instagram/home');
  }

  


}