  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Tambah Brand Privacy Return
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Brand Privacy Return</a></li>
        <li class="active">Tambah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <a  href="<?php echo base_url();?>admin/brand"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo base_url();?>admin/brand/add" enctype="multipart/form-data" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Logo</label>
                  <div class="col-sm-6">
                    <input type="file" name="brand_logo" id="exampleInputFile" />
                    <p class="help-block">Ukuran yang disarankan 290px * 81px</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-6">
                    <input type="text" name="brand_name" class="form-control" id="inputEmail3" placeholder="Brand" value="<?php echo set_value('brand_name');?>" >
                    <?php echo form_error('brand_name', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">API Name</label>
                  <div class="col-sm-6">
                    <input type="text" name="brand_api" class="form-control" id="inputEmail3" placeholder="API Name" value="<?php echo set_value('brand_api');?>" >
                    <?php echo form_error('brand_api', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
                  <div class="col-sm-6">
                    <textarea id="editor1" name="brand_description"><?php echo set_value('brand_description');?></textarea>
                    <?php echo form_error('brand_description', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Privacy Return</label>
                  <div class="col-sm-6">
                    <textarea id="editor1" name="brand_privacy_return"><?php echo set_value('brand_privacy_return');?></textarea>
                    <?php echo form_error('brand_privacy_return', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="brand_status" id="optionsRadios1" value="enabled" checked>
                        Enabled
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="brand_status" id="optionsRadios2" value="disabled">
                        Disabled
                      </label>
                    </div>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" name="submit" value="Tambah Brand" class="btn btn-info pull-right">
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
        <!-- end col-md-6 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- CK Editor -->
  <script src="<?php echo base_url();?>assets/admin/plugins/ckeditor/ckeditor.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('brand_description'),
    CKEDITOR.replace('brand_privacy_return')
  })
</script>