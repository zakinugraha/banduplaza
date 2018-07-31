  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
              <?php echo $this->session->flashdata('thumbnail') ?>
            </div>

            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <a  href="<?php echo base_url();?>admin/product/all"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="<?php echo base_url();?>admin/product/tambah" method="POST" enctype="multipart/form-data" class="form-horizontal">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Nama Produk</label>
                      <div class="col-sm-4">
                        <input type="text" name="product_name" class="form-control" id="inputEmail3" placeholder="Nama Produk"  value="<?php echo set_value('product_name');?>">
                        <?php echo form_error('product_name', '<p class="text-red">', '</p>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Pilih menu <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select name="type_nav_page_id" class="form-control" id="nav_id" onchange="get_category();">
                          <?php
                            $type=$this->db->query('SELECT * FROM type_nav_page ORDER BY type_nav_page_name ASC')->result();
                            echo '<option value="0">-- Pilih Tipe Produk --</option>';
                            foreach ($type AS $nav) {
                              echo '<option value="'.$nav->type_nav_page_id.'">'.$nav->type_nav_page_name.'</option>';
                            }
                          ?>
                        </select>
                        <?php echo form_error('type_nav_page_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Brand <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select name="brand_id" class="form-control">
                          <?php
                            $brand = $this->db->query('SELECT * FROM brand ORDER BY brand_name ASC')->result();
                            echo '<option value="0">-- Pilih Brand --</option>';
                            foreach ($brand AS $merch) {
                              echo '<option value="'.$merch->brand_id.'">'.$merch->brand_name.'</option>';
                            }
                          ?>
                        </select>
                        <?php echo form_error('brand_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Gender <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select name="type_gender_id" class="form-control">
                          <?php
                            $gender = $this->db->query('SELECT * FROM type_gender ORDER BY type_gender_id ASC')->result();
                            foreach ($gender AS $g) {
                              echo '<option value="'.$g->type_gender_id.'">'.$g->type_gender_name.'</option>';
                            }
                          ?>
                        </select>
                        <?php echo form_error('type_gender_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Kategori <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select name="type_category_id" class="form-control" id="category_id"></select>
                        <?php echo form_error('type_category_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Kode Produk <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <input type="text" name="product_code" class="form-control" placeholder="Kode product" value="<?php echo set_value('product_code');?>"/>
                        <?php echo form_error('product_code', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right">Harga Produk <span class="text-danger">*</span></label>
                      <div class="col-sm-3">                        
                          <input name="product_price_base" class="form-control" type="text" id="form-field-icon-1" placeholder="Harga dasar" value="<?php echo set_value('product_price_base');?>" />
                          <?php echo form_error('product_price_base', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>

                          <input type="text" name="product_price_sell" class="form-control" id="form-field-icon-2" placeholder="Harga jual" value="<?php echo set_value('product_price_sell');?>" />
                          <?php echo form_error('product_price_sell', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Type Diskon <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select name="promo_id" class="form-control" id="create_promo" class="col-xs-10 col-sm-4">
                          <?php
                            $type=$this->db->query('SELECT * FROM promo ORDER BY promo_id ASC')->result();
                            foreach ($type AS $p) {
                              echo '<option value="'.$p->promo_id.'">'.$p->promo_label.'</option>';
                            }
                          ?>
                        </select>
                        <?php echo form_error('promo_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Berat <span class="text-danger">*</span></label>
                      <div class="col-sm-2">
                        <input type="text" name="product_weight" class="form-control" placeholder="Berat Produk" value="<?php echo set_value('product_weight');?>" />
                        <?php echo form_error('product_weight', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Sumber Ukuran <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <select name="size_source" class="form-control">
                          <option value="1">CURL Bandros</option>
                          <option value="2" selected>Manual</option>
                          <option value="3">CURL Mangprangstore</option>
                        </select>
                        <?php echo form_error('size_source', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Gambar</label>
                      <div class="col-sm-6">
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <input type="file" name="product_image[]" id="id-input-file-2" />
                        <p class="help-block">Ukuran yang disarankan 1100 px*1100 px</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right">Status <span class="text-danger">*</span></label>
                      <div class="col-sm-3">
                        <div class="radio">
                          <label>
                            <input name="product_status" value="publish" type="radio" class="ace" checked/>
                            <span class="lbl"> Publish</span>
                          </label>
                        </div>

                        <div class="radio">
                          <label>
                            <input name="product_status" value="draft" type="radio" class="ace" />
                            <span class="lbl"> Draft</span>
                          </label>
                        </div>
              
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Rating <span class="text-danger">*</span></label>
                      <div class="col-sm-2">
                        <select name="product_rating" class="form-control">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3" selected>3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>               
                        <?php echo form_error('product_rating', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Deskripsi Singkat <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <textarea id="editor1" name="product_short_desc"><?php echo set_value('product_short_desc');?></textarea>
                        <?php echo form_error('product_short_desc', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Deskripsi Produk <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <textarea id="editor2" name="product_description"><?php echo set_value('product_description');?></textarea>
                        <?php echo form_error('product_description', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tags</label>
                      <div class="col-sm-6">
                        <input type="text" name="product_tags" id="form-field-1" placeholder="Nama Produk" class="form-control" value="<?php echo set_value('product_tags');?>" />
                        <?php echo form_error('product_tags', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta</label>
                      <div class="col-sm-6">
                        <input type="text" name="product_meta" id="form-field-1" placeholder="Meta" class="form-control" value="<?php echo set_value('product_meta');?>" />
                        <?php echo form_error('product_meta', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
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

  <!-- CK Editor -->
  <script src="<?php echo base_url();?>assets/admin/plugins/ckeditor/ckeditor.js"></script>

  <script type="text/javascript">
    var element_brand=$("#category_id");
    $(function(){
      });

    function get_category()
    {
        element_brand.html('');
        var nav_id=$('#nav_id').val();
        $.ajax({
          url:'<?php echo base_url()?>admin/product/get_category/'+nav_id,
          type:'get',
          dataType:'json',
          success:function(response){
              element_brand.html('<option value="">-- Pilih kategori --</option>');
              $.each(response,function(index,rowArr){
                  element_brand.append('<option value="'+rowArr['type_category_id']+'">'+rowArr['type_category_name']+'</option>');
              });
          },
          error:function(response){
              alert('an error has occurred, please try again...');
              return false;
          }

        });
        
    }
  </script>

  <script>
    $(function () {
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace('product_description')
      CKEDITOR.replace('product_short_desc')
    })
  </script>