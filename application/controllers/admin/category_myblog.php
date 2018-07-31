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

        if(isset($_POST['edit'])) {
          $this->mod->set_table_name('category');
          $array_data=array(
            'category_name'=>$this->input->post('category_name'),
            'category_description'=>$this->input->post('category_description'),
            'category_status'=>$this->input->post('category_status'),
            'category_edited_date'=>date('Y-m-d'),
            'category_color'=>$this->input->post('category_status')=="active"?'#00c0ef':'#dd4b39'
          );
          $this->mod->update($this->input->post('category_id'),$array_data);
          $edited = $this->db->query('SELECT * FROM category WHERE category_id="'.$this->input->post('category_id').'"')->row();
          $edited->permalink = str_replace(" ", "-", $edited->category_id);
          echo json_encode($edited);
        } else {
          $this->mod->set_table_name('category');
          $array_data=array(
            'category_name'=>$this->input->post('category_name'),
            'category_description'=>$this->input->post('category_description'),
            'category_status'=>$this->input->post('category_status'),
            'category_created_date'=>date('Y-m-d'),
            'category_color'=>$this->input->post('category_status')=="active"?'#00c0ef':'#dd4b39'
          );
          $this->mod->insert($array_data);
          $category_id = $this->db->insert_id();
          $new_category = $this->db->query('select * from category where category_id='.$category_id)->row();
          //variabel yang akan dikirim ke proses ajax
          // $new_category->permalink = str_replace(" ", "-", $new_category->category_name);
          echo json_encode($new_category);
        }
      } else {
        $data['list'] = $this->db->query('SELECT * FROM category ORDER BY category_id DESC')->result();
        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/aside');
        $this->load->view('admin/category/list', $data);
        $this->load->view('admin/layout/footer');
      }
          
  }

  public function delete($id) 
  {
    $this->mod->set_table_name('category');
    $this->mod->delete($id);
    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>Kategori artikel berhasil dihapus..</div>');
    redirect ('admin/category');
  }
  
}