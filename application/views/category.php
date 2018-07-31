	
	<main id="main-content" class="main-content">
		<div class="information-product">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<ol class="breadcrumb trans">
							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li class="sep"><span><i class="fa fa-caret-right"></i></span></li>
							<li><a href="<?php echo base_url();?>">Product</a></li>
							<li class="sep"><span><i class="fa fa-caret-right"></i></span></li>
							<li class="active"><?php echo $nav_name->type_nav_page_name;?></li>
						</ol>
					</div> <!-- //col -->
				</div>
			</div>
		</div> <!-- information-product -->

		<section id="listing" class="listing">
			<div class="container">
				<div class="row content">

					<div class="col-xs-12 col-sm-2 sidebar">
						<button class="btn btn-info btn-block visible-xs" type="button" data-toggle="collapse" data-target="#filter" aria-expanded="false" aria-controls="collapseExample">
							Filter Item <span class="caret"></span>
						</button>
						
						<div class="l-b visible-xs"></div>

						<div id="filter" class="filter collapse">
							<div class="panel-group" id="nav_page" role="tablist" aria-multiselectable="true">
								
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingOne">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-controls="collapseOne" style="display:block;position:relative;">
						                        Filter <i class="indicator fa fa-minus"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						                <div class="panel-body">
						                   <div class="checkboxs">
												<div class="scroll-box-nav">
													<div id="branddivID">
														<ul class="media-list">
															<a href="<?php echo base_url().'page/'.url_title(strtolower($nav_name->type_nav_page_name));?>" class="" >
																<li class="media <?php echo $url_id==''?'active':'';?>"><span>Semua Produk</span></li>
															</a>
															<a href="<?php echo base_url().'product/hot/'.url_title(strtolower($nav_name->type_nav_page_name)).'/discount';?>" class="" >
																<li class="media"><span>Diskon</span></li>
															</a>
															<a href="<?php echo base_url().'product/hot/'.url_title(strtolower($nav_name->type_nav_page_name)).'/whatsnew';?>" class="" >
																<li class="media"><span>Produk Terbaru</span></li>
															</a>
														</ul>
													</div>
												</div>

											</div>
						                </div>
						            </div>
						        </div>
						    </div>

							<div class="l-b-filter"></div>

							<div class="panel-group" id="brand" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingTwo">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-controls="collapseTwo" style="display:block;position:relative;">
						                        Brand <i class="indicator fa fa-minus"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
						                <div class="panel-body">
						                   <div class="checkboxs">
												<div class="scroll-box-nav">
													<div id="branddivID">
														<ul class="media-list">
															<?php foreach ($brand AS $merch) { ?>															
															<a href="<?php echo base_url();?>product/brand/<?php echo url_title(strtolower($nav_name->type_nav_page_name)).'/'.url_title(strtolower($merch->merchant));?>">
																<li class="media">
																	<span><?php echo $merch->merchant;?></span>
																</li>
															</a>															
															<?php } ?>	
														</ul>
													</div>
												</div>

											</div>
						                </div>
						            </div>
						        </div>
						    </div>

						    <div class="l-b-filter"></div>

							<div class="panel-group" id="category" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingThree">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-controls="collapseThree" style="display:block;position:relative;">
						                        Category <i class="indicator fa fa-minus"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
						                <div class="panel-body">
						                   <div class="checkboxs">
												<div class="scroll-box-nav">
													<div id="branddivID">
														<ul class="media-list">
															<?php foreach ($category AS $item) { ?>															
															<a href="<?php echo base_url();?>product/item/<?php echo url_title(strtolower($nav_name->type_nav_page_name)).'/'.str_replace(" ", "-", strtolower($item->category));?>" class="" >
																<li class="media">
																	<span><?php echo ucfirst($item->category);?></span>
																</li>
															</a>
															<?php } ?>	
														</ul>
													</div>
												</div>

											</div>
						                </div>
						            </div>
						        </div>
						    </div>
						    
							<div class="l-b-filter"></div>
							
							<div class="break checkboxs">
								<div class="b-title"><b>Price</b><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price=n&sort_by='.$filter['sort_by'];?>" class="remove">Hapus Filter</a></div>
								
								<div class="scroll-box">

									<ul class="media-list price">
										<li class="media checkbox">
											<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price=300000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="300000" ? "is_active" : "";?>" >
												<span><i class="fa fa-angle-right"></i> 300.000</span>
											</a>
										</li>
										<li class="media checkbox">
											<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price=200000,300000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="200000,300000" ? "is_active" : "";?>" >
												<span>200.000 - 300.000</span>
											</a>
										</li>
										<li class="media checkbox">
											<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price=100000,200000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="100000,200000" ? "is_active" : "";?>" >
												<span>100.000 - 200.000</span>
											</a>
										</li>
										<li class="media checkbox">
											<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price=100000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="100000" ? "is_active" : "";?>" >
												<span><i class="fa fa-angle-left"></i> 100.000</span>
											</a>
										</li>
									</ul>
								</div>
							</div> <!-- //price -->

						</div> <!-- //filter -->
					</div> <!-- //col filter -->
	
					<div class="col-xs-12 col-sm-10 main">
						<div class="content-product">
							<div class="row">

								<div class="col-md-6">
									<h3>Fashion <?php echo $gender;?></h3>
								</div>
								<div class="col-md-6">
									<div class="sort text-right">
										<ul class="list-inline">
											<li>
												<div class="select-style">
													<div class="dropdown">
														<button class="btn-sort dropdown-toggle" type="button" data-toggle="dropdown"><?php echo isset($_GET['sort_by']) ? $select : 'Urut Berdasarkan';?></button>
														<ul class="dropdown-menu">
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price='.$filter['price'].'&sort_by=default';?>">Default</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price='.$filter['price'].'&sort_by=newest';?>">Terbaru</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price='.$filter['price'].'&sort_by=most-popular';?>">Terpopuler</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price='.$filter['price'].'&sort_by=price-high';?>">Harga Tertinggi</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?price='.$filter['price'].'&sort_by=price-low';?>">Harga Terendah</a></li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div> <!-- //sort -->
								</div> <!-- //col -->
								
							</div> <!-- //row -->
							
							<div class="l-b"></div>
							
							<div class="the-list">
								<div class="row">

								<?php
									echo $empty;
									foreach ($list AS $row) { 
								?>
								<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
									<div class="top-product">
										<?php
									        if ($row->product_price_discount!='0') { 
									          $percent = $row->product_price_discount/$row->product_price_sell*100;
									    ?>
									          <div class="discount">
									          	<span><?php echo ceil($percent);?>%</span>
									          	<span class="off">OFF</span>
									          </div>
									    <?php } ?>
									    <!-- <div class="bottom-item">
											<div class="love">
												<button type="button" name="btn_like" class="btn_like" onclick="alert('you like this!')"><i class="fa fa-heart"></i></button>
											</div>
										</div> -->
									</div>
									
									<a class="the-item block same-height" href="<?php echo base_url();?>product/view/<?php echo url_title(strtolower($row->product_name).'-'.strtolower($row->product_code)).'-'.$row->product_id;?>">
										
										<div class="images">
											<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'" LIMIT 1')->row(); ?>
											<img src="<?php echo base_url();?>upload/images/product/thumbs/<?php echo $image_default->image_product_file_name;?>" alt="Item" />
											
										</div> <!-- //images -->
										
										<div class="box-item">
											
											<div class="brand">
												<h4>
												<?php 
													$brand=$this->db->query('SELECT brand_name from brand WHERE brand_id="'.$row->brand_id.'" LIMIT 1')->row();
													echo $brand->brand_name;
												?>
												</h4>
											</div>
											<div class="name"><span><?php echo ucwords(strtolower($row->product_name));?></span></div> <!-- //name -->
											
											<!-- <div class="love" title="25 Orang menyukai produk ini">
												<label>25</label>
											</div> -->
											
											<div class="box-price">
												<div class="price-after">
													<span><strike>
													<?php
														$price = $row->product_price_sell;
														echo $row->product_price_discount>'0' ? 'Rp '.number_format($row->product_price_sell,0) : '';
													?>
													</strike></span>
												</div>
												<div class="price">		
													<span>												 
													<?php 
														$price_now = $row->product_price_sell-$row->product_price_discount;
														echo $row->product_price_discount>'0' ? 'Rp '.number_format($price_now,0) : 'Rp '.number_format($row->product_price_sell,0);
													?>	
													</span>														
												</div> <!-- //price -->
											</div>

											
											
										</div> <!-- //box-item -->

									</a> <!-- //item -->
								</div> <!-- //col -->
								<?php } ?>
									
								</div> <!-- //row -->
							</div> <!-- //the list -->


						
							<div class="l-b"></div>
							
							<div class="pagination-list">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<span class="count"><?php echo 'Menampilkan '.$from.' - '.$to.' dari '.$count.' produk';?></span>
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

	<script>
		function toggleChevron(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find("i.indicator")
		        .toggleClass('fa-plus fa-minus');
		}
		$('#nav_page').on('hidden.bs.collapse', toggleChevron);
		$('#nav_page').on('shown.bs.collapse', toggleChevron);
		$('#brand').on('hidden.bs.collapse', toggleChevron);
		$('#brand').on('shown.bs.collapse', toggleChevron);
		$('#category').on('hidden.bs.collapse', toggleChevron);
		$('#category').on('shown.bs.collapse', toggleChevron);
	</script>

	<script type="text/javascript">  
		$(function(){
			$('.checkbox').on('change',function(){
				$('#form').submit();
			});
		});
	</script>