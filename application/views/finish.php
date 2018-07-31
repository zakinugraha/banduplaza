<main id="main-content" class="main-content">
    <section id="finish" class="finish">
        <div class="container">
        	<div class="order-finish-inside">
                <img src="<?php echo base_url();?>assets/front/images/check-ongkir.png">
                <h3>Terima Kasih!</h3>
                <label>Order ID : <?php echo $this->input->get('invoice');?></label>
            </div>

            <!-- <div class="title-bar">
                <p class="title">Order anda dalam proses pengecekan</p>
            </div> -->

            <div class="content">                
                <p>Terima kasih telah melengkapi proses order anda.</p>
                <p>Tinggal satu langkah lagi untuk mendapatkan barang yang kamu inginkan.</p>
                <p>Silahkan selesaikan pembayaran anda dengan mengikuti instruksi yang sudah kami kirimkan ke email kamu. </p>
                <p>Apabila anda sudah melakukan proses pembayaran, segera lakukan konfirmasi <a href="<?php echo base_url();?>confirm">disini</a>, agar barang pesanan kamu segera kami kirim.</p>
                <br>

                <div style="color:#ffffff;background-color:#a03333;padding:8px 10px;border-radius:3px;"><i class="fa fa-exclamation-circle"></i> Jangan pernah melakukan transaksi diluar instruksi yang kami berikan. Hanya lakukan transaksi ke rekening yang kami berikan via email.<br>Segala transaksi diluar instruksi yang telah ditentukan bukan merupakan tanggung jawab kami.</div>
                
                <br>
                <p>Terima kasih telah berbelanja</p>
            </div>

            <?php
                if ($this->input->get('invoice')!='') {
            ?>

            <!-- <div class="content" style="overflow-x:auto";>
                <div class="detail">
                    <div class="detail-header">
                        <div class="col-md-8">
                            <h5>Invoice No</h5>
                            <h3 class="inv-num"><?php echo $this->input->get('invoice');?></h3>
                            <br>
                            <p>Tanggal Order : <?php echo $detail->invoice_date_order;?></p>
                            <p>Tanggal Expired : <?php echo $detail->invoice_date_expired;?></p>
                            <p>Metode Pembayaran : Transfer Bank</p>
                            <br>
                        </div>
                        <div class="col-md-4">
                            <p>Penerima : <?php echo $detail->invoice_name;?></p>
                            <p>No Telp : <?php echo $detail->invoice_phone;?></p>
                            <p>Alamat :</p>
                            <p><?php echo $detail->invoice_address;?></p>
                            <p><?php echo $city->area_name;?></p>
                            <p><?php echo $province->area_name;?></p>
                            <p><?php echo $detail->invoice_postcode;?></p>
                        </div>                        
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Size</th>              
                                        <th>Price</th>              
                                        <th>Discount</th>              
                                        <th>Total</th>              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($list AS $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row->product_name.' ('.$row->product_code.') * '.$row->product_qty;?></td>
                                        <td>
                                        <?php 
                                            $stock = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$row->product_size.'" LIMIT 1')->row();
                                            $size = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_id="'.$stock->size_attributes_id.'" LIMIT 1')->row();
                                            echo $size->size_attributes_value; 
                                        ?> 
                                        </td>
                                        <td>Rp. <?php echo number_format($row->product_price_sell*$row->product_qty,0);?></td>
                                        <td>Rp. <?php echo number_format($row->product_price_discount*$row->product_qty,0);?></td>
                                        <td>Rp. <?php echo number_format($row->product_price_total,0);?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4">Discount Voucher</td>
                                        <td>Rp. <?php echo number_format($detail->invoice_discount,0);?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Shipping</td>                                        
                                        <td>Rp. <?php echo number_format($detail->invoice_shipping,0);?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Grand Total</strong></td>
                                        <td><strong>Rp. <?php echo number_format($detail->invoice_grand_total,0);?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php } ?>
            
        </div>
    </section>
</main>