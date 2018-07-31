<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Pengguna
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Pengguna</a></li>
        <li class="active">Semua Artikel</li>
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
              <a  href="<?php echo base_url();?>admin/employees/tambah"><button type="button" class="btn btn-primary"><i class="fa fa-plus" style="margin-right:5px;"></i> Tambah Pengguna Baru</button></a>
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
              <table class="table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Pengguna</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Tanggal Daftar</th>
                  <th style="width: 70px">Aksi</th>
                </tr>
                <?php
                  $no=1;
                  foreach ($list AS $row) {
                ?>
                <tr>
                  <td><?php echo $no++;?></td>
                  <td>
                    <a href="<?php echo base_url();?>admin/employees/ubah/<?php echo $row->employees_id;?>"><strong><?php echo $row->name;?></strong></a>
                  </td>
                  <td><?php echo $row->username;?></td>
                  <td><?php echo $row->email;?></td>
                  <td><span class="label label-info"><?php echo ucfirst($row->status_user);?></span></td>
                  <td><?php echo full_parsing_date($row->registration_date);?></td>
                  <td>
                    <a href="<?php echo base_url();?>admin/employees/ubah/<?php echo $row->employees_id;?>" class="btn btn-danger btn-xs" title="Ubah"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo base_url();?>admin/employees/hapus/<?php echo $row->employees_id;?>" onclick="return confirm('Hapus data?')" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash-o"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <?php echo $pagination; ?>
                <!-- <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li> -->
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