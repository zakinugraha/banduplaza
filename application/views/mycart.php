<main id="main-content" class="main-content">
	<section id="mycart" class="mycart">
		<div class="container">
			<div class="count text-center">
				<span>
					<?php 
						if (!empty($_SESSION['order'])) {
							echo 'Anda memiliki '.$count_order.' item di keranjang belanja';
						} else {
							echo 'Anda tidak memiliki item apapun di keranjang belanja';
						}
					?>
				</span>
			</div>
		</div>

		<div class="container">
			<div class="cart-content box-back block">				
					
				<div class="cart-list">
					<div class="cart-canvas">
						<?php 
							if (!empty($_SESSION['order'])) {
								
							foreach ($list AS $row) { 
								$navigasi_id = $this->db->query('SELECT * FROM type_nav_page WHERE type_nav_page_id="'.$row['type_nav_page_id'].'"')->row();
								$navigasi_name = $navigasi_id->type_nav_page_name;
						?>
						<div class="cart-item">
							<div class="col-xs-12 col-sm-3">
								<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row['product_id'].'" LIMIT 1')->row(); ?>
								<img src="<?php echo base_url();?>upload/images/product/thumbs/<?php echo $image_default->image_product_file_name;?>">
							</div>
							
							<div class="col-xs-12 col-sm-9">
								<a href="<?php echo base_url();?>product/view/<?php echo strtolower($navigasi_name).'/'.url_title(strtolower($row['product_name'])).'-'.url_title(strtolower($row['product_code'])).'-'.$row['product_id'];?>">
									<span><?php echo $row['product_name'];?></span>
								</a>
								<span><?php echo ' ('.$row['product_code'].')';?></span>
								<!-- <em>from </em><a href="#">Merch</a> -->

								<div class="row">
									<div class="col-xs-4">
										Brand
									</div>
									<div class="col-xs-8">
										<span class="divider">:</span>
										<span class="detail">
										<?php 
											$get_brand = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$row['brand_id'].'" LIMIT 1')->row();
											echo $get_brand->brand_name;
										?>
										</span>
									</div>

									<div class="col-xs-4">
										Warna
									</div>
									<div class="col-xs-8">
										<span class="divider">:</span>
										<span class="detail">Sesuai gambar</span>
									</div>

									<div class="col-xs-4">
										Ukuran
									</div>
									<div class="col-xs-8">
										<span class="divider">:</span>
										<span class="detail">
										<?php 
											$get_size = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$row['product_size'].'" && product_id="'.$row['product_id'].'" LIMIT 1')->row();
											$attr_id = $get_size->size_attributes_id;
											$get_size_value = $this->db->query('SELECT * FROM size_attributes WHERE size_attributes_id="'.$attr_id.'" LIMIT 1')->row();
											echo $get_size_value->size_attributes_value;
										?>
										</span>
									</div>

									<div class="col-xs-4">
										Jumlah
									</div>
									<div class="col-xs-8">
										<span class="divider">:</span>
										<span class="detail"><?php echo $row['product_qty'];?> pcs</span>
									</div>

									<div class="col-xs-4">
										Harga
									</div>
									<div class="col-xs-8">
										<span class="divider">:</span>
										<span class="detail"><?php echo 'Rp. '.number_format($row['product_price_total'],0);?></span>
									</div>

									<div class="col-xs-12">
										<a href="<?php echo base_url();?>mycart/delete/<?php echo $row['product_id'];?>" class="delete">Hapus <i class="fa fa-trash-o"></i></a>
									</div>
								</div>

							</div>
						</div> <!-- End cart-item -->

						<div class="clearfix"></div>
						<?php 
								}
							} else { // Jika cart list kosong / tidak ada produk apapun di keranjang belanja
						?>
							<div class="box-empty text-center">
								<a href="<?php echo base_url();?>" class="big">Mulai<br>berbelanja</a>
							</div>
						<?php
							}

							if (!empty($_SESSION['order'])) {
						?>

						<div class="cart-total">
							<div class="col-xs-12 col-sm-3">
								&nbsp;
							</div>

							<div class="col-xs-12 col-sm-12">
								<div class="row">
									<div class="col-xs-6">
										<b>Total Harga</b><br>
										<!-- <span>Harga belum termasuk ongkos kirim</span> -->
									</div>
									<div class="col-xs-6">
										<span class="divider">:</span>
										<span class="detail"><b><?php echo 'Rp. '.number_format($total_price_order,0);?></b></span>
									</div>
								</div>

								<div class="row text-center">
									<a href="<?php echo base_url();?>" class="continue">Lanjutkan belanja</a>
									<a href="<?php echo base_url();?>checkout" class="checkout">Proses ke checkout</a>
								</div>
							</div>
						</div>

						<?php
							}
						?>

					</div>
				</div>					
				
			</div>
		</div>

	</section>
	

</main>