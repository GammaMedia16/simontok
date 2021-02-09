<?php
  $title = "Edit Data User";
  $icon = "fa fa-users";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
$user_id = $this->session->user_id;
  //$this->load->view('design/header');
?>
<!-- Main content -->

<!-- Info paneles -->
<!-- Main row -->
<div class="row">
   <?php if($this->session->sub_role == 3) { ?>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading">Edit Data Pengguna</h3>
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <form id="userEditForm" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?= $record->id_user ?>"/>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $record->nama_user ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Jenis Kelamin</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="gender" id="gender" value="<?= $record->gender ?>" placeholder="L/P"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Username</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="username" id="username" value="<?= $record->username ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Satuan Kerja</label>
                        <div class="col-lg-8">
                            <input type="text" readonly="" class="form-control" name="nama_satker" id="nama_satker" value="<?= $record->nama_satker ?>"/>
                            <input type="hidden" class="form-control" name="satker_kode" id="satker_kode" value="<?= $record->satker_kode ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" onclick="location.href='<?=base_url('admin/users')?>'" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
    <?php } ?>
    <?php if($record->id_user == $user_id && $this->session->sub_role == 4) { ?>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading">Edit Data Pengguna</h3>
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <form id="userEditForm" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?= $record->id_user ?>"/>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $record->nama_user ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Jenis Kelamin</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="gender" id="gender" value="<?= $record->gender ?>" placeholder="L/P"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Username</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="username" id="username" value="<?= $record->username ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Satker</label>
                        <div class="col-lg-8">
                            <input type="text" readonly="" class="form-control" name="nama_satker" id="nama_satker" value="<?= $record->nama_satker ?>"/>
                            <input type="hidden" class="form-control" name="satker_kode" id="satker_kode" value="<?= $record->satker_kode ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
    <?php } ?>
    <?php if($record->id_user == $this->session->user_id || $this->session->roles_id == 1) { ?>
              <div class="col-md-6">
              <!-- Profile Image -->
              <!-- Profile Image -->
              <div class="panel panel-default">
                <div class="panel-header with-border">
                  <h3 class="panel-heading">Form Ubah Password</h3>
                </div>
                <div class="panel-body ">
                  <form id="userChangePass" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-5 control-label">Old Password</label>
                        <div class="col-lg-6">
                            <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?= $record->id_user ?>"/>
                            <input type="hidden" class="form-control" name="oldpass" id="oldpass" value="<?php echo $record->password ?>"/>
                            <input type="password" class="form-control" name="old_password" id="old_password" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-5 control-label">New Password</label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" name="new_password" id="new_password" value=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-5 control-label">Confirm New Password</label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" value=""/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-5">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" onclick="location.href='<?=base_url('admin/users')?>'" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              </div><!-- /.col -->
    <?php } ?>
</div><!-- /.row -->

<script src="<?=base_url('assets/dist/js/content/users.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>