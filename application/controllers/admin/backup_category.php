<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Category extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('all_model_mdl', 'mod');
    $this->load->helper('indonesia_date');
  }

  public function index()
  {
    if (!empty($_POST)) {
      $array_data=array(
        'category_name'=>$this->input->post('category_name'),
        'category_description'=>$this->input->post('category_description'),
        'category_status'=>$this->input->post('category_status'),
        'category_created_date'=>date('Y-m-d')
      );
      if(isset($_POST['edit'])){
        $this->mod->update($this->input->post('category_id'),$array_data);
        $edit_category=$this->db->query('SELECT * FROM category WHERE category_id="'.$this->input->post('category_id').'"')->row();
        $edit_category->permalink = str_replace(" ", "-", $edit_category->category_name);
        echo json_encode($edit_category);
      } else {
        $this->mod->set_table_name('category');
        $this->mod->insert($array_data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Kategori artikel berhasil ditambah..</div>');
        redirect ('admin/category');
      }
    } else {      
      $data['list'] = $this->db->query('SELECT * FROM category ORDER BY category_id DESC')->result();
      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/category/list', $data);
      $this->load->view('admin/layout/footer');
    }

      
  }
  
}