<main id="main-content" class="main-content">
    <section id="contact" class="contact">
        <div class="container text-center">

            <div class="contact-help">
                <ul>
                    <li>
                        <div class="bar">
                            <span><i class="fa fa-envelope-o"></i></span>
                            <div class="text">
                                <span class="text-title">Hubungi Kami</span>
                                <span class="text-desc">Butuh bantuan? Hubungi kami di halo@banduplaza.com.</span>
                            </div>
                        </div>
                    </li>
                    <li>
                         <div class="bar">
                            <span><i class="fa fa-gift"></i></span>
                            <div class="text">
                                <span class="text-title">Promo Menarik</span>
                                <span class="text-desc">Nikmati potongan harga dan voucher buat kamu member banduplaza.</span>
                            </div>
                        </div>
                    </li>
                    <li>
                         <div class="bar">
                            <span><i class="fa fa-info-circle"></i></span>
                            <div class="text">
                                <span class="text-title">Ikuti Kami</span>
                                <span class="text-desc">Ikuti kami untuk mendapatkan informasi menarik.</span>
                            </div>
                        </div>
                    </li>
                    <li>
                         <div class="bar">
                            <span><i class="fa fa-thumbs-up"></i></span>
                            <div class="text">
                                <span class="text-title">Produk Berkualitas</span>
                                <span class="text-desc">Kami selalu memastikan kualitas produk yang anda pesan.</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contact-inside">
                 <h3>Sampaikan pertanyaan kamu dengan mengisi form berikut</h3>
            </div>
        

        
            <div class="row text-center">
                <div class="form">
                    <div class="box">

                        <form action="<?php echo base_url();?>contact/send" method="POST">
                            <!-- <input type="hidden" name="token" value="<?php echo $this->input->get('token');?>"> -->
                            <div class="form-group text-left">
                                <div class="col-md-3">
                                    <label>Nama <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" value="<?php echo set_value('name');?>" placeholder="Nama kamu"  > 
                                    <?php echo form_error('name', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Email <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" name="email" class="form-control" value="<?php echo set_value('email');?>" placeholder="Email Kamu"  >
                                    <?php echo form_error('email', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Judul <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="judul" class="form-control" value="<?php echo set_value('judul');?>" placeholder="Judul"  >
                                    <?php echo form_error('judul', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Pesan <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="5" name="pesan" placeholder="Pesan / Pertanyaan"><?php echo set_value('pesan');?></textarea>
                                    <?php echo form_error('pesan', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" name="submit" value="Kirim" class="submit">
                            </div>
                        </form>

                    </div>

                </div>

            </div>
            
        </div>

    </section>
</main>