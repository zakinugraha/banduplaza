<main id="main-content" class="main-content">
    <section id="confirm" class="confirm">
        <div class="container text-center">
            <div class="attention">
                <span>Lengkapi form berikut untuk melakukan konfirmasi pembayaran anda</span>
            </div>

            <?php echo $this->session->flashdata('message');?>
        </div>

        <div class="container">
        <div class="box-back block">
            <div class="form">
                <form action="<?php echo base_url();?>confirm" method="POST">
                    <div class="form-group">
                        <label>Invoice No <span class="req">*</span></label>
                        <input type="text" name="invoice_number" value="<?php echo $this->input->get('id');?>" class="form-control">
                        <?php echo form_error('invoice_number', '<p class="required">', '</p>');?>
                    </div>

                    <div class="form-group">
                        <label>Nominal Transfer <span class="req">*</span> (Hanya isi dengan angka tanpa koma atau titik)</label>
                        <input type="text" name="nominal" value="<?php echo set_value('nominal');?>" class="form-control" placeholder="Nominal transfer">
                        <?php echo form_error('nominal', '<p class="required">', '</p>');?>
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