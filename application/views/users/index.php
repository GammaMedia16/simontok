<?php
  $title = $judul;
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
                  <h3 class="panel-heading"><?= $title ?></h3>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <?php 
                    $access = $this->session->sub_role;
                    if (!$access) { $access = 0; }
                    if ($access == 3) { ?>
                        <div class="col-lg-12">
                            <a href="<?=base_url('admin/users/create');?>" class="btn btn-primary">
                            <i class="fa fa-user-plus"></i>&nbsp;&nbsp;TAMBAH DATA PENGGUNA
                            </a>
                            <br><br><br>
                        </div>
                        
                        
                    <?php } ?>
                    <div class="alert" style="display: none;"></div>
                    <div class="table-responsive col-xs-12">
                          <table id="tableKu" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="5%">NO</th>
                                <th width="25%">NAMA </th>
                                <th width="15%">USERNAME </th>
                                <th width="15%">PASSWORD</th>
                                <th width="15%">ROLE</th>
                                <th width="15%">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->nama_user ?></td>
                                <td><?= $row->username ?></td>
                                <td><?= $row->password ?></td>
                                <td><?= $row->subrole ?></td>
                                <td>
                                  <button onclick="location.href='<?=base_url('admin/users/edit/'.$row->id_user.'');?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                  <button id="deleteUser" onclick="deleteUser(<?= $row->id_user ?>)" type="button" class="btn btn-xs btn-danger"><i class="fa fa-close"></i>&nbsp;Delete</button>
                                </td>
                            </tr>
                            <?php $no++; } ?>
                            </tbody>
                          </table>
                    </div>
                    </div>
                </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?=base_url('assets/dist/js/content/users.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>