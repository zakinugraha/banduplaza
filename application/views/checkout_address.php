<main id="main-content" class="main-content">
    <section id="checkout" class="checkout">
        <div class="container text-center">

        </div>

        <div class="container ">
        	<div class="col-md-8">
        		<div class="checkout_wizard">
        			<ul>
        				<li>
        					<a href="<?php echo base_url();?>checkout/address_validation" class="active">
        						Step 1<br>
        						<small>Shipping Address</small>
        					</a>
        				</li>
        				<li>
        					<a href="<?php echo base_url();?>checkout/ship">
        						Step 2<br>
        						<small>Shipping Metode</small>
        					</a>
        				</li>
        				<li>
        					<a href="#">
        						Step 3<br>
        						<small>Order Review</small>
        					</a>
        				</li>
        			</ul>
        		</div>
        		<div class="title-bar">
        			<h4>Check your shipping address</h4>
        		</div>
        		<div class="content-bar">
        			<?php if ($count==0) {?>
        				<a href="<?php echo base_url();?>configuration/add_address" class="change"><i class="fa fa-pencil"></i> Buat alamat pengiriman</a>
        			<?php } else { ?>
	        			<p class="lead"><?php echo $address->name.' ('.$customer->customer_phone.')';?></p>
	        			<p><?php echo $address->address;?></p>
	        			<p><?php echo $city_name.' - '.$prov_name;?></p>
	        			<p><?php echo $address->postcode;?></p>
	        			<a href="<?php echo base_url();?>configuration/edit_address" class="change"><i class="fa fa-pencil"></i> Ubah alamat pengiriman</a>
        			<?php } ?>
        		</div>
        		<div class="footer-bar">
        			<?php if ($count==1) {?>
        				<a href="<?php echo base_url();?>checkout/ship" class="next1">Next</a>
        			<?php } ?>
        		</div>
        	</div>

        	<div class="col-md-4">

        	</div>
        </div>


    </section>
</main>