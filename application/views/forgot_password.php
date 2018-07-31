<main id="main-content" class="main-content">
    <section id="login" class="login">
        <div class="container text-center">
            <div class="attention">
                <span>Masukan email anda untuk melengkapi proses selanjutnya</span>
            </div>

            <?php echo $this->session->flashdata('message');?>
        </div>

        <div class="container ">
            <div class="form text-center">
                <div class="box">

                    <form action="<?php echo base_url();?>login/forgot" method="POST">

                        <div class="form-group">
                            <label>Email <span class="req">*</span></label>
                            <input type="text" name="email" class="form-control" value="<?php echo set_value('email');?>" required > 
                            <?php echo form_error('email', '<p class="required">', '</p>');?>
                        </div>

                        <div class="form-group text-center">
                            <input type="submit" name="submit" value="Submit" class="submit">
                        </div>
                    </form>

                </div>

            </div>
        </div>

    </section>
</main>