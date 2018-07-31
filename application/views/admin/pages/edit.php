  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Halaman
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Halaman</a></li>
        <li class="active">Ubah</li>
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
              <a  href="<?php echo base_url();?>admin/pages"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo current_url();?>" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-6">
                    <input type="text" name="pages_title" class="form-control" id="inputEmail3" placeholder="Thumbnail Alias" value="<?php echo isset($_POST['pages_title'])? $_POST['pages_title']:$edit->pages_title;?>" >
                    <?php echo form_error('pages_title', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
                  <div class="col-sm-9">
                    <textarea id="editor1" name="pages_content" rows="10" cols="80"><?php echo isset($_POST['pages_content'])? $_POST['pages_content']:$edit->pages_content;?></textarea>
                    <?php echo form_error('pages_content', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" name="submit" value="Simpan Perubahan" class="btn btn-info pull-right">
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
    CKEDITOR.replace('pages_content')
  })
</script>