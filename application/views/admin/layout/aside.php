<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>assets/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['user_account']['name'];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo base_url();?>admin/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        
        <li class="treeview <?php echo $this->uri->segment(2)=="product" || $this->uri->segment(2)=="category"?"active":"";?>">
          <a href="#">
            <i class="fa fa-tags"></i>
            <span>Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $this->uri->segment(2)=="product"?"active":"";?>"><a href="<?php echo base_url();?>admin/product/all"><i class="fa fa-circle-o"></i> Product</a></li>
            <li class="<?php echo $this->uri->segment(2)=="category"?"active":"";?>"><a href="<?php echo base_url();?>admin/category"><i class="fa fa-circle-o"></i> Category</a></li>
          </ul>
        </li>

        <li class="treeview <?php echo $this->uri->segment(2)=="order"?"active":"";?>">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Order</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $this->uri->segment(2)=="order"?"active":"";?>"><a href="<?php echo base_url();?>admin/order/all"><i class="fa fa-circle-o"></i> Order</a></li>
            <li class="<?php echo $this->uri->segment(3)=="create"?"active":"";?>"><a href="<?php echo base_url();?>admin/order/create"><i class="fa fa-circle-o"></i> Create Order</a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo $this->uri->segment(2)=="popular_product"?"active":"";?>">
          <a href="#">
            <i class="fa fa-bar-chart"></i>
            <span>Statistic</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $this->uri->segment(2)=="popular_product"?"active":"";?>"><a href="<?php echo base_url();?>admin/popular_product/all"><i class="fa fa-circle-o"></i> Popular Product</a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo $this->uri->segment(2)=="report"?"active":"";?>">
          <a href="#">
            <i class="fa fa-file-text-o"></i>
            <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $this->uri->segment(3)=="sell"?"active":"";?>"><a href="<?php echo base_url();?>admin/report/sell"><i class="fa fa-circle-o"></i> Sell Report</a></li>
          </ul>
        </li>
        
        <li class="treeview <?php echo $this->uri->segment(2)=="employees" || $this->uri->segment(2)=="customer"?"active":"";?>">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $this->uri->segment(2)=="employees"?"active":"";?>"><a href="<?php echo base_url();?>admin/employees/all"><i class="fa fa-circle-o"></i> Employees</a></li>
            <li class="<?php echo $this->uri->segment(2)=="customer"?"active":"";?>"><a href="<?php echo base_url();?>admin/customer/all"><i class="fa fa-circle-o"></i> Customer</a></li>
          </ul>
        </li>

        <li class="treeview <?php echo $this->uri->segment(2)=="bank" || $this->uri->segment(2)=="brand" || $this->uri->segment(2)=="support" || $this->uri->segment(2)=="size_chart" || $this->uri->segment(2)=="promo" || $this->uri->segment(2)=="banner" || $this->uri->segment(2)=="pages" || $this->uri->segment(2)=="testimoni"?"active":"";?>">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Configuration</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo $this->uri->segment(2)=="banner"?"active":"";?>"><a href="<?php echo base_url();?>admin/banner/all"><i class="fa fa-circle-o"></i> Banner</a></li>
            <li class="<?php echo $this->uri->segment(2)=="pages"?"active":"";?>"><a href="<?php echo base_url();?>admin/pages/all"><i class="fa fa-circle-o"></i> Pages</a></li>
            <li class="<?php echo $this->uri->segment(2)=="bank"?"active":"";?>"><a href="<?php echo base_url();?>admin/bank/all"><i class="fa fa-circle-o"></i> Bank Payment</a></li>
            <li class="<?php echo $this->uri->segment(2)=="brand"?"active":"";?>"><a href="<?php echo base_url();?>admin/brand/all"><i class="fa fa-circle-o"></i> Brand Privacy Return</a></li>
            <li class="<?php echo $this->uri->segment(2)=="support"?"active":"";?>"><a href="<?php echo base_url();?>admin/support/all"><i class="fa fa-circle-o"></i> Support</a></li>
            <li class="<?php echo $this->uri->segment(2)=="size_chart"?"active":"";?>"><a href="<?php echo base_url();?>admin/size_chart/all"><i class="fa fa-circle-o"></i> Size Chart</a></li>
            <li class="<?php echo $this->uri->segment(2)=="promo"?"active":"";?>"><a href="<?php echo base_url();?>admin/promo/all"><i class="fa fa-circle-o"></i> Set Promo</a></li>
            <li class="<?php echo $this->uri->segment(2)=="testimoni"?"active":"";?>"><a href="<?php echo base_url();?>admin/testimoni/all"><i class="fa fa-circle-o"></i> Testimoni</a></li>
          </ul>
        </li>
        <li class="<?php echo $this->uri->segment(2)=="instagram" ? "active":"";?>"><a href="<?php echo base_url();?>admin/instagram"><i class="fa fa-instagram"></i> <span>Instagram</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>