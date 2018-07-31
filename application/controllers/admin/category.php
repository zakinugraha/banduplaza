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
      if ($this->input->post('submit')) {
        if ($this->input->post('select')==0) {
          $array_nav=array(
            'type_nav_page_name'=>$this->input->post('type_name'),
            'type_nav_page_desc'=>$this->input->post('type_deskripsi')
          );
          $this->mod->set_table_name('type_nav_page');
          $this->mod->insert($array_nav);
          redirect ('admin/category');
        } else {
          $array_data=array(
            'type_nav_page_id'=>$this->input->post('select'),
            'type_category_name'=>$this->input->post('type_name'),
            'type_category_desc'=>$this->input->post('type_deskripsi')
          );
          $this->mod->set_table_name('type_category');
          $this->mod->insert($array_data);
          redirect ('admin/category');
        }
        
      } else {
        $data['list'] = $this->db->query('SELECT * FROM type_category ORDER BY type_category_id DESC')->result();
        $data['navigation'] = $this->db->query('SELECT * FROM type_nav_page')->result();

        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/aside');
        $this->load->view('admin/category/list', $data);
        $this->load->view('admin/layout/footer');
      }
          
  } // end function

  public function delete($id)
  {
    $this->mod->set_table_name('type_nav_page');
    $this->mod->delete($id);
    $this->db->query('DELETE FROM type_category WHERE type_nav_page_id='.$id);
    $this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus kategori<br></div>');
    redirect ('admin/category');
  }

  public function delete_sub($id)
  {
    $this->mod->set_table_name('type_category');
    $this->mod->delete($id);
    $this->session->set_flashdata('success', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sukses hapus sub kategori<br></div>');
    redirect('admin/category');
  }


}