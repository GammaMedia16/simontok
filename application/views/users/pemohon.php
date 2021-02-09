<?php
  $title = "Data Pemohon Perizinan Online";
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
                  <h3 class="panel-heading">Data Pemohon</h3>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <div class="alert" style="display: none;"></div>
                    <div class="table-responsive col-xs-12">
                          <table id="mdiTable" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>NAMA </th>
                                <th>USERNAME </th>
                                <th>ROLE</th>
                                <th>ID USER SIPOT</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->nama_user ?></td>
                                <td><?= $row->username ?></td>
                                <td><?= $row->role ?></td>
                                <td><?= $row->id_user_sipot ?></td>
                                
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