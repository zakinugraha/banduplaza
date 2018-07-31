  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Panduan Ukuran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Panduan Ukuran</a></li>
        <li class="active">Semua Daftar</li>
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
              <a  href="<?php echo base_url();?>admin/size_chart/all"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo base_url();?>admin/size_chart/add" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Item</label>
                  <div class="col-sm-3">
                    <select name="type_nav_page_id" class="form-control" required>
                      <?php
                        $item=$this->db->query('SELECT * FROM type_nav_page ORDER BY type_nav_page_name ASC')->result();
                        echo '<option value="">-- Pilih Item --</option>';
                        foreach ($item AS $i) {
                          echo '<option value="'.$i->type_nav_page_id.'">'.$i->type_nav_page_name.'</option>';                    
                        }
                      ?>
                    </select>
                    <?php echo form_error('type_nav_page_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Brand</label>
                  <div class="col-sm-3">
                    <select name="brand_id" class="form-control" required>
                      <?php
                        $brand=$this->db->query('SELECT * FROM brand ORDER BY brand_name ASC')->result();
                        echo '<option value="">-- Pilih Brand --</option>';
                        foreach ($brand AS $b) {
                          echo '<option value="'.$b->brand_id.'">'.$b->brand_name.'</option>';                    
                        }
                      ?>
                    </select>
                    <?php echo form_error('brand_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Size Chart Content</label>
                  <div class="col-sm-9">
                    <textarea id="size_chart_content" name="size_chart_content"><?php echo set_value('size_chart_content');?></textarea>
                    <?php echo form_error('size_chart_content', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" name="submit" value="Tambah Panduan Ukuran" class="btn btn-info pull-right">
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