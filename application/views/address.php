<main id="main-content" class="main-content">
    <section id="address" class="address">
        <div class="container text-center">
            <div class="attention">
                <span>Berikut adalah alamat anda. Setiap barang yang sudah anda order akan dikirim ke alamat ini.</span>
            </div>
        </div>

        <div class="container ">
            <div class="content">

                <?php
                    $cek = $this->db->query('SELECT * FROM address WHERE customer_id="'.base64_decode($_SESSION['user_customer']['customer_id']).'"')->num_rows();
                    if ($cek==0) {
                ?>
                 <p class="title">Anda belum mengisi alamat</p>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <a href="<?php echo base_url();?>configuration/add_address" class="button">Tambah alamat</a>
                        </div>
                    </div>
                    
                </div>
                <?php
                    } else {
                ?>
                <p class="title">Berikut adalah alamat anda</p>
                <div class="row">

                    <div class="form-group">
                        <div class="col-xs-12"><?php echo $config->title;?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12"><?php echo $config->name;?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12"><?php echo $config->address;?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12"><?php echo $city->area_name;?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12"><?php echo $provinsi->area_name;?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12"><?php echo $config->postcode;?></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12"><a href="<?php echo base_url();?>configuration/edit_address" class="button">Ubah alamat</a></div>
                    </div>

                </div>
                <?php } ?>
            </div>
        </div>

    </section>
</main>