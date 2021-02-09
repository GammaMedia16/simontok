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
                      <label class="col-lg-3 control-label">Tahun</label>
                      <div class="col-lg-3">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->tahun_keg ?>
                        </label>
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
                      <label class="col-lg-3 control-label">Jenis Usaha</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->jenis_usaha ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Keterangan Jenis Usaha</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->ket_usaha ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Keuntungan Usaha</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          Rp <?= number_format($record->keuntungan_usaha, 0, ',', '.') ?>
                        </label>
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
                          <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->jml_anggota_interaksi ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Rerata Pendapatan Kelompok (Rp)</label>
                      <div class="col-lg-6">
                          <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          Rp <?= number_format($record->rata_pendapatan, 0, ',', '.') ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Jumlah Kas Kelompok</label>
                      <div class="col-lg-6">
                          <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          Rp <?= number_format($record->jml_kas, 0, ',', '.') ?>
                        </label>
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
                          <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->nama_mitra ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Tahap Kegiatan</label>
                      <div class="col-lg-6 inputGroupContainer">
                          <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->tahap_mitra ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nama Kegiatan</label>
                      <div class="col-lg-6">
                        <label id="" class="col-lg-6 control-label" style="text-align: left !important;font-weight: normal !important;">
                          <?= $record->nama_keg_mitra ?>
                        </label>
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
                    <div class="form-group">
                        <label class="col-lg-8 pull-left col-lg-offset-3">Diperbarui oleh <?= $record->nama_user ?> pada <?php $waktu = date_create($record->last_update); echo date_format($waktu, 'd M Y H:i:s'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <a href="<?= base_url('pemberdayaan/binadesa') ?>" class="btn btn-primary">Kembali</a>
                            <a target="_blank" href="<?= base_url('pemberdayaan/binadesa/unduhdetail/'.$record->id_pdskk) ?>" class="btn btn-info">
                            <i class="fa fa-download"></i> Unduh PDF</a>
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

<?php
  load_controller('Commons', 'footer');
?>
