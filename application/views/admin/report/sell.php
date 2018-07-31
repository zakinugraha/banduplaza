  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Penjualan
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Laporan</a></li>
        <li class="active">Penjualan</li>
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
          <div class="box" style="border-top:none">
            <!-- /.box-header -->
            <div class="box-body"> 
              <form action="" method="POST">   
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Pilih periode :</label>
                      <select name="cmb_year" class="form-control">
                        <?php foreach ($list_year AS $year) { ?>
                          <option value="<?php echo $year->tahun;?>"<?php echo $year->tahun==$year_now?"selected":"";?>><?php echo $year->tahun;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <select name="cmb_month" class="form-control" >
                        <option value="">Semua Bulan</option>
                        <option value="01" <?php echo $month_now=='01'?'selected':''?>>Januari</option>
                        <option value="02" <?php echo $month_now=='02'?'selected':''?>>Februari</option>
                        <option value="03" <?php echo $month_now=='03'?'selected':''?>>Maret</option>
                        <option value="04" <?php echo $month_now=='04'?'selected':''?>>April</option>
                        <option value="05" <?php echo $month_now=='05'?'selected':''?>>Mei</option>
                        <option value="06" <?php echo $month_now=='06'?'selected':''?>>Juni</option>
                        <option value="07" <?php echo $month_now=='07'?'selected':''?>>Juli</option>
                        <option value="08" <?php echo $month_now=='08'?'selected':''?>>Agustus</option>
                        <option value="09" <?php echo $month_now=='09'?'selected':''?>>September</option>
                        <option value="10" <?php echo $month_now=='10'?'selected':''?>>Oktober</option>
                        <option value="11" <?php echo $month_now=='11'?'selected':''?>>November</option>
                        <option value="12" <?php echo $month_now=='12'?'selected':''?>>Desember</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-1">
                    <label>&nbsp;</label>
                    <input type="submit" name="submit" value="Apply" class="btn btn-sm btn-success form-control">
                  </div>

                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
          <?php
            echo '<label>Periode : '.parsing_month($month_now).' '.$year_now.'</label>';
          ?>
          <div class="box box-primary">

            <div class="box-body table-responsive no-padding">
              <table class="table" id="tablebody">
                <tr>
                  <th style="width:10px">#</th>
                  <th>Invoice</th>
                  <th>Sub Total</th>
                  <th>Ongkos Kirim</th>
                  <th>Total</th>                  
                </tr>

                <?php
                  if ($count>0) {
                    $total_periode = 0;
                    foreach ($list AS $row) {
                      echo '<tr><td colspan="5" style="background-color:#ecf0f5;"><strong>'.full_parsing_date($row->tahun).'</strong></td></tr>';
                      $invoice = $this->db->query('SELECT * FROM invoice WHERE date_format(invoice_date_order,"%Y-%m-%d")="'.$row->tahun.'" && invoice_status_id>="3" && invoice_status_id<="5"')->result();
                      // echo '<tr><td>'.$invoice.'</td></tr>';
                      $no=0;
                      $total = 0;
                      foreach ($invoice AS $in) {
                        echo '<tr>';
                        echo '<td style="text-align:center;">'.++$no.'</td>';
                        echo '<td><a href="'.base_url().'admin/order/view/'.$in->invoice_id.'" title="Lihat detail">'.$in->invoice_number.'</td>';
                        echo '<td>Rp. '.number_format($in->invoice_total_price,0).'</td>';
                        echo '<td>Rp. '.number_format($in->invoice_shipping,0).'</td>';
                        echo '<td>Rp. '.number_format($in->invoice_grand_total,0).'</td>';
                        echo '</tr>';
                        $total+=$in->invoice_grand_total;
                      }
                      $grand_total = $total;
                      echo '<tr>';
                      echo '<td colspan="4" style="text-align:center;font-weight:700;">Grand Total</td>';
                      echo '<td>Rp. '.number_format($grand_total,0).'</td>';
                      echo '</tr>';
                      $total_periode+=$grand_total;
                    } // end foreach
                    $month_total = $this->db->query('SELECT * FROM invoice WHERE date_format(invoice_date_order,"%Y")="'.$year_now.'" && date_format(invoice_date_order,"%m")="'.$month_now.'" && invoice_status_id>="3" && invoice_status_id<="5"')->result();
                    $grand_total_periode = $total_periode;
                    echo '<tr>';
                    echo '<td colspan="4" style="background-color:#7893a2;text-align:center;font-size:14px;font-weight:bold;border-right:1px solid #7893a2">Total penjualan periode '.parsing_month($month_now).' '.$year_now.'</td>';
                    echo '<td style="background-color:#7893a2;font-size:14px;font-weight:bold;border-left:1px solid #7893a2">Rp. '.number_format($grand_total_periode,0).'</td>';
                    echo '</tr>';
                    
                  } else { 
                    echo '<tr><td colspan="5" style="text-align:center;font-style:italic;">Tidak ada transaksi</td></tr>';
                  }
                ?>                
              </table>
            </div>
            
          </div>
          <!-- /.box -->

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">

  </script>