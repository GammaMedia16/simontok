<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  
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
          <div class="panel-action">
            <a target="_blank" style="opacity: 1 !important;" id="btnUnduhResume" type="button" class="btn btn-outline btn-xs"><i class="fa fa-download"></i> <strong>Unduh PDF</strong></a>
            <a style="opacity: 1 !important;" href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a> 
          </div>
        </div>
      </div><!-- /.panel-header -->
      <div class="panel-wrapper collapse">
        <div class="panel-body">
          <form id="filterResumePDSKK" method="post" role="form" class="form-horizontal">
            <div class="form-group">
              <label class="col-lg-2 control-label">Fungsi KK</label>
              <div class="col-lg-3">
                <select onChange="this.form.submit()" name="fungsi_kk_id" id="fungsi_kk_id" class="form-control" style="width: 100%;" >
                        <?php if ($fungsi_exist == 0) { ?>
                            <option selected value="0">SEMUA DATA</option>
                        <?php } else { ?>
                            <option value="0">SEMUA DATA</option>
                        <?php } ?>
                        <?php foreach ($dataFungsiKK as $row2) { ?>
                            <?php if ($fungsi_exist == $row2->id_fungsi_kk) { ?>
                            <option selected value="<?= $row2->id_fungsi_kk ?>"><?= $row2->nama_fungsi ?></option>
                            <?php } else { ?>
                            <option value="<?= $row2->id_fungsi_kk ?>"><?= $row2->nama_fungsi ?></option>
                            <?php } ?>
                        <?php } ?>
                </select>
              </div>
              <label class="col-lg-2 control-label">Tahun</label>
              <div class="col-lg-3">
                <select name="tahun" id="tahun" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                  <?php if ($tahun_exist == 0) { ?>
                      <option selected value="0">SEMUA DATA</option>
                  <?php } else { ?>
                      <option value="0">SEMUA DATA</option>
                  <?php } ?>
                  <?php 
                  $thn_min = 2014;
                  $thn_max = date("Y");
                  $no = 1; 
                  for ($i=$thn_min; $i <= $thn_max; $i++) { ?>

                    <?php if ($tahun_exist == $i) { ?>
                        <option selected value="<?= $i; ?>"><?= $i; ?></option>
                    <?php } else { ?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
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
              <label class="col-lg-2 control-label">Unit Kawasan</label>
              <div class="col-lg-4">
                <select onChange="this.form.submit()" name="kk_reg" id="kk_reg" class="form-control select2" style="width: 100%;" >
                        <?php if ($satker_exist == 0) { ?>
                            <option selected value="0">SEMUA DATA</option>
                        <?php } else { ?>
                            <option value="0">SEMUA DATA</option>
                        <?php } ?>
                        <?php foreach ($dataKK as $row) { ?>
                            <?php if ($kk_exist == $row->reg_kk) { ?>
                            <option selected value="<?= $row->reg_kk ?>"><?= $row->short_name.'. '.$row->nama_kk ?></option>
                            <?php } else { ?>
                            <option value="<?= $row->reg_kk ?>"><?= $row->short_name.'. '.$row->nama_kk ?></option>
                            <?php } ?>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <?php if ($this->session->sub_role != 4 ) { ?>
              <label class="col-lg-2 control-label">Provinsi</label>
              <div class="col-lg-4">
                <select onChange="this.form.submit()" name="prov_id" id="prov_id" class="form-control select2" style="width: 100%;" >
                        <?php if ($prov_exist == 0) { ?>
                            <option selected value="0">SEMUA DATA</option>
                        <?php } else { ?>
                            <option value="0">SEMUA DATA</option>
                        <?php } ?>
                        <?php foreach ($dataProv as $row1) { ?>
                            <?php if ($prov_exist == $row1->id_prov) { ?>
                            <option selected value="<?= $row1->id_prov ?>"><?= $row1->nama_prov ?></option>
                            <?php } else { ?>
                            <option value="<?= $row1->id_prov ?>"><?= $row1->nama_prov ?></option>
                            <?php } ?>
                        <?php } ?>
                </select>
              </div>
              <?php } ?>
              <label class="col-lg-2 control-label">Jenis Usaha</label>
              <div class="col-lg-4">
                <select onChange="this.form.submit()" name="usaha_id" id="usaha_id" class="form-control" style="width: 100%;" >
                        <?php if ($usaha_exist == 0) { ?>
                            <option selected value="0">SEMUA DATA</option>
                        <?php } else { ?>
                            <option value="0">SEMUA DATA</option>
                        <?php } ?>
                        <?php foreach ($dataUsaha as $row2) { ?>
                            <?php if ($usaha_exist == $row2->id_reference) { ?>
                            <option selected value="<?= $row2->id_reference ?>"><?= $row2->detail_1 ?></option>
                            <?php } else { ?>
                            <option value="<?= $row2->id_reference ?>"><?= $row2->detail_1 ?></option>
                            <?php } ?>
                        <?php } ?>
                </select>
              </div>
            </div>
          </form>
        </div><!-- /.panel-body -->
      </div>
    </div><!-- /.panel -->
  </div><!-- /.col -->
  <div class="col-lg-12 col-sm-12 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">JUMLAH BIAYA/BANTUAN PENGEMBANGAN USAHA EKONOMI PRODUKTIF <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li><i class="fa fa-money text-green"></i></li>
              <li class="text-right">Rp<span class=""><?= number_format($record->jml_biaya, 0, ',', '.') ?></span></li>
          </ul>
      </div>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">JUMLAH KELOMPOK TERLIBAT <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li><i class="fa fa-users text-orange"></i></li>
              <li class="text-right">
                <span class="counter">
                <?= $record->jml_kelompok ?></span>Kelompok</li>
          </ul>
      </div>
  </div>
  
  <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">JUMLAH MASYARAKAT TERLIBAT <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li><i class="fa fa-users text-purple"></i></li>
              <li class="text-right">
                <span class="counter">
                <?= number_format($jml_anggota_interaksi, 0, ',', '.') ?></span>Orang</li>
          </ul>
      </div>
  </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
        <h3 class="box-title">JUMLAH KELOMPOK BERDASARKAN JENIS USAHA <?= $tahun_judul ?></h3>
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
  <div class="col-lg-6 col-sm-6 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">JUMLAH DESA YANG TERLIBAT <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li><i class="fa fa-fort-awesome text-info"></i></li>
              <li class="text-right"><span class="counter"><?= $jml_desa_terlibat ?></span>Desa</li>
          </ul>
      </div>
  </div><!-- 
  <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">RERATA PENDAPATAN PER BULAN <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li style="width: 25% !important;"><i class="fa fa-money text-green"></i></li>
              <li class="text-right">
                Rp<span class=""><?= number_format($record->jml_rata_pendapatan, 0, ',', '.') ?></span></li>
          </ul>
      </div>
  </div> -->
  <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">JUMLAH SATUAN KERJA <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li><i class="fa fa-building text-warning"></i></li>
              <li class="text-right"><span class="counter"><?= $record->jml_satker ?></span>Satker</li>
          </ul>
      </div>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
      <div class="white-box">
          <h3 class="box-title">JUMLAH UNIT KAWASAN KONSERVASI <?= $tahun_judul ?></h3>
          <ul class="list-inline two-part">
              <li><i class="fa fa-globe text-green"></i></li>
              <li class="text-right">
                <span class="counter">
                <?= $record->jml_kawasan ?></span>Kawasan</li>
          </ul>
      </div>
  </div>
</div>
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
<script src="<?=base_url('assets/dist/js/content/binadesa.js')?>"></script>
<script type="text/javascript">
  $('#btnUnduhResume').click(function(){ 
      $('#filterResumePDSKK').attr('action','<?= base_url('pemberdayaan/binadesa/unduhresume') ?>');
      $('#filterResumePDSKK').attr('target','target="_blank"');
      var form = document.getElementById("filterResumePDSKK");
      form.submit(); 
      $('#filterResumePDSKK').attr('action','');
      $('#filterResumePDSKK').attr('target','');
  });
</script>
<?php
  load_controller('Commons', 'footer');
?>