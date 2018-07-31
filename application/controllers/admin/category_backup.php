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
      $this->form_validation->set_message('required', '%s harus diisi');
      $this->form_validation->set_rules('category_name', 'Nama Kategori', 'required|xss_clean');
      $this->form_validation->set_rules('category_description', 'Deskripsi Kategori', 'required|xss_clean');
      if ($this->form_validation->run()==TRUE) {
        $this->mod->set_table_name('category');
        $array_data=array(
          'category_name'=>$this->input->post('category_name'),
          'category_description'=>$this->input->post('category_description'),
          'category_status'=>$this->input->post('category_status'),
          'category_created_date'=>date('Y-m-d'),
          'category_edited_date'=>date('Y-m-d')
        );
        $this->mod->insert($array_data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Kategori artikel berhasil ditambah..</div>');
        redirect ('admin/category');
      }
      // Jika validasi gagal
      $data['list'] = $this->db->query('SELECT * FROM category ORDER BY category_id DESC')->result();
      $this->load->view('admin/layout/header');
      $this->load->view('admin/layout/aside');
      $this->load->view('admin/category/list', $data);
      $this->load->view('admin/layout/footer');
    } else {
      if (!empty($_POST)) {
        $array_data=array(
          'category_name'=>$this->input->post('category_name'),
          'category_description'=>$this->input->post('category_description'),
          'category_status'=>$this->input->post('category_status'),
          'category_created_date'=>date('Y-m-d'),
          'category_edited_date'=>date('Y-m-d')
        );
        if(isset($_POST['edit'])){
          $this->mod->update($this->input->post('category_id'),$array_data);
          $edited_category = $this->db->query('select * from category where category_id='.$this->input->post('category_id'))->row();
          $edited_category->permalink = str_replace(" ", "-", $edited_category->company_name);
          echo json_encode($edited_category);
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

  public function edit() 
  {
    $this->mod->set_table_name('category');
    $array_data=array(
      'category_name'=>$this->input->post('edit_category_name'),
      'category_description'=>$this->input->post('edit_category_description'),
      'category_status'=>$this->input->post('edit_category_status'),
      'category_edited_date'=>date('Y-m-d')
    );
    $this->mod->update($this->input->post('edit_category_id'),$array_data);
    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Kategori artikel berhasil dirubah..</div>');
    redirect ('admin/category');
  }

  public function delete($id) 
  {
    $this->mod->set_table_name('category');
    $this->mod->delete($id);
    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Kategori artikel berhasil dihapus..</div>');
    redirect ('admin/category');
  }
  
}