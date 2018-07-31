<main id="main-content" class="main-content">
	<section id="mycart" class="mycart">
		<div class="container">
			<div class="count text-center">
				<span>
					<?php 
						if ($count>0) {
							echo $count.' produk di daftar wishlist anda';
						} else {
							echo 'Anda tidak mempunyai produk apapun di daftar wishlist anda.';
						}
					?>
				</span>
			</div>
		</div>

		<div class="container">
			<div class="cart-content block">
				<div class="container">
					<div class="row">
						
						<div class="cart-list">
							<div class="cart-canvas">
								<?php 
									if ($count>0) {
										foreach ($list AS $row) { 
								?>
										<div class="cart-item">
											<div class="col-xs-12 col-sm-3">
												<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'" LIMIT 1')->row(); ?>
												<img src="<?php echo base_url();?>upload/images/product/<?php echo $image_default->image_product_file_name;?>">
											</div>

											<div class="col-xs-12 col-sm-9">
												<a href="<?php echo base_url();?>product/view/<?php echo url_title(strtolower($row->product_name)).'-'.url_title(strtolower($row->product_code)).'-'.$row->product_id;?>">
													<span><?php echo $row->product_name;?></span>
												</a>
												<span><?php echo ' ('.$row->product_code.')';?></span>

												<div class="row">
													<div class="col-xs-4">
														Brand
													</div>
													<div class="col-xs-8">
														<span class="divider">:</span>
														<span class="detail">
														<?php 
															$get_brand = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$row->brand_id.'" LIMIT 1')->row();
															echo $get_brand->brand_name;
														?>
														</span>
													</div>

													<div class="col-xs-4">
														Kode
													</div>
													<div class="col-xs-8">
														<span class="divider">:</span>
														<span class="detail"><?php echo $row->product_code;?></span>
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
															$get_size = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$row->stock_management_id.'" && product_id="'.$row->product_id.'" LIMIT 1')->row();
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
														<span class="detail"><?php echo $row->mywishlist_qty;?> pcs</span>
													</div>

													<div class="col-xs-12">
														<a href="<?php echo base_url();?>mywishlist/delete/<?php echo $row->mywishlist_id;?>" class="delete">Hapus <i class="fa fa-trash-o"></i></a>
														<?php
															$cek = $this->db->query('SELECT * FROM stock_management WHERE stock_management_id="'.$row->stock_management_id.'"')->row();
															if ($cek->stock_management_value>0) {
														?>
															<a href="<?php echo base_url();?>mywishlist/buy/<?php echo $row->mywishlist_id;?>" class="buy">Beli <i class="fa fa-check"></i></a>
														<?php	
															}
														?>
														
													</div>

												</div>

											</div>
										</div>

										<div class="clearfix"></div>

										
								<?php 
										} // End foreach
									} else {
								?>
									<div class="box-empty text-center">
										<a href="<?php echo base_url();?>" class="big">Mulai<br>berbelanja</a>
									</div>
								<?php
									}
								?>
								<div class="cart-total">
									<div class="col-xs-12 col-sm-12">

										<div class="row text-center">
											<a href="<?php echo base_url();?>" class="continue">Lanjutkan belanja</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>

	</section>
	

</main>