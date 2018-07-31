<main id="main-content" class="main-content">
    <section id="register" class="register">
        <div class="container text-center">
            <div class="attention">
                <span>Lengkapi form berikut untuk melengkapi proses pendaftaran anda</span>
            </div>

            <?php echo $this->session->flashdata('warning');?>
        </div>

        <div class="container ">
            <div class="form">
                <div class="box">

                    <form action="<?php echo base_url();?>login/register" method="POST">

                        <div class="form-group">
                            <label>Title <span class="req">*</span></label>
                            <div class="form-control-option">
                                <input type="radio" name="title" value="mr" checked><span>Mr.</span>
                            </div>
                            <div class="form-control-option">
                                <input type="radio" name="title" value="mrs"><span>Mrs.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name');?>" required >
                            <?php echo form_error('name', '<p class="required">', '</p>');?>
                        </div>

                        <div class="form-group">
                            <label>Username <span class="req">*</span></label>
                            <input type="text" name="username" class="form-control" value="<?php echo set_value('username');?>" required >
                            <?php echo form_error('username', '<p class="required">', '</p>');?>
                        </div>

                        <div class="form-group">
                            <label>Password <span class="req">*</span></label>
                            <input type="password" name="password" class="form-control" value="<?php echo set_value('password');?>" required >
                            <?php echo form_error('password', '<p class="required">', '</p>');?>
                        </div>

                        <div class="form-group">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?php echo set_value('email');?>" required >
                            <?php echo form_error('email', '<p class="required">', '</p>');?>
                        </div>

                        <div class="form-group">
                            <label>Phone Number <span class="req">*</span></label>
                            <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone');?>" required >
                            <?php echo form_error('phone', '<p class="required">', '</p>');?>
                        </div>

                        <div class="form-group">
                            <label>Newsletter <span class="req">*</span></label>
                            <div class="form-control-option">
                                <input type="radio" name="newsletter" value="yes" checked><span>Yes, send me newsletter</span>
                            </div>
                            <div class="form-control-option">
                                <input type="radio" name="newsletter" value="no"><span>No, thanks</span>
                            </div>
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