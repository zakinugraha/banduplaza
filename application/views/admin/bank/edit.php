  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Bank
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bank</a></li>
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
              <a  href="<?php echo base_url();?>admin/bank"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Logo</label>
                  <div class="col-sm-6">
                    <input type="file" name="bank_logo" id="exampleInputFile" />
                    <p class="help-block">Ukuran yang disarankan 145px * 47px</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Bank Name</label>
                  <div class="col-sm-6">
                    <input type="text" name="bank_name" class="form-control" id="inputEmail3" placeholder="Nama Bank" value="<?php echo isset($_POST['bank_name'])? $_POST['bank_name']:$edit->bank_name;?>" >
                    <?php echo form_error('bank_name', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">No Rekening</label>
                  <div class="col-sm-6">
                    <input type="text" name="bank_rek" class="form-control" id="inputEmail3" placeholder="No Rekening" value="<?php echo isset($_POST['bank_rek'])? $_POST['bank_rek']:$edit->bank_rek;?>" >
                    <?php echo form_error('bank_rek', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Atas Nama</label>
                  <div class="col-sm-6">
                    <input type="text" name="bank_an" class="form-control" id="inputEmail3" placeholder="Atas Nama" value="<?php echo isset($_POST['bank_an'])? $_POST['bank_an']:$edit->bank_an;?>" >
                    <?php echo form_error('bank_an', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="bank_status" id="optionsRadios1" value="enabled" <?php echo $edit->bank_status=="enabled"?"checked":"";?> />
                        Enabled
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="bank_status" id="optionsRadios2" value="disabled" <?php echo $edit->bank_status=="disabled"?"checked":"";?> />
                        Disabled
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Deskripsi</label>
                  <div class="col-sm-6">
                    <textarea id="editor1" name="bank_note"><?php echo isset($_POST['bank_note'])? $_POST['bank_note']:$edit->bank_note;?></textarea>
                    <?php echo form_error('bank_note', '<p class="text-red">', '</p>');?>
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
    CKEDITOR.replace('bank_note')
  })
</script>