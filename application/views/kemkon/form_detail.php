<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  $disabled = '';
  if ($access == 4) {
    $disabled = 'disabled';
  }
?>

<!-- Small paneles (Stat panel) -->
  <div class="row">
            <div class="col-md-12">

              <!-- Profile Image -->
              <div class="panel panel-default">
                <div class="panel-header with-border">
                  <h3 class="panel-heading"><?= $judul?></h3>
                </div>
                <div class="panel-body ">
                  <form id="updatePDSKKForm" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA KELOMPOK</u>
                            <?php
                        $data_kelompok = load_controller('Binadesa', 'getdatakelompokdetail', $record->kelompok_id, NULL, 'pemberdayaan/');
                          
                      ?>
                        </label>
                    </div>
                    <div class="form-group" style="margin-bottom: 5px !important;">
                      <label class="col-lg-3 control-label">Nama Kelompok</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $data_kelompok->nama_kelompok ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 5px !important;">
                      <label class="col-lg-3 control-label">Jumlah Anggota</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <table style="text-align: left !important;font-weight: normal !important;">
                            <tr><td>Laki-laki</td><td>:</td><td><?= $data_kelompok->jml_anggota_l ?> Orang</td></tr>
                            <tr><td>Perempuan</td><td>:</td><td><?= $data_kelompok->jml_anggota_p ?> Orang</td></tr>
                            <tr><td>Total</td><td>:</td><td><?= $data_kelompok->jml_anggota_kelompok ?> Orang</td></tr>
                          </table>
                        </label>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 5px !important;">
                      <label class="col-lg-3 control-label">Unit Kawasan</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $data_kelompok->short_name.' '.$data_kelompok->nama_kk ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px !important;">
                      <label class="col-lg-3 control-label">Nama Satker</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $data_kelompok->nama_satker ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      
                      
                      <div class="col-lg-10 col-lg-offset-1">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="5%">NO</th>
                                <th width="20%">PROVINSI</th>
                                <th width="25%">KAB/KOTA</th>
                                <th width="20%">KECAMATAN</th>
                                <th width="30%">DESA</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $no=1;
                                $arr_desa = load_controller('Binadesa', 'getdatadesadetail', $record->desa_id, NULL, 'pemberdayaan/');
                                foreach ($arr_desa as $key => $value) {
                              ?>
                                  <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_prov']) ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_kab_kota']) ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_kec']) ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_desa']) ?></td>
                                  </tr>
                              <?php $no++; } ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA PERJANJIAN KERJASAMA</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Tujuan Kemitraan</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->tujuan_kemitraan ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Judul PKS</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->judul_pks ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Nomor PKS</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->no_pks ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Tanggal PKS</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->newtgl ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Jangka Waktu</label>
                      <label id="" class="col-lg-8 control-label" style="text-align: left !important;font-weight: normal !important;">
                        <?php 
                          $jmlhari = intval($record->jangka_waktu) * 365; 
                          $hitung_tgl_akhir = date('Y-m-d',strtotime($record->newtgl." ".$jmlhari." days"));
                          $tgl_berakhir = date_create($hitung_tgl_akhir); 
                          if ($record->jangka_waktu > 0) {
                        ?>
                          <?= $record->jangka_waktu.' Tahun' ?> (Berakhir Pada <?= date_format($tgl_berakhir, 'd M Y'); ?>)
                        <?php } else { ?>
                          -
                        <?php } ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Nomor Surat Persetujuan Dirjen</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->no_spd ?>
                      </label>
                    </div>
                    <div class="form-group formPM">
                      <label class="col-lg-4 control-label">Aktivitas Pemanfaatan</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= load_controller('Kemkon', 'getdataaktivitasview', $record->aktivitas_pemanfaatan, NULL, 'pemberdayaan/') ?>
                      </label>
                    </div>
                    <div class="form-group formPM">
                      <label class="col-lg-4 control-label">Volume Pemanfaatan</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->vol_pemanfaatan ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Keterangan</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->keterangan ?>
                      </label>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Luas</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->luas.' Ha' ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Nilai Ekonomi</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= 'Rp '.$record->nilai_ekonomi ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Zona/Blok</label>
                      <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->zona_blok_detail ?>
                      </label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>FILE LAMPIRAN</u>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">File BA Verifikasi</label>
                        <div class="col-lg-6">
                            <?php if ($record->file_ba_verifikasi != '') { ?>
                            <a target="_blank" href="<?= base_url('assets/filekemitraankonservasi/'.$record->file_ba_verifikasi) ?>">
                            <?= $record->file_ba_verifikasi ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">File PKS</label>
                        <div class="col-lg-6">
                            <?php if ($record->file_pks != '') { ?>
                            <a target="_blank" href="<?= base_url('assets/filekemitraankonservasi/'.$record->file_pks) ?>">
                            <?= $record->file_pks ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">File Peta</label>
                        <div class="col-lg-6">
                            <?php if ($record->file_peta != '') { ?>
                            <a target="_blank" href="<?= base_url('assets/filekemitraankonservasi/'.$record->file_peta) ?>">
                            <?= $record->file_peta ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 pull-left col-lg-offset-3">Diperbarui oleh <?= $record->nama_user ?> pada <?php $waktu = date_create($record->last_update); echo date_format($waktu, 'd M Y H:i:s'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-4">
                            <a href="<?= base_url('pemberdayaan/kemkon') ?>" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/kemkon.js')?>"></script> 
<script type="text/javascript">
  var initialLoad = true;
  $(document).ready(function () {
    initialLoad = false;
    if (initialLoad == false) {
      
      var id_select = <?= $record->kelompok_id ?>;
      var dataKelompok = $.parseJSON($.ajax({
                  url:  '../getdatakelompok',
                  dataType: "json",
                  type: 'GET',
                  data: {id:id_select},
                  async: false
              }).responseText);
      var desaView = $.ajax({
                  url:  '../getdatadesaview',
                  type: 'GET',
                  data: {val:dataKelompok['desa_id']},
                  async: false
              }).responseText;
      var detailKelompok = "Nama Kelompok : " + dataKelompok['nama_kelompok'];
          detailKelompok += "<br>Desa : " + desaView;
          detailKelompok += "<br>Unit Kawasan : " + dataKelompok['short_name'] + ". " + dataKelompok['nama_kk'];
          detailKelompok += "<br>Satker : " + dataKelompok['nama_satker'];

      $("#isiKelompok").html(detailKelompok);
    }

  });
</script>
<?php
  load_controller('Commons', 'footer');
?>
