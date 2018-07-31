  <!-- Update Stock Modal -->
  <div id="resi_modal" class="modal fade" role="dialog">
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
          <form method="post" action="<?php echo current_url();?>">
            <div class="form-group">
              <label class="col-sm-12 control-label no-padding-right" for="form-field-6">No Resi</label>
              <div class="col-sm-6">
                <input type="text" name="no_resi" id="no_resi" class="form-control no_resi" autofocus>
                <input type="hidden" name="inv_id" id="inv_id" class="inv_id">                
              </div>
              <input type="submit" name="submit_resi" value="Submit" id="btn_update_stock" class="btn btn-sm btn-primary" style="margin-top:0;margin-left:10px">
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
        Daftar Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Order</a></li>
        <li class="active">Semua Order</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table" id="tablebody">
                <tr>
                  <th>#</th>
                  <th>Invoice Number</th>
                  <th>Customer</th>
                  <th>Order Date</th>
                  <th>Expired Date</th>
                  <th>Total Order</th>
                  <th style="width:200px;">Status Order</th>
                  <th style="width:120px;">Resi</th>
                  <th>Aksi</th>
                </tr>
                <?php
                  $no=0;
                  foreach ($list AS $row) {
                ?>
                <tr>
                  <td><?php echo ++$no;?></td>
                  <td><strong><a href="<?php echo base_url();?>admin/order/view/<?php echo $row->invoice_id;?>"><?php echo $row->invoice_number;?></a></strong></td>
                  <td><?php echo $row->invoice_name;?></td>
                  <td><?php echo full_parsing_date($row->invoice_date_order).' - '.date('H:i:s',strtotime($row->invoice_date_order));?></td>   
                  <td><?php echo full_parsing_date($row->invoice_date_expired).' - '.date('H:i:s',strtotime($row->invoice_date_expired));?></td>   
                  <td><?php echo 'Rp. '.number_format($row->invoice_grand_total,0);?></td>
                  <td>
                    <!-- <span class="label" style="background-color:<?php echo $row->invoice_status_color;?>"><?php echo $row->invoice_status_name;?></span> -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-xs" style="background-color:<?php echo $row->invoice_status_color;?>;color:#fff"><?php echo $row->invoice_status_name;?></button>
                      <button type="button" class="btn btn-xs dropdown-toggle" style="background-color:<?php echo $row->invoice_status_color;?>;color:#fff" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <?php foreach ($status AS $st) { ?>
                        <li><a href="<?php echo base_url();?>admin/order/update?id=<?php echo $row->invoice_id.'&invoice_status='.$st->invoice_status_id;?>"><?php echo $st->invoice_status_name;?></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                  </td>
                  <td>
                    <?php if ($row->invoice_resi_number=="") { ?>
                    <button class="btn btn-warning btn-xs" title="Lihat" onClick="$('.no_resi').val('0');$('.inv_id').val(<?php echo $row->invoice_id;?>).val();" data-toggle="modal" data-target="#resi_modal">Update Resi</button>
                    <?php } else { ?>
                    <button class="btn btn-primary btn-xs" title="Lihat" onClick="$('.no_resi').val(<?php echo $row->invoice_resi_number;?>).val();$('.inv_id').val(<?php echo $row->invoice_id;?>).val();" data-toggle="modal" data-target="#resi_modal"><?php echo $row->invoice_resi_number;?></button>
                    <?php } ?>
                  </td>

                  <td><a href="<?php echo base_url();?>admin/order/view/<?php echo $row->invoice_id;?>" class="btn btn-danger btn-xs" title="Lihat"><i class="fa fa-fw fa-mail-forward"></i> Buka</a></td>
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
  <!-- /.content-wrapper -->

  <script>
    $(function () {
    // when the modal is closed
    $('#resi_modal').on('hidden.bs.modal', function () {
      $(this).removeData('bs.modal');
      $(".no_resi").empty();
      $(".inv_id").empty();
    });

  });
    </script>