  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Kategori Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Kategori</a></li>
        <li class="active">Daftar Kategori</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message') ?>
        </div>
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Kategori</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama Kategori</label>
                  <div class="col-sm-9">
                    <input type="text" name="type_name" class="form-control" id="type_name" placeholder="Nama Kategori">
                    <?php echo form_error('type_name', '<p class="text-red">', '</p>');?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Dibawah Kategori</label>
                  <div class="col-sm-9">
                    <select name="select" class="form-control">                      
                      <?php
                        foreach ($navigation AS $nav) {
                          echo '<option value="'.$nav->type_nav_page_id.'">'.$nav->type_nav_page_name.'</option>';
                        } 
                      ?>
                      <option value="0">[ Buat kategori baru ]</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi Kategori</label>
                  <div class="col-sm-9">
                    <textarea name="type_deskripsi" class="form-control" rows="5" placeholder="Deskripsi Kategori"></textarea>
                    <?php echo form_error('type_deskripsi', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="Submit" name="submit" id="btn_submit_add" value="Tambah Kategori" class="btn btn-info pull-right">
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->

        <div class="col-md-6">
          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Kategori</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <?php
                  $no=0;
                  foreach ($navigation AS $row) {
                ?>
                <tr style="background-color: #f3f3f3;">
                  <th colspan="2"><?php echo $row->type_nav_page_name;?></th>
                  <th style="float:right;">
                    <a href="<?php echo base_url();?>admin/category/delete/<?php echo $row->type_nav_page_id;?>" class="btn btn-danger btn-xs" title="Ubah"><i class="fa fa-trash-o"></i> Hapus Kategori</a>
                  </th>
                </tr>
                <?php
                  $count_sub_kategori=$this->db->query('SELECT * FROM type_category WHERE type_nav_page_id="'.$row->type_nav_page_id.'"')->num_rows(); // Count
                  if ($count_sub_kategori>0) {
                    $sub_kategori=$this->db->query('SELECT * FROM type_category WHERE type_nav_page_id="'.$row->type_nav_page_id.'"')->result();
                    $i=0;
                    foreach ($sub_kategori AS $sub) {
                ?>
                  <tr>
                    <td>
                    <a href="<?php echo base_url();?>admin/category/delete_sub/<?php echo $sub->type_category_id;?>">
                        <img src="<?php echo base_url();?>assets/admin/img/trash.png" alt="Hapus">
                      </a>
                    </td>
                    <td><?php echo $sub->type_category_name;?></td>
                    <td>&nbsp;</td>
                  </tr>
                <?php
                    }
                  } else {
                ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td><?php echo '<small>-- Belum ada kategori --</small>';?></td>
                      <td>&nbsp;</td>
                    </tr>
                <?php
                    
                  }
                ?>
                <tr>
                  
                </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
        </div> 
        <!-- end col-md-6 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- bootstrap color picker -->
  <script src="<?php echo base_url();?>assets/admin/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      $('#btn_submit_add').click(function(){
        var category_name = $('#category_name').val();
        var category_description = $('#category_description').val();
        var category_created_date = $('#category_created_date').val();
        var category_status = $('#category_status').val();
        // var category_status = document.querySelector('input[name="edit_category_status"]:checked').value;

        // validasi
        if(category_name.length==0 || category_name==""){
          alert("Nama Kategori Harus Diisi");
        } else if (category_description.length==0 || category_description=="") {
          alert("Deskripsi Kategori Harus Diisi");
        } else {
          $.ajax({
            url : '<?php echo current_url()?>',
            dataType : 'json',
            type : 'post',
            data : {category_name:category_name,category_description:category_description,category_status:category_status,category_created_date:category_created_date},
            success:function(res) {
              var text = '<li class="item" id="record_'+res.category_id+'">'+
                          '<div class="product-img">'+
                          '<a href="<?php echo base_url();?>admin/category/delete/'+res.category_id+'"><img src="<?php echo base_url();?>assets/admin/img/trash.png" alt="Hapus"></a>'+
                          '</div>'+
                          '<div class="product-info">'+
                          '<a href="javascript:edit_data('+res.category_id+')" class="product-title category_name">'+res.category_name+'</a>'+
                          '<span id="mystatus" class="label pull-right category_status" style="background-color:'+res.category_color+'">'+res.category_status+'</span>'+
                          '<input type="hidden" id="data-'+res.category_id+'" value='+JSON.stringify(res)+' />'+
                          '<span class="product-description category_description">'+res.category_description+'</span>'+
                          '</div></li>';
              //generate hasil html table ke dalam id tablebody
              $("#tablebody").append(text);

              $('input[name=category_name]').val('');
              $('#category_description').val('');
              $("#add-notifikasi").show().fadeOut(5000);
            },
            error:function(res) {
              console.log('Ajax failure ' +res);
            }
          }); 
        }          
      }); // end btn_submit_add


      // edit data
      $('#btn_submit_edit').click(function(){
        var category_name = $('#edit_category_name').val();
        var category_description = $('#edit_category_description').val();
        var category_edited_date = $('#edit_category_edited_date').val();
        var category_id = $('#edit_category_id').val();
        var category_status = $('#edit_category_status').val();
        // var category_status = document.querySelector('input[name="edit_category_status"]:checked').value;

        // validasi    
        if(category_name.length==0 || category_name==""){
          alert("Nama Kategori Harus Diisi");
        } else if (category_description.length==0 || category_description=="") {
          alert("Deskripsi Kategori Harus Diisi");
        } else {
           $.ajax({
            url : '<?php echo current_url()?>',
            dataType : 'json',
            type : 'post',
            cache: false,
            data : {category_name:category_name,category_description:category_description,category_status:category_status,category_id:category_id,category_edited_date:category_edited_date,edit:true},
            success:function(res) {
              console.log('success');

              $("#record_"+res.category_id).find('.category_name').text(res.category_name);
              $("#record_"+res.category_id).find('.category_description').text(res.category_description);
              $("#record_"+res.category_id).find('.category_status').text(res.category_status);
              if (res.category_status=='active') {
               $("#record_"+res.category_id).find('#mystatus').addClass('label-info').removeClass('label-danger');
              } else {
                $("#record_"+res.category_id).find('#mystatus').addClass('label-danger').removeClass('label-info');
              }
              $("#modal-edit").modal('hide');
              $("#notifikasi").show().fadeOut(10000);
            },
            error:function(res) {
             console.log(JSON.stringify(res));
            }
          }); 
        }
         
      }); // end btn_submit_edit


    }); // end document

    function edit_data(data_id){
      var data = $("#data-"+data_id).val();
      data = $.parseJSON(data);
      $("#edit_category_id").val(data_id);
      $("#edit_category_name").val(data.category_name);
      $("#edit_category_description").val(data.category_description);
      // $("#edit_category_color").val(data.category_color);
      $("#edit_category_status").val(data.category_status);
      $("#modal-edit").modal('show');
    }

    // delete kategori
    $('#btn_delete').click(function(){
      var id=$('#edit_category_id').val();
      $.ajax({
        url:'<?php echo base_url();?>admin/category/delete?id='+id,
        dataType:'json',
        type:'get',        
      }); 
      $("#modal-edit").modal('hide');
      window.location.reload();
    });

    $(function () {
      $('.my-colorpicker1').colorpicker()
    });

  </script>