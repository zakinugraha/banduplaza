  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Bank
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Brand Privacy Return</a></li>
        <li class="active">Semua Bank</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php echo $this->session->flashdata('message') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <a  href="<?php echo base_url();?>admin/brand/add"><button type="button" class="btn btn-primary"><i class="fa fa-plus" style="margin-right:5px;"></i> Tambah Brand Baru</button></a>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">                  
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table" id="tablebody">
                <tr>
                  <th>#</th>
                  <th>Logo</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Privacy Return</th>
                  <th style="width:100px;">Aksi</th>
                </tr>
                <?php
                  $no=0;
                  foreach ($list AS $row) {
                ?>
                <tr>
                  <td><?php echo ++$no;?></td>
                  <td><img src="<?php echo base_url().'upload/images/brands/'.$row->brand_logo;?>" width="145px"></td>
                  <td><?php echo $row->brand_name;?></td>
                  <td><span class="label label-<?php echo $row->brand_status=="enabled"?"success":"danger";?>"><?php echo $row->brand_status;?></span></td>
                  <td><?php echo substr($row->brand_privacy_return, 0, 500);?></td>
                  <td>
                    <a href="<?php echo base_url();?>admin/brand/edit/<?php echo $row->brand_id;?>" class="btn btn-danger btn-xs" title="Ubah"><i class="fa fa fa-pencil"></i></a>
                    <a href="<?php echo base_url();?>admin/brand/delete/<?php echo $row->brand_id;?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash-o"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <?php echo $pagination; ?>
              </ul>
            </div>
          </div>
          <!-- /.box -->

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->