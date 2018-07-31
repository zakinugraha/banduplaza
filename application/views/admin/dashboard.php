  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">

        <!-- Left col -->
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <!-- Info Boxes Style 2 -->
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="ion ion-android-checkmark-circle"></i></span>
                <?php
                  $count_product = $this->db->query('SELECT * FROM product')->num_rows();
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Produk</span>
                  <span class="info-box-number"><?php echo $count_product;?></span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    dari semua kategori
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <!-- Info Boxes Style 2 -->
              <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="ion ion-android-stopwatch"></i></span>
                <?php
                  $bulan = date('m');
                  $count_invoice_month = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order, "%m") = "'.$bulan.'"')->num_rows();
                  $count_invoice = $this->db->query('SELECT * FROM invoice')->num_rows();
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Invoice Diterbitkan</span>
                  <span class="info-box-number"><?php echo $count_invoice;?></span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                      dari total <?php echo $count_invoice;?> invoice
                    </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <!-- Info Boxes Style 2 -->
              <div class="info-box bg-red">
                <span class="info-box-icon"><i class="ion ion ion-alert-circled"></i></span>
                <?php
                  $list_penjualan = $this->db->query('SELECT invoice_grand_total, invoice_status_id FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5"')->result();
                  $count_penjualan = $this->db->query('SELECT invoice_grand_total, invoice_status_id FROM invoice')->num_rows();
                  $total = 0;
                  foreach ($list_penjualan AS $list) {
                    $total+=$list->invoice_grand_total;
                  }
                  $grand_total = $total;
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Total Penjualan</span>
                  <span class="info-box-number"><?php echo number_format($grand_total, 0);?></span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    dari <?php echo $count_penjualan;?> transaksi
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <!-- /.info-box -->
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-paper-outline"></i></span>
                <?php
                  $count_wait_confirm = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id="1"')->num_rows();
                ?>
                <div class="info-box-content">
                  <span class="info-box-text">Menunggu Pembayaran</span>
                  <span class="info-box-number"><?php echo $count_wait_confirm;?></span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <span class="progress-description">
                    Menunggu konfirmasi pembayaran
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>


          </div>
          
        </div>
        <!-- /.col-md-4 -->

        <?php
          $month = array();
          $year = array();
          $tahun = date('Y');
          $list_bulan = $this->db->query('SELECT DISTINCT DATE_FORMAT(invoice_date_order, "%m") AS month FROM invoice WHERE DATE_FORMAT(invoice_date_order, "%Y") = "'.$tahun.'" ORDER BY invoice_date_order ASC')->result();
          foreach ($list_bulan AS $b) {
            $count_penjualan = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order, "%m") = "'.$b->month.'" && DATE_FORMAT(invoice_date_order, "%Y") = "'.$tahun.'"')->num_rows();
            array_push($month,array(parsing_month($b->month)));
            array_push($year,array($count_penjualan));
          }
        ?>

      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Laporan Penjualan Tahun <?php echo $tahun;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Sales: <?php echo $tahun;?></strong>
                  </p>                  

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="areaChart" style="height:250px"></canvas>                    
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                  <?php
                    $tahun = date('Y');
                    $count_invoice_this_year = $this->db->query('SELECT * FROM invoice WHERE DATE_FORMAT(invoice_date_order, "%Y") = "'.$tahun.'"')->num_rows();
                    $count_wait_confirm_this_year = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id="1" && DATE_FORMAT(invoice_date_order, "%Y")="'.$tahun.'"')->num_rows();
                    $count_confirm_this_year = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id>="3" && invoice_status_id<="5" && DATE_FORMAT(invoice_date_order, "%Y")="'.$tahun.'"')->num_rows();
                    $count_expired_this_year = $this->db->query('SELECT * FROM invoice WHERE invoice_status_id="6" && DATE_FORMAT(invoice_date_order, "%Y")="'.$tahun.'"')->num_rows();
                  ?>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Invoice diterbitkan</span>
                    <span class="progress-number"><b><?php echo $count_invoice_this_year;?></b>/100</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Menunggu Pembayaran</span>
                    <span class="progress-number"><b><?php echo $count_wait_confirm_this_year;?></b>/<?php echo $count_invoice_this_year;?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Konfirmasi Pembayaran</span>
                    <span class="progress-number"><b><?php echo $count_confirm_this_year;?></b>/<?php echo $count_invoice_this_year;?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Invoice Jatuh Tempo</span>
                    <span class="progress-number"><b><?php echo $count_expired_this_year;?></b>/<?php echo $count_invoice_this_year;?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header" id="total_omzet"></h5>
                    <span class="description-text">TOTAL OMZET</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header" id="total_profit"></h5>
                    <span class="description-text">TOTAL PROFIT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                    <h5 class="description-header" id="total_product"></h5>
                    <span class="description-text">PRODUK TERJUAL</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-up"></i> 18%</span>
                    <h5 class="description-header" id="target"></h5>
                    <span class="description-text">TARGET OMZET</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Sparkline -->
  <script src="<?php echo base_url();?>assets/admin/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?php echo base_url();?>assets/admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url();?>assets/admin/js/pages/dashboard2.js"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url();?>assets/admin/plugins/chart.js/Chart.js"></script>

  <script>
    $(document).ready(function(){

      $('#total_omzet').html('<img src="<?php echo base_url();?>assets/admin/img/loader.gif">');
      $('#total_profit').html('<img src="<?php echo base_url();?>assets/admin/img/loader.gif">');
      $('#total_product').html('<img src="<?php echo base_url();?>assets/admin/img/loader.gif">');
      $('#target').html('<img src="<?php echo base_url();?>assets/admin/img/loader.gif">');
      $.ajax({
        url : '<?php echo base_url();?>admin/dashboard/total',
        dataType:'json',
        data : 'get',
        success:function(res) {
          // console.log(res);
          $('#total_omzet').text('IDR '+res.omzet);
          $('#total_profit').text('IDR '+res.profit);
          $('#total_product').text(res.count+' pcs');
          $('#target').text('IDR '+res.target);
        },
        error:function(res) {
          $('#total_omzet').text('Nan');
          $('#total_profit').text('Nan');
          $('#total_product').text('Nan');
          $('#target').text('Nan');
        }
      });
    });
  </script>

  
<script>
  $(function () {
    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)
    // Initial data
    var bl = <?php echo json_encode($month)?>;
    var th = <?php echo json_encode($year)?>;

    var areaChartData = {
      labels  : bl,
      datasets: [
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : th
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
  })
</script>