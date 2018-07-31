	<footer id="footer" class="footer">
		<div class="box">
			<div class="container">
				
				<div class="col-md-4">
					<ul>
						<?php
							$query = $this->db->query('SELECT * FROM support LIMIT 4')->result();
							foreach ($query AS $support) {
						?>
						<li><a href="<?php echo base_url().'help/'.$support->support_sess.'/'.url_title(strtolower($support->support_title));?>"><?php echo $support->support_title;?></a></li>
						<?php } ?>
						<li><a href="<?php echo base_url();?>confirm">Konfirmasi Transfer</a></li>
					</ul>
					<div class="footer-social">						
						<a href="https://www.facebook.com/banduplaza/" target="_BLANK" style="margin-right:3px;"><img src="<?php echo base_url();?>assets/front/images/iconfacebook.png" style="width:24px;"></a>
						<a href="https://www.instagram.com/banduplaza/" target="_BLANK"><img src="<?php echo base_url();?>assets/front/images/iconinstagram.png" style="width:28px;"></a>
						<a href="https://line.me/R/ti/p/%40banduplaza" target="_BLANK"><img src="<?php echo base_url();?>assets/front/images/iconline.png" style="width:26px;"></a>
						<a href="<?php echo base_url();?>contact" target="_BLANK"><img src="<?php echo base_url();?>assets/front/images/iconmail.png" style="width:28px;"></a>
					</div>
				</div>
				
				<div class="col-md-4">					
					<div class="form">
						<label>Enter Your Email Address</label>
						<form method="GET" action="<?php echo base_url();?>subscribe/add">
							<input type="email" name="email_subs" id="email" placeholder="Your Email">
							<input type="button" name="submit" value="Subscribe" id="btn_subscribe">
							<p id="info_subs" style="color:blue;display:none;margin:0">Thank for Subscribing!</p>
							<p id="err_subs" style="color:#ff5b19;display:none;margin:0">Email is not valid</p>
							<p id="empty_subs" style="color:#ff5b19;display:none;margin:0">Email is not valid</p>
						</form>
						<p>Masukan email anda untuk mendapatkan promo terbaru dari kami</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="payment-method">
						<label>Metode Pembayaran</label>
						<ul class="payment">
							<li><img src="<?php echo base_url();?>assets/front/images/mandiri.jpg"></li>
							<li><img src="<?php echo base_url();?>assets/front/images/bca.jpg"></li>
							<li><img src="<?php echo base_url();?>assets/front/images/bri.jpg"></li>
							<li><img src="<?php echo base_url();?>assets/front/images/midtrans.jpg"></li>
						</ul>
						<label class="cs">Customer Service</label>
						<p>Text/Whatsapp : 082126603648</p>
						<p>Email : customerservice@banduplaza.com</p>
					</div>
				</div>

			</div>

			<div class="container">
				<div class="col-md-12">
					<div class="copyright text-center">
						© Copyright banduplaza.com 2016 - 2017
					</div> <!-- //copyright -->
				</div>
			</div>
					
		</div>
	</footer>

	<script type="text/javascript">
		$(function() {
			$("#email").keypress(
				function(e) {
					if ((e.which && e.which == 13) || (e.jeyCode && e.keyCode == 13)) {
						return false;
					} else {
						return true;
				}
			});
		});

		$('#btn_subscribe').click(function(){
			var email_subs=$('input[name=email_subs]').val();
			var atpos = email_subs.indexOf("@");
    		var dotpos = email_subs.lastIndexOf(".");

			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email_subs.length) {
				$("#err_subs").show().fadeOut(5000);
			} else {
				$.ajax({
					url:'<?php echo base_url();?>subscribe/add?email='+email_subs,
					dataType:'json',
					type:'get',
					data:{subscribe_email:email_subs},
					success:function(res){
						$("#info_subs").show().fadeOut(5000);
						$('input[name=email_subs]').val('Thank for Subscribing');
					}
				});	
			}
					
		});
	</script>


	<script src="<?php echo base_url();?>assets/front/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!-- BX Slider //detail: http://bxslider.com -->
	<script src="<?php echo base_url();?>assets/front/plugins/bxslider/jquery.bxslider.min.js"></script>
	<!-- Zoom image //detail: http://www.jqueryscript.net/zoom/Smooth-Image-Zoom-Pan-Plugin-With-jQuery-ZooMove.html -->
	<script src="<?php echo base_url();?>assets/front/plugins/zoom/zoomove.min.js"></script>
	<!-- Site -->
	<script src="<?php echo base_url();?>assets/front/js/sticky-kit.js"></script>
	<script src="<?php echo base_url();?>assets/front/js/grid.js"></script>
	<script src="<?php echo base_url();?>assets/front/js/site.js"></script>


    <!--Start of Tawk.to Script-->
	<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/595f38a16edc1c10b0344c15/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
	</script>
	<!--End of Tawk.to Script-->

</body>
</html>

