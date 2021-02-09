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
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Kelompok</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <input type="hidden" class="form-control" name="id_pdskk" id="id_pdskk" value="<?= $record->id_pdskk ?>"/>
                          <input type="hidden" class="form-control" name="kelompok_id_old" id="kelompok_id_old" value="<?= $record->kelompok_id ?>"/>
                          <input type="hidden" class="form-control" name="usaha_id_old" id="usaha_id_old" value="<?= $record->usaha_id ?>"/>
                          <input type="hidden" class="form-control" name="tahun_keg_old" id="tahun_keg_old" value="<?= $record->tahun_keg ?>"/>
                          <input type="hidden" class="form-control" name="file_rpl_old" id="file_rpl_old" value="<?= $record->file_rpl ?>"/>
                          <input type="hidden" class="form-control" name="file_rkt_old" id="file_rkt_old" value="<?= $record->file_rkt ?>"/>
                          <input type="hidden" class="form-control" name="foto_usaha_old" id="foto_usaha_old" value="<?= $record->foto_usaha ?>"/>
                          <select name="kelompok_id" id="kelompok_id" class="form-control select2" style="width: 100%;" data-placeholder="-- Pilih Kelompok --">
                              <?php foreach ($dataKelompok as $row) { ?>
                                <?php if ($record->kelompok_id == $row->id_kelompok) { ?>
                                  <option selected value="<?= $row->id_kelompok ?>"><?= $row->nama_kelompok ?></option>
                                <?php } else { ?>
                                  <option value="<?= $row->id_kelompok ?>"><?= $row->nama_kelompok ?></option>
                                <?php } ?>
                                  
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label col-lg-offset-3 text-red">Data Kelompok belum ada?</label>
                      <div class="col-lg-6" style="text-align: left !important;">
                          <a href="<?=base_url();?>referensi/kelompok/add?flag=2&id_pdskk=<?= $record->id_pdskk ?>" type="button" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> <strong>TAMBAH DATA KELOMPOK</strong></a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Detail Data Kelompok</label>
                      <label id="isiKelompok" class="col-lg-6 control-label" style="text-align: left !important;">
                          
                      </label>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Tahun</label>
                      <div class="col-lg-3">
                        <select name="tahun" id="tahun" class="form-control" style="width: 100%;">
                            <?php 
                            $thn_min = 2014;
                            $thn_max = date("Y");
                            $no = 1; 
                            for ($i=$thn_min; $i <= $thn_max; $i++) { ?>
                              <?php if ($record->tahun_keg == $i) { ?>
                                  <option selected value="<?= $i; ?>"><?= $i; ?></option>
                              <?php } else { ?>
                                  <option value="<?= $i; ?>"><?= $i; ?></option>
                              <?php } ?>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA TAHAP KEGIATAN</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-10 col-lg-offset-1">
                        <table id="formTahap" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="5%">NO</th>
                                <th width="30%">TAHAP KEGIATAN</th>
                                <th width="40%">NAMA KEGIATAN</th>
                                <th width="25%">BIAYA/NILAI BANTUAN (Rp)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; foreach ($dataTahap as $row) { 
                                foreach ($recordTahap as $rowTahap) { 
                                  if ($rowTahap->tahap_id == $row->id_reference) { 
                                    $valueNamaKeg = $rowTahap->nama_keg;
                                    $valueBiayaKeg = $rowTahap->biaya_keg;
                                    break;
                                  } else {
                                    $valueNamaKeg = "";
                                    $valueBiayaKeg = "";
                                  }
                                } ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= '<b>'.$row->detail_1.'</b>' ?><input type="hidden" class="form-control" id="tahap_id<?=$row->id_reference?>" name="tahap_id<?=$row->id_reference?>" value="<?= $row->id_reference ?>" />
                                    </td>
                                    <td><input type="text" class="form-control" id="nama_keg<?=$row->id_reference?>" name="nama_keg<?=$row->id_reference?>" value="<?= $valueNamaKeg ?>" /></td>
                                    <td><input type="text" class="form-control" id="biaya_keg<?=$row->id_reference?>" name="biaya_keg<?=$row->id_reference?>" value="<?= $valueBiayaKeg ?>" /></td>
                                </tr>
                                
                              <?php $no++; } ?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA KETERLIBATAN MITRA</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nama Mitra</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="nama_mitra" id="nama_mitra" value="<?= $record->nama_mitra ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Tahap Kegiatan</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <select name="tahap_id_mitra" id="tahap_id_mitra" class="form-control" style="width: 100%;" data-placeholder="-- Pilih Tahap Kegiatan -- --">
                            <option value="">-- Pilih Tahap Kegiatan --</option>
                              <?php foreach ($dataTahap as $row) { ?>
                                <?php if ($record->tahap_id_mitra == $row->id_reference) { ?>
                                  <option selected value="<?= $row->id_reference ?>"><?= $row->detail_1 ?></option>
                                <?php } else { ?>
                                  <option value="<?= $row->id_reference ?>"><?= $row->detail_1 ?></option>
                                <?php } ?>
                                  
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nama Kegiatan</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="nama_keg_mitra" id="nama_keg_mitra" value="<?= $record->nama_keg_mitra ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA USAHA KELOMPOK</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Jenis Usaha</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <select name="usaha_id" id="usaha_id" class="form-control" style="width: 100%;" data-placeholder="-- Pilih Jenis Usaha --">
                            <option value="">-- Pilih Jenis Usaha --</option>
                              <?php foreach ($dataUsaha as $row1) { ?>
                                <?php if ($record->usaha_id == $row1->id_reference) { ?>
                                  <option selected value="<?= $row1->id_reference ?>"><?= $row1->detail_1 ?></option>
                                <?php } else { ?>
                                  <option value="<?= $row1->id_reference ?>"><?= $row1->detail_1 ?></option>
                                <?php } ?>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Keterangan Jenis Usaha</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="ket_usaha" id="ket_usaha" value="<?= $record->ket_usaha ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Keuntungan Usaha</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="keuntungan_usaha" id="keuntungan_usaha" value="<?= $record->keuntungan_usaha ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>AKTIVITAS ANGGOTA KELOMPOK</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Jumlah Anggota Kelompok Berinteraksi dengan KK</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="jml_anggota_interaksi" id="jml_anggota_interaksi" value="<?= $record->jml_anggota_interaksi ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Rerata Pendapatan Kelompok (Rp)</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="rata_pendapatan" id="rata_pendapatan" value="<?= $record->rata_pendapatan ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Jumlah Kas Kelompok</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="jml_kas" id="jml_kas" value="<?= $record->jml_kas ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>FILE LAMPIRAN</u>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File RPL</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filerpl" name="filerpl" />
                            <span class="text-muted">Format file *.PDF dengan ukuran maksimal 5MB.</span>
                            <p class="text-muted">*) Jika file tidak diubah, dikosongkan saja.</p>
                            <?php if ($record->file_rpl != '') { ?>
                            File RPL: <a target="_blank" href="<?= base_url('assets/filepembinaandesa/'.$record->file_rpl) ?>">
                            <?= $record->file_rpl ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File RKT</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filerkt" name="filerkt" />
                            <span class="text-muted">Format file *.PDF dengan ukuran maksimal 5MB.</span>
                            <p class="text-muted">*) Jika file tidak diubah, dikosongkan saja.</p>
                            <?php if ($record->file_rkt != '') { ?>
                            File RKT: <a target="_blank" href="<?= base_url('assets/filepembinaandesa/'.$record->file_rkt) ?>">
                            <?= $record->file_rkt ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Foto Usaha/Kegiatan</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="fotousaha" name="fotousaha" />
                            <span class="text-muted">Format file *.JPG/JPEG/PNG dengan ukuran maksimal 1MB.</span>
                            <p class="text-muted">*) Jika file tidak diubah, dikosongkan saja.</p>
                            <?php if ($record->foto_usaha != '') { ?>
                            Foto Usaha: <a target="_blank" href="<?= base_url('assets/filepembinaandesa/'.$record->foto_usaha) ?>">
                            <?= $record->foto_usaha ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" onclick="deleteData(<?= $record->kelompok_id ?>,<?= $record->tahun_keg ?>)" class="btn btn-danger">Hapus Data</button>
                            <a href="<?= base_url('pemberdayaan/binadesa') ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/binadesa.js')?>"></script> 
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
      //console.log(dataKK);
  }).trigger('change');
</script>
<?php
  load_controller('Commons', 'footer');
?>
