<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Produk</a></li>
        <li class="active">Tambah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">

        <!-- Left col -->
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <?php echo $this->session->flashdata('message') ?>
            </div>

            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <a  href="#"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="<?php echo base_url();?>admin/upload/tambah" method="POST" enctype="multipart/form-data" class="form-horizontal">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Gambar</label>
                      <div class="col-sm-6">
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <p class="help-block">Ukuran yang disarankan 1100 px * 1100 px</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Thumbnail</label>
                      <div class="col-sm-6">
                        <input type="file" name="product_thumbnail" id="id-input-file-2" />
                        <p class="help-block">Ukuran yang disarankan 350 px * 350 px</p>
                      </div>
                    </div>

                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="submit" name="submit" value="Tambah Produk" class="btn btn-info pull-right">
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->


          </div>
          
        </div>
        <!-- /.col-md-4 -->

        
        

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->