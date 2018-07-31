	<link href="<?php echo base_url();?>assets/front/css/loader.css" rel="stylesheet">	
	<main id="main-content" class="main-content">

		<div class="information-product">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<ol class="breadcrumb trans">
							<li><a href="<?php echo base_url();?>" class="home"><i class="fa fa-home"></i></a></li>
							<li class="slash"><span>/</span></li>
							<li><a>Search</a></li>
							<li class="slash"><span>/</span></li>
							<li><a><?php echo str_replace("+", " ", ucfirst($search));?></a></li>
						</ol>
						<!-- <h1>Shoes Collection</h1> -->
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

							<div class="panel-group" id="category" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingThree">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-controls="collapseThree" style="display:block;position:relative;">
						                        Product <i class="indicator fa fa-angle-up"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
						                <div class="panel-body">
						                   	<div class="checkboxs">
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<?php foreach ($category AS $item) { ?>
														<li class="media checkbox">
															<a href="<?php echo base_url();?>shop/<?php echo lcfirst(url_title($item->type_nav_page_name));?>" class="<?php echo $this->uri->segment(2)==url_title(strtolower($item->type_nav_page_name)) ? "is_active" : "";?>">
																<span><?php echo $item->type_nav_page_name;?></span>
															</a>
														</li>
														<?php } ?>
													</ul>
												</div>
											</div>
						                </div>
						            </div>
						        </div>
						    </div>

							<div class="panel-group" id="brand" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingTwo">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-controls="collapseTwo" style="display:block;position:relative;">
						                        Brand <i class="indicator fa fa-angle-up"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
						                <div class="panel-body">
						                   	<div class="checkboxs">
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<?php foreach ($brand AS $merch) { ?>
														<li class="media checkbox">
															<a href="<?php echo base_url();?>brand/<?php echo url_title(strtolower($merch->brand_name));?>" class="<?php echo $this->uri->segment(2)==url_title(strtolower($merch->brand_name)) ? "is_active" : "";?>">
																<span><?php echo $merch->brand_name;?></span>
															</a>
														</li>
														<?php } ?>
													</ul>
												</div>
											</div>
						                </div>
						            </div>
						        </div>
						    </div>
							
							<div class="panel-group" id="price" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingFour">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-controls="collapseFour" style="display:block;position:relative;">
						                        Price <i class="indicator fa fa-angle-up"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
						                <div class="panel-body">
						                   	<div class="checkboxs">
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<li class="media checkbox">
															<a href="<?php echo base_url().'search/'.'?q='.$_GET['q'].'&price=300000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="300000" ? "is_active" : "";?>" >
																<span><i class="fa fa-angle-right"></i> 300.000</span>
															</a>
														</li>
														<li class="media checkbox">
															<a href="<?php echo base_url().'search/'.'?q='.$_GET['q'].'&price=200000,300000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="200000,300000" ? "is_active" : "";?>" >
																<span>200.000 - 300.000</span>
															</a>
														</li>
														<li class="media checkbox">
															<a href="<?php echo base_url().'search/'.'?q='.$_GET['q'].'&price=100000,200000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="100000,200000" ? "is_active" : "";?>" >
																<span>100.000 - 200.000</span>
															</a>
														</li>
														<li class="media checkbox">
															<a href="<?php echo base_url().'search/'.'?q='.$_GET['q'].'&price=100000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="100000" ? "is_active" : "";?>" >
																<span><i class="fa fa-angle-left"></i> 100.000</span>
															</a>
														</li>														
													</ul>
													<a href="<?php echo base_url().'search/'.'?q='.$_GET['q'].'&price=n&sort_by='.$filter['sort_by'];?>" class="remove">Hapus Filter</a>
												</div>
											</div>
						                </div>
						            </div>
						        </div>
						    </div>


						</div> <!-- //filter -->
					</div> <!-- //col filter -->
	
					<div class="col-xs-12 col-sm-10 main-listing">
						<div class="content-product">
							
							<div class="top-box">
								<div class="col-md-6">
									<h3>Semua koleksi <?php echo $search;?></h3>
								</div> <!-- //col -->
								<div class="col-md-6">
									<div class="sort text-right">
										<ul class="list-inline">
											<li>
												<div class="select-style">
													<div class="dropdown">
														<button class="btn-sort dropdown-toggle" type="button" data-toggle="dropdown"><?php echo isset($_GET['sort_by']) ? $select : 'Urut Berdasarkan';?></button>
														<ul class="dropdown-menu">
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?q='.$_GET['q'].'&price='.$filter['price'].'&sort_by=default';?>">Default</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?q='.$_GET['q'].'&price='.$filter['price'].'&sort_by=newest';?>">Terbaru</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?q='.$_GET['q'].'&price='.$filter['price'].'&sort_by=most-popular';?>">Terpopuler</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?q='.$_GET['q'].'&price='.$filter['price'].'&sort_by=price-high';?>">Harga Tertinggi</a></li>
															<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'?q='.$_GET['q'].'&price='.$filter['price'].'&sort_by=price-low';?>">Harga Terendah</a></li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div> <!-- //sort -->
								</div> <!-- //col -->
								
							</div> <!-- //row -->
														
							<div class="the-list">

								<div class="preloader">
								    <div class="cssload-thecube">
										<div class="cssload-cube cssload-c1"></div>
										<div class="cssload-cube cssload-c2"></div>
										<div class="cssload-cube cssload-c4"></div>
										<div class="cssload-cube cssload-c3"></div>
									</div>
								</div>​

								<div class="list-content">
									<div class="row">

										<?php
											echo $empty;
											foreach ($list AS $row) { 
												$navigasi_id = $this->db->query('SELECT * FROM type_nav_page WHERE type_nav_page_id="'.$row->type_nav_page_id.'"')->row();
												$navigasi_name = $navigasi_id->type_nav_page_name;
										?>
										<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">

											<div class="top-product">
												<?php
											        if ($row->product_price_discount>'0') { 
											          	$margin = ($row->product_price_sell-$row->product_price_discount)*100;
										          		$percent = $margin/$row->product_price_sell;
											    ?>
											          <div class="discount">
											          	<span><?php echo ceil($percent);?>%</span>
											          	<span class="off">OFF</span>
											          </div>
											    <?php } ?>
											</div>

											<a class="the-item block same-height" href="<?php echo base_url();?>product/view/<?php echo strtolower($navigasi_name).'/'.url_title(strtolower($row->product_name).'-'.strtolower($row->product_code)).'-'.$row->product_id;?>">
												
												<div class="images">
													<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$row->product_id.'" && image_product_status="default"')->row(); ?>
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

													<div class="name">
														<span><?php echo ucwords(strtolower($row->product_name));?></span>
													</div> <!-- //name -->
													
													<?php
														if ($row->product_rating>=3) {
													?>
														<div class="rating-star">
															<ul class="list-inline no-margin">
																<li class="no-padding">
																	<img src="<?php echo base_url();?>assets/front/images/rating/<?php echo $row->product_rating;?>.png">
																</li>
															</ul>
														</div> <!-- //rating -->	
													<?php } ?>

													<div class="box-price">
														<div class="price-after">
															<span>
															<?php
																$price = $row->product_price_sell;
																echo $row->product_price_discount>'0' ? '<strike>IDR '.number_format($row->product_price_sell,0).'</strike>' : '';
															?>
															</span>
														</div>
														<div class="price">		
															<span>												 
															<?php 
																echo $row->product_price_discount>'0' ? 'IDR '.number_format($row->product_price_discount,0) : 'IDR '.number_format($row->product_price_sell,0);
															?>	
															</span>
														</div> <!-- //price -->
														
													</div>
													
												</div> <!-- //box-item -->
												
											</a> <!-- //item -->
										</div> <!-- //col -->
										<?php } ?>
										
									</div> <!-- //row -->
								</div> <!-- //list-content -->
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
		$(function() {
		    $.ajax({
		        // url: 'http://code.jquery.com/jquery-latest.min.js',
		        url: '<?php echo base_url();?>assets/front/js/jquery-latest.min.js',
		        dataType: 'script',
		        beforeSend: function(evt) {
		            if ( ! $('.preloader').is('.show') ) $('.preloader').addClass('show');
		        },
		        complete: function(jqXHR, textStatus) {
		            // disable either here or at the end
		            $('.preloader').removeClass('show');
		            $('.list-content').addClass('show-content');

		            // handle error and success
		        }
			});
		});
	</script>

	<script>
		function toggleChevron(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find("i.indicator")
		        .toggleClass('fa-angle-down fa-angle-up');
		}
		$('#gender').on('hidden.bs.collapse', toggleChevron);
		$('#gender').on('shown.bs.collapse', toggleChevron);
		$('#nav_page').on('hidden.bs.collapse', toggleChevron);
		$('#nav_page').on('shown.bs.collapse', toggleChevron);
		$('#brand').on('hidden.bs.collapse', toggleChevron);
		$('#brand').on('shown.bs.collapse', toggleChevron);
		$('#category').on('hidden.bs.collapse', toggleChevron);
		$('#category').on('shown.bs.collapse', toggleChevron);
		$('#price').on('hidden.bs.collapse', toggleChevron);
		$('#price').on('shown.bs.collapse', toggleChevron);
	</script>

	<script type="text/javascript">  
		$(function(){
			$('.checkbox').on('change',function(){
				$('#form').submit();
			});
		});
	</script>