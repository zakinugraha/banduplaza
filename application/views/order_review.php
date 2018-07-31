<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-riKCY137fmDMnGp_"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<main id="main-content" class="main-content grey">
    <section id="order-review" class="order-review">
        
        <div class="container ">        
            <div class="box-back">                
                <div class="col-md-8">
                    <div class="row">
                        <div class="form">
                            <div class="box-ongkir">
                                <img src="<?php echo base_url();?>assets/front/images/check-ongkir.png">
                                <h5>Hooorayy! Kamu mendapatkan FREE ONGKIR up to IDR 25,000</h5>
                            </div>
                        </div>

                        <div class="form">
                            <div class="desc-payment">
                                <div class="col-sm-12" style="margin-bottom:10px">
                                    <h3 class="ship"><i class="fa fa-money" style="margin-right:5px;"></i>Metode Pembayaran</h3>
                                    <p class="head">Pilih metode pembayaran untuk menyelesaikan proses order anda.</p>
                                </div>

                                <div class="col-sm-12">
                                    <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                                        <p><strong><i class="fa fa-exclamation-circle"></i> Penting!</strong> 
                                        Demi keamanan dan kenyamanan user dalam proses berbelanja, seluruh transaksi di Banduplaza menggunakan Midtrans Online Payment Gateway.</p>
                                        <p>Apa itu Midtrans Online Payment Gateway? Lihat <a href="<?php echo base_url();?>help/1500602543/keamanan-transaksi">disini</a></p>
                                    </div>                                   
                                </div>
                                <div class="col-sm-12">
                                    <input type="hidden" name="token" value="<?php echo $snapToken?>">
                                    <button type="button" name="submit" id="pay-button" class="pay">Pilih metode pembayaran</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end col -->

                <div class="col-md-4">
                    <div class="row">
                        <div class="form">
                            <h5 class="info"><i class="fa fa-shopping-cart"></i> Info Pesanan</h5>
                            <table>
                                <tr>
                                    <th class="text-left"><span>Produk</span></th>
                                    <th class="text-right"><span>Harga</span></th>
                                </tr>
                                <?php 
                                    $i=0;
                                    foreach ($list_order AS $row) { 
                                        $product = $this->db->query('SELECT product_id, product_name from product WHERE product_id="'.$row['product_id'].'"')->row();
                                ?>
                                    <tr>
                                        <td><?php echo $product->product_name;?></td>
                                        <td class="text-right"><?php echo $row['product_qty'].' x '.number_format($row['product_price'],0);?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>Shipping <span style="color:red">*</span></td>
                                    <td class="text-right"><?php echo number_format($shipping_cost,0);?></td>
                                </tr>
                                <tr>
                                    <td>Voucher</td>
                                    <td class="text-right"><?php echo number_format($invoice_discount,0);?></td>
                                </tr>
                                <tr>
                                    <td class="total text-center">Total</td>
                                    <td class="total text-right"><?php echo number_format($grand_total,0);?></td>
                                </tr>
                            </table>

                            <h5 class="info-d"><i class="fa fa-book"></i> Alamat Pengiriman</h5>
                            <div class="l-b-detail"></div>
                            <p><?php echo $customer_name;?></p>
                            <p><?php echo $customer_phone;?></p>
                            <p><strong>Alamat :</strong></p>
                            <?php echo $customer_address;?>
                            <p><?php echo $city;?></p>
                            <p><?php echo $province;?></p>
                            <p><?php echo $customer_postcode;?></p>
                            <div class="l-b-detail"></div>
                            <p><strong>Catatan :</strong></p>
                            <?php echo $customer_note=='' ? 'Tidak ada catatan' : $customer_note;?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
</main>

<script>

    $('#pay-button').click(function (event) {
        event.preventDefault();
        $.ajax({
            url: '<?php base_url();?>order/review',
            cache: false,

            success: function(data) {
                snap.pay('<?php echo $snapToken?>', {
                    onSuccess: function(result){
                        console.log('success');
                        console.log(result);
                    },
                    onPending: function(result){
                        location.href = '<?php echo base_url() ?>order/success?order_id='+result.order_id+'&payment_type='+result.payment_type+'&pdf_url='+result.pdf_url;
                        // location.href = '<?php echo base_url() ?>order/success';
                        console.log('pending');
                        console.log(result);
                        // console.log(result.finish_redirect_url);
                    },
                    onError: function(result){
                        console.log('error');
                        console.log(result);
                    },
                    onClose: function(){
                        console.log('close');
                        console.log('customer closed the popup without finishing the payment');
                    }
                })
            }
        });           
    });
</script>