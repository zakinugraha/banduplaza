	<!-- Modal Notify Sukses -->
	<div id="notify-cart" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- body modal -->
				<div class="modal-body text-center" style="padding: 40px 10px 30px;">
					<p class="text-center" id="notify-title" style="font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:20px;"></p>	
					<div id="notify-img"></div>
					<div id="notify-checkout" style="margin-top:30px"></div>				
				</div>
			</div>
		</div>
	</div>

	<!-- Modal size-guide -->
	<div id="size-guide" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Panduan Ukuran</h4>
				</div>
				<!-- body modal -->
				<div class="modal-body">
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
				<!-- footer modal -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<main id="main-content" class="main-content">

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
								<input type="hidden" name="product_id" id="product_id" value="<?php echo $view->product_id;?>">
							</div> <!-- //col -->
						</div>
					</div>
				</div>
			</div> <!-- information-product -->

			<!-- <div class="container">
				<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Info Bandu!</strong> Dapatkan Promo <strong>FREE ONGKIR</strong> se Indonesia di HARBOLNAS nya Banduplaza. Jangan sampai ketinggalan!<br></div>
			</div> -->

			<div class="container">
				<div class="row">						
					
					<div class="background-box">

						<div class="col-xs-12 col-sm-6">
							<div class="images margin-15">
								 
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
											          echo '<div class="save-up"><span>*Beli sekarang lebih hemat '.ceil($percent).'%</span></div>';
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
											<p class="avail-size">Size : </p>
											<ul class="size">
												<?php 
													$stock = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value, m.product_id from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where product_id="'.$view->product_id.'"');
													foreach ($stock AS $sm) { 
												?>
												<li>
													
														<?php echo $sm->stock_management_value=='0' ? '<span class="text-danger"><strike>'.$sm->size_attributes_value.'</strike></span>' : '<span>'.$sm->size_attributes_value.'</span>';?>
													
												</li>
												<?php } ?>
											</ul>
											
										</div>									
										
									</div> <!-- End row -->
								</div>
									
								<div class="l-b-filter-detail"></div>

								<div class="bound-last">
									<div class="form-box">
										<form action="" method="POST">
											<div class="choice-detail">
												<div class="row">
												
													<div class="col-sm-6">
														<div class="text-uppercase the-label">Ukuran <a href="#" class="size-guide" data-toggle="modal" data-target="#size-guide" class="size-guide">(Size Guide)</a></div>
														<div class="form-group position-relative">
															<div class="select-style">
																<select name="size" id="size" class="form-control-detail">
																	<?php															
																		$cek = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value, m.product_id from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where product_id="'.$view->product_id.'"');
																		foreach ($cek AS $row) {
																			echo '<option value="'.strtolower($row->stock_management_id).'">'.$row->size_attributes_value.'</option>';
																		} // End foreach															
																	?>
																</select>															
															</div>
														</div>
													</div> <!-- //col -->
													
													<div class="col-sm-6">
														<div class="text-uppercase the-label">Jumlah</div>
														<div class="form-group position-relative">
															<div class="select-style">
																<select name="quant" id="quant" class="form-control-detail">
																	<?php 
																		for ($i=1;$i<=10;$i++) { 
																			echo '<option value="'.$i.'">'.$i.'</option>';
																		}
																	?>
															</select>
															</div>
														</div> <!-- //qty -->
													</div> <!-- //col -->

													<div class="col-sm-12">
														<div class="form-group" style="margin-top:5px;">
															<!-- <input type="submit" name="submit" value="Beli Sekarang" class="btn btn-buy btn-lg text-uppercase text-bold"> -->
															<button type="button" id="add_to_cart" class="btn btn-buy btn-lg text-uppercase text-bold" value="Beli Sekarang">Beli Sekarang</button>
														</div> <!-- //buy -->
														<div class="l-b-filter-detail"></div>
														<div class="order-wa">
															Order via Whatsapp
															<div class="l-b-filter-detail"></div>
															Format Order : ORDER#NAMA PRODUK#SIZE#JUMLAH
															<p>0821-2660-3648</p>
														</div>
														
													</div>
													
												</div> <!-- //row -->
											</div> <!-- //choice -->
											
										</form>
										<div class="l-b-filter-detail"></div>
									</div>
								</div>

								<div class="panel-group panel-detail" id="material" role="tablist" aria-multiselectable="true">
							        <div class="panel panel-light">
							            <div class="panel-heading" role="tab" id="headingMaterial">
							                <h4 class="panel-title">
							                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-controls="collapseOne">
							                    	<i class="indicator fa fa-plus"></i> Detail Material 
							                    </a>
							                </h4>
							            </div>
							            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMaterial">
							                <div class="panel-body body-detail">
							                   	<?php echo $view->product_description;?>
							                </div>
							            </div>
							        </div>
							    </div>

								<div class="panel-group panel-detail" id="stok" role="tablist" aria-multiselectable="true">
							        <div class="panel panel-light">
							            <div class="panel-heading" role="tab" id="headingStok">
							                <h4 class="panel-title">
							                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-controls="collapseTwo">
							                    	<i class="indicator fa fa-plus"></i> Stok Produk 
							                    </a>
							                </h4>
							            </div>
							            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingStok">
							                <div class="panel-body body-detail">
							                   	<table class="table table-condensed table-bordered text-center no-margin">
													<thead>
														<tr class="warning">
															<th class="text-center">Size</th>
															<th class="text-center">Stock</th>
														</tr>
													</thead>
													
													<tbody>
														<?php 
															$stock = $this->mod->custom_fetch_query('select m.*, s.size_attributes_id, s.size_attributes_value, m.stock_management_value, m.product_id from stock_management m inner join size_attributes s on (m.size_attributes_id=s.size_attributes_id) where product_id="'.$view->product_id.'"');
															foreach ($stock AS $sm) { 
														?>
																<tr>
																	<td><?php echo $sm->size_attributes_value;?></td>
																	<td class="<?php echo $sm->stock_management_value=='0' ? 'text-danger' : '';?>">
																		<?php echo $sm->stock_management_value=='0' ? '<strike>'.$sm->stock_management_value.' pcs</strike>' : $sm->stock_management_value.' pcs';?>
																	</td>
																</tr>
														<?php
															} // End if
														?>
													</tbody>
												</table>
												<br>
												<p>* Stock dapat berubah sewaktu-waktu.</p>
							                </div>
							            </div>
							        </div>
							    </div>

								<div class="panel-group panel-detail" id="privacy" role="tablist" aria-multiselectable="true">
							        <div class="panel panel-light">
							            <div class="panel-heading" role="tab" id="headingPrivacy">
							                <h4 class="panel-title">
							                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-controls="collapseThree">
							                    	<i class="indicator fa fa-plus"></i> Kebijakan Produk 
							                    </a>
							                </h4>
							            </div>
							            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPrivacy">
							                <div class="panel-body body-detail">
							                   	<?php echo $brand->brand_privacy_return;?>
							                </div>
							            </div>
							        </div>
							    </div>

								<div class="panel-group panel-detail" id="payment" role="tablist" aria-multiselectable="true">
							        <div class="panel panel-light">
							            <div class="panel-heading" role="tab" id="headingpayment">
							                <h4 class="panel-title">
							                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-controls="collapseThree">
							                    	<i class="indicator fa fa-plus"></i> Metode Pembayaran
							                    </a>
							                </h4>
							            </div>
							            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingpayment">
							                <div class="panel-body body-detail">
							                   	<p>
							                   		Seluruh transaksi di Banduplaza menggunakan Midtrans Online Payment Gateway System. Sehingga transaksi di Banduplaza
							                   		semakin aman dan mudah.
							                   	</p>
							                   	<p>Lebih lanjut mengenai Midtrans dan keamanan transaksi, klik <a href="<?php echo base_url();?>help/1500602543/keamanan-transaksi" target="_BLANK" style="font-weight:600;color:#dc8f1e;">disini</a></p>
							                </div>
							            </div>
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
        	<div class="col-md-12" style="padding:10px 0;background-image:url(../../../upload/images/display/back.jpg);margin-bottom:20px;text-align:center;">
		        <div class="container">
		        	<div class="line-behind-title text-uppercase text-center">
			            <div class="separator-line-testi-view">
			              <span class="testi">Kepuasan Pelanggan</span>
			            </div>
			        </div>

			        <div class="transparent-testi">
					    <div class="carousel slide" data-ride="carousel" id="quote-carousel">				      
							<!-- Bottom Carousel Indicators -->
							<ol class="carousel-indicators">
								<?php
									$list_testi=$this->db->query('SELECT * FROM testimoni ORDER BY testimoni_id DESC LIMIT 5')->result();
									$no=0;
									foreach ($list_testi AS $testi) {
								?>
										<li data-target="#quote-carousel" data-slide-to="<?php echo $no++;?>" class="<?php $no=='0'?'active':'';?>"></li>
								<?php
									}
								?>
							</ol>
				        
							<!-- Carousel Slides / Quotes -->
							<div class="carousel-inner">
								<?php
									$no=0;
									foreach ($list_testi AS $ct) {
								?>
								<div class="item <?php echo $no++=='0'?'active':'';?>">

								    <div class="col-sm-12">
								    	<?php if ($ct->testimoni_image!='') { ;?>
								    	<img src="<?php echo base_url();?>upload/images/testimoni/<?php echo $ct->testimoni_image;?>" class="testi">
								      	<?php } else {};?>
								      	<p class="testi">&ldquo;<?php echo $ct->testimoni_desc;?>&rdquo;</p>
								      	<small><strong><?php echo $ct->testimoni_name.', '.$ct->testimoni_region;?></strong></small>
								    </div>							  
								</div>
								<?php
									}
								?>
							</div>			        

				      	</div>    
				      	<!-- <a href="#" class="open-testimoni">Lihat semua testimoni</a> -->
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
														?>
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

	<script type="text/javascript">
		$(document).ready(function(){
			$('#add_to_cart').click(function() {
				var product_id = $('#product_id').val();
				var qty = $('#quant').val();
				var size = $('#size').val();
				var notify_img = document.getElementById("notify-img");

				// efek loading
				$("#notify-cart").modal().show();
				document.getElementById('notify-img').innerHTML = '<img src="<?php echo base_url();?>assets/front/images/notify-loading.gif">';
				document.getElementById('notify-title').innerHTML = 'Adding to cart...';

				$.ajax({
					url : '<?php echo base_url();?>product/add_to_cart?product_id='+product_id+'&qty='+qty+'&size='+size,
					dataType : 'json',
					type : 'get',
					success:function(res) {
						if (res.val=="1") {
							document.getElementById('notify-img').innerHTML = '<img src="<?php echo base_url();?>assets/front/images/add-to-cart-success.png">';
							document.getElementById('notify-title').innerHTML = res.text;
							document.getElementById('notify-checkout').innerHTML = '<a href="<?php echo base_url();?>checkout" class="notify-checkout">Proses ke Checkout</a>';
						} else {
							document.getElementById('notify-img').innerHTML = '<img src="<?php echo base_url();?>assets/front/images/add-to-cart-fail.png">';
							document.getElementById('notify-title').innerHTML = res.text;
							document.getElementById('notify-checkout').innerHTML = '<div class="notify-warning text-center"><span>Silahkan gunakan fitur Cek Stok Produk</span></div>';
						}
					}
				});
			});
		});
	</script>

	<script>
		function toggleChevron(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find("i.indicator")
		        .toggleClass('fa-minus fa-plus');
		}
		$('#material').on('hidden.bs.collapse', toggleChevron);
		$('#material').on('shown.bs.collapse', toggleChevron);
		$('#stok').on('hidden.bs.collapse', toggleChevron);
		$('#stok').on('shown.bs.collapse', toggleChevron);
		$('#privacy').on('hidden.bs.collapse', toggleChevron);
		$('#privacy').on('shown.bs.collapse', toggleChevron);
		$('#payment').on('hidden.bs.collapse', toggleChevron);
		$('#payment').on('shown.bs.collapse', toggleChevron);

		$(function() {
	      $("#email_home").keypress(
	        function(e) {
	          if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
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

	    $(document).ready(function() {
		  //carousel options
		  $('#quote-carousel').carousel({
		    pause: true, interval: 10000,
		  });
		});
	</script>