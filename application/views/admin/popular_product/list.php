  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Produk Terpopuler
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Laporan</a></li>
        <li class="active">Produk Terpopuler</li>
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
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group input-group-sm" style="width:100%;">
                    <label>Pilih periode :</label>
                    <form method="POST" action="<?php echo current_url();?>">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="reservation">
                        <span class="input-group-btn"><input type="submit" name="apply" value="Apply" class="btn btn-flat btn-success"></span>
                      </div>
                      <input type="hidden" class="form-control pull-right" name="from" id="start" value="<?php echo isset($from) ? $from : $start_last_month;?>">
                      <input type="hidden" class="form-control pull-right" name="to" id="end" value="<?php echo isset($from) ? $to : date("Y-m-d");?>">
                    </form>
                  </div>
                </div>
                <!-- <div class="col-md-4">
                  <div class="input-group input-group-sm" style="width:250px;">
                    <label>Pilih Tipe Produk :</label>
                    <form method="POST" action="<?php echo current_url();?>">
                      <div class="form-group">
                        <select class="form-control">
                          <option>Sepatu</option>
                          <option>Tas</option>
                        </select>
                        <input type="submit" name="applyType" value="Apply" class="btn btn-flat btn-success" style="display:inherit">
                      </div>
                    </form>
                  </div>
                </div> -->
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $title_stats;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="chart">
                <canvas id="bar-chart-horizontal" width="800" height="450"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- ChartJS -->
  <script src="<?php echo base_url();?>assets/admin/plugins/Chart.js/AjaxChart.min.js"></script><!-- date-range-picker -->
  <script src="<?php echo base_url();?>assets/admin/plugins/moment/min/moment.min.js"></script>
  <script src="<?php echo base_url();?>assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script type="text/javascript">
    function stats_val() {
      // alert('yes');
      $('#start').val($('#daterangepicker_start').val());
      $('#end').val($('#daterangepicker_end').val());    
    }
  </script>

  <script>
    $(function () {

      var nama = <?php echo json_encode($nama_product)?>;
      var total = <?php echo json_encode($total)?>;
      var color = <?php echo json_encode($color)?>;

      new Chart(document.getElementById("bar-chart-horizontal"), {
        type: 'horizontalBar',
        data: {
          labels: nama,
          datasets: [
            {
              label: "Dilihat",
              backgroundColor: color,
              data: total
            }
          ]
        },
        options: {
          scales: {
            yAxes: [{
              gridLines: {
                drawOnChartArea: false
              }
            }]
          },
          legend: { display: false },
          title: {
            display: false,
            text: 'Predicted world population (millions) in 2050'
          }
        }
    });

    //Date range picker
    $('#reservation').daterangepicker()

  })
</script>