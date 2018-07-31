	
	<main id="main-content" class="main-content">
		<div class="information-product">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<ol class="breadcrumb trans">
							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li class="sep"><span><i class="fa fa-caret-right"></i></span></li>
							<li><a href="<?php echo base_url();?>">Shop</a></li>
							<li class="sep"><span><i class="fa fa-caret-right"></i></span></li>
							<li class="active"><?php echo ucfirst($this->uri->segment(2));?></li>
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

							<div class="panel-group" id="category" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingThree">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-controls="collapseThree" style="display:block;position:relative;">
						                        Product <i class="indicator fa fa-minus"></i> 
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

						    <!-- <div class="l-b-filter"></div>

							<div class="panel-group" id="brand" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingTwo">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-controls="collapseTwo" style="display:block;position:relative;">
						                        Item <i class="indicator fa fa-minus"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
						                <div class="panel-body">
						                   	<div class="checkboxs">
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<?php foreach ($item AS $i) { ?>
														<li class="media checkbox">
															<a href="#" class="<?php echo $this->uri->segment(2)==url_title(strtolower($i->p_item)) ? "is_active" : "";?>">
																<span><?php echo $i->p_item;?></span>
															</a>
														</li>
														<?php } ?>
													</ul>
												</div>
											</div>
						                </div>
						            </div>
						        </div>
						    </div> -->

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
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<?php foreach ($brand AS $merch) { ?>
														<li class="media checkbox">
															<a href="<?php echo base_url();?>brand/<?php echo url_title(strtolower($merch->merchant));?>" class="<?php echo $this->uri->segment(2)==url_title(strtolower($merch->merchant)) ? "is_active" : "";?>">
																<span><?php echo $merch->merchant;?></span>
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

							<div class="l-b-filter"></div>

							<div class="panel-group" id="gender" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingThree">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-controls="collapseThree" style="display:block;position:relative;">
						                        Gender <i class="indicator fa fa-minus"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						                <div class="panel-body">
						                   	<div class="checkboxs">
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<?php foreach ($gender AS $g) { ?>
														<li class="media checkbox">
															<a href="<?php echo base_url().'shop/'.$this->uri->segment(2).'/'.strtolower($g->type_gender_name);?>" class="<?php echo ucfirst($this->uri->segment(3))==$g->type_gender_name ? 'is_active' : '';?>">
																<span><?php echo $g->type_gender_name;?></span>
															</a>
														</li>
														<?php } ?>
													</ul>
													<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2);?>" class="remove">Hapus Filter</a>
												</div>
											</div>
						                </div>
						            </div>
						        </div>
						    </div>
						    
							<div class="l-b-filter"></div>
							
							<div class="panel-group" id="price" role="tablist" aria-multiselectable="true">
						        <div class="panel panel-light">
						            <div class="panel-heading" role="tab" id="headingFour">
						                <h4 class="panel-title">
						                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-controls="collapseFour" style="display:block;position:relative;">
						                        Price <i class="indicator fa fa-minus"></i> 
						                    </a>
						                </h4>
						            </div>
						            <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
						                <div class="panel-body">
						                   	<div class="checkboxs">
							                   	<div class="scroll-box">
													<ul class="media-list price">
														<li class="media checkbox">
															<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?><?php echo $this->uri->segment(3)!=''?$this->uri->segment(3):'';?><?php echo '?price=300000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="300000" ? "is_active" : "";?>" >
																<span><i class="fa fa-angle-right"></i> 300.000</span>
															</a>
														</li>
														<li class="media checkbox">
															<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?><?php echo $this->uri->segment(3)!=''?$this->uri->segment(3):'';?><?php echo '?price=200000,300000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="200000,300000" ? "is_active" : "";?>" >
																<span>200.000 - 300.000</span>
															</a>
														</li>
														<li class="media checkbox">
															<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?><?php echo $this->uri->segment(3)!=''?$this->uri->segment(3):'';?><?php echo '?price=100000,200000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="100000,200000" ? "is_active" : "";?>" >
																<span>100.000 - 200.000</span>
															</a>
														</li>
														<li class="media checkbox">
															<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?><?php echo $this->uri->segment(3)!=''?$this->uri->segment(3):'';?><?php echo '?price=100000&sort_by='.$filter['sort_by'];?>" class="<?php echo $check=="100000" ? "is_active" : "";?>" >
																<span><i class="fa fa-angle-left"></i> 100.000</span>
															</a>
														</li>														
													</ul>
													<a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/';?><?php echo $this->uri->segment(3)!=''?$this->uri->segment(3):'';?><?php echo '?price=n&sort_by='.$filter['sort_by'];?>" class="remove">Hapus Filter</a>
												</div>
											</div>
						                </div>
						            </div>
						        </div>
						    </div>


						</div> <!-- //filter -->
					</div> <!-- //col filter -->
	
					<div class="col-xs-12 col-sm-10 main">
						<div class="content-product">
							<div class="row">								

								<div class="col-md-6">
									<h3><?php echo ucfirst($this->uri->segment(2));?></h3>
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
									</div>
									
									<a class="the-item block same-height" href="<?php echo base_url();?>product/view/<?php echo url_title(strtolower($row->product_name).'-'.strtolower($row->product_code)).'-'.$row->product_id;?>">
										
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

											<?php
												if ($row->product_rating>=3) {
											?>
											<div class="rating-star">
												<ul class="list-inline no-margin">
													<li class="no-padding">
														<img src="<?php echo base_url();?>assets/front/images/rating/<?php echo $row->product_rating;?>.png">
														<?php
															// $n = $row->product_rating;
															// for ($i=1; $i<=5; $i++) {
														?>
														<!-- <i class="fa fa-star" style="color:<?php echo $i<=$n ? 'gold' : '#d0d0cf';?>"></i> -->
														<?php //} ?>
													</li>
												</ul>
											</div> <!-- //rating -->	
											<?php } ?>	
											
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

	<script type="text/javascript">
		var element_list=$("#the-list").find('list-product');

		$(document).ready(function(){
			$('#the-list').ready(function(){
			 	var jqxhr=$.ajax({
	                url:'<?php echo base_url()?>shop/sepatu',
	                type:'get',
	                dataType:'json',
	            });
	            $("#load_content").show();

	            jqxhr.success(function(response){
	            	element_list.html('Pilih Kota/Kabupaten');
	            	$.each(response,function(index,rowArr){

	            	});
	            });

			});
		});
	</script>

	<script>
		function toggleChevron(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find("i.indicator")
		        .toggleClass('fa-plus fa-minus');
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

