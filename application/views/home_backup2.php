    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/plugins/responsiveimage/css/demo_thumb.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/plugins/responsiveimage/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/front/plugins/responsiveimage/css/elastislide.css" />

    <main id="main" class="main">

    <!-- Banner -->
    <section id="banner-slide" class="banner-slide">      
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <a href="<?php echo base_url();?>product/brand/pria/footstep">
                <img src="<?php echo base_url();?>upload/images/banner/banner1.jpg" alt="jaket bomber">
              </a>
            </div>

            <div class="item">
              <a href="<?php echo base_url();?>product/brand/pria/moofeat">
                <img src="<?php echo base_url();?>upload/images/banner/banner2.jpg" alt="tas">
              </a>
            </div>
          </div>

          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <img src="<?php echo base_url();?>assets/front/images/banner.png" class="img-responsive">
    </section>  

    <section id="banner-category" class="banner-category">
        <div class="container">
          <div class="col-md-6">
            <div class="row">
              <div class="box">
                <a href="<?php echo base_url();?>shop/shoes">
                  <img src="<?php echo base_url();?>upload/images/banner/banner_category_shoes.jpg" class="img-responsive">
                </a>
                <div class="list">
                  <ul>
                    <li><a href="<?php echo base_url();?>brand/footstep-footwear">Footstep Footwear</a></li>
                    <li><a href="<?php echo base_url();?>brand/moofeat">Moofeat</a></li>
                    <li><a href="<?php echo base_url();?>brand/toods-footwear">Toods Footwear</a></li>
                    <li><a href="<?php echo base_url();?>search?q=sepatu+gunung">Trekking</a></li>
                    <li><a href="<?php echo base_url();?>brand/zapato">Zapato</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="box">
                <a href="<?php echo base_url();?>shop/bag">
                  <img src="<?php echo base_url();?>upload/images/banner/banner_2.jpg" class="img-responsive">
                </a>
                <div class="list">
                  <ul>
                    <li><a href="<?php echo base_url();?>brand/firefly">Firefly Bags</a></li>
                    <li><a href="<?php echo base_url();?>brand/rayleigh">Rayleigh</a></li>
                    <li><a href="<?php echo base_url();?>brand/visval">Visval</a></li>
                    <li><a href="<?php echo base_url();?>brand/nvl">NVL</a></li>
                    <li><a href="<?php echo base_url();?>search?q=tas+gunung">Trekking</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>          
        </div>
      </section>  

    <section id="display-middle" class="display-middle">
      <div class="image">
        <a href="#">
          <img src="<?php echo base_url();?>upload/images/display/footstep-leather.jpg" class="img-responsive">
        </a>
      </div>

      <div class="image">
        <a href="#">
          <img src="<?php echo base_url();?>upload/images/display/bag-footstep.jpg" class="img-responsive">
        </a>
      </div>

      <div class="image">
        <a href="#">
          <img src="<?php echo base_url();?>upload/images/display/smooth-footstep.jpg" class="img-responsive">
        </a>
      </div>
      <div class="image">
        <a href="#">
          <img src="<?php echo base_url();?>upload/images/display/zapato-footwear.jpg" class="img-responsive">
        </a>
      </div>

      <div class="image">
        <a href="#">
          <img src="<?php echo base_url();?>upload/images/display/moofeat-haven.jpg" class="img-responsive">
        </a>
      </div>

      <div class="image">
        <a href="#">
          <img src="<?php echo base_url();?>upload/images/display/nvl-bag.jpg" class="img-responsive">
        </a>
      </div>

        
    </section>

    <!-- <section id="bottom-banner" class="bottom-banner">
      <div class="container">
        <div class="col-md-4">
          <a href="#"><img src="<?php echo base_url();?>upload/images/display/1.webp" class="img-responsive"></a>
        </div>
        <div class="col-md-4">
          <a href="#"><img src="<?php echo base_url();?>upload/images/display/2.webp" class="img-responsive"></a>
        </div>
        <div class="col-md-4">
          <a href="#"><img src="<?php echo base_url();?>upload/images/display/3.webp" class="img-responsive"></a>
        </div>
      </div>
    </section>

    <section id="bottom-banner-two" class="bottom-banner-two">
      <div class="container">
        <div class="col-md-12">
          <a href="#"><img src="<?php echo base_url();?>upload/images/display/4.webp" class="img-responsive"></a>
        </div>
      </div>
    </section> -->

    <!-- Shop by Category -->
    <section id="by_category" class="by_category">
      <div class="container">
        <div class="col-md-4">
          <div class="title-display">
            <h4>What's New On Moofeat</h4>
          </div>
          <a href="<?php echo base_url();?>product/brand/pria/moofeat?price=n&amp;sort_by=price-low">
            <img src="<?php echo base_url();?>upload/images/display/moofeat.jpg" class="img-responsive" style="margin-bottom:15px;">
          </a>
          <a href="<?php echo base_url();?>product/brand/pria/moofeat">
            <img src="<?php echo base_url();?>upload/images/display/sep.jpg" class="img-responsive">
          </a>
          
        </div>

        <div class="col-md-8">
          <div class="content">
            <div id="rg-gallery" class="rg-gallery">
              <div class="rg-thumbs">
                
                <div class="es-carousel-wrapper">
                  <div class="es-carousel">
                    <ul>
                      <li>
                        <a href="<?php echo base_url();?>search?q=sepatu+casual">
                          <img src="<?php echo base_url();?>upload/images/category/display_fstp.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" />
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url();?>product/brand/pria/nvl">
                          <img src="<?php echo base_url();?>upload/images/category/display_nvl1.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" />
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url();?>product/brand/pria/footstep">
                          <img src="<?php echo base_url();?>upload/images/category/display_fstp2.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" />
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url();?>product/brand/pria/footstep?price=n&amp;sort_by=price-low">
                          <img src="<?php echo base_url();?>upload/images/category/display1.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" />
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url();?>search/?q=backpack&amp;price=n&amp;sort_by=price-high">
                          <img src="<?php echo base_url();?>upload/images/category/display_nvl3.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" />
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- End Elastislide Carousel Thumbnail Viewer -->
              </div><!-- rg-thumbs -->
            </div><!-- rg-gallery -->
          </div><!-- content -->     
          
        </div>

        <div class="col-md-12">
          <img src="<?php echo base_url();?>upload/images/display/banner-bottom.png" class="img-responsive" style="margin-bottom:15px;">
        </div>

      </div>
    </section>

    <section id="is_content_bottom" class="is_content_bottom">
      <div class="container">
        <div class="col-md-12">
          <div class="line-behind-title text-uppercase text-center">
            <div class="separator-line">
              <span>Discover More</span>
            </div>
          </div>
        </div>
        
        <div class="box">
          <div class="col-md-4">
            <a href="<?php echo base_url();?>product/brand/pria/epic-holiday">
              <img src="<?php echo base_url();?>upload/images/display/eh.jpg" class="img-responsive">
            </a>
            <div style="margin:20px 0 30px;"> 
              <h4 class="head">Exclusive From Epic Holiday</h4>
              <p class="desc-head">Dapatkan Koleksi Ekslusif Original by Epic Holiday</p>      
            </div>        
          </div>
          <div class="col-md-4">
            <a href="<?php echo base_url();?>search?q=hijacket">
              <img src="<?php echo base_url();?>upload/images/display/hijacket.jpg" class="img-responsive">
            </a>     
            <div style="margin:20px 0 30px;">         
              <h4>Hijacket for Hijabers</h4>
              <p>Produk terbaru untuk kamu hijabers agar terlihat makin cantik dan trendi</p>  
            </div>            
          </div>
          <div class="col-md-4">
            <a href="#">
              <img src="<?php echo base_url();?>upload/images/display/pick.jpg" class="img-responsive">
            </a>
            <div style="margin:20px 0 30px;"> 
              <h4>Pick Your Style</h4>
              <p>Pilih fashion sesuai dengan selera dan gaya kamu</p>
            </div>
          </div>
        </div>     
            
      </div>
    </section>

    
    
    <section id="is_content_bottom" class="is_content_bottom">
      <div class="container">
        <div class="col-md-12">
          <div class="line-behind-title text-uppercase text-center">
            <div class="separator-line">
              <span>Hot This Week</span>
            </div>
          </div>
        </div>

        <div class="top">
          <div class="col-md-8">
            <a href="<?php echo base_url();?>search?q=dress"><img src="<?php echo base_url();?>upload/images/display/d1.jpg" class="img-responsive"></a>    
          </div>
          <div class="col-md-4">
            <a href="<?php echo base_url();?>product/item/pria/sepatu"><img src="<?php echo base_url();?>upload/images/display/d2.jpg" class="img-responsive"></a>    
          </div>
        </div>
        <div class="bottom">
          <div class="col-md-4">
            <a href="<?php echo base_url();?>search?q=jaket+pria"><img src="<?php echo base_url();?>upload/images/display/d3.jpg" class="img-responsive"></a>    
          </div>
          <div class="col-md-8">
            <a href="<?php echo base_url();?>search?q=hijacket"><img src="<?php echo base_url();?>upload/images/display/d4.jpg" class="img-responsive"></a>    
          </div>
        </div>
      </div>
    </section>

    <section id="is_text" class="is_text">
      <div class="container">
        <div class="col-md-6">
          <p>
            Banduplaza adalah website jual beli online yang khusus bergerak di bidang fashion pria dan wanita. Dengan mengedepankan
            produk-produk lokal menjadi lebih dikenal.
          </p>
        </div>

        <div class="col-md-6">
          <p>
            Bandung selama ini dikenal dengan industri kreatif. Terutama di bidang fashion pria dan wanita. Maka tak heran mendapat
            julukan Paris Van Java. Dengan ini, banduplaza hadir sebagai solusi untuk masyarakat yang selama ini menjadikan Bandung
            sebagai kiblat dalam fashion sehari-hari.
          </p>
        </div>
      </div>
    </section>

    
  </main> <!-- //main -->
  
  <script type="text/javascript" src="<?php echo base_url();?>assets/front/plugins/responsiveimage/js/jquery.tmpl.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/front/plugins/responsiveimage/js/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/front/plugins/responsiveimage/js/jquery.elastislide.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/front/plugins/responsiveimage/js/gallery.js"></script>