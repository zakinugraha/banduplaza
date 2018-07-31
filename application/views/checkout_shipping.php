<main id="main-content" class="main-content">
    <section id="checkout" class="checkout">
        <div class="container text-center">

        </div>

        <div class="container ">
        	<div class="col-md-8">
        		<div class="checkout_wizard">
        			<ul>
        				<li>
        					<a href="<?php echo base_url();?>checkout/address_validation">
        						Step 1<br>
        						<small>Shipping Address</small>
        					</a>
        				</li>
        				<li>
        					<a href="<?php echo base_url();?>checkout/ship" class="active">
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
        			<h4>Select your shipping method</h4>
        		</div>
        		<div class="content-bar">
        			
        		</div>
        		<div class="footer-bar">
        			<a href="<?php echo base_url();?>checkout/address_validation" class="prev">Previous</a>
        			<a href="#" class="next">Next</a>
        		</div>
        	</div>

        	<div class="col-md-4">

        	</div>
        </div>


    </section>
</main>