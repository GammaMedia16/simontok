<?php
  $title = "Peta Hasil Monitoring";
  $icon = "fa fa-map-o";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  $user_id = $this->session->user_id;
?>
<!-- Main content -->
<section class="content">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= 'Filter Data '.$title ?></h3>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                    <div class="col-lg-12 pull-right">
                    <form method="post" role="form" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Jenis Kegiatan</label>
                          <div class="col-lg-4">
                          <select name="tallysheet" id="tallysheet" class="form-control select2" style="width: 100%;">
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
                          <label class="col-lg-2 control-label">Kawasan</label>
                          <div class="col-lg-4">
                          <select name="kk" id="kk" class="form-control select2" style="width: 100%;" >
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
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Tanggal</label>
                            <div class="col-lg-6 inputGroupContainer date">
                                <div class="input-group input-append date">
                                    <input type="text" class="form-control" id="inputTglIns0" name="dari" style="cursor: pointer" value="<?= date('Y').'-01-01' ?>" placeholder="YYYY-MM-DD"/>
                                    <span class="input-group-addon add-on">s.d.</span>
                                    <input type="text" class="form-control" id="inputTglIns1" name="sampai" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-12 col-lg-offset-5">
                              <button id="" type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lihat Data</button>
                          </div>
                        </div>
                    </form>
                    </div>
                    </div>
                </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
<div class="row">
  <div class="col-lg-12">
    <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading"><?= $title ?>
              </h3>
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <?= $map['html']?> 
            </div>
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</div><!-- /.col -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?></h3>
                </div><!-- /.panel-header -->
                <div class="panel-body">
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
                                            <?php
                                            $arr_petugas = explode(';', $row->petugas_id); 
                                            if (in_array($user_id, $arr_petugas)) { ?>
                                                <a target="_blank" href="<?=base_url('tallysheet/cetaklaporan/'.$row->id_data_monitoring.'/'.$user_id);?>" class="btn btn-xs btn-success"><i class="fa fa-print"></i>&nbsp;Unduh Laporan</a>
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
</section>
<?= $map['js']; ?>
<script src="<?=base_url('assets/dist/js/content/tallysheet.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>