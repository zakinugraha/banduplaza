<main id="main-content" class="main-content">
    <section id="login" class="login">
        <div class="container text-center">
            <div class="attention">
                <span>Masukan password baru anda</span>
            </div>

            <?php echo $this->session->flashdata('message');?>
        </div>

        <div class="container ">
            <div class="form text-center">
                <div class="box">

                    <form action="<?php echo base_url();?>login/reset/<?php echo $unicode;?>" method="POST">

                        <div class="form-group">
                            <label>Password baru <span class="req">*</span></label>
                            <input type="password" name="password" class="form-control" required > 
                            <?php echo form_error('password', '<p class="required">', '</p>');?>
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