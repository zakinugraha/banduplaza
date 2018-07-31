<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">  <!-- onload="window.print();" -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Banduplaza.
          <small class="pull-right">Tanggal : <?php echo full_parsing_date($view->invoice_date_order);?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>Banduplaza</strong><br>
          Phone : 082126603648<br>
          Email: info@banduplaza.com
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $view->invoice_name;?></strong><br>
          <?php echo $view->invoice_address;?><br>
          <?php echo $get_city->area_name;?><br>
          <?php echo 'Kode POS : '.$view->invoice_postcode;?><br>
          Phone: <?php echo $view->invoice_phone;?><br>
          Email: <?php echo $view->invoice_email;?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?php echo $view->invoice_number;?></b><br>
        <br>
        <b>Invoice #:</b> <?php echo $view->invoice_number;?><br>
        <b>Order:</b> <?php echo full_parsing_date($view->invoice_date_order);?><br>
        <b>Expired:</b> <?php echo full_parsing_date($view->invoice_date_expired);?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Size</th>
            <th>Harga</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Grand Total</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($list AS $data) { ?>
            <tr>
              <td><?php echo $data->product_name.' ('.$data->product_code.')';?></td>
              <td><?php echo $data->product_qty;?></td>
              <td>
                <?php 
                  $size = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$data->product_size.'"')->row();
                  $size_name = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_id="'.$size->size_attributes_id.'"')->row();
                  echo $size_name->size_attributes_value;
                ?>
              </td>
              <td><?php echo 'Rp '.number_format($data->product_price_sell);?></td>
              <td><?php echo 'Rp '.number_format($data->product_price_sell-$data->product_price_discount);?></td>
              <td><?php echo 'Rp '.number_format($data->product_price);?></td>
              <td><?php echo 'Rp '.number_format($data->product_price*$data->product_qty);?></td>
            </tr>
          <?php } ?>
          
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods:</p>
        <!-- <p>Transfer via Bank <?php echo $view->bank_id=="0"?"Transfer Bank" : $bank_method->bank_name;?></p> -->
        <?php if ($view->bank_id!="0") { ?>
        <img src="<?php echo base_url();?>upload/images/bank/<?php echo $bank_method->bank_logo;?>" alt="<?php echo $bank_method->bank_name;?>">
        <?php } ?>
        <!-- <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
        <img src="../../dist/img/credit/american-express.png" alt="American Express">
        <img src="../../dist/img/credit/paypal2.png" alt="Paypal"> -->

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Transfer via <strong><?php echo $view->bank_id=="0"?"Midtrans Payment Gateway" : " Bank ".$bank_method->bank_name;?></strong><br>
          Selalu cek mutasi rekening bank terhadap semua konfirmasi pembayaran.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Expired : <?php echo full_parsing_date($view->invoice_date_expired);?></p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td><?php echo 'Rp. '.number_format($view->invoice_total_price);?></td>
            </tr>
            <tr>
              <th>Shipping:</th>
              <td><?php echo 'Rp. '.number_format($view->invoice_shipping);?></td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><?php echo 'Rp. '.number_format($view->invoice_grand_total);?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
