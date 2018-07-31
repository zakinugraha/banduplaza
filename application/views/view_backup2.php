	<main id="main-content" class="main-content grey">
		<section id="detail" class="detail">

			<div class="information-product">
				<div class="container">
					<div class="bread-border">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<ol class="breadcrumb trans">
									<li><a href="<?php echo base_url();?>" class="home"><i class="fa fa-home"></i></a></li>
									<li class="slash"><span>/</span></li>
									<li><a href="<?php echo base_url();?>shop/<?php echo lcfirst($nav_name->type_nav_page_name);?>"><?php echo $nav_name->type_nav_page_name;?></a></li>
									<li class="slash"><span>/</span></li>
									<li><a><?php echo $view->product_name;?></a></li>
								</ol>
							</div> <!-- //col -->
						</div>
					</div>
				</div>
			</div> <!-- information-product -->

			<!-- <div class="container">
				<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Info Bandu!</strong> Dapatkan potongan harga 10% dengan memasukan kode voucher <strong>MERAHPUTIH10</strong><br></div>
			</div> -->

			<div class="container">
				<div class="row">						
					<?php
						if ($this->input->get('message')!='') {
							echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Stok produk tidak mencukupi</i></div>';
						} else if ($this->input->get('attention')!='') {
							echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Ukuran produk belum dipilih</i></div>';
						} else if ($this->input->get('full-order')!='') {
							echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Anda sudah memberikan ulasan untuk produk ini.</i></div>';
						} else if ($this->input->get('empty-order')!='') {
							echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Anda belum pernah berbelanja produk ini.</i></div>';
						} else if ($this->input->get('product')!='') {
							echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Produk yang anda pilih masih tersedia.</i></div>';
						} else if ($this->input->get('mywishlist')!='') {
							echo '<div class="attention-warning text-center"><i class="fa fa-exclamation-circle"></i> Produk yang anda pilih sudah ada di wishlist anda.</i></div>';
						}
					?> 	
					<div class="background-box">

						<div class="col-xs-12 col-sm-6">
							<div class="images">
								 
								<div id="carousel" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">

										<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$view->product_id.'" && image_product_status="default"')->row(); ?>
										<div class="item active zoom">
											<figure class="zoo-item" zoo-scale="2" zoo-image="<?php echo base_url();?>upload/images/product/<?php echo $image_default->image_product_file_name;?>">Loading...</figure>
										</div>

										<?php 
											$images = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$view->product_id.'" ORDER BY image_product_id ASC')->result();
											foreach ($images AS $img) { 
										?>
											<div class="item">
												<figure class="zoo-item" zoo-scale="2" zoo-image="<?php echo base_url();?>upload/images/product/<?php echo $img->image_product_file_name;?>">Loading...</figure>
											</div>
										<?php } ?>

									</div>
								</div> 
							</div> <!-- //images -->

							<div class="clearfix">
								<div id="thumbcarousel" class="carousel slide" data-interval="false">
									<div class="carousel-inner">

										<div class="item active">
											<?php 
												$images = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$view->product_id.'" ORDER BY image_product_id ASC')->result();
												$no=1;
												foreach ($images AS $img) { 
											?>
											<div data-target="#carousel" data-slide-to="<?php echo $no++;?>" class="thumb"><img src="<?php echo base_url();?>upload/images/product/thumbs/<?php echo $img->image_product_file_name;?>"></div>
											<?php } ?>
										</div><!-- /item -->

									</div><!-- /carousel-inner -->
									<?php
										$count = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$view->product_id.'" ORDER BY image_product_id ASC')->num_rows();
										if ($count>4) {
									?>
									<a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left"></span>
									</a>
									<a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right"></span>
									</a>
									<?php } ?>
								</div> <!-- /thumbcarousel -->
							</div><!-- /clearfix -->
							
						</div> <!-- //col -->
						
						<div class="col-xs-12 col-sm-6">
							<div class="item-detail">
								<div class="bound">
									<div class="row">
										<div class="col-md-12">
											<!-- <div class="brand text-brand text-muted"><?php echo $brand->brand_name;?></div> --> <!-- //brand -->
											<span class="text-title"><?php echo $view->product_name;?></span>
											<span>by <?php echo $brand->brand_name;?></span>
											<?php
												if ($view->product_rating>=3) {
											?>
											
											<ul class="list-inline no-margin" style="margin-bottom:15px !important">
												<li class="no-padding">
													<img src="<?php echo base_url();?>assets/front/images/rating/<?php echo $view->product_rating;?>.png">
												</li>
											</ul>
												
											<?php } ?>

											<!-- <div class="l-b-filter-detail"></div> -->

											<!-- <label class="price">Price</label> -->
											<div style="position:relative;margin-top:10px;">
												<?php
										        if ($view->product_price_discount!='0') { ?>
													<div class="cut price-discount"><span><strike><?php echo 'IDR '.number_format($view->product_price_sell);?></strike></span></div>
												<?php } ?>
												<div class="price"><span><?php echo $view->product_price_discount>0 ? 'IDR '.number_format($view->product_price_discount,0) : 'IDR '.number_format($view->product_price_sell,0);?></span></div> <!-- //price -->
												

												<?php
											        if ($view->product_price_discount!='0') { 
											        	$margin = ($view->product_price_sell-$view->product_price_discount)*100;
									          			$percent = $margin/$view->product_price_sell;
											          echo '<div class="save-up"><span>*Lebih hemat '.ceil($percent).'%</span></div>';
											        }
											    ?>
										    </div>

										    <div class="l-b-filter-detail"></div>

										    <?php echo $view->product_short_desc;?>

										    <span class="text-code" style="margin-top:15px;">Product Code : <?php echo $view->product_code;?></span>
											<?php
									    		if ($view->product_total_stock==0) {
									    			$color='red';
									    			$text='Sold Out';
									    		} else if ($view->product_total_stock>0 && $view->product_total_stock<5) {
									    			$color='yellow';
									    			$text='Limited Stock';
									    		} else {
									    			$color='green';
									    			$text='Ready Stock';
									    		}
									    	?>
											<span class="text-code">Avaibility : <?php echo $text;?></span>
											<span class="text-code">Tags : 
												<?php 
													$tags = explode("#", $view->product_tags);
													$count = count($tags);
													for ($no=1; $no < $count; ++$no) {
														echo '<a href="'.base_url().'search?q='.$tags[$no].'">#'.str_replace(" ", "", $tags[$no]).' </a>';
													}
												?>	
											</span>
										</div>									
										
									</div> <!-- End row -->
								</div>
									
								<div class="l-b-filter-detail"></div>

								<div class="bound-last">
									<div class="form-box">
										<form action="" method="POST">
											<div class="choice-detail">
												<div class="row">

													<div class="col-sm-12">
														<div class="dropdown">
															<button class="dropdown-toggle size" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																- Pilih Ukuran - <span style="position:relative;float:right;top:-3px;right:20px;font-size:20px;font-weight:600"><i class="fa fa-angle-down"></i></span> <!-- <span class="caret" style="position:relative;float:right;top:5px;right:5px"></span> -->
															</button>
															<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
																<?php
																	$cek = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value, m.product_id from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where product_id="'.$view->product_id.'"');
																	foreach ($cek AS $row) {
																?>
																<li class="btndr"><a href="#" class="<?php echo $row->stock_management_value==0?'through':'';?>" value="<?php echo $row->stock_management_id;?>"><?php echo $row->size_attributes_value?></a></li>
																<?php
																	} // End foreach
																?>
															</ul>
															<input type="hidden" name="size" id="size">
														</div>
													</div>													

													<div class="col-sm-12">
														<div class="form-group inline-block padding10">
															<input type="submit" name="submit" value="Beli Sekarang" class="btn btn-buy btn-lg text-uppercase text-bold">
														</div> <!-- //buy -->														
													</div>

													<!-- <div class="col-sm-12">
														<label>Atau</label>
														<a href="https://api.whatsapp.com/send?phone=6282126603648&text=Silahkan%20order%20dengan%20format%20seperti%20berikut%3A%0ANama%3A%20%0ATelp%3A%20%0AEmail%3A%20%0ANama%20Produk%3A%20%0AUkuran%3A%0AJumlah%3A" target="_BLANK" class="wa">
															<img src="<?php echo base_url();?>assets/front/images/Whatsapp-icon.png">Order Via WhatsApp
														</a>
													</div> -->
													
												</div> <!-- //row -->
											</div> <!-- //choice -->
											
										</form>
										<div class="l-b-filter-detail"></div>
									</div>
								</div>
								
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#material">Detail</a></li>
									<li><a data-toggle="tab" href="#panduan">Panduan Ukuran</a></li>
									<li><a data-toggle="tab" href="#kebijakan">Kebijakan</a></li>
								</ul>

								<div class="tab-content">
									<div id="material" class="tab-pane fade in active">
										<?php echo $view->product_description;?>	
									</div>
									<div id="panduan" class="tab-pane fade">
										<?php
											$get = $this->db->query('SELECT * FROM size_chart WHERE brand_id="'.$brand->brand_id.'" && type_nav_page_id="'.$nav_name->type_nav_page_id.'" LIMIT 1')->row();
											$count = $this->db->query('SELECT * FROM size_chart WHERE brand_id="'.$brand->brand_id.'" && type_nav_page_id="'.$nav_name->type_nav_page_id.'"')->num_rows();
											if ($count>0) {
												echo $get->size_chart_content;
											} else {
												echo '<p>Tidak ada keterangan</p>';
											}
										?>
									</div>
									<div id="kebijakan" class="tab-pane fade">
										<?php echo $brand->brand_privacy_return;?>
									</div>
								</div>									
							</div>
						</div> <!-- //detail -->
						
					</div>	
				</div>
			</div> <!-- //container -->
		</section> <!-- //detail -->

		<section id="main-bottom" class="main-bottom">
			<div class="top">
          <div class="container">
            <div class="bar">
              <i class="fa fa-shopping-cart"></i>
              <a href="<?php echo base_url();?>help/1491812947/cara-berbelanja">How to Shop</a>
            </div>
            <div class="bar">
              <i class="fa fa-question-circle-o"></i>
              <a href="#">FAQ's</a>
            </div>
            <div class="bar">
              <i class="fa fa-commenting-o"></i>
              <a href="<?php echo base_url();?>contact">Need Help</a>
            </div>
          </div>            
        </div>
        	<div class="subscribe-us">
	          <div class="subscribe">
	            <div class="container">
	              <div class="form">
	                <span>Mau dapat diskon 10%?</span>
	                <span class="block">Masukan email kamu dan dapatkan harga spesial</span>
	                <form method="get" action="<?php echo base_url();?>subscribe/add">
	                  <input type="text" name="email_subs_home" id="email_home" placeholder="Please Enter Your Email Address"><i class="fa fa-envelope envelope"></i>
	                  <div id="success" class="subs-success" style="display:none;">Thank for Subscribing!</div>
	                  <div id="err" class="subs-err" style="display:none;">Email is not valid</div>
	                  <button type="button" name="submit" id="btn_subs_home">Kirim <i class="fa fa-angle-double-right"></i></button>
	                </form>
	              </div>
	              
	            </div>
	          </div>
	        </div>
      	</section>

      	<section id="similiar" class="similiar">
	      	<div class="container">
		      	<div class="row">
			      	<div class="col-md-12">
						<div class="background-box-similiar">
							<div class="col-md-12">
					          <div class="line-behind-title text-uppercase text-center">
					            <div class="separator-line">
					              <span>Kamu juga pasti menyukai</span>
					            </div>
					          </div>
					        </div>
							<ul class="product-similar arrival">
								<?php foreach ($related AS $rel) { ?>
								<li class="item same-height">
									<a href="<?php echo base_url();?>product/view/<?php echo strtolower($nav_name->type_nav_page_name).'/'.url_title(strtolower($rel->product_name).'-'.strtolower($rel->product_code)).'-'.$rel->product_id;?>" class="block">
										<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$rel->product_id.'" LIMIT 1')->row(); ?>
										<div class="images position-relative" style="background-image:url('<?php echo base_url();?>upload/images/product/thumbs/<?php echo $image_default->image_product_file_name;?>')">
										<?php
											$get_stock = $this->db->query('SELECT * FROM stock_management WHERE product_id="'.$rel->product_id.'"')->result();
											$stock = 0;
											foreach ($get_stock AS $get) {
												$stock+=$get->stock_management_value;
											}
											$total_stock = $stock;

											if ($total_stock==0) {
												$stok_status = '<span class="badge-new sold">Sold Out</span>';
											} else if ($total_stock>0) {
												$stok_status = '';
											}
											echo $stok_status;
										?>
										<!-- <span class="badge-new sold">Sold Out</span> <!-- //image -->
										</div>
										<div class="box-similiar">
											<?php
												$cek_brand = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$rel->brand_id.'" LIMIT 1')->row();
											?>
											<div class="brand"><h4><?php echo $cek_brand->brand_name;?></h4></div> <!-- //brand -->
											<div class="name">
												<span><?php echo $rel->product_name;?></span>
											</div> <!-- //name -->

											<?php
													if ($rel->product_rating>=3) {
												?>
												<div class="rating-star">
													<ul class="list-inline no-margin">
														<li class="no-padding">
															<img src="<?php echo base_url();?>assets/front/images/rating/<?php echo $rel->product_rating;?>.png">
														</li>
													</ul>
												</div> <!-- //rating -->	
												<?php } ?>	

											<div class="box-price">
												<div class="price-after-rel">
													<span><strike>
													<?php
														echo $rel->product_price_discount>0 ? 'IDR '.number_format($rel->product_price_sell,0) : '';
													?>
													</strike></span>
												</div>
											
												<div class="price">											
													<span>
														<?php
															echo $rel->product_price_discount>0 ? 'IDR '.number_format($rel->product_price_discount,0) : 'IDR '.number_format($rel->product_price_sell,0);
															// echo 'RP '.number_format($rel->product_price_sell,0)
														;?>
													</span>
												</div> <!-- //price -->

												
												
											</div>
										</div>
									</a> <!-- //col -->
								</li>
								<?php } ?>
								
							</ul> <!-- //slide -->	
							
						</div>	
					</div> <!-- End Col -->
				</div> <!-- End Container -->
			</div> <!-- End Container -->
		</section>
		
	</main> <!-- //main -->	
	<script>
		function toggleChevron(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find("i.indicator")
		        .toggleClass('fa-angle-up fa-angle-down');
		}
		$('#deskripsi').on('hidden.bs.collapse', toggleChevron);
		$('#deskripsi').on('shown.bs.collapse', toggleChevron);
		$('#stock').on('hidden.bs.collapse', toggleChevron);
		$('#stock').on('shown.bs.collapse', toggleChevron);
		$('#panduan').on('hidden.bs.collapse', toggleChevron);
		$('#panduan').on('shown.bs.collapse', toggleChevron);
		$('#return').on('hidden.bs.collapse', toggleChevron);
		$('#return').on('shown.bs.collapse', toggleChevron);

		$(function() {
	      $("#email_home").keypress(
	        function(e) {
	          if ((e.which && e.which == 13) || (e.jeyCode && e.keyCode == 13)) {
	            return false;
	          } else {
	            return true;
	          }
	        });
	    });

		$('#btn_subs_home').click(function(){
	      var email_subs_home=$('input[name=email_subs_home]').val();
	      var atpos = email_subs_home.indexOf("@");
	      var dotpos = email_subs_home.lastIndexOf(".");

	      if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email_subs_home.length) {
	        $("#err").show().fadeOut(5000);
	      } else {
	        $.ajax({
	          url:'<?php echo base_url();?>subscribe/add?email='+email_subs_home,
	          dataType:'json',
	          type:'get',
	          data:{subscribe_email:email_subs_home},
	          success:function(res){
	            $("#success").show().fadeOut(5000);
	            $('input[name=email_subs_home]').val('Thank for Subscribing');
	          }
	        }); 
	      }
	          
	    });
	</script>