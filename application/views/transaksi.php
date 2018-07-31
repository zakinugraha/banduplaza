<main id="main-content" class="main-content">
    <section id="transaksi" class="transaksi">

        <div class="container ">
            <div class="content">
                <div class="t_header">
                    <span>Berikut adalah riwayat order anda</span>
                </div>

                <div class="box-back" style="padding: 10px 0;">

                    <div class="col-md-9">
                        <div class="row">
                            <div class="t_body">
                                <?php
                                    if ($count==0) {
                                        echo "Belum ada transaksi";
                                    } else {
                                        foreach ($list AS $row) {
                                ?>
                                        <div class="list_transaksi">
                                            <div class="col-md-4">
                                            <div class="left">
                                                <h4>Invoice No : #<a href="<?php echo base_url();?>transaksi/detail?invoice=<?php echo $row->invoice_number;?>" target="_BLANK" class="link"><?php echo $row->invoice_number;?></a></h4>
                                                <!-- <div class="l-b-transaksi"></div> -->
                                                <p>Order Date : <?php echo $row->invoice_date_order;?></p>
                                                <p>Expired Date : <?php echo $row->invoice_date_expired;?></p>
                                                <p>Status : <?php echo ucfirst($row->invoice_transaction_status);?></p>
                                                <p>No Resi : <?php echo $row->invoice_resi_number;?></p>
                                                <?php if ($row->invoice_status_id=="1") { ?>
                                                    <!-- <a href="<?php echo base_url().'confirm?id='.$row->invoice_number;?>">Konfirmasi</a> -->
                                                <?php } ?>
                                            </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="right">
                                                    <table>
                                                        <tr>
                                                            <th style="min-width:250%">Item</th>
                                                            <th style="min-width:250%">Price</th>
                                                            <th style="min-width:250%">Discount</th>
                                                            <th style="min-width:250%">Total</th>
                                                        </tr> 
                                                        <?php
                                                            $product = $this->db->query('select s.*, s.summary_order_id, s.invoice_number, s.product_id, s.product_qty, s.product_price, s.product_price_total, p.product_id, p.product_name, p.product_code from summary_order s inner join product p on (s.product_id=p.product_id) where s.invoice_number="'.$row->invoice_number.'" order by s.summary_order_id asc')->result();
                                                            foreach ($product AS $pr) {
                                                        ?>
                                                        <tr class="body">
                                                            <td class="item"> <?php echo $pr->product_name.' ('.$pr->product_code.') * '.$pr->product_qty;?></td>
                                                            <td>Rp. <?php echo number_format($pr->product_price_sell*$pr->product_qty,0);?></td>
                                                            <td>Rp. <?php echo number_format($pr->product_price_discount*$pr->product_qty,0);?></td>
                                                            <td>Rp. <?php echo number_format($pr->product_price_total,0);?></td>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr class="body">
                                                            <td class="item">Discount Voucher</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>Rp. <?php echo number_format($row->invoice_discount,0);?></td>
                                                        </tr>
                                                        <tr class="body">
                                                            <td class="item">Shipping</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>Rp. <?php echo number_format($row->invoice_shipping,0);?></td>
                                                        </tr>
                                                        <tr class="grandtotal">
                                                            <td class="tot-text" colspan="3">Grand Total</td>
                                                            <td class="tot-text">Rp. <?php echo number_format($row->invoice_grand_total,0);?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                <?php 
                                        }
                                    }
                                ?>
                            </div>
                            <div class="pagination-list">
                                <div class="row">
                                    
                                    <div class="col-xs-12 col-sm-12 text-right">
                                        <ul class="pagination no-margin">
                                            <?php echo $pagination; ?>
                                        </ul>
                                    </div> <!-- //col -->
                                </div> <!-- //row -->
                            </div> <!-- //pagination -->

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="note">
                            <ul>
                                <li><span>Detail order anda akan dikirim melalui email</span></li>
                                <li><span>Lakukan pembayaran sesuai dengan total yang tertera di invoice</span></li>
                                <li><span>Segera lakukan konfirmasi pembayaran setelah melakukan transaksi</span></li>
                                <li><span>Apabila ada pertanyaan silahkan hubungi kami <a href="<?php echo base_url();?>contact">disini</a></span></li>
                                <li><span>Terima kasih telah berbelanja di banduplaza</span></li>
                            </ul>
                        </div>
                    </div>
                    
                </div> <!-- End row-->
            </div>
        </div>

    </section>
</main>