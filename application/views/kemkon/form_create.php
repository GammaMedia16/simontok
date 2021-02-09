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
                  <form id="createKemkonForm" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA KELOMPOK</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Kelompok</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <select name="kelompok_id" id="kelompok_id" class="form-control select2" style="width: 100%;" data-placeholder="-- Pilih Kelompok --">
                            <?php foreach ($dataKelompok as $row) { ?>
                              <option value="<?= $row->id_kelompok ?>"><?= $row->nama_kelompok ?></option>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label col-lg-offset-3 text-red">Data Kelompok belum ada?</label>
                      <div class="col-lg-6" style="text-align: left !important;">
                          <a href="<?=base_url();?>referensi/kelompok/add?flag=3" type="button" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> <strong>TAMBAH DATA KELOMPOK</strong></a>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Detail Data Kelompok</label>
                      <label id="isiKelompok" class="col-lg-6 control-label" style="text-align: left !important;">
                          
                      </label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA PERJANJIAN KERJASAMA</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Tujuan Kemitraan</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <select name="tujuan_id" id="tujuan_id" class="form-control" style="width: 100%;" data-placeholder="-- Pilih Tujuan Kemitraan --">
                              <?php foreach ($dataTujuan as $row) { ?>
                              <option value="<?= $row->id_reference ?>"><?= $row->detail_1 ?></option>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Judul PKS</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="judul_pks" id="judul_pks" value=""/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nomor PKS</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="no_pks" id="no_pks" value=""/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Tanggal PKS</label>
                      <div class="col-lg-4 inputGroupContainer date">
                        <div class="input-group input-append date">
                            <input type="text" class="form-control" id="inputTglIns1" name="tgl_pks" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nomor Surat Persetujuan Dirjen</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="no_spd" id="no_spd" value=""/>
                      </div>
                    </div>
                    <div class="form-group formPM">
                      <label class="col-lg-3 control-label">Aktivitas Pemanfaatan</label>
                      <div class="col-lg-8 inputGroupContainer">
                          <select name="aktivitas_pemanfaatan[]" multiple="multiple" id="aktivitas_pemanfaatan" class="form-control select2" style="width: 100%;" data-placeholder="-- Pilih Aktivitas Pemanfaatan (bisa lebih dari 1) --">
                              <?php foreach ($dataAktivitas as $row) { ?>
                              <option value="<?= $row->id_reference ?>"><?= $row->detail_1 ?></option>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group formPM">
                      <label class="col-lg-3 control-label">Volume Pemanfaatan</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="vol_pemanfaatan" id="vol_pemanfaatan" value=""/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Keterangan</label>
                      <div class="col-lg-6">
                          <textarea id="keterangan" class="form-control" name="keterangan" cols="50"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Jangka Waktu</label>
                      <div class="col-lg-4">
                          <div class="input-group input-append">
                              <input type="text" class="form-control" id="jangka_waktu" name="jangka_waktu" />
                              <span class="input-group-addon add-on">Tahun</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Luas</label>
                      <div class="col-lg-4">
                          <div class="input-group input-append">
                              <input type="text" class="form-control" id="luas" name="luas" />
                              <span class="input-group-addon add-on">Ha</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nilai Ekonomi</label>
                      <div class="col-lg-6">
                          <div class="input-group input-append">
                              <span class="input-group-addon add-on">Rp</span>
                              <input type="text" class="form-control" id="nilai_ekonomi" name="nilai_ekonomi" />
                              
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Zona/Blok</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <select name="zona_blok" id="zona_blok" class="form-control" style="width: 100%;" data-placeholder="-- Pilih Zona/Blok --">
                              <?php foreach ($dataZonaBlok as $row) { ?>
                              <option value="<?= $row->id_reference ?>"><?= $row->detail_1 ?></option>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>FILE LAMPIRAN</u>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File BA Verifikasi</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filebaverifikasi" name="filebaverifikasi" />
                            <span class="text-muted">Format file *.PDF dengan ukuran maksimal 2MB.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File PKS</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filepks" name="filepks" />
                            <span class="text-muted">Format file *.PDF dengan ukuran maksimal 5MB.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File Peta</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filepeta" name="filepeta" />
                            <span class="text-muted">Format file *.KML dengan ukuran maksimal 2MB.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('pemberdayaan/kemkon') ?>" class="btn btn-primary">Batal</a>
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
  $(document).ready(function () {
        
        
    });
  $('#tujuan_id').on('change', function() {
      var id_select = $(this).val();
      if (id_select == 1) {
        $('.formPM').hide();
      } else {
        $('.formPM').show();
      }

  }).trigger('change');

  $('#kelompok_id').select2().on('change', function() {
      var id_select = $(this).val();
      var dataKelompok = $.parseJSON($.ajax({
                  url:  'getdatakelompok',
                  dataType: "json",
                  type: 'GET',
                  data: {id:id_select},
                  async: false
              }).responseText);
      var desaView = $.ajax({
                  url:  'getdatadesaview',
                  type: 'GET',
                  data: {val:dataKelompok['desa_id']},
                  async: false
              }).responseText;
      var detailKelompok = "Nama Kelompok : " + dataKelompok['nama_kelompok'];
          detailKelompok += "<br>Desa : " + desaView;
          detailKelompok += "<br>Unit Kawasan : " + dataKelompok['short_name'] + ". " + dataKelompok['nama_kk'];
          detailKelompok += "<br>Satker : " + dataKelompok['nama_satker'];

      $("#isiKelompok").html(detailKelompok);
      //console.log(dataKK);
  }).trigger('change');
</script>
<?php
  load_controller('Commons', 'footer');
?>
