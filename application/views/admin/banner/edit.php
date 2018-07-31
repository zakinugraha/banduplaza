  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Banner
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Banner</a></li>
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
              <a  href="<?php echo base_url();?>admin/banner"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Thumbnail</label>
                  <div class="col-sm-6">
                    <img src="<?php echo base_url();?>upload/images/banner/<?php echo $edit->banner_image;?>" class="img-responsive thumbnail" width="300px">
                    <input type="file" name="banner_image" id="exampleInputFile" />
                    <p class="help-block">Ukuran yang disarankan 1583px * 554px</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-6">
                    <input type="text" name="banner_title" class="form-control" id="inputEmail3" placeholder="Title" value="<?php echo isset($_POST['banner_title'])? $_POST['banner_title']:$edit->banner_title;?>" >
                    <?php echo form_error('banner_title', '<p class="text-red">', '</p>');?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Permalink</label>
                  <div class="col-sm-6">
                    <input type="text" name="banner_permalink" class="form-control" id="inputEmail3" placeholder="Permalink" value="<?php echo isset($_POST['banner_permalink'])? $_POST['banner_permalink']:$edit->banner_permalink;?>" >
                    <?php echo form_error('banner_permalink', '<p class="text-red">', '</p>');?>
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