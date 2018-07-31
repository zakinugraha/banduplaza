  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Pengguna
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Pengguna</a></li>
        <li class="active">Ubah</li>
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
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <a  href="<?php echo base_url();?>admin/employees"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo base_url();?>admin/employees/ubah/<?php echo $edit->employees_id;?>" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama Pengguna</label>
                  <div class="col-sm-6">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Nama"  value="<?php echo isset($_POST['name'])? $_POST['name']:$edit->name;?>">
                    <?php echo form_error('name', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                  <div class="col-sm-6">
                    <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Username" value="<?php echo isset($_POST['username'])? $_POST['username']:$edit->username;?>">
                    <input type="hidden" name="username_hide" value="<?php echo $edit->username;?>">
                    <?php echo form_error('username', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                  <div class="col-sm-6">
                    <input type="password" name="password" class="form-control" id="inputEmail3" placeholder="Password" value="<?php echo isset($_POST['password'])? $_POST['password']:base64_decode($edit->password);?>">
                    <?php echo form_error('password', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Email Pengguna</label>
                  <div class="col-sm-6">
                    <input type="text" name="email" class="form-control" id="inputEmail3" placeholder="Email Pengguna" value="<?php echo isset($_POST['email'])? $_POST['email']:$edit->email;?>">
                    <input type="hidden" name="email_hide" value="<?php echo $edit->email;?>">
                    <?php echo form_error('email', '<p class="text-red">', '</p>');?>
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
    CKEDITOR.replace('artikel_description')
    CKEDITOR.replace('artikel_short_description')
  })
</script>