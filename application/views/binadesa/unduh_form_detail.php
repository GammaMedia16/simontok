<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
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
                    <div class="form-group" style="margin-bottom: 25px !important;">
                      <div class="col-lg-6">
                        <table border="0" width="90%">
                          <tr>
                            <td width="30%">Nama Kelompok</td>
                            <td width="5%">:</td>
                            <td width="65%"><?= $data_kelompok->nama_kelompok ?></td>
                          </tr>
                          <tr>
                            <td width="30%" valign="top">Jumlah Anggota</td>
                            <td width="5%" valign="top">:</td>
                            <td width="65%">
                              <table style="text-align: left !important;font-weight: normal !important;">
                                <tr><td>Laki-laki</td><td>:</td><td><?= $data_kelompok->jml_anggota_l ?> Orang</td></tr>
                                <tr><td>Perempuan</td><td>:</td><td><?= $data_kelompok->jml_anggota_p ?> Orang</td></tr>
                                <tr><td>Total</td><td>:</td><td><?= $data_kelompok->jml_anggota_kelompok ?> Orang</td></tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td width="30%">Unit Kawasan</td>
                            <td width="5%">:</td>
                            <td width="65%"><?= $data_kelompok->short_name.' '.$data_kelompok->nama_kk ?></td>
                          </tr>
                          <tr>
                            <td width="30%">Nama Satker</td>
                            <td width="5%">:</td>
                            <td width="65%"><?= $data_kelompok->nama_satker ?></td>
                          </tr>
                        </table>

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
                                print_r($arr_desa);
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
                      <label class="col-lg-3 control-label">Tahun : <?= $record->tahun_keg ?></label>
                      
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
                                  
                              <?php $total_biaya = 0; $no=1; foreach ($recordTahap as $row) { ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= '<b>'.$row->detail_1.'</b>' ?></td>
                                    <td><?= '<b>'.$row->nama_keg.'</b>' ?></td>
                                    <td><?= '<b>Rp '.number_format($row->biaya_keg, 0, ',', '.').'</b>' ?></td>
                                </tr>
                                
                              <?php $total_biaya += $row->biaya_keg; $no++; } ?>
                                <tr>
                                    <td colspan="3" align="right"> <b>TOTAL</b></td>
                                    <td><?= '<b>Rp '.number_format($total_biaya, 0, ',', '.').'</b>' ?></td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA USAHA KELOMPOK</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <table border="0" width="90%">
                        <tr>
                          <td width="30%">Jenis Usaha</td>
                          <td width="5%">:</td>
                          <td width="65%"><?= $record->jenis_usaha ?></td>
                        </tr>
                        <tr>
                          <td width="30%">Keterangan Jenis Usaha</td>
                          <td width="5%">:</td>
                          <td width="65%"><?= $record->ket_usaha ?></td>
                        </tr>
                        <tr>
                          <td width="30%">Keuntungan Usaha</td>
                          <td width="5%">:</td>
                          <td width="65%">Rp <?= $record->keuntungan_usaha ?></td>
                        </tr>
                        
                      </table>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>AKTIVITAS ANGGOTA KELOMPOK</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <table border="0" width="90%">
                        <tr>
                          <td width="30%">Jumlah Anggota Kelompok Berinteraksi dengan KK</td>
                          <td width="5%">:</td>
                          <td width="65%"><?= $record->jml_anggota_interaksi ?></td>
                        </tr>
                        <tr>
                          <td width="30%">Rerata Pendapatan Kelompok</td>
                          <td width="5%">:</td>
                          <td width="65%">Rp <?= $record->rata_pendapatan ?></td>
                        </tr>
                        <tr>
                          <td width="30%">Jumlah Kas Kelompok</td>
                          <td width="5%">:</td>
                          <td width="65%">Rp <?= $record->jml_kas ?></td>
                        </tr>
                        
                      </table>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>DATA KETERLIBATAN MITRA</u>
                        </label>
                    </div>
                    <div class="form-group">
                      <table border="0" width="90%">
                        <tr>
                          <td width="30%">Nama Mitra</td>
                          <td width="5%">:</td>
                          <td width="65%"><?= $record->nama_mitra ?></td>
                        </tr>
                        <tr>
                          <td width="30%">Tahap Kegiatan</td>
                          <td width="5%">:</td>
                          <td width="65%"><?= $record->tahap_mitra ?></td>
                        </tr>
                        <tr>
                          <td width="30%">Nama Kegiatan</td>
                          <td width="5%">:</td>
                          <td width="65%"><?= $record->nama_keg_mitra ?></td>
                        </tr>
                        
                      </table>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">
                            <u>FILE LAMPIRAN</u>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File RPL</label>
                        <div class="col-lg-6">
                            <?php if ($record->file_rpl != '') { ?>
                            <a target="_blank" href="<?= base_url('assets/filepembinaandesa/'.$record->file_rpl) ?>">
                            <?= $record->file_rpl ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File RKT</label>
                        <div class="col-lg-6">
                            <?php if ($record->file_rkt != '') { ?>
                            <a target="_blank" href="<?= base_url('assets/filepembinaandesa/'.$record->file_rkt) ?>">
                            <?= $record->file_rkt ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Foto Usaha/Kegiatan</label>
                        <div class="col-lg-6">
                            <?php if ($record->foto_usaha != '') { ?>
                            <img class="img-responsive" src="<?= base_url('assets/filepembinaandesa/'.$record->foto_usaha) ?>">
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
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

  });
</script>
