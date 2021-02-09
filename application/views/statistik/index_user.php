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
  <div class="col-lg-12">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Jumlah PKS Kemitraan Konservasi
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-file-text text-blue"></i></li>
                <li class="text-right">
                  <span class="counter">
                  <?= $dataPKSTahunTotal ?></span>PKS</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartPKSTahun" class="chartdiv" style="height: 50vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <div class="col-lg-12">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> Grafik Luas Kemitraan Konservasi
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <ul class="list-inline two-part">
                <li><i class="fa fa-globe text-success"></i></li>
                <li class="text-right">
                  <span class="counter">
                  <?= number_format($dataLuasPKSTahunTotal,2) ?></span>Ha</li>
            </ul>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartLuasPKSTahun" class="chartdiv" style="height: 50vh;"></div>
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
  var dataPKSTahun = JSON.parse('<?php echo $dataPKSTahun; ?>');
  var dataLuasPKSTahun = JSON.parse('<?php echo $dataLuasPKSTahun; ?>');
</script>
<script src="<?=base_url('assets/dist/js/content/statistik-user.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>