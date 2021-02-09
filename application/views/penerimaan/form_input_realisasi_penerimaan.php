<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
?>

  <!-- Small paneles (Stat panel) -->
  <div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading">Data Realisasi Penerimaan Tahun <?= $rowTarget->thn_target_penerimaan ?> : <br><br><?= '['.$rowTarget->kode_akun_penerimaan.'] '.$rowTarget->jenis_penerimaan ?>
          <button onclick="location.href='<?=base_url('penerimaan/realisasi');?>'" type="button" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</button>
          </h3>

        </div>
        <div class="panel-body ">
          <div class="table-responsive col-xs-12">
            <table id="tableKu" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="10%">TANGGAL TRANSAKSI</th>
                  <th width="10%">BULAN</th>
                  <th width="20%">KETERANGAN</th>
                  <th width="10%">JUMLAH REALISASI</th>
                  <th width="10%">JUMLAH PENGEMBALIAN</th>
                  <th width="15%">JUMLAH NETTO</th>
                  <th width="10%">USER</th>
                  <th width="15%">AKSI</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($recordReal as $rowRP) { ?>
                <tr>
                  <td><?php $waktu = date_create($rowRP->tgl_transaksi_rterima); echo date_format($waktu, 'd F Y'); ?></td>
                  <td><?= $bulan[$rowRP->bulan-1] ?></td>
                  <td><?= $rowRP->keterangan ?></td>
                  <td align="right"><?= number_format($rowRP->jml_rterima, 0, ',', '.'); ?></td>
                  <td align="right"><?= number_format($rowRP->jml_pengembalian, 0, ',', '.'); ?></td>
                  <td align="right"><?= number_format($rowRP->jml_netto, 0, ',', '.'); ?></td>
                  <td><?= $rowRP->nama_user ?></td>
                  <td>
                    <?php if ($access == 6) { ?>
                      <button style="margin-bottom: 5px" onclick="location.href='<?=base_url('penerimaan/editrealisasipenerimaan/'.$rowRP->id_rterima);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah Realisasi</button>
                      <?php if ($rowRP->jml_pengembalian == 0) { ?>
                          <button style="margin-bottom: 5px" onclick="location.href='<?=base_url('penerimaan/ubahpengembalian/'.$rowRP->id_rterima);?>'" type="button" class="btn btn-xs btn-success"><i class="fa fa-plus"></i>&nbsp;Pengembalian</button>
                      <?php } else { ?>
                          <button style="margin-bottom: 5px" onclick="location.href='<?=base_url('penerimaan/ubahpengembalian/'.$rowRP->id_rterima);?>'" type="button" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i>&nbsp;Ubah Pengembalian</button>

                      <?php } ?>
                    <?php } ?></td>

                </tr>
              <?php $no++; } ?>
              </tbody>
            </table>
            <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
          </div>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  <?php if ($access == 6) { ?>
  <div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading"><?= $judul?></h3>
        </div>
        <div class="panel-body ">
          <form id="createRealisasiPenerimaan" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
            <div class="alert" style="display: none;"></div>
            <input type="hidden" class="form-control" name="kode_akun_penerimaan" id="kode_akun_penerimaan" value="<?= $rowTarget->kode_akun_penerimaan ?>"/>
            <div class="form-group">
              <label class="col-lg-3 control-label">Tanggal Transaksi</label>
              <div class="col-lg-4 inputGroupContainer date">
                <div class="input-group input-append date">
                    <input type="text" class="form-control" id="inputTglIns1" name="tgl_transaksi_rterima" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Bulan</label>
              <div class="col-lg-4">
                  <select name="bulan" id="bulan" class="form-control" style="width: 100%;">
                      <?php 
                      $no = 1; 
                      for ($i=0;$i<=11;$i++) { 
                        $val = $i+1; ?>
                        <option value="<?= $val; ?>"><?= $bulan[$i]; ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Jumlah Realisasi Penerimaan</label>
              <div class="col-lg-6">
                  <input type="text" class="form-control" name="jml_rterima" id="jml_rterima" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Keterangan</label>
              <div class="col-lg-6">
                  <textarea id="keterangan" class="form-control" name="keterangan" cols="50"></textarea>
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= base_url('penerimaan/realisasi') ?>" class="btn btn-primary">Batal</a>
                </div>
            </div>
          </form>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  <?php } ?>
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/penerimaan.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
