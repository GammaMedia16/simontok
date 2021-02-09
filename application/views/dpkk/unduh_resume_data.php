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
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <hr>
    <table width="100%" border="0" cellspacing="20px">
      <tr>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">LUAS DAERAH PENYANGGA KAWASAN KONSERVASI</span>
        </td>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH DAERAH PENYANGGA KAWASAN KONSERVASI</span>
        </td>
      </tr>
      <tr>
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-success" style="font-family:fontawesome;">&#xf279;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 26pt;"><?= number_format($record->luas_dpkk, 2,".",",") ?></span>Ha
        </td>
        <!-- ----------- -->
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-info" style="font-family:fontawesome;">&#xf0c0;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 26pt;"><?= $record->jml_desa ?></span>Desa
        </td>
      </tr>
    </table>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">

    <hr>
    <table width="100%" border="0" cellspacing="20px">
      <tr>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH UNIT KAWASAN KONSERVASI <?= $tahun_judul ?></span>
        </td>
        <td colspan="3" valign="top" align="right">
          <span style="font-size: 10pt;">JUMLAH SATUAN KERJA <?= $tahun_judul ?></span>
        </td>
        
      </tr>
      <tr>
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-green" style="font-family:fontawesome;">&#xf57e;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= $record->jml_kawasan ?></span>Kawasan
        </td>

        <!-- ----------- -->
        <td width="10%"></td>
        <td width="10%" align="right" style="font-size: 24pt;">
          <i class="text-orange" style="font-family:fontawesome;">&#xf1ad;</i>
        </td>
        <td width="30%" align="right" style="font-size: 16pt;">
          <span style="font-size: 28pt;"><?= $record->jml_satker ?></span>Satker
        </td>
        
      </tr>
    </table>
  </div>
</div>

<hr>
  

</div>