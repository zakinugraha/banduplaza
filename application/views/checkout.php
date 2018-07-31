<main id="main-content" class="main-content grey">
    <section id="checkout" class="checkout">
        <div class="container text-center">
            <div class="col-sm-12">
                <?php
                    if ($this->input->get('message')=='warning') {
                        echo '<div class="attention"><i class="fa fa-exclamation-circle"></i> Anda tidak mempunyai produk apapun di keranjang belanja anda</div></div>';
                    } else if ($this->input->get('message')=='empty') {
                        echo '<div class="attention-warning"><i class="fa fa-exclamation-circle"></i> Untuk melanjutkan proses checkout, silahkan login terlebih dahulu.</div></div>';
                    } else if ($this->input->get('message')=='address') {
                        echo '<div class="attention-warning"><i class="fa fa-exclamation-circle"></i> Untuk melanjutkan proses checkout, silahkan anda mengisi alamat pengiriman terlebih dahulu.</div></div>';
                    }  else if ($this->input->get('message')=='no_voucher') {
                        echo '<div class="attention-warning"><i class="fa fa-exclamation-circle"></i> Voucher tidak terdaftar.</div></div>';
                    }   else if ($this->input->get('message')=='voucher_ready') {
                        echo '<div class="attention-warning"><i class="fa fa-exclamation-circle"></i> Voucher sudah digunakan.</div></div>';
                    } 
                ?>
            </div>
        </div>

        <div class="container ">
                
            <div class="col-md-8">
                <div class="row">
                    <div class="form">

                        <div id="address" style="display:block;">
                            <div class="col-sm-12" style="margin-bottom:10px">
                                <h3 class="ship"><i class="fa fa-book" style="margin-right:5px;"></i>Alamat Pengirman</h3>
                                <p>Isi alamat dengan benar. Alamat yang diisi akan menjadi alamat tujuan pesanan anda.</p>
                            </div>

                            <form action="<?php echo base_url();?>checkout" method="POST">
                                <input type="hidden" name="invoice_number" value="<?php echo $invoice_number;?>" >
                                <div class="form-group">
                                    <label class="col-sm-3">Nama <span class="req">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control" value="<?php echo set_value('name');?>" >
                                        <?php echo form_error('name', '<p class="required">', '</p>');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Email <span class="req">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="email" class="form-control" value="<?php echo set_value('email');?>" >
                                        <?php echo form_error('email', '<p class="required">', '</p>');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Telepon <span class="req">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone');?>" >
                                        <?php echo form_error('phone', '<p class="required">', '</p>');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Alamat <span class="req">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea name="address" rows="3" class="form-control"><?php echo set_value('address');?> </textarea>
                                        <?php echo form_error('address', '<p class="required">', '</p>');?>
                                    </div>
                                </div>

                                <div class="form-group position-relative">
                                    <label class="col-sm-3">Provinsi <span class="req">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="select-style">
                                            <select name="province" class="form-control" id="province_id_ship" onchange="get_city_ship();">
                                            <option value="">-- Pilih provinsi --</option>
                                                <?php foreach ($province AS $row) { ?>
                                                <option value="<?php echo $row->area_api_id;?>"><?php echo $row->area_name?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('province', '<p class="required">', '</p>');?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group position-relative">
                                    <label class="col-sm-3">Kota <span class="req">*</span></label>                                        
                                    <div class="col-sm-9">
                                        <div class="select-style">
                                            <select name="city" class="form-control" id="city_id_ship" onchange="get_cost();"></select>                                        
                                            <?php echo form_error('city', '<p class="required">', '</p>');?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Kode POS</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="postcode" class="form-control" value="<?php echo set_value('postcode');?>" >
                                        <?php echo form_error('postcode', '<p class="required">', '</p>');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Catatan </label>
                                    <div class="col-sm-9">
                                        <textarea name="note" rows="3" class="form-control"><?php echo set_value('note');?> </textarea>
                                    </div>
                                </div>

                                <hr class="sep">

                                <div class="form-group-payment">
                                    <h3><i class="fa fa-money" style="margin-right:10px;"></i>Metode Pembayaran</h3>
                                    <div class="payment-list">
                                        <ul>
                                            <?php
                                                $bank = $this->db->query('SELECT * FROM bank WHERE bank_status="enabled" ORDER BY bank_updated_date DESC')->result();
                                                foreach ($bank AS $bk) {
                                            ?>
                                            <li>                                                    
                                                <input type="radio" name="bank_id" value="<?php echo $bk->bank_id;?>" <?php echo $bk->bank_id=='2' ? 'checked' : '';?> />
                                                <div class="bank-img">
                                                    <img src="<?php echo base_url();?>upload/images/bank/<?php echo $bk->bank_logo;?>">
                                                </div>
                                                <div class="bank-note">
                                                    <span><?php echo $bk->bank_name;?></span>
                                                    <?php echo $bk->bank_note;?>
                                                </div>
                                                
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- <div class="l-b"></div> -->

                                <div class="col-sm-12" style="margin-top:30px">
                                    <h3 class="ship"><i class="fa fa-truck" style="margin-right:10px;"></i>Paket Pengiriman</h3>
                                    <p>Pilih salah satu paket pengiriman yang anda inginkan</p>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group" style="padding:0">
                                        <?php echo form_error('shipping_cost', '<p class="required">', '</p>');?>
                                        <div id="load_ship" class="load"><img src="<?php echo base_url();?>assets/front/images/ajax-loader.gif"> Menampilkan paket pengiriman...</div>
                                    </div>
                                

                                    <!-- <p class="title">Select your shipping </p> -->
                                    <!-- <h3 class="free-ongkir">Free Ongkir</h3> -->
                                
                                    <table class="table container_cost">
                                        <tbody></tbody>
                                    </table>

                                    <div class="form-group">
                                        <!-- <p class="free-ongkir" style="display:none;color:#ff4b4b">* Klik "Lanjut" untuk mendapatkan promo FREE ONGKIR up to IDR 25,000</p> -->
                                        <input type="hidden" class="total_shipping" name="shipping_cost" value="0">
                                        <?php if (!empty($_SESSION['order'])) { ?>
                                            <input type="hidden" id="total_weight" name="weight_total" class="input-text" value="<?php echo $weight;?>">
                                        <?php }else{ ?>
                                            <input type="hidden" id="total_weight" name="weight_total" class="input-text" value="1">
                                        <?php } ?>
                                    </div>
                                    
                                </div>

                                <div class="form-group text-center">
                                    <input type="submit" name="submit" value="Lanjut" class="submit">
                                </div>
                            </form>
                            
                        </div> <!-- End id address -->
                        
                    </div>                    

                </div> <!-- end row -->
            </div>
            <div class="col-md-4">
                <div class="box-price">

                    <div class="bar-title">
                        <span>Billing</span>
                    </div>

                    <div class="form-group">
                        <span class="total">Total Pembelian : </span>
                        <span class="right">Rp. <?php echo isset($_SESSION['order']) ? number_format($pembelian,0) : '0';?></span>
                    </div>
                    <div class="form-group">
                        <span class="total">Diskon : </span>
                        <span class="right">
                            <?php 
                                $get_order_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
                                if (count($get_order_arr)>0) {
                                     echo isset($_SESSION['discount']) ? 'Rp. '.number_format($_SESSION['discount']['discount_total'],0) : 'Rp. 0';
                                 } else {
                                    unset($_SESSION['order']);
                                    unset($_SESSION['discount']);
                                    echo '0';
                                 }
                            ?>
                        </span>
                    </div>

                    <hr class="sep-total">

                    <div class="form-group">
                        <span class="total">Grand Total : </span>
                        <span class="right">Rp. <?php echo isset($_SESSION['order']) ? number_format($grand_total,0) : '0';?></span>
                    </div>

                    <div class="form-group">
                        <p class="text"><span class="req">*</span> belum termasuk ongkos kirim</p>
                    <hr class="sep-total">
                        <!-- <input type="text" name="disc_hide" value="<?php echo $discount;?>"> -->
                        <div class="cek_member">
                            <!-- <input type="checkbox" name="c1" id="checkbox" class="hide">
                            <label for="checkbox"> Gunakan Kode Voucher</label> -->
                            <p>Gunakan Voucher</p>
                        </div>
                        <div class="cek-member-form" id="cek_member" style="display:block">
                            <form method="POST" action="<?php echo base_url();?>checkout/cek_code">
                                <input type="text" name="discount_code" class="form-control" placeholder="Masukan kode voucher">
                                <input type="submit" name="cek_code" value="Cek" class="cek_submit">
                            </form>
                            <div class="info">
                                <div class="content">
                                    <div class="symbol">
                                        <i class="fa fa-info-circle"></i>
                                        <span>Mau dapat voucher diskon?</span>
                                    </div>
                                    <div class="desc">
                                        <span>Caranya gampang. Kamu tinggal follow akun sosial media banduplaza. Disana kamu juga bisa dapet informasi produk terbaru dari banduplaza.</span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url();?>" class="go-shop">Lanjutkan Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </section>
</main>

<!-- Add Address -->
<script type="text/javascript">
    var element_city_ship=$("#city_id_ship");
    $(function(){
    });

    function get_city_ship()
    {
        element_city_ship.html('<option value="">Loading...</option>');
        var province_id_ship=$('#province_id_ship').val();
        var jqxhr=$.ajax({
            url:'<?php echo base_url()?>checkout/get_city/'+province_id_ship,
            type:'get',
            dataType:'json',

        });
        jqxhr.success(function(response){
            element_city_ship.html('<option value="">-- Pilih Kota/Kabupaten --</option>');
            $.each(response,function(index,rowArr){
                element_city_ship.append('<option value="'+rowArr['area_api_id']+'">'+rowArr['area_name']+'</option>');
            });
        });
        jqxhr.error(function(response){
            alert('an error has occurred, please try again...');
            return false;
        });
    }

    function get_cost()
    {
        var ori_province=$('#province_id_ship').val();
        var ori_city=$('#city_id_ship').val();
        var total_weight=$('#total_weight').val();
        var element_cost=$("table.container_cost").find('tbody');

        var jqxhr=$.ajax({
            url:'<?php echo base_url()?>checkout/get_cost/'+ori_city+'/'+total_weight,
            type:'get',
            dataType:'json',
        });

        $("#load_ship").addClass('load-show');

        jqxhr.success(function(response){
            element_cost.html('');
            $.each(response,function(index,rowArr){
                var result_cost=rowArr['cost'];
                $.each(result_cost,function(indexCost,rowArrCost){
                    element_cost.append('<tr style="border-bottom:1px solid #ddd;"><td style="width:50px;text-align:center;vertical-align:middle;border:none"><input name="cost_value" onclick="$(\'.total_shipping\').val($(this).val());$(\'.cost_value\').html($(this).val());" type="radio" value="'+rowArrCost['value']+'"></td><td style="border:none"><strong>JNE</strong><br>'+rowArr['description']+' ('+rowArr['service']+')'+'<br>Estimasi barang sampai : '+rowArrCost['etd']+' hari</td><td style="vertical-align:middle;text-align:center;border:none;"><span class="price">Rp. '+rowArrCost['value']+'</span></td></tr>');
                });
            });

            $("#load_ship").hide();
            $("#list_ship").show();
            $(".free-ongkir").show();
            // $("#btn_ship").hide();
            // $("#address").hide();
            // $("#list_cost").show();
        });
        jqxhr.error(function(response){
            alert('an error has occurred, please try again...');
            return false;
        });
    }
</script>

