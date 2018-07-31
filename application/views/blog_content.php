<main id="main-content" class="main-content grey">
	<div class="information-product">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<ol class="breadcrumb trans">
						<li><a href="<?php echo base_url();?>" class="home"><i class="fa fa-home"></i></a></li>
						<li class="slash"><span>/</span></li>
						<li><a href="<?php echo base_url();?>blog">Blog</a></li>
						<li class="slash"><span>/</span></li>
						<li><a><?php echo $content->blogcontent_title;?></a></li>
					</ol>
				</div> <!-- //col -->
			</div>
		</div>
	</div> <!-- information-product -->

	<section id="blog-content" class="blog-content">
		
		<div class="blog-detail">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
					
						<div class="content-blog">
							<div class="title">
								<h1><?php echo $content->blogcontent_title;?></h1>
								<div class="note"><span>Ditulis oleh Admin, <?php echo full_parsing_date($content->blogcontent_date);?></span></div>
							</div>
							<div class="article-content">
								<?php 
									echo '<p><img src="http://www.banduplaza.com/upload/images/banner/banner-foster-min.jpg" style="width:100%"></p>';
									echo $content->blogcontent_description;
								?>
							</div>
							<div class="tag">
								<ul>
									<li>
										<a class="love" title="<?php echo $content->blogcontent_like<5?'5':$content->blogcontent_like;?> orang menyukai artikel ini"><?php echo $content->blogcontent_like<5?'5':$content->blogcontent_like;?></a>
									</li>
									<li>
										<a class="view" title="artikel ini sudah dibaca sebanyak <?php echo $content->blogcontent_view<10?'10':$content->blogcontent_view;?> kali"><?php echo $content->blogcontent_view<10?'10':$content->blogcontent_view;?></a>
									</li>
									<li>
										<a class="tags"><?php echo ucfirst($content->blogcontent_label);?></a>
									</li>
								</ul>
							</div>
						</div>

						<div class="similiar-article">
							<label>Artikel Terkait</label>
							<div class="similiar-box">
								<div class="col-md-3">
									<a href="#" class="same-height">
										<img src="<?php echo base_url();?>upload/images/artikel/artikel_1487075063.jpg" class="img-responsive">
										<div class="box">
											<h3>Gara-gara Keenan Pearce, Hamish Daud Gak Jadi Berantem Sama Pasangannya</h3>
											
										</div>
									</a>
								</div>
								<div class="col-md-3">
									<a href="#" class="same-height">
										<img src="<?php echo base_url();?>upload/images/artikel/artikel_1487075108.jpg" class="img-responsive">
										<div class="box">
											<h3>Gara-gara Keenan Pearce, Hamish Daud Gak Jadi Berantem Sama Pasangannya</h3>
											
										</div>
									</a>
								</div>
								<div class="col-md-3">
									<a href="#" class="same-height">
										<img src="<?php echo base_url();?>upload/images/artikel/artikel_1487075063.jpg" class="img-responsive">
										<div class="box">
											<h3>Gara-gara Keenan Pearce, Hamish Daud Gak Jadi Berantem Sama Pasangannya</h3>
											
										</div>
									</a>
								</div>
								<div class="col-md-3">
									<a href="#" class="same-height">
										<img src="<?php echo base_url();?>upload/images/artikel/artikel_1487076450.jpg" class="img-responsive">
										<div class="box">
											<h3>Gara-gara Keenan Pearce, Hamish Daud Gak Jadi Berantem Sama Pasangannya</h3>
											
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="popular-article">
							<label>Artikel Populer</label>

							<div class="list-popular">
								<a href="#">
									<img src="<?php echo base_url();?>upload/images/artikel/<?php echo $most_popular->blogcontent_thumb;?>" class="img-responsive">
									<div class="title-popular">
										<h3><?php echo $most_popular->blogcontent_title;?></h3>
									</div>
								</a>
							</div>
							
							<?php foreach ($popular AS $pop) { ?>
							<div class="list-popular">
								<a href="#">
									<div class="title-popular">
										<h3><?php echo $pop->blogcontent_title;?></h3>
									</div>
								</a>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>

				
			</div>
		</div>

	</section>
</main>