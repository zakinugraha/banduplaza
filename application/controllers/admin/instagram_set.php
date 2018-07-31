<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Instagram_set extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    
    $this->load->view('admin/layout/header');
    $this->load->view('admin/layout/aside');
    $this->load->view('admin/instagram/list2');
    $this->load->view('admin/layout/footer');     
        
  }


}