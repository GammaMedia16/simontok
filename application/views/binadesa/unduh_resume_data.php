<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  //load_controller('Commons', 'sidebar', $title, $icon);
  
?>
<!-- Main content -->
<section class="content">
<!-- Info paneles -->
<!-- Main row -->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-inverse">
      <div class="panel-header">
        <div class="panel-heading"><?= $title ?>
        </div>
      </div><!-- /.panel-header -->
      <div class="panel-wrapper collapse">
        <div class="panel-body">

        </div><!-- /.panel-body -->
      </div>
    </div><!-- /.panel -->
  </div><!-- /.col -->
  <div class="col-lg-12 col-sm-12 col-xs-12">
    <table width="100%" border="0" cellspacing="20px">
      <tr>
        <td colspan="3" align="right">
          <h3>JUMLAH BIAYA/BANTUAN PENGEMBANGAN USAHA EKONOMI PRODUKTIF <?= $tahun_judul ?></h3>
        </td>
      </tr>
      <tr>
        <td width="30%"></td>
        <td width="15%" align="right" style="font-size: 28pt;">
          <i class="text-green" style="font-family:fontawesome;">&#xf3d1;</i>
        </td>
        <td width="55%" align="right" style="font-size: 18pt;">
          Rp<span style="font-size: 38pt;"><?= number_format($record->jml_biaya, 0, ',', '.') ?></span>
        </td>
      </tr>
    </table>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <hr>
    <table width="100%" border="0" cellspacing="20px">
      <tr>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH KELOMPOK TERLIBAT <?= $tahun_judul ?></span>
        </td>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH MASYARAKAT TERLIBAT <?= $tahun_judul ?></span>
        </td>
      </tr>
      <tr>
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-orange" style="font-family:fontawesome;">&#xf0c0;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= $record->jml_kelompok ?></span>Kelompok
        </td>
        <!-- ----------- -->
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-purple" style="font-family:fontawesome;">&#xf0c0;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= number_format($jml_anggota_interaksi, 0, ',', '.') ?></span>Orang
        </td>
      </tr>
    </table>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">

    <hr>
    <table width="100%" border="0" cellspacing="20px">
      <tr>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH DESA YANG TERLIBAT <?= $tahun_judul ?></span>
        </td><!-- 
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">RERATA PENDAPATAN PER BULAN <?= $tahun_judul ?></span>
        </td> -->
      </tr>
      <tr>
        
        <!-- ----------- -->
        <td width="20%"></td>
        <td width="20%" align="right" style="font-size: 24pt;">
          <i class="text-purple" style="font-family:fontawesome;">&#xf494;</i>
        </td>
        <td width="60%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= $jml_desa_terlibat ?></span>Desa
        </td>

        <!-- <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-green" style="font-family:fontawesome;">&#xf3d1;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          Rp<span style="font-size: 28pt;"><?= number_format($record->jml_rata_pendapatan, 0, ',', '.') ?></span>
        </td> -->
      </tr>
    </table>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">

    <hr>
    <table width="100%" border="0" cellspacing="20px">
      <tr>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH SATUAN KERJA <?= $tahun_judul ?></span>
        </td>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH UNIT KAWASAN KONSERVASI <?= $tahun_judul ?></span>
        </td>
      </tr>
      <tr>
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-orange" style="font-family:fontawesome;">&#xf1ad;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= $record->jml_satker ?></span>Satker
        </td>
        <!-- ----------- -->
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-green" style="font-family:fontawesome;">&#xf57e;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= $record->jml_kawasan ?></span>Kawasan
        </td>
      </tr>
    </table>
  </div>
</div>

<hr>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box" style="margin-top: -30 !important;margin-bottom: -20 !important;">
        <h3 class="box-title">JUMLAH KELOMPOK BERDASARKAN JENIS USAHA <?= $tahun_judul ?></h3>
        <?php
          $warna = array('success','info','warning','danger','inverse','success','info','warning','danger','inverse','success','info','warning','danger','inverse','success','info','warning','danger','inverse');

          $x=0; 
          $total_arr = array();
          foreach ($record1 as $row1) {
            $total_arr[] = $row1->jml_kelompok;
          }
          $total_all = array_sum($total_arr);
          foreach ($record1 as $row) {
          $persen = intval($row->jml_kelompok) / intval($total_all) * 100;
        ?>
        <h5><?= $row->jenis_usaha ?>&nbsp;&nbsp;:&nbsp;&nbsp;<span class="pull-right"><?= $row->jml_kelompok ?></span></h5>
        
        <?php $x++; } ?>
        <h4>Jumlah Total Usaha yang terbentuk&nbsp;&nbsp;&nbsp;<span class="pull-right"><?= $total_all ?></span></h4>
      </div>
      
  </div>
  

</div>