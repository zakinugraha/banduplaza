<main id="main-content" class="main-content">
    <section id="order-unfinish" class="order-unfinish">
        <div class="container text-center">

            <div class="order-unfinish-inside">
                <h3>Thank You!</h3>
                <label>Order ID : <?php echo $_GET['order_id'];?></label>
            </div>

            <div class="content">
            	<p style="font-weight:bold;margin-bottom:10px;">Tinggal satu langkah lagi untuk melengkapi proses order anda</p>
            	<p>Untuk melengkapi proses order anda, silahkan lakukan proses pembayaran sesuai dengan petunjuk yang kami kirimkan ke email anda.</p>
                <p>Detail order anda bisa dilihat pada email instruksi pembayaran.</p>
            </div>

            <div class="link">
            	<!-- <a href="<?php echo base_url();?>confirm" class="detail">Konfirmasi Pembayaran</a> -->
            	<a href="<?php echo $_GET['pdf_url'];?>" target="_BLANK" class="download">Petunjuk Transaksi</a>
            </div>

            <!-- <div class="social">
            	<h5>Follow Us</h5>
            	<a href="#" target="_BLANK" class="facebook">Facebook</a>
            	<a href="#" target="_BLANK" class="instagram">Instagram</a>
            	<a href="#" target="_BLANK" class="line">Line</a>
            </div> -->

        </div>

    </section>
</main>