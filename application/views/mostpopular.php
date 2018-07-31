	
	<main id="main-content" class="main-content">
		<section id="listing" class="listing">
			<div class="container">
				<div class="row content">
					<div class="col-xs-12 col-sm-3 sidebar">
						<button class="btn btn-info btn-block visible-xs" type="button" data-toggle="collapse" data-target="#filter" aria-expanded="false" aria-controls="collapseExample">
							Filter Item <span class="caret"></span>
						</button>
						
						<div class="l-b visible-xs"></div>

						<div id="filter" class="filter collapse">
							<div class="title text-uppercase"><b>Filter</b></div>
							
							<div class="l-b"></div>
							
							<div class="break checkboxs">
								<div class="b-title text-uppercase"><b>Brand</b></div>
								
								<div class="scroll-box">
									<div id="branddivID">
										<ul class="media-list">
											<?php foreach ($brand AS $merch) { ?>
											<li class="media checkbox">
												<a href="<?php echo base_url();?>product/brand/<?php echo url_title(strtolower($nav_name->type_nav_page_name)).'/'.url_title(strtolower($merch->merchant));?>" >
													<span><?php echo $merch->merchant;?></span>
												</a>
											</li>
											<?php } ?>
										</ul>
									</div>
								</div>

							</div> <!-- //brand -->
							
							<div class="break checkboxs">
								<div class="b-title text-uppercase"><b>Category</b></div>
								
								<div class="scroll-box">
									<ul class="media-list">
										<?php foreach ($category AS $item) { ?>
										<li class="media checkbox">
											<a href="<?php echo base_url();?>product/item/<?php echo url_title(strtolower($nav_name->type_nav_page_name)).'/'.str_replace(" ", "-", strtolower($item->type_category_name));?>" >
												<span><?php echo ucfirst($item->type_category_name);?></span>
											</a>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div> <!-- //category -->
							
						</div> <!-- //filter -->
					</div> <!-- //col filter -->
	
					<div class="col-xs-12 col-sm-9 main">
						<div class="content">
							<ol class="breadcrumb text-uppercase">
								<li><a href="<?php echo base_url();?>">Home</a></li>
								<li class="active"><?php echo 'Whats New';?></li>
							</ol>
							
							<div class="row">
								<div class="col-xs-6">
									<h5 class="text-uppercase"><b>Semua Koleksi</b></h5>
								</div> <!-- //col -->
								
								<div class="col-xs-6">
									<div class="sort text-right">
										<ul class="list-inline">
											<li><span><b>Sort by</b></span></li>
											<li>
												<div class="select-style">
													<form id="sort" action="<?php echo base_url();?>product/<?php echo $this->uri->segment(2);?>" method="GET">
														<select class="form-control" name="sort_by" onchange="document.getElementById('sort').submit();">
															<option value="default" <?php echo !isset($_GET['sort_by']) ? 'selected' : '';?> >Default</option>
															<option value="newest" <?php echo $get_uri=='newest' ? 'selected' : '';?> >Newest</option>
															<option value="most-popular" <?php echo $get_uri=='most-popular' ? 'selected' : '';?> >Most Popular</option>
															<option value="price-high" <?php echo $get_uri=='price-high' ? 'selected' : '';?> >Highest Price</option>
															<option value="price-low" <?php echo $get_uri=='price-low' ? 'selected' : '';?> >Lowest Price</option>
														</select>
													</form>
												</div>
											</li>
										</ul>
									</div> <!-- //sort -->
								</div> <!-- //col -->
							</div> <!-- //row -->
							
							<div class="l-b"></div>
							
							<div class="pagination-list">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<span class="count">Menampilkan 1 - 36 dari <?php echo $count;?> produk</span>
									</div> <!-- //col -->
									
									<div class="col-xs-12 col-sm-6 text-right">
										<ul class="pagination no-margin">
											<?php echo $pagination; ?>
										</ul>
									</div> <!-- //col -->
								</div> <!-- //row -->
							</div> <!-- //pagination -->
							
							<div class="l-b"></div>
							
							<div class="the-list"> <!-- Menampilkan hasil disini -->
								
								<div class="row" id="data_result">

								<?php
									//echo $empty;
									foreach ($list AS $row) { 
								?>
								<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
									<a class="the-item block same-height" href="<?php echo base_url();?>product/view/<?php echo url_title(strtolower($row->product_name).'-'.strtolower($row->product_code)).'-'.$row->product_id;?>">
										
										<div class="images">
											<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'" LIMIT 1')->row(); ?>
											<img src="<?php echo base_url();?>upload/images/product/<?php echo $image_default->image_product_file_name;?>" alt="Item" />
										</div> <!-- //images -->
										
										<div class="name"><b><?php echo $row->product_name;?></b></div> <!-- //name -->
										
										<div class="row">
											<div class="col-xs-8">
												<div class="price"><b> <!-- baru sampe sini -->
													<?php 
														$price_now = $row->product_price_sell-$row->product_price_discount;
														echo $row->product_price_discount>'0' ? 'Rp. '.number_format($price_now,0) : 'Rp. '.number_format($row->product_price_sell,0);
													?>
												</b></div> <!-- //price -->
												<div class="cut text-muted">
													<small><strike>
														<?php
															$price = $row->product_price_sell;
															echo $row->product_price_discount>'0' ? 'Rp. '.number_format($row->product_price_sell,0) : '';
														?>
													</strike></small>
												</div>
											</div> <!-- //col -->

											<?php
										        if ($row->product_price_discount!='0') { 
										          $percent = $row->product_price_discount/$row->product_price_sell*100;
										          echo '<div class="col-xs-4 text-right"><div class="discount">-'.ceil($percent).'%</div></div>';
										        }
										    ?>

										</div> <!-- //row -->

										<?php

											$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$row->product_id.'"')->result();
											$stock = 0;
											foreach ($get_stock AS $get) {
												$stock+=$get->stock_management_value;
											}
											$total_stock = $stock;

											if ($total_stock=="0") {
												$stok_status = '<div class="product-stock"><div class="stock"><span class="stock-empty">Out of stock</span></div></div>';
											} else if ($total_stock>="1" && $total_stock<="5") {
												$stok_status = '<div class="product-stock"><div class="stock"><span class="stock-limited">Limited Stock</span></div></div>';
											} else if ($total_stock>="6") {
												$stok_status = '<div class="product-stock"><div class="stock"><span class="stock-ready">Ready stock</span></div></div>';
											}
											echo $stok_status;
										?>
										
										<div class="rating-star">
											<ul class="list-inline no-margin">
												<li class="no-padding">
													<i class="icon ic-star"></i>
													<i class="icon ic-star"></i>
													<i class="icon ic-star"></i>
													<i class="icon ic-star"></i>
													<i class="icon ic-star"></i>
												</li>
												
												<li><span class="text-muted">176 ulasan</span></li>
											</ul>
										</div> <!-- //rating -->
									</a> <!-- //item -->
								</div> <!-- //col -->
								<?php } ?>
								
							</div> <!-- //row -->
								
							</div> <!-- //the list -->
							
							<div class="l-b"></div>
							
							<div class="pagination-list">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<span class="count">Menampilkan 1 - 36 dari <?php echo $count;?> produk</span>
									</div> <!-- //col -->
									
									<div class="col-xs-12 col-sm-6 text-right">
										<ul class="pagination no-margin">
											<?php echo $pagination; ?>
										</ul>
									</div> <!-- //col -->
								</div> <!-- //row -->
							</div> <!-- //pagination -->
						</div> <!-- item listing -->
					</div> <!-- //col item -->
				</div> <!-- //row -->
			</div> <!-- //container -->
		</section> <!-- //listing -->
	</main> <!-- //main -->