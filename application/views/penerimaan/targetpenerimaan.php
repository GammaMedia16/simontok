<?php
  $title = "Target Penerimaan";
  $icon = "fa fa-plus";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<!-- Main content -->
<section class="content">
<!-- Info boxes -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title"><?= $title ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                    <div class="col-lg-12 pull-right">
                    <form method="post" role="form" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Jenis Kegiatan</label>
                          <div class="col-lg-4">
                          <select name="tallysheet" id="tallysheet" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                                <?php if ($tall_exist == 0) { ?>
                                    <option selected value="0">SEMUA DATA</option>
                                <?php } else { ?>
                                    <option value="0">SEMUA DATA</option>
                                <?php } ?>
                                <?php foreach ($dataTallysheet as $row1) { ?>
                                    <?php if ($tall_exist == $row1->id) { ?>
                                    <option selected value="<?= $row1->id ?>"><?= ucwords($row1->name) ?></option>
                                    <?php } else { ?>
                                    <option value="<?= $row1->id ?>"><?= ucwords($row1->name) ?></option>
                                    <?php } ?>
                                <?php } ?>
                                
                            </select>
                          </div>
                          <label class="col-lg-2 control-label">Resort</label>
                          <div class="col-lg-4">
                          <select name="resort" id="resort" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                                <?php if ($res_exist == 0) { ?>
                                    <option selected value="0">SEMUA DATA</option>
                                <?php } else { ?>
                                    <option value="0">SEMUA DATA</option>
                                <?php } ?>
                                <?php foreach ($dataRes as $row) { ?>
                                    <?php if ($res_exist == $row->id) { ?>
                                    <option selected value="<?= $row->id ?>"><?= $row->nama_resort ?></option>
                                    <?php } else { ?>
                                    <option value="<?= $row->id ?>"><?= $row->nama_resort ?></option>
                                    <?php } ?>
                                <?php } ?>
                                
                            </select>
                          </div>
                        </div>
                    </form>
                    </div>
                    <?php 
                    $user_id = $this->session->user_id;
                    $access = $this->session->roles_id;
                    $sub_role = $this->session->sub_role;
                    if (!$access) { $access = 0; }
                    if ($access == 2) { ?>
                    <div class="col-lg-12">
                        <br>
                        <a href="<?=base_url();?>tallysheet/formadd" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>INPUT DATA MONITORING</strong></a>
                        <br><br>
                    </div>
                    <?php } ?>
                    
                    <div class="table-responsive col-lg-12">
                          <table id="tableTallysheet" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>JENIS KEGIATAN</th>
                                <th>WAKTU</th>
                                <th>LOKASI</th>
                                <th>AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                              <tr>
                                <td><?= $row->id_data_monitoring ?></td>
                                <td><?= ucwords($row->name) ?></td>
                                <td><?php $waktu = date_create($row->date_time); echo date_format($waktu, 'd M Y H:i:s'); ?></td>
                                <td>
                                  <?= $row->lat.','.$row->lon ?>
                                  <hr style="margin-top:5px;margin-bottom:5px;">
                                  <?= $row->nama_resort ?>
                                </td>
                                <td >
                                    <table width="100%">
                                        <tr>
                                          <td>
                                            <?php if ($sub_role == 4) { ?>
                                                <button onclick="location.href='<?=base_url('tallysheet/validasi/'.$row->id_data_monitoring);?>'" type="button" class="btn btn-sm btn-danger"><i class="fa fa-check"></i>&nbsp;Validasi</button>
                                            <?php } ?>
                                            <?php if ($sub_role == 6 && $row->resort_id <= 3) { ?>
                                                <button onclick="location.href='<?=base_url('tallysheet/validasi/'.$row->id_data_monitoring);?>'" type="button" class="btn btn-sm btn-danger"><i class="fa fa-check"></i>&nbsp;Validasi</button>
                                            <?php } ?>
                                            <?php if ($sub_role == 7 && $row->resort_id >= 4 && $row->resort_id <= 7) { ?>
                                                <button onclick="location.href='<?=base_url('tallysheet/validasi/'.$row->id_data_monitoring);?>'" type="button" class="btn btn-sm btn-danger"><i class="fa fa-check"></i>&nbsp;Validasi</button>
                                            <?php } ?>
                                            <?php if ($sub_role == 8 && $row->resort_id >= 8) { ?>
                                                <button onclick="location.href='<?=base_url('tallysheet/validasi/'.$row->id_data_monitoring);?>'" type="button" class="btn btn-sm btn-danger"><i class="fa fa-check"></i>&nbsp;Validasi</button>
                                            <?php } ?>
                                            <?php if ($access == 2 && $user_id == $row->user_input) { ?>
                                                <button onclick="location.href='<?=base_url('tallysheet/edit/'.$row->id_data_monitoring);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                            <?php } ?>
                                            
                                            <button id="" onclick="detailDataMonitoring(<?= $row->id_data_monitoring ?>)" type="button" class="btn btn-xs btn-info"><i class="fa fa-info"></i>&nbsp;Detail</button></td>
                                        </tr>
                                    </table>
                                    
                                    
                                </td>
                              </tr>
                            <?php $no++; } ?>
                            </tbody>
                          </table>
                    </div>
                    </div>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
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
</section>
<script src="<?=base_url('assets/dist/js/content/tallysheet.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>