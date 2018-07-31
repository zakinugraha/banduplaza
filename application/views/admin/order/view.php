  <!-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-riKCY137fmDMnGp_"></script> -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoice
        <small>#<?php echo $view->invoice_number;?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Invoice</a></li>
        <li class="active">View</li>
      </ol>
    </section>

    <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
      </div>
    </div>

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
                <td><?php echo 'Rp '.number_format($data->product_price_discount);?></td>
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

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="<?php echo base_url();?>admin/order/print_preview/<?php echo $view->invoice_id;?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" id="pay-button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
          <input type="hidden" name="token" value="<?php echo $snapToken?>">
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
  <!-- /.content-wrapper -->

  <script>
      var result_token = document.getElementById('token');
      var payButton = document.getElementById('pay-button');
      var shipping = $(".total_shipping").val();

      $('#pay-button').click(function (event) {
          event.preventDefault();
          // payButton.addEventListener('click', function () {
          // snap.pay(result_token); // store your snap token here
          // alert('<?php echo $snapToken?>'); // store your snap token here
          $.ajax({
              url: '<?php base_url();?>admin/order/pay',
              cache: false,

              success: function(data) {
                  snap.pay('<?php echo $snapToken?>', {
                      onSuccess: function(result){
                          console.log('success');
                          console.log(result);
                      },
                      onPending: function(result){
                          console.log('pending');
                          // location.href = '<?php echo base_url() ?>dashboard/view/'+result.order_id;
                          // location.href = result.finish_redirect_url;
                          console.log(result);
                          // console.log(result.finish_redirect_url);
                      },
                      onError: function(result){
                          console.log('error');
                          console.log(result);
                      },
                      onClose: function(){
                          console.log('customer closed the popup without finishing the payment');
                          // window.close();
                      }
                  })
              }
          });
                  
      // });
      });
  </script>