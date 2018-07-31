<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<META HTTP-EQUIV=”EXPIRES” CONTENT=Fri, 8 Dec 2017 11:12:01 GMT”>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo isset($title) ? $title : 'Pusat Sepatu dan Tas Terlengkap';?></title>
	<meta name="description" content="<?php echo strip_tags($content->blogcontent_short_desc);?>">

	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/front/images/favicon.png">
	
	<!-- Site -->
	<!-- <link href="<?php echo base_url();?>assets/front/plugins/webfont/font.css" rel="stylesheet"> -->
	<link href="<?php echo base_url();?>assets/front/plugins/iconfont/iconfont.css" rel="stylesheet">
	<!-- Bootstrap -->
	<link href="<?php echo base_url();?>assets/front/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/front/css/main-site.css" rel="stylesheet">

	<!-- Font Awesome -->
  	<link href="<?php echo base_url();?>assets/front/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo base_url();?>assets/front/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	
  	<?php if ($this->uri->segment(2)=='view') { ?>
			<!-- Zoom -->
		<link href="<?php echo base_url();?>assets/front/plugins/zoom/zoomove.min.css" rel="stylesheet">
		<!-- BX Slider -->
		<link href="<?php echo base_url();?>assets/front/plugins/bxslider/jquery.bxslider.css" rel="stylesheet">
	<?php } ?>

	<!-- Google Analytics -->
	<script>
		// (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		// (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		// m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		// })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		// ga('create', 'UA-89249767-1', 'auto');
		// ga('send', 'pageview');	
	</script>

	<script>
		if($(window).width() > 50) {
			$(window).scroll(function(){
				if ($(this).scrollTop() > 50) {
					$("#top-header").addClass('fixed');
				} else {
					$("#top-header").removeClass('fixed');
				}
			});			
		};
	</script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>
	
<body>
	<header id="header">
		<nav class="navbar navbar-default navbar-static-top yamm">

			

			<div class="top-bar text-center">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="bar-first">
								<a href="<?php echo base_url();?>help/1491812947/cara-berbelanja"><i class="fa fa-shopping-cart"></i><span>Cara Berbelanja</span></a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="bar">
								<a href="<?php echo base_url();?>help"><i class="fa fa-commenting-o"></i><span>Pusat Bantuan</span></a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="bar-last">
								<a href="<?php echo base_url();?>confirm"><i class="fa fa-check-circle"></i><span>Konfirmasi Pembayaran</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="top-header" id="top-header">
				<div class="container">

					<div class="col-md-12">
						<div class="row">						
							<div class="box-left">
								<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/front/images/logo.png"></a>
							</div>
						
							<div class="box-right">
								<ul>
					        		<li>
					        			<a href="<?php echo base_url();?>shop/shoes<?php echo isset($type_gender) ? $type_gender : '';?>" class="<?php echo $this->uri->segment(2)=="shoes"? "menu-active" : "";?>">Shoes</a>
					        		</li>
					        		<li>
					        			<a href="<?php echo base_url();?>shop/bag" class="<?php echo $this->uri->segment(2)=="bag"? "menu-active" : "";?>">Bag</a>
					        		</li>
					        		<li>
					        			<a href="<?php echo base_url();?>whatnew" class="<?php echo $this->uri->segment(1)=="whatnew"? "menu-active" : "";?>">New Arrival</a>
					        		</li>
					        		<li>
					        			<a href="<?php echo base_url();?>sale" class="text-red">Sale!</a>
					        		</li>
					        		<li>
					        			<a href="<?php echo base_url();?>testimonial" class="<?php echo $this->uri->segment(1)=="testimonial"? "menu-active" : "";?>">Testimonial</a>
					        		</li>
					        		<li>
					        			<a href="<?php echo base_url();?>contact" class="<?php echo $this->uri->segment(1)=="contact"? "menu-active" : "";?>">Contact Us</a>
					        		</li>
					        	</ul>
							</div>

							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#open-menu" aria-expanded="false" aria-controls="open-menu">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							
							<!-- Collapse -->
							<div class="collapse navbar-collapse menu-header" id="open-menu" style="clear: both;">
								<div class="container">
									<ul class="nav navbar-nav text-left">
										
										<li><a href="<?php echo base_url();?>shop/shoes">Shoes</a></li>
										<li><a href="<?php echo base_url();?>shop/bag">Bag</a></li>
										<li><a href="<?php echo base_url();?>whatnew">What's New</a></li>
										<li><a href="<?php echo base_url();?>sale" class="text-red">Sale!</a></li>
										<li><a href="<?php echo base_url();?>testimonial">Testimonial</a></li>
										<!-- <li><a href="#">Blog</a></li> -->
										<li><a href="<?php echo base_url();?>contact">Contact Us</a></li>
										<li><a href="<?php echo base_url();?>confirm">Konfirmasi Pembayaran</a></li>
										<li>
											<div class="nav-search">
												<form id="nav-search" class="position-relative" action="<?php echo base_url().'search';?>">
													<input type="text" class="form-control" placeholder="Saya cari..." value="<?php echo (isset($search)) ? $search : ''; ?>" onkeypress="product_search(event)" name="q" id="search_text" />
													<button type="submit" id="search-submit"><i class="icon ic-search"></i></button>
												</form>
											</div>
										</li>
									</ul>
								</div> <!-- //menu -->
							</div> <!-- //container -->

							<!-- Modal Search -->
							<div id="read-more" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<!-- konten modal-->
									<div class="modal-content">
										<!-- heading modal -->
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Cari produk...</h4>
										</div>
										<!-- body modal -->
										<div class="modal-body">
											<form method="GET" action="<?php echo base_url().'search';?>">
												<input type="text" class="form-control" placeholder="Cari produk berdasarkan nama, kode produk atau tag..." value="<?php echo (isset($search)) ? $search : ''; ?>" onkeypress="product_search(event)" name="q" id="search_text" />
												<br><button type="submit" id="search-submit" class="btn btn-default"><i class="fa fa-search"></i> Cari..</button>
											</form>
										</div>
										<!-- footer modal -->
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>

							<div class="box-icon">
								<ul class="nav navbar-nav navbar-right">
									<li class="search">
										<a href="#" class="position-relative u_icon search" data-toggle="modal" data-target="#read-more"></a>
										<div class="dropdown-menu no-shadow padding5">
											<form id="search" class="position-relative" action="<?php echo base_url().'search';?>">
												<input type="text" class="form-control" placeholder="Saya cari..." value="<?php echo (isset($search)) ? $search : ''; ?>" onkeypress="product_search(event)" name="q" id="search_text" />
												<button type="submit" id="search-submit"><i class="icon ic-search"></i></button>
											</form>
										</div>
									</li>
									<!-- Cart -->
									<li class="cart dropdown">
										<a href="#" class="position-relative dropdown-toggle cart c_icon" data-toggle="dropdown" role="button">
											<?php
												$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
												$count_order = count($get_session_arr);
									        ?>
											<!-- <span class="count text-center text-white"><?php echo $count_order;?></span> -->
										</a>
										
										<div class="dropdown-menu no-shadow shopping-cart">
											<ul class="shopping-cart-items">
												<li class="clearfix title text-center sub">
													<b>Keranjang Belanja</b>
												</li>
												<?php
													$get_session_arr=isset($_SESSION['order'])?$_SESSION['order']:array();
													$list = array_slice($get_session_arr,0,2);
													foreach ($list AS $item) {
										        ?>
												<li class="clearfix noborder">
													<?php $image_default = $this->db->query('SELECT * FROM image_product WHERE product_id="'.$item['product_id'].'" LIMIT 1')->row(); ?>
													<img src="<?php echo base_url();?>upload/images/product/<?php echo $image_default->image_product_file_name;?>" width="70px" alt="item1" />
													<span class="item-name"><b><?php echo $item['product_name'];?></b></span>
													<a href="<?php echo base_url();?>mycart/delete/<?php echo $item['product_id'];?>">
														<span class="item-remove icon ic-clear text-center" role="button"></span>
													</a>
													<span class="item-quantity text-muted"><?php echo $item['product_qty'];?> item(s)</span>
													<span class="item-price">
														Rp<b><span class="idr text-right"><?php echo $item['product_price_discount']>'0' ? number_format($item['product_price']*$item['product_qty'],0) : number_format($item['product_price_sell']*$item['product_qty'],0)?></span></b>
													</span>
												</li>
												<?php } ?>
												
												<li class="clearfix">
													<div style="margin-bottom:10px;">
														<div class="col-xs-6">
															<a href="<?php echo base_url();?>mycart" class="btn btn-default btn-block">Lihat semua</a>
														</div> <!-- //back shopping -->
														
														<div class="col-xs-6">
															<a href="<?php echo base_url();?>checkout" class="btn btn-warning btn-block">Checkout</a>
														</div> <!-- //checkout -->
													</div>
												</li>
											</ul>
										</div>
									</li> 
									
								</ul>
							</div>
							
						</div>
					</div>
				</div>

			</div> <!-- // top-header -->
			
		</nav> <!-- //navbar -->
	</header> <!-- //header -->

	<script>
	    function product_search(e) {
	        if (e.keyCode == 13) {
	            var tb = document.getElementById("search_text").value;
	            if (tb != '') {
	                location.href = '<?php echo base_url() ?>search?q=' + tb;
	            } else {
	                location.href = '<?php echo base_url() ?>search';
	            }
	            return true;
	        }
	    }
	</script>