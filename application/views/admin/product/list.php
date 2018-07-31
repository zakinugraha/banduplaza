  <!-- Update Stock Modal -->
  <div id="update_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Stock</h4>
        </div>
        <!-- body modal -->
        <div class="modal-body">
          <form method="get" action="<?php echo base_url();?>admin/product/update_stock">
            <div class="form-group">
              <label class="col-sm-12 control-label no-padding-right" for="form-field-6">Total Stok</label>
              <div class="col-sm-6">
                <input type="text" name="total_stock" id="total_stock" class="form-control total_stock" autofocus>
                <input type="hidden" name="sm_id" id="sm_id" class="sm_id">                
              </div>
              <input type="button" name="submit" value="Rubah Stock" id="btn_update_stock" class="btn btn-sm btn-primary" style="margin-top:0;margin-left:10px">
            </div>
          </form> 
          
        </div>
        <!-- footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Rating Modal -->
  <div id="rating_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Rating</h4>
        </div>
        <!-- body modal -->
        <div class="modal-body">
          <form method="get" action="<?php echo base_url();?>admin/product/update_rating">
            <div class="form-group">
              <label class="col-sm-12 control-label no-padding-right" for="form-field-6">Pilih jumlah rating</label>
              <div class="col-sm-6">
                <select name="rating_id" id="rating_id" class="form-control">
                  <option value="1">1</option>
                  <option value="15">1.5</option>
                  <option value="2">2</option>
                  <option value="25">2.5</option>
                  <option value="3">3</option>
                  <option value="35">3.5</option>
                  <option value="4">4</option>
                  <option value="45">4.5</option>
                  <option value="5">5</option>
                </select>
              </div>
              <input type="hidden" id="product_id" class="product_id">
              <input type="button" name="submit" value="Simpan Data" id="btn_update_rating" class="btn btn-sm btn-primary" style="margin-top:0;margin-left:10px">
            </div>
            
          </form>
        </div>
        <!-- footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Produk
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Produk</a></li>
        <li class="active">Semua Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message') ?>
          <?php echo $this->session->flashdata('thumbnail') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <a  href="<?php echo base_url();?>admin/product/tambah"><button type="button" class="btn btn-primary"><i class="fa fa-plus" style="margin-right:5px;"></i> Tambah Produk Baru</button></a>
              <div class="box-tools">
                <form id="search" action="<?php echo base_url();?>admin/product/search">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="q" id="search_text" class="form-control pull-right" onkeypress="product_search(event)" value="<?php echo (isset($search)) ? $search : ''; ?>" placeholder="Search">                  
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            
            <div class="box-header" style="border-top:1px solid #f4f4f4">
              <!-- Pengurutan -->
              <div class="btn-group">
                <button type="button" class="btn btn-default">Urut Berdasarkan : <?php echo $select;?></button>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu" style="width:100%">
                  <li><a href="<?php echo base_url();?>admin/product/all?sort_by=newest">Produk Terbaru</a></li>
                  <li><a href="<?php echo base_url();?>admin/product/all?sort_by=best-seller">Produk Terlaris</a></li>
                  <li><a href="<?php echo base_url();?>admin/product/all?sort_by=popular">Paling banyak dilihat</a></li>
                </ul>
              </div>
            </div>
              
            

            <div class="box-body table-responsive no-padding">
              <table class="table" id="tablebody">
                <tr>
                  <th style="width:10px">#</th>
                  <th style="width:100px">Gambar</th>
                  <th>Nama Produk</th>
                  <th style="width:200px">Grafik 7 Hari Terakhir</th>
                  <th>Status</th>
                  <th style="width: 200px;text-align:center;">Stok Produk</th>
                  <th style="width: 150px;">Edit Stok</th>
                  <th style="width: 100px">Aksi</th>
                </tr>
                <?php
                  $no=0;
                  foreach ($list AS $row) {
                ?>
                <tr>
                  <td><?php echo ++$no;?></td>
                  <td>
                    <?php 
                      $count = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'"')->num_rows();
                      if ($count>0) {
                        $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'" LIMIT 1')->row();
                        $image_prim = $image_default->image_product_file_name;
                        echo '<img src="'.base_url().'upload/images/product/thumbs/'.$image_prim.'" class="thumbnail" width="100px" style="margin-bottom:0;">';
                      } else {
                        $image_prim = 'noimage.jpg';
                        echo '<img src="'.base_url().'upload/images/product/thumbs/'.$image_prim.'" class="thumbnail" width="100px" style="margin-bottom:0;">';
                        echo '<br>Tidak ada gambar';
                      }                            
                    ?>  
                  </td>
                  <td>
                    <a href="<?php echo base_url();?>admin/product/ubah/<?php echo $row->product_id;?>"><strong><?php echo $row->product_name;?></strong></a> by <span class="text-danger"><?php echo $row->brand_name;?></span><span><?php echo ' ('.$row->product_code.')';?> <br>
                    <span class="text-base-price<?php echo $row->product_price_discount>0?'-caret':'';?>"><strong><?php echo 'Rp. '.number_format($row->product_price_sell);?></strong></span>
                    <span class="text-discount"><?php echo $row->product_price_discount>0?'Rp. '.number_format($row->product_price_discount):'';?></span>
                    <span>
                    <?php
                      if ($row->promo_discount_type=='1') {
                        echo '&nbsp;';
                      } else if ($row->promo_discount_type==2) {
                        echo '<span class="label label-warning">'.$row->promo_value.'%</span>';
                      } else {
                        echo '<span class="label label-warning">Rp. '.$row->promo_value.'</span>';
                      }
                    ?>
                    </span>
                    <br>
                    <!-- <span><?php echo full_parsing_date($row->product_create_date);?></span> -->
                    <span class="text-success"><?php echo $row->type_category_name;?></span> / <span class="text-success"><?php echo $row->type_nav_page_name;?></span> - <span><?php echo full_parsing_date($row->product_create_date).' - '.date('H:i:s',strtotime($row->product_create_date));?></span>
                    <a href="#" onclick="$('.product_id').val(<?php echo $row->product_id;?>).val()" data-toggle="modal" data-target="#rating_modal"><span><div id="rating_now"><img src="<?php echo base_url();?>assets/admin/img/rating/<?php echo $row->product_rating.'.png';?>" title="Klik untuk rubah rating"></div></span></a>
                    
                    <?php 
                      $tags = explode("#", $row->product_tags);
                      $count = count($tags);
                      for ($i=1; $i < $count; ++$i) {
                        echo '<span class="label label-success" style="margin-right:3px;">'.$tags[$i].' </span>';
                      }
                    ?>
                  </td>

                  <td>                                      
                    <div class="sparkline" data-type="bar" data-width="97%" data-height="100px" data-bar-Width="14" data-bar-Spacing="7" data-bar-Color="#f39c12">

                      <?php
                        $today = date('Y-m-d');
                        $yesterday = date('Y-m-d', strtotime('-1 days', strtotime($today)));
                        $last7 = date('Y-m-d', strtotime('-7 days', strtotime($today)));
                        
                        $count_view = $this->db->query('SELECT * FROM grafik_view WHERE grafik_view_date BETWEEN "'.$last7.'" and "'.$today.'" and product_id="'.$row->product_id.'"')->num_rows();
                        if ($count_view==0) {
                          echo "0,0,0,0,0,0,0,0";
                        } else {
                          echo "10";
                          $from = $last7;
                          $to = $today;
                          while (strtotime($from)<strtotime($to)){
                            $from = mktime(0,0,0,date('m',strtotime($from)),date('d',strtotime($from))+1,date('Y',strtotime($from)));
                            $from=date('Y-m-d', $from);
                            $count_val = $this->db->query('SELECT * FROM grafik_view WHERE grafik_view_date="'.$from.'" && product_id="'.$row->product_id.'"')->num_rows();
                            $get_val = $this->db->query('SELECT * FROM grafik_view WHERE grafik_view_date="'.$from.'" && product_id="'.$row->product_id.'"')->row();
                            if ($count_val==0) {
                              $val = '0';
                            } else {
                              $val = $get_val->grafik_view_point;
                            }
                            echo ','.$val;
                          }
                        }
                      ?>
                    </div>
                  </td>
                  <td style="vertical-align: middle;"><span class="label label-<?php echo $row->product_status=="publish"?"info":"warning";?>"><?php echo ucfirst($row->product_status);?></span></td>
         
                  <td style="vertical-align:middle">
                    <?php
                      $get_size = $this->mod->custom_fetch_query('select m.*, a.size_attributes_id, a.size_attributes_value, m.stock_management_id from stock_management m inner join size_attributes a on (m.size_attributes_id=a.size_attributes_id) where product_id="'.$row->product_id.'" order by a.size_attributes_id asc');
                      foreach ($get_size AS $sm) {
                         if ($sm->stock_management_value >5) {
                          $btn = "default";
                        } else if ($sm->stock_management_value>0 && $sm->stock_management_value<=5) {
                          $btn = "warning";
                        } else {
                          $btn = "danger";
                        }
                    ?>
                        <button type="button" onclick="$('.total_stock').val(<?php echo $sm->stock_management_value;?>).val();$('.sm_id').val(<?php echo $sm->stock_management_id;?>).val();" data-toggle="modal" data-target="#update_modal" class="btn btn-<?php echo $btn;?> btn-xs"><?php echo $sm->size_attributes_value.'('.$sm->stock_management_value.')';?></button>
                        
                    <?php
                      }
                    ?>                    
                    
                  </td>
                  <td style="vertical-align:middle">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs">Tambah Stok</button>
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo base_url();?>admin/product/combination/<?php echo $row->product_id;?>" target="_BLANK">Tambah Stok</a></li>
                        <li class="divider"></li>
                        <li><a href="" onClick="window.open('<?php echo base_url();?>admin/product/set_to_first?id=<?php echo $row->product_id;?>');">Set Habis</a></li>
                      </ul>
                    </div>
                  </td>
                  <td style="vertical-align: middle;">
                    <a href="<?php echo base_url();?>admin/product/ubah/<?php echo $row->product_id;?>" class="btn btn-danger btn-xs" title="Ubah"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo base_url();?>admin/product/hapus/<?php echo $row->product_id;?>" onclick="return confirm('Produk bisa disembunyikan. Lanjutkan hapus data?')" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash-o"></i></a>
                    <a href="" onclick="window.open('<?php echo base_url();?>admin/product/set_to_first?id=<?php echo $row->product_id;?>');" class="btn btn-danger btn-xs" title="Set posisi pertama"><i class="fa fa-hand-pointer-o"></i></a>
                    
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <?php echo $pagination; ?>
              </ul>
            </div>
          </div>
          <!-- /.box -->

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper

  <!-- Sparkline -->
  <script src="<?php echo base_url();?>assets/admin/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

  <script type="text/javascript">
   $(document).ready(function(){ $.notify("Hello World"); });
    $(document).ready(function(){
      $('#btn_update_rating').click(function(){
        var rating=$('#rating_id').val();
        var product_id=$('#product_id').val();
        $.ajax({
          url:'<?php echo base_url();?>admin/product/update_rating?id='+product_id+'&value='+rating,
          dataType:'json',
          type:'get',
          data:{product_id:product_id,product_rating:rating},
          success:function(res){
            alert('success');
            $("#rating_modal").modal('hide');
          }
        }); 
      });
      // End update rating

      $('#btn_update_stock').click(function(){
        var stock=$('#total_stock').val();
        var id=$('#sm_id').val();
        $.ajax({
          url:'<?php echo base_url();?>admin/product/update_stock?id='+id+'&value='+stock,
          dataType:'json',
          type:'get',
          data:{stock_management_id:id,stock_management_value:stock},
          success:function(res){
            $.notify('<i class="icon fa fa-check"></i> Stok produk berhasil di update');
            // for the ones that aren't closable and don't fade out there is a .hide() function.
            $("#update_modal").modal('hide');
          }
        }); 
      });
      // End update rating
    });
  </script>

  <script>
    function product_search(e) {
      if (e.keyCode == 13) {
          var tb = document.getElementById("search_text").value;
          if (tb != '') {
              location.href = '<?php echo base_url() ?>admin/product/search?q=' + tb;
          } else {
              location.href = '<?php echo base_url() ?>admin/product/search';
          }
          return true;
      }
    }

    $(function () {
      //INITIALIZE SPARKLINE CHARTS
      $(".sparkline").each(function () {
        var $this = $(this);
        $this.sparkline('html', $this.data());
      });
      /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
    });
  </script>