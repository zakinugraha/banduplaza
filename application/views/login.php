<main id="main-content" class="main-content">
    <section id="login" class="login">
        <div class="container text-center">

            <div class="login-help">
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
                                <span class="text-desc">Ikuti kami dan dapatkan promo menarik yang kami berikan.</span>
                            </div>
                        </div>
                    </li>
                    <li>
                         <div class="bar">
                            <span><i class="fa fa-check-square"></i></span>
                            <div class="text">
                                <span class="text-title">Keamanan Pembayaran</span>
                                <span class="text-desc">Kami selalu memastikan keamanan pembayaran anda.</span>
                            </div>
                        </div>
                    </li>
                    <li>
                         <div class="bar">
                            <span><i class="fa fa-truck"></i></span>
                            <div class="text">
                                <span class="text-title">Pengiriman</span>
                                <span class="text-desc">Kami menyediakan fasilitas pengiriman dan penukaran barang untuk anda.</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="login-inside">
                 <h3>Silahkan login dengan akun anda</h3>
            </div>
           
            <!-- <div class="attention">
                <span>Lengkapi form berikut</span>
            </div> -->

            <?php echo $this->session->flashdata('warning');?>
            <?php
                $param = explode("-", $this->input->get('token'));
                $token = $param[0];
                if (base64_decode($token)=='checkout') {
                    echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Untuk melanjutkan proses checkout, silahkan login terlebih dahulu</i></div>';
                } else if (base64_decode($token)=='wishlist') {
                    echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Untuk menambah produk ke wishlist, silahkan login terlebih dahulu</i></div>';
                }
            ?>
        </div>

        <div class="container ">
            <div class="row text-center">
                <div class="form">
                    <div class="box">

                        <form action="<?php echo base_url();?>login" method="POST">
                            <input type="hidden" name="token" value="<?php echo $this->input->get('token');?>">
                            <div class="form-group text-left">
                                <div class="col-md-3">
                                    <label>Email <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="email" class="form-control" value="<?php echo set_value('email');?>" placeholder="Alamat email" required > 
                                    <?php echo form_error('email', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Password <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="password" name="password" class="form-control" value="<?php echo set_value('password');?>" placeholder="Password" required >
                                    <?php echo form_error('password', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group text-left">
                                <div class="col-md-3 text-left">
                                    <label>&nbsp;</label>
                                </div>
                                <div class="col-md-9 text-left">
                                    <input type="checkbox" name="chk_remember_me" class="rem" /><span class="lbl"> Remember Me</span>
                                    <a href="<?php echo base_url();?>login/forgot" style="float:right;">Forgot Password</a>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" name="submit" value="Login" class="submit">
                            </div>
                        </form>

                    </div>

                </div>

                <!-- <hr class="login-divider"> -->

                <div class="login-line">
                    <span>Belum punya akun? Buat akun baru</span>
                </div>

                <!-- <div class="login-inside">
                     <h3>Buat akun baru</h3>
                </div> -->

                <div class="form">
                    <div class="box">

                        <form action="<?php echo base_url();?>login/register" method="POST">
                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Title <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9 text-left">
                                    <div class="form-control-option">
                                        <input type="radio" name="title" value="mr" checked><span>Mr.</span>
                                    </div>
                                    <div class="form-control-option">
                                        <input type="radio" name="title" value="mrs"><span>Mrs.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-left">
                                <div class="col-md-3">
                                    <label>Name <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" value="<?php echo set_value('name');?>" required > 
                                    <?php echo form_error('name', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Username <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="username_reg" class="form-control" value="<?php echo set_value('username_reg');?>" required >
                                    <?php echo form_error('username_reg', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Password <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="password" name="password_reg" class="form-control" value="<?php echo set_value('password_reg');?>" required >
                                    <?php echo form_error('password_reg', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Email <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" name="email_reg" class="form-control" value="<?php echo set_value('email_reg');?>" required >
                                    <?php echo form_error('email_reg', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 text-left">
                                    <label>Phone <span class="req">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone');?>" required >
                                    <?php echo form_error('phone', '<p class="required text-left">', '</p>');?>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" name="submit" value="Register" class="submit">
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </section>
</main>