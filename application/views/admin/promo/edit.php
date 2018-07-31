  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Promo
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Promo</a></li>
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
              <a  href="<?php echo base_url();?>admin/promo/all"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo current_url();?>" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Label</label>
                  <div class="col-sm-6">
                    <input type="text" name="promo_label" class="form-control" id="inputEmail3" placeholder="Label" value="<?php echo isset($_POST['promo_label'])? $_POST['promo_label']:$promo->promo_label;?>" >
                    <?php echo form_error('promo_label', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Brand</label>
                  <div class="col-sm-3">
                    <select name="promo_discount_type" class="form-control" required>
                      <option value="2" <?php echo $promo->promo_discount_type=='2'?'selected':'';?>>Percent</option>
                      <option value="3" <?php echo $promo->promo_discount_type=='3'?'selected':'';?>>Price</option>
                    </select>
                    <?php echo form_error('promo_discount_type', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Value</label>
                  <div class="col-sm-6">
                    <input type="text" name="promo_value" class="form-control" id="inputEmail3" placeholder="Value" value="<?php echo isset($_POST['promo_value'])? $_POST['promo_value']:$promo->promo_value;?>" >
                    <?php echo form_error('promo_value', '<p class="text-red">', '</p>');?>
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
    CKEDITOR.replace('size_chart_content')
  })
</script>