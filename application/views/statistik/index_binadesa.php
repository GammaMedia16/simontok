<?php
  $title = $judul;
  $icon = "fa fa-bar-chart";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<section class="content">
<?php 
$access = $this->session->sub_role;
$roles = $this->session->roles_id;
?>

<div class="row"> 
  <div class="col-lg-12">
    <div class="panel panel-inverse">
      <div class="panel-header">
        <div class="panel-heading"><?= $title ?>
        <?php if ($this->session->sub_role != 4 ) { ?>
          <div class="panel-action">
            <a style="opacity: 1 !important;" href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a> 
          </div>
        <?php } ?>
        </div>
      </div><!-- /.panel-header -->
      <div class="panel-wrapper collapse">
        <div class="panel-body">
          <form id="filterResumePDSKK" method="post" role="form" class="form-horizontal">
            <div class="form-group">
              <?php if ($this->session->sub_role != 4 ) { ?>
              <label class="col-lg-2 control-label">Satuan Kerja</label>
              <div class="col-lg-4">
                <select onChange="this.form.submit()" name="satker_kode" id="satker_kode" class="form-control select2" style="width: 100%;" >
                        <?php if ($satker_exist == 0) { ?>
                            <option selected value="0">SEMUA DATA</option>
                        <?php } else { ?>
                            <option value="0">SEMUA DATA</option>
                        <?php } ?>
                        <?php foreach ($dataSatker as $row) { ?>
                            <?php if ($satker_exist == $row->kode_satker) { ?>
                            <option selected value="<?= $row->kode_satker ?>"><?= $row->nama_satker ?></option>
                            <?php } else { ?>
                            <option value="<?= $row->kode_satker ?>"><?= $row->nama_satker ?></option>
                            <?php } ?>
                        <?php } ?>
                </select>
              </div>
              <?php } ?>
            </div>
          </form>
        </div><!-- /.panel-body -->
      </div>
    </div><!-- /.panel -->
  </div><!-- /.col -->

  <div class="col-lg-6">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Pembiayaan Pemberdayaan Masyarakat
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline">
                <li style="width: 25% !important;"><i class="fa fa-money text-green" style="font-size: 28pt !important;"></i></li>
                <li style="width: 75% !important;float: right;" class="text-right">
                  Rp<span class="" style="font-size: 28pt !important;">
                  <?= number_format($dataBiayaPMTotal, 0, ',', '.') ?></span></li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartBiayaPMTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <div class="col-lg-6">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Masyarakat Terlibat Pembinaan Desa
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-users text-blue" style="font-size: 28pt !important;"></i></li>
                <li class="text-right">
                  <span class="" style="font-size: 28pt !important;">
                  <?= number_format($dataMasyBinaDesaTahunTotal, 0, ',', '.') ?></span>Orang</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartMasyBinaDesaTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>   
  <div class="col-lg-6">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Kelompok Terlibat Pembinaan Desa
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-users text-orange" style="font-size: 28pt !important;"></i></li>
                <li class="text-right">
                  <span class="" style="font-size: 28pt !important;">
                  <?= number_format($dataKelompokBinaDesaTahunTotal, 0, ',', '.') ?></span>Kelompok</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartKelompokBinaDesaTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Desa Terlibat Pembinaan Desa
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-fort-awesome text-info" style="font-size: 28pt !important;"></i></li>
                <li class="text-right">
                  <span class="" style="font-size: 28pt !important;">
                  <?= number_format($dataDesaTerlibatTahunTotal, 0, ',', '.') ?></span>Desa</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartDesaTerlibatTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Unit KK Terlibat Pembinaan Desa
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-globe text-green" style="font-size: 28pt !important;"></i></li>
                <li class="text-right">
                  <span class="" style="font-size: 28pt !important;">
                  <?= number_format($dataKKTerlibatTahunTotal, 0, ',', '.') ?></span>Kawasan</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartKKTerlibatTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Satker Terlibat Pembinaan Desa
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-building text-warning" style="font-size: 28pt !important;"></i></li>
                <li class="text-right">
                  <span class="" style="font-size: 28pt !important;">
                  <?= number_format($dataSatkerTerlibatTahunTotal, 0, ',', '.') ?></span>Satker</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartSatkerTerlibatTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="col-lg-6" style="display: none;">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Rerata Pendapatan Kelompok
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-money text-green" style="font-size: 28pt !important;"></i></li>
                <li class="text-right">
                  <span class="" style="font-size: 28pt !important;">
                  Rp<?= number_format($dataRataPendapatanTahunTotal, 0, ',', '.') ?></span></li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartRataPendapatanTahun" class="chartdiv" style="height: 50vh;display: none;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
        <h3 class="box-title">JUMLAH KELOMPOK BERDASARKAN JENIS USAHA</h3>
        <?php
          $warna = array('success','info','warning','danger','inverse','success','info','warning','danger','inverse','success','info','warning','danger','inverse','success','info','warning','danger','inverse');

          $x=0; 
          $total_arr = array();
          $total_usaha = array();
          foreach ($record1 as $row1) {
            $total_arr[] = $row1->jml_kelompok;
          }
          $total_all = array_sum($total_arr);
          foreach ($record1 as $row) {
          $persen = intval($row->jml_kelompok) / intval($total_all) * 100;
        ?>
        <h5><?= $row->jenis_usaha ?><span class="pull-right"><?= $row->jml_kelompok ?></span></h5>
        <div class="progress">
            <div class="progress-bar progress-bar-<?= $warna[$x] ?>" aria-valuenow="<?= $row->jml_kelompok ?>" aria-valuemin="0" aria-valuemax="<?= $total_all ?>" style="width: <?= number_format($persen, 0) ?>%" role="progressbar"> <span class="sr-only"></span> </div>
        </div>
        <?php $x++; } ?>
        <h4>Jumlah Total Usaha yang terbentuk<span class="pull-right"><?= $total_all ?></span></h4>
      </div>
    </div> 
</div>
</section>
<script src="<?=base_url('assets/dist/js/content/website.js')?>"></script> 
<script src="<?=base_url('assets/plugins/amcharts/core.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/charts.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/amcharts.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/animated.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/material.js')?>"></script>
<script type="text/javascript">
  var dataBiayaPMTahun = JSON.parse('<?php echo $dataBiayaPMTahun; ?>');
  var dataMasyBinaDesaTahun = JSON.parse('<?php echo $dataMasyBinaDesaTahun; ?>');
  var dataKelompokBinaDesaTahun = JSON.parse('<?php echo $dataKelompokBinaDesaTahun; ?>');
  var dataKelompokBinaDesaTahun = JSON.parse('<?php echo $dataKelompokBinaDesaTahun; ?>');
  var dataDesaTerlibatTahun = JSON.parse('<?php echo $dataDesaTerlibatTahun; ?>');
  var dataKKTerlibatTahun = JSON.parse('<?php echo $dataKKTerlibatTahun; ?>');
  var dataSatkerTerlibatTahun = JSON.parse('<?php echo $dataSatkerTerlibatTahun; ?>');
  var dataRataPendapatanTahun = JSON.parse('<?php echo $dataRataPendapatanTahun; ?>');
  
</script>
<script src="<?=base_url('assets/dist/js/content/statistik-binadesa.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>