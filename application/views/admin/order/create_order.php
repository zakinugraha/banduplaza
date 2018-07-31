  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <style>
    section.list {
      display: flex;
      flex-flow: row wrap;
    }
    section.list > div {
      /*flex: 1;*/
      padding: 0.5rem;
    }
    input[type="radio"].product {
      display: none;
      &:not(:disabled) ~ label {
        cursor: pointer;
      }
      &:disabled ~ label {
        color: hsla(150, 5%, 75%, 1);
        border-color: hsla(150, 5%, 75%, 1);
        box-shadow: none;
        cursor: not-allowed;
      }
    }
    label.list_product {
      height: 100%;
      display: block;
      background: white;
      border: 1px solid hsl(202, 52%, 49%);
      border-radius: 0;
      padding: 0;
      margin-bottom: 1rem;
      /*margin: 1rem;*/
      text-align: center;
      box-shadow: 0px 3px 10px -2px hsla(150, 5%, 65%, 0.5);
      position: relative;
    }
    input[type="radio"].product:checked + label {
      background: hsl(202, 52%, 49%);
      color: hsla(215, 0%, 100%, 1);
      box-shadow: 0px 0px 5px hsl(202, 52%, 49%)
      &::after {
        color: hsla(215, 5%, 25%, 1);
        font-family: FontAwesome;
        border: 2px solid hsla(150, 75%, 45%, 1);
        content: "\f00c";
        font-size: 24px;
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        height: 50px;
        width: 50px;
        line-height: 50px;
        text-align: center;
        border-radius: 50%;
        background: white;
        box-shadow: 0px 2px 5px -2px hsla(0, 0%, 0%, 0.25);
      }
    }
    p.list_product {
      font-weight: 900;
      margin: 10px 0 5px 0;
    }


    @media only screen and (max-width: 700px) {
      section {
        flex-direction: column;
      }
    }

  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Buat Invoice Baru
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Order</a></li>
        <li class="active">Buat Invoice Baru</li>
      </ol>
    </section>

    <div class="col-md-12">
      <div class="row">
        <div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            Hanya bisa digunakan untuk membuat satu produk di keranjang belanja. Apabila produk lebih dari satu, buat invoice melalui halaman front-end dengan mengisi biodata customer.
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">

        <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
          <!-- Left col -->
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <?php echo $this->session->flashdata('message') ?>
              </div>

              
                <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                      Data Customer
                    </div>
                    <!-- form start -->
                    
                      <div class="box-body">

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Invoice No</label>
                          <div class="col-sm-4">
                            <input type="text" name="invoice_number" class="form-control" id="inputEmail3" placeholder="Nama Customer"  value="<?php echo $invoice_number;?>" readonly>
                            <?php echo form_error('invoice_number', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Tanggal</label>
                          <div class="col-sm-3">
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" name="date_order" class="form-control pull-right" value="<?php echo date("Y-m-d H:i:s");?>">
                            </div>
                            <?php echo form_error('invoice_number', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Nama Customer</label>
                          <div class="col-sm-4">
                            <input type="text" name="customer_name" class="form-control" id="inputEmail3" placeholder="Nama Customer"  value="<?php echo set_value('customer_name');?>">
                            <?php echo form_error('customer_name', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Telp Customer</label>
                          <div class="col-sm-4">
                            <input type="text" name="customer_phone" class="form-control" id="inputEmail3" placeholder="Telp Customer"  value="<?php echo set_value('customer_phone');?>">
                            <?php echo form_error('customer_phone', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Email Customer</label>
                          <div class="col-sm-4">
                            <input type="email" name="customer_email" class="form-control" id="inputEmail3" placeholder="Email Customer"  value="<?php echo set_value('customer_email');?>">
                            <?php echo form_error('customer_email', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Alamat Pengiriman <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <textarea id="editor1" name="customer_address"><?php echo set_value('customer_address');?></textarea>
                            <?php echo form_error('customer_address', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Kode POS</label>
                          <div class="col-sm-4">
                            <input type="text" name="postcode" class="form-control" id="inputEmail3" placeholder="Kode POS"  value="<?php echo set_value('postcode');?>">
                            <?php echo form_error('postcode', '<p class="text-red">', '</p>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Bank <span class="text-danger">*</span></label>
                          <div class="col-sm-3">
                            <select name="bank_id" class="form-control">
                              <?php foreach ($bank AS $b) { ?>
                                <option value="<?php echo $b->bank_id;?>"><?php echo $b->bank_name?></option>
                              <?php } ?>
                            </select>
                            <?php echo form_error('province', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                          </div>
                        </div>

                      </div>
                      <!-- /.box-body -->
                    
                  </div>
                  <!-- /.box -->
                </div>
                <!--/.col (right) -->

                <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <div class="box box-info">
                    <div class="box-header with-border">
                      Produk
                    </div>
                    <div class="box-body">
                      <div class="form-group">
                          <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Produk <span class="text-danger">*</span></label>
                          <div class="col-sm-3">
                            <select name="nav_page" class="form-control" id="nav_page" onchange="nav_product();">
                              <option value="">-- Pilih Kategori --</option>
                              <?php foreach ($nav AS $product) { ?>
                                <option value="<?php echo $product->type_nav_page_id;?>"><?php echo $product->type_nav_page_name?></option>
                              <?php } ?>
                            </select>
                            <input type="hidden" class="product_id" name="product_id" class="input-text">
                            <input type="hidden" class="total_weight" name="total_weight" class="input-text">
                          </div>
                        </div>
                    </div>

                    <div class="box-body">
                      <div class="form-group">
                          <div class="col-sm-12">
                            <div id="loading" style="display:none;text-align:center;"><img src="<?php echo base_url();?>assets/admin/img/ring-loader.gif" style="margin-top:30px;width:70px"></div>
                            <section class="list" id="list_product"></section>                        
                          </div>
                        </div>
                    </div>

                  </div>

                </div>


                <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <div class="box box-info">
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                      Metode Pengiriman
                    </div>
                    <!-- form start -->
                    
                      <div class="box-body">

                        <div class="form-group">
                          <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Provinsi <span class="text-danger">*</span></label>
                          <div class="col-sm-3">
                            <select name="province" class="form-control" id="province_id_ship" onchange="get_city_ship();">
                              <option value="">-- Pilih Provinsi --</option>
                              <?php foreach ($province AS $row) { ?>
                                <option value="<?php echo $row->area_api_id;?>"><?php echo $row->area_name?></option>
                              <?php } ?>
                            </select>
                            <?php echo form_error('province', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Kota/Kabupaten <span class="text-danger">*</span></label>
                          <div class="col-sm-3">
                            <select name="city" class="form-control" id="city_id_ship" onchange="get_cost();"></select>
                            <?php echo form_error('city', '<div class="clearfix"></div><div class="text-danger">', '</div>');?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label no-padding-right" for="form-field-6">Ship <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <table class="shop_table shop_table_responsive cart table table container_cost">
                                <tbody></tbody>
                            </table>
                            <input type="hidden" class="total_shipping" name="shipping_cost" value="0">
                          </div>
                        </div>

                      </div>
                      <!-- /.box-body -->

                      <div class="box-footer">
                        <input type="submit" name="submit" value="Submit" class="btn btn-info pull-right">
                      </div>
                    
                  </div>
                  <!-- /.box -->
                </div>
                <!--/.col (right) -->


            </div>
              
              
            
          </div>
          <!-- /.col-md-4 -->

          
        </form>

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

  <script type="text/javascript">
    var element_city_ship=$("#city_id_ship");
    

    $(function(){
    });

    function nav_product()
    {
      var list = $("#list_product");
      var nav_id = $("#nav_page").val();
      $('#loading').show();
      var jqxhr=$.ajax({
          url:'<?php echo base_url()?>admin/order/get_product/'+nav_id,
          type:'get',
          dataType:'json',
          success:function(res) {   
          // console.log(res);         
            $.each(res,function(index,rowArr){
              
              var text = '<div>'+
                            '<input type="radio" id="control_0'+rowArr['product_id']+'" name="select" class="product" value="'+rowArr['product_id']+'" onclick="$(\'.product_id\').val($(this).val());$(\'.total_weight\').val('+rowArr['product_weight']+')">'+
                            '<label class="list_product" for="control_0'+rowArr['product_id']+'">'+
                            '<img src="<?php echo base_url();?>upload/images/new_product/thumbs/'+rowArr['image_product_file_name']+'">'+
                            '<p class="list_product">'+rowArr['product_name']+'</p>'+
                            '</label>'+
                        '</div>';
              list.append(text);
              
            });
            $('#loading').hide();
          },
          error:function(res) {
            alert('an error has occurred, please try again...');
            return false;
          }
      });
    }

    function get_city_ship()
    {
      element_city_ship.html('<option value="">Loading...</option>');
      var province_id_ship=$('#province_id_ship').val();
      var jqxhr=$.ajax({
          url:'<?php echo base_url()?>admin/order/get_city/'+province_id_ship,
          type:'get',
          dataType:'json',
          success:function(response) {
            element_city_ship.html('<option value="">-- Pilih Kota/Kabupaten --</option>');
            $.each(response,function(index,rowArr){
                element_city_ship.append('<option value="'+rowArr['area_api_id']+'">'+rowArr['area_name']+'</option>');
            });
          },
          error:function(response) {
            alert('an error has occurred, please try again...');
            return false;
          }
      });
    }

    function get_cost()
    {
      var ori_province=$('#province_id_ship').val();
      var ori_city=$('#city_id_ship').val();
      var total_weight=$('.total_weight').val();
      var element_cost=$("table.container_cost").find('tbody');

      var jqxhr=$.ajax({
          url:'<?php echo base_url()?>admin/order/get_cost/'+ori_city+'/'+total_weight,
          type:'get',
          dataType:'json',
          success:function(response) {
            console.log(response);
            element_cost.html('');
            $.each(response,function(index,rowArr){
                var result_cost=rowArr['cost'];
                $.each(result_cost,function(indexCost,rowArrCost){
                    element_cost.append('<tr>'+
                                            '<td>'+
                                                '<input name="cost_value" onclick="$(\'.total_shipping\').val($(this).val());$(\'.cost_value\').html($(this).val());" type="radio" value="'+rowArrCost['value']+'">'+
                                            '</td>'+
                                            '<td style="text-align:left"><strong>JNE</strong><br>'+rowArr['description']+' ('+rowArr['service']+')'+'<br>Estimasi barang sampai : '+rowArrCost['etd']+' hari'+
                                            '</td>'+
                                            '<td><span class="price">Rp. '+rowArrCost['value']+'</span></td>'+
                                        '</tr>');
                });
            });

            // $("#load_ship").hide();
            $("#list_ship").show();
            $(".free-ongkir").show();
            // $("#btn_ship").hide();
            // $("#address").hide();
            // $("#list_cost").show();
          },
          error:function(response) {
            alert('an error has occurred, please try again...');
            return false;
          }
      });
    }

    $(function () {
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace('customer_address')
    })
  </script>