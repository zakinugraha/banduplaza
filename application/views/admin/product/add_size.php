  <!--Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Ukuran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Produk</a></li>
        <li class="active">Tambah Ukuran</li>
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
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <a href="" onclick="window.close();"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo current_url();?>" class="form-horizontal">
              <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="form-field-6">Product Code</label>
                  <div class="col-sm-3">
                    <input type="text" name="product_code" class="form-control" value="<?php echo $product_code;?>" disabled>
                    <?php echo form_error('product_code', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="form-field-6">Attribute <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <select name="size_attributes_id" class="form-control" id="attributes_id" onchange="get_combine();" required>
                      <?php
                        $type=$this->db->query('SELECT * FROM size_type ORDER BY size_type_id ASC')->result();
                        echo '<option value="">-- Pilih tipe size --</option>';
                        foreach ($type AS $size) {
                          if ($size->size_type_id!=4) {
                            echo '<option value="'.$size->size_type_id.'">'.$size->size_type_name.'</option>';
                          }                     
                        }
                      ?>
                    </select>
                    <?php echo form_error('size_type_id', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="form-field-6">Value <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <select name="stock_management_value" class="form-control" id="value_id" required></select>
                    <?php echo form_error('stock_management_value', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="form-field-6">Quantity <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" name="stock_value" class="form-control" required>
                    <?php echo form_error('stock_value', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" name="submit" value="Tambah" class="btn btn-info pull-right">
              </div>
              <!-- /.box-footer -->
            </form>

          </div>
          <!-- /.box -->

        </div>
        <!-- end col-md-6 -->

        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <!-- <a href="<?php echo base_url();?>admin/product/all"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-left" style="margin-right:5px;"></i> Kembali</button></a> -->
              <h4>Daftar Ukuran dan Stok </h4>
            </div>
        
            <form action="<?php echo base_url();?>admin/product/delete_selected_size/<?php echo $product_id;?>" method="POST" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <!-- <label class="col-sm-3 control-label no-padding-right" for="form-field-6">&nbsp;</label> -->
                  <div class="col-sm-9">
                    <select name="list_attr[]" class="col-xs-10 col-sm-12" id="list_id" style="min-height: 120px;" multiple />
                      <?php foreach($list_attr AS $attr) { ?>
                      <option value="<?php echo $attr->stock_management_id;?>"><?php echo 'Size : '.$attr->size_attributes_value.', Qty : '.$attr->stock_management_value;?></option>
                      <?php } ?>
                    </select>
                    <?php echo form_error('list_attr', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-offset-3 col-md-9">
                    <input type="submit" name="delete_size" value="Hapus" class="btn btn-danger">
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    var element_brand=$("#value_id");
    $(function(){
      });

    function get_combine()
      {
        element_brand.html('');
        var attributes_id=$('#attributes_id').val();
        $.ajax({
            url:'<?php echo base_url()?>admin/product/get_combination/'+attributes_id,
            type:'get',
            dataType:'json',
            success:function(response){
              element_brand.html('');
              $.each(response,function(index,rowArr){
                  element_brand.append('<option value="'+rowArr['size_attributes_id']+'">'+rowArr['size_attributes_value']+'</option>');
              });
            },
            error:function(response){
              alert('an error has occurred, please try again...');
              return false;
            }

        });
            
      }
  </script>