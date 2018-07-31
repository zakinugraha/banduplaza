<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Form extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
    $this->load->helper('indonesia_date');
  }

  public function index()
  {

    $this->load->view('admin/layout/header');
    $this->load->view('admin/layout/aside');
    $this->load->view('admin/form');
    $this->load->view('admin/layout/footer');
  }
  
}