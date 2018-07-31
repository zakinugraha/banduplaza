  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Halaman
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Halaman</a></li>
        <li class="active">Semua Halaman</li>
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
              <a  href="<?php echo base_url();?>admin/pages/add"><button type="button" class="btn btn-primary"><i class="fa fa-plus" style="margin-right:5px;"></i> Tambah Banner Baru</button></a>
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
                  <th>Title</th>
                  <th>Deskripsi</th>
                  <th style="width:100px;">Aksi</th>
                </tr>
                <?php
                  $no=0;
                  foreach ($list AS $row) {
                ?>
                <tr>
                  <td><?php echo ++$no;?></td>
                  <td><?php echo $row->pages_title;?></td>
                  <td><?php echo substr($row->pages_content, 0, 150);?></td>
                  <td>
                    <a href="<?php echo base_url();?>admin/pages/edit/<?php echo $row->pages_id;?>" class="btn btn-danger btn-xs" title="Ubah"><i class="fa fa fa-pencil"></i></a>
                    <a href="<?php echo base_url();?>admin/pages/delete/<?php echo $row->pages_id;?>" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash-o"></i></a>
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