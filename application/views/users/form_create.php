<?php
  $title = "Create Data Admin";
  $icon = "fa fa-users";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<!-- Main content -->

<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading">Input Data Pengguna</h3>
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <form id="userCreateForm" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="nama" id="nama" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Jenis Kelamin</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="gender" id="gender" value="" placeholder="L/P"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Username</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="username" id="username" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">New Password</label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" name="new_password" id="new_password" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Confirm Password</label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Sub Roles</label>
                        <div class="col-lg-6">
                            <select name="sub_role" id="sub_role" class="form-control" style="width: 100%;">
                              <?php foreach ($record1 as $row1) { ?>
                                <option value="<?=$row1->id_role ?>"><?= $row1->role ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Satuan Kerja</label>
                        <div class="col-lg-6">
                            <select name="satker_kode" id="satker_kode" class="form-control select2" style="width: 100%;">
                              <?php foreach ($record2 as $row2) { ?>
                                <option value="<?=$row2->kode_satker ?>"><?= $row2->nama_satker ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" onclick="location.href='<?=base_url('admin/users')?>'" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->

<script src="<?=base_url('assets/dist/js/content/users.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>