  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Pengguna : <?php echo $edit->customer_name;?>
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
              <a  href="<?php echo base_url();?>admin/customer"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo base_url();?>admin/customer/ubah/<?php echo $edit->customer_id;?>" class="form-horizontal">
              <div class="box-body">                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="customer_title" value="mr" <?php echo $edit->customer_title=="mr"?"checked":"";?> />
                        Mr.
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="customer_title" value="mrs" <?php echo $edit->customer_title=="mrs"?"checked":"";?> />
                        Mrs.
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-6">
                    <input type="text" name="customer_name" class="form-control" id="inputEmail3" placeholder="Nama"  value="<?php echo isset($_POST['customer_name'])? $_POST['customer_name']:$edit->customer_name;?>">
                    <?php echo form_error('customer_name', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Email Pengguna</label>
                  <div class="col-sm-6">
                    <input type="text" name="customer_email" class="form-control" id="inputEmail3" placeholder="Email Pengguna" value="<?php echo isset($_POST['customer_email'])? $_POST['customer_email']:$edit->customer_email;?>">
                    <input type="hidden" name="customer_email_hide" value="<?php echo $edit->customer_email;?>">
                    <?php echo form_error('customer_email', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Newsletter</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="customer_newsletter" value="yes" <?php echo $edit->customer_newsletter=="yes"?"checked":"";?> />
                        Yes
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="customer_newsletter" value="no" <?php echo $edit->customer_newsletter=="no"?"checked":"";?> />
                        No
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Status Customer</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="customer_status" value="active" <?php echo $edit->customer_status=="active"?"checked":"";?> />
                        Active
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="customer_status" value="susplend" <?php echo $edit->customer_status=="suspend"?"checked":"";?> />
                        Suspend
                      </label>
                    </div>
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