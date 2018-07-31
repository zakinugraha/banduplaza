Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Kategori Artikel
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
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
            <form method="POST" action="<?php echo base_url();?>admin/category" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Tanggal</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputEmail3" value="<?php echo date('Y-m-d');?>" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="category_status" id="optionsRadios1" value="active" checked>
                        Aktif
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="category_status" id="optionsRadios2" value="draft">
                        Tidak Aktif
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama Kategori</label>
                  <div class="col-sm-9">
                    <input type="text" name="category_name" class="form-control" id="inputEmail3" placeholder="Nama Kategori">
                    <?php echo form_error('category_name', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="category_description" rows="5" placeholder="Deskripsi Kategori"></textarea>
                    <?php echo form_error('category_description', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" name="submit" value="Tambah Kategori" class="btn btn-info pull-right">
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
            <div class="box-body">
              <ul class="products-list product-list-in-box">
              <?php foreach ($list AS $row) { ?>
                <li class="item">
                  <div class="product-info">
                    <a href="javascript:edit_data(<?php echo $row->category_id?>)" class="product-title"><?php echo $row->category_name;?>
                      <span class="label label-<?php echo $row->category_status=="active"?"info":"danger";?> pull-right"><?php echo $row->category_status;?></span>
                    </a>
                    <input type="hidden" id="data-<?php echo $row->category_id ?>" value='<?php echo json_encode($row)?>' />
                    <span class="product-description">
                      <?php echo $row->category_description;?>
                    </span>
                  </div>
                </li>
                <!-- /.item -->
                <?php } ?>
              </ul>
            </div>
            <!-- /.box-body -->

            <!-- /.modal start -->
            <div class="modal fade" id="modal-edit">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ubah Data Kategory</h4>
                  </div>
                  <div class="modal-body">
                    
                    <form class="form-horizontal">

                      <div class="box-body">
                        <div class="form-group">                          
                          <label for="inputEmail3" class="col-sm-3 control-label">Tanggal</label>

                          <div class="col-sm-4">
                            <input type="text" class="form-control" id="category_created_date" value="<?php echo date('Y-m-d');?>" disabled>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-3 control-label">Status</label>
                          <div class="col-sm-9">
                            <div class="radio">
                              <label>
                                <input type="radio" name="category_status" id="category_status" value="active" checked>
                                Aktif
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="category_status" id="category_status" value="draft">
                                Tidak Aktif
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Nama Kategori</label>
                          <div class="col-sm-9">
                            <input type="text" name="category_name" id="category_name" class="category_name form-control" id="inputEmail3" placeholder="Nama Kategori">
                            <?php echo form_error('category_name', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" name="category_description" id="category_description" rows="5" placeholder="Deskripsi Kategori"></textarea>
                            <?php echo form_error('category_description', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>
                      </div>
                      <!-- /.box-footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <input type="text" name="edit" value="true" />
                        <input type="text" name="category_id" id="category_id" class="category_id">
                        <input type="button" name="submit_edit" value="Simpan Perubahan" id="submit_edit" class="btn btn-info pull-right">
                      </div>
                    </form>
                  </div>
                  
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

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

  <script type="text/javascript">
    $('#submit_edit').click(function(){
      var category_name = $('#category_name').val();
      var category_description = $('#category_description').val();
      var category_status = $('#category_status').val();
      var category_created_date = $('#category_created_date').val();
      var category_id = $('#category_id').val();

      //Validasi
      if(category_name.length==0 || category_name==""){
        alert("Nama Kategori Harus Diisi");
      }else if(category_description.length==0 || category_description==""){
        alert("Deskripsi Kategori Harus Diisi");
      }else{
        $.ajax({
          url : '<?php echo current_url()?>',
          dataType : 'json',
          type:'post',
          data : {category_name:category_name,category_description:category_description,category_status:category_status,category_created_date:category_created_date,category_id:category_id,edit:true}, // register data yang akan di post 
          success:function(res){
            //mengosongkan input data dari modal popup
            $('#category_name').val('');
            $('#category_description').val('');
            $("#category_status").val("");
            $("#category_created_date").val("");
            $('#modal-edit').modal('hide');
          }
        });
      }

    });


    function edit_data(data_id){
      var data = $("#data-"+data_id).val();
      data = $.parseJSON(data);
      $("#category_id").val(data_id);
      $("#category_name").val(data.category_name);
      $("#category_description").val(data.category_description);
      $("#modal-edit").modal('show');
    }
  </script>