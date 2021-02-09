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
      <center><h2><?= $judul ?></h2></center>
  </div>
</div>
<div class="row"> 
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
</div>
</section>
<script src="<?=base_url('assets/dist/js/content/website.js')?>"></script> 
<script src="<?=base_url('assets/plugins/amcharts/core.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/charts.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/amcharts.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/animated.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/material.js')?>"></script>
<script type="text/javascript">
  var dataMasyBinaDesaTahun = JSON.parse('<?php echo $dataMasyBinaDesaTahun; ?>');
  var dataKelompokBinaDesaTahun = JSON.parse('<?php echo $dataKelompokBinaDesaTahun; ?>');
  var dataDesaTerlibatTahun = JSON.parse('<?php echo $dataDesaTerlibatTahun; ?>');
  var dataSatkerTerlibatTahun = JSON.parse('<?php echo $dataSatkerTerlibatTahun; ?>');
  
</script>
<script src="<?=base_url('assets/dist/js/content/statistik-pdskk.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>