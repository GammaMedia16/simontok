<?php
  $title = "Hasil Data Patroli";
  $icon = "fa fa-bar-chart";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<section class="content">
<div class="col-lg-12">
  <span style="font-size:16pt;font-weight:300;"><?= strtoupper($title)." : ".strtoupper($judul).' DI '.strtoupper($nama_resort) ?></span>
  <button type="button" onclick="location.href='<?=base_url('analisis')?>'" class="btn btn-warning pull-right"><i class="fa fa-chevron-circle-left"></i>&nbsp;Kembali</button><br><br>
</div>
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading"><?= "Data ".ucwords($judul)." Tahun ".date('Y') ?></h3>
                  
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <div class="chart-responsive">
                    <div>
                      <input type="hidden" class="form-control" name="t_id" id="t_id" value="<?= $t_id ?>"/>
                      <input type="hidden" class="form-control" name="r_id" id="r_id" value="<?= $r_id ?>"/>
                      <input type="hidden" class="form-control" name="ref_column" id="ref_column" value="<?= $ref_column ?>"/>
                      <input type="hidden" class="form-control" name="jml_ref_column" id="jml_ref_column" value="<?= $jml_ref_column ?>"/>
                      <input type="hidden" class="form-control" name="dari" id="dari" value="<?= $dari ?>"/>
                      <input type="hidden" class="form-control" name="sampai" id="sampai" value="<?= $sampai ?>"/>
                        <canvas id="barChartperBulan" style="width:100%"></canvas>
                    </div>
                    
                </div>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
        <div class="panel-footer with-border">
          <span class="text-muted">Sumber : Data Patroli yang Tervalidasi</span>
        </div><!-- /.panel-header -->
    </div><!-- /.col -->
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading"><?= "Data ".ucwords($judul)." per Tahun" ?></h3>
                  <div class="panel-tools pull-right">
                    <button class="btn btn-panel-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <div class="chart-responsive">
                    <div>
                        <canvas id="barChartperTahun" style="width:100%"></canvas>
                    </div>
                    
                </div>
            </div><!-- /.panel-body -->
            <div class="panel-footer with-border">
          <span class="text-muted">Sumber : Data Patroli yang Tervalidasi</span>
        </div><!-- /.panel-header -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->
<div class="row">
    <?php for ($i=1; $i <= $jml_ref_column ; $i++) {  ?>
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-header">
              <h3 class="panel-heading"><div id="addJudul<?= $i ?>"></h3>
                  
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <div class="chart-responsive">
                    <div>
                        <canvas id="barChartAdd<?= $i ?>" style="width:100%"></canvas>
                        <div id="barLegendAdd<?= $i ?>"></div>
                    </div>
                    
                </div>
            </div><!-- /.panel-body -->
            <div class="panel-footer with-border">
          <span class="text-muted">Sumber : Data Patroli yang Tervalidasi</span>
        </div><!-- /.panel-header -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
    <?php } ?>
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
<script src="<?=base_url('assets/dist/js/content/hasil-resorttallysheet.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>