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
  <span style="font-size:16pt;font-weight:300;"><?= strtoupper($title).' DI '.strtoupper($nama_resort)." : ".$periode ?></span>
  <button type="button" onclick="location.href='<?=base_url('analisis')?>'" class="btn btn-warning pull-right"><i class="fa fa-chevron-circle-left"></i>&nbsp;Kembali</button>
  <input type="hidden" class="form-control" name="r_id" id="r_id" value="<?= $r_id ?>"/>
  <input type="hidden" class="form-control" name="dari" id="dari" value="<?= $dari ?>"/>
  <input type="hidden" class="form-control" name="sampai" id="sampai" value="<?= $sampai ?>"/><br><br>
</div>
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
      <div class="col-md-12">
        <div class="panel">
          <div class="panel-header with-border">
            <?php 
              
            ?>
            <h3 class="panel-heading">Rekap Monitoring Data <?= ucwords($nama_resort) ?> </h3>
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
  <?php $i = 1; foreach ($rTallysheet as $rTallysheet) {  
    if ($rTallysheet->reference_column != "") { 
    $arrColReff = explode(';', $rTallysheet->reference_column);
    if (count($arrColReff) > 1) {
      $ppanel = 12;
      $pchart = 6;
    } else {
      $ppanel = 6;
      $pchart = 12;
    }
    ?>
    <div class="col-lg-<?= $ppanel ?>">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading"><?= "Data ".ucwords($rTallysheet->name)." di ".ucwords($nama_resort) ?></h3>
                  <div class="panel-tools pull-right">
                    <input type="hidden" class="form-control" name="t_id" id="t_id" value="<?= $rTallysheet->tallysheet_id ?>"/>
                    <button class="btn btn-panel-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
            </div><!-- /.panel-header -->
            <div class="panel-body">
              <?php $c=1; foreach ($arrColReff as $rColReff) { ?>
              <div class="col-lg-<?= $pchart ?>">
                <div class="chart-responsive">
                  <p class="text-center">
                  <strong>
                    Rekap Data per <?= ucwords(str_replace("_", " ", $rColReff)) ?>
                  </strong></p>
                  <div>
                      <canvas id="barChartReff<?= $rTallysheet->tallysheet_id.$c ?>" style="width:100%"></canvas>
                      <div id="barLegendReff<?= $rTallysheet->tallysheet_id.$c ?>"></div>
                  </div>
                </div>
              </div>
              <?php if (($c % 2) == 0) {
                echo "<div class=\"clearfix\"> </div><br><br><br>";
              } ?>
              <?php $c++; } ?>
            </div><!-- /.panel-body -->
            <div class="panel-footer with-border">
          <span class="text-muted">Sumber : Data Patroli yang Tervalidasi</span>
        </div><!-- /.panel-header -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
    <?php }
    $i++; } ?>
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
<script src="<?=base_url('assets/dist/js/content/hasil-resort.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>