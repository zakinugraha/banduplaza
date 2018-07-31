<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-riKCY137fmDMnGp_"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<main id="main-content" class="main-content">
    <section id="order-review" class="order-review">
        <div class="container text-center">

            <div class="order-review-inside">
                 <h3>Review Your Order</h3>
            </div>
            
            <div class="row text-center">
                <div class="form">
                    <div class="box">
                        <!-- <input type="text" name="token" value="<?php echo $snapToken?>"> --> <!-- Snap Token  -->
                        <div class="top">
                            <h4>Billing Address</h4>
                            <p class="name"><?php echo $customer_name;?></p>
                            <p>Phone : <?php echo $customer_phone;?></p>
                            <?php echo $customer_address;?>
                            <p><?php echo $city;?></p>
                            <p><?php echo $province;?></p>
                            <p>Postal Code : <?php echo $customer_postcode;?></p>
                        </div>
                        <div class="middle">
                            <h4>Shipping</h4>
                            <p>Shipping JNE from Bandung to <?php echo $city;?></p>
                            <p>IDR <?php echo $shipping_cost;?></p>
                        </div>
                        <div class="bottom">
                            <h4>Item Detail</h4>
                            <table>
                                <tr>
                                    <th>Item(s)</th>
                                    <th>Price</th>
                                </tr>
                                <?php 
                                    $i=0;
                                    foreach ($list_order AS $row) { 
                                        $product = $this->db->query('SELECT product_id, product_name from product WHERE product_id="'.$row['product_id'].'"')->row();
                                ?>
                                    <tr>
                                        <td><?php echo $product->product_name.' * '.$row['product_qty'];?></td>
                                        <td><?php echo 'Rp '.number_format($row['product_price'],0);?></td>
                                    </tr>
                                <?php } ?>
                                    
                                <tr>
                                    <td>Diskon Voucher</td>
                                    <td><?php echo 'Rp '.number_format($invoice_discount,0);?></td>
                                </tr>    
                                <tr>
                                    <td>Shipping</td>
                                    <td><?php echo 'Rp '.number_format($shipping_cost,0);?></td>
                                </tr>
                                <tr class="total">
                                    <td>Grand Total</td>
                                    <td><?php echo 'Rp '.number_format($grand_total,0);?></td>
                                </tr>
                            </table>
                        </div>

                    </div>

                    <div class="agree">
                        <input type="checkbox" name="chk_agree" id="checkbox" class="hide" checked>
                        <label for="checkbox"> Saya menyetujui <a href="#" target="_BLANK">syarat dan Ketentuan</a> yang berlaku</label>
                        <button type="button" name="submit" id="pay-button" class="submit">Submit Order</button>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $snapToken?>">
                </div>

            </div>
            
        </div>

    </section>
</main>

<script>    
    var result_token = document.getElementById('token');
    var payButton = document.getElementById('pay-button');
    var shipping = $(".total_shipping").val();

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
                        console.log('pending');
                        location.href = '<?php echo base_url() ?>order/unfinish?order_id='+result.order_id+'&payment_type='+result.payment_type+'&pdf_url='+result.pdf_url;
                        // location.href = result.finish_redirect_url;
                        // console.log(result);
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