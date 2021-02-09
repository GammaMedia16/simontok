<?php
  $title = "Hasil Data Patroli";
  $icon = "fa fa-bar-chart";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  $tgldari = date_create($dari); 
  $tgl_dari = date_format($tgldari, 'd F Y');
  $tglsmp = date_create($sampai); 
  $tgl_sampai = date_format($tglsmp, 'd F Y');
  //-----------
  $periode = $tgl_dari.' - '.$tgl_sampai;
  //$this->load->view('design/header');
?>
<section class="content">
<div class="col-lg-12">
  <span style="font-size:16pt;font-weight:300;"><?= strtoupper($title).' : '.strtoupper($nama_petugas) ?></span>
  <br><br>
</div>
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?></h3>
                  
                </div><!-- /.panel-header -->
                <div class="panel-body">
                  <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                  <input type="hidden" class="form-control" name="dari" id="dari" value="<?= $dari ?>"/>
                  <input type="hidden" class="form-control" name="sampai" id="sampai" value="<?= $sampai ?>"/>
                  <input type="hidden" class="form-control" name="petugas_exist" id="petugas_exist" value="<?= $petugas_exist ?>"/>
                      <form id="" method="get" enctype="multipart/form-data" class="form-horizontal" >
                      <div class="form-group">
                        <label class="col-lg-4 control-label">Petugas</label>
                        <div class="col-lg-4">
                          <select name="petugas_id" id="petugas_id" class="form-control select2" style="width: 100%;" >
                                  <?php foreach ($dataPetugas as $row) { ?>
                                      <?php if ($petugas_exist == $row->id_user) { ?>
                                      <option selected value="<?= $row->id_user ?>"><?= $row->nama_user ?></option>
                                      <?php } else { ?>
                                      <option value="<?= $row->id_user ?>"><?= $row->nama_user ?></option>
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
                        <div class="col-lg-8 pull-right">
                          <button type="submit" class="btn btn-primary">Lihat Hasil</button>
                          <button type="button" onclick="location.href='<?=base_url('analisis/pegawai')?>'" class="btn btn-warning">Reset</button>
                        </div>
                      </div>
                    </form>
                </div>
                </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->

  <?php if ($view == true) { ?>
  <div class="row">
      <div class="col-md-12">
        <div class="panel">
          <div class="panel-header with-border">
            <h3 class="panel-heading">Rekap Monitoring Data : <?= $nama_petugas ?></h3>
          </div><!-- /.panel-header -->
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <p class="text-center">
                  <strong>Rekap Data Patroli: <?= $periode ?></strong>
                </p>
                <div >
                  <!-- Sales Chart Canvas -->
                  <canvas id="salesChart" style="height: 180px;"></canvas>
                </div><!-- /.chart-responsive -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- ./panel-body -->
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-green"><?= $countPNew ?>%</span>
                  <h5 class="description-header"><?= $countNew ?></h5>
                  <span class="description-text">DATA BELUM TERVALIDASI (BARU)</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-blue"><?= $countPValid ?>%</span>
                  <h5 class="description-header"><?= $countValid ?></h5>
                  <span class="description-text">DATA TERVALIDASI (VALID)</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-3 col-xs-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-red"><?= $countPTrash ?>%</span>
                  <h5 class="description-header"><?= $countTrash ?></h5>
                  <span class="description-text">DATA TIDAK VALID (SAMPAH)</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-3 col-xs-6">
                <div class="description-block">
                  <span class="description-percentage text-red"><?= $countPTotal ?>%</span>
                  <h5 class="description-header"><?= $countTotalData ?></h5>
                  <span class="description-text">TOTAL DATA MONITORING</span>
                </div><!-- /.description-block -->
              </div>

            </div><!-- /.row -->
          </div><!-- /.panel-footer -->
        </div><!-- /.panel -->
      </div><!-- /.col -->
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?></h3>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
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
                            <?php
                                  $arr_petugas = explode(';', $row->petugas_id); 
                                  if (in_array($petugas_exist, $arr_petugas)) { ?>
                              <tr>
                                <td><?= $row->id_data_monitoring ?></td>
                                <td><?= ucwords($row->name) ?></td>
                                <td><?php $waktu = date_create($row->date_time); echo date_format($waktu, 'd M Y H:i:s'); ?><br><span class="text-muted" style="font-size: 8pt">Diinput oleh: <?= $row->nama_user_input ?></span></td>
                                <td>
                                  <?= $row->lat.','.$row->lon ?>
                                  <hr style="margin-top:5px;margin-bottom:5px;">
                                  <?= $row->nama_resort ?>
                                </td>
                                <td >
                                      <a target="_blank" href="<?=base_url('tallysheet/cetaklaporan/'.$row->id_data_monitoring.'/'.$petugas_exist);?>" class="btn btn-xs btn-success"><i class="fa fa-print"></i>&nbsp;Unduh Laporan</a>
                                  
                                </td>
                              </tr>
                              <?php } ?>
                            <?php $no++; } ?>
                            </tbody>
                          </table>
                    </div>
                    </div>
                </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->
  <?php } ?>
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
<script src="<?=base_url('assets/dist/js/content/hasil-pegawai.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>