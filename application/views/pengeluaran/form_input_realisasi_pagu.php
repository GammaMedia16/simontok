<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $total_realisasi_pagu = 0;
  foreach ($recordRealPagu as $rowRP) {
    $total_realisasi_pagu += $rowRP->jml_rpagu;
  }
  $sisa_pagu = $rowPagu->pagu - $total_realisasi_pagu;
?>

  <!-- Small paneles (Stat panel) -->
  <div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading" style="line-height: 20pt !important;"><u>Data Realisasi Pagu Anggaran </u><br>
            Pagu Anggaran : <?= number_format($rowPagu->pagu, 0, ',', '.'); ?><br>
            Detail : <?= $rowPagu->ket ?><br>
            Total Realisasi : <?= number_format($total_realisasi_pagu, 0, ',', '.'); ?><br>
            <span class="text-red">Sisa Pagu : <?= number_format($sisa_pagu, 0, ',', '.'); ?></span>
          <button onclick="location.href='<?=base_url('pengeluaran/realisasi');?>'" type="button" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</button>
          </h3>

        </div>
        <div class="panel-body ">
          <div class="table-responsive col-xs-12">
            <div class="alert" style="display: none;"></div>
            <table id="tableKu" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="20%">TANGGAL TRANSAKSI</th>
                  <th width="10%">BULAN</th>
                  <th width="15%">JUMLAH REALISASI SPJ</th>
                  <th width="20%">KETERANGAN</th>
                  <th width="15%">USER</th>
                  <th width="20%">AKSI</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; 
               foreach ($recordRealPagu as $rowRP) { ?>
                <tr>
                  <td><?php $waktu = date_create($rowRP->tgl_transaksi_rpagu); echo date_format($waktu, 'd F Y'); ?></td>
                  <td><?= $bulan[$rowRP->bulan-1] ?></td>
                  <td align="right"><?= number_format($rowRP->jml_rpagu, 0, ',', '.'); ?></td>
                  <td><?= $rowRP->ket_rpagu ?></td>
                  <td><?= $rowRP->nama_user ?></td>
                  <td>
                    <?php if ($access == 3 || $access == 5) { ?>
                      <button onclick="location.href='<?=base_url('pengeluaran/editrealisasipagu/'.$rowRP->id_rpagu);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                      <button onclick="hapusRealisasiPagu(<?= $rowRP->id_rpagu ?>)" type="button" class="btn btn-xs btn-danger"><i class="fa fa-close"></i>&nbsp;Hapus</button>
                    <?php } ?></td>

                </tr>
              <?php $no++; } ?>
              </tbody>
            </table>
            <div class="alert" style="display: none;"></div>
            <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
          </div>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  <?php if ($access == 3 || $access == 5) { ?>
  <div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading"><?= $judul?></h3>
        </div>
        <div class="panel-body ">
          <form id="createRealisasiPagu" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
            <div class="alert" style="display: none;"></div>
            <input type="hidden" class="form-control" name="kdindex" id="kdindex" value="<?= $rowPagu->kdindex ?>"/>
            <div class="form-group">
              <label class="col-lg-3 control-label">Tanggal Transaksi</label>
              <div class="col-lg-4 inputGroupContainer date">
                <div class="input-group input-append date">
                    <input type="text" class="form-control" id="inputTglIns1" name="tgl_transaksi_rpagu" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
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

              <label class="col-lg-3 control-label">Pagu Anggaran<br>Detail<br><span class="text-red">Sisa Pagu</span></label>
              <label class="col-lg-6 control-label" style="text-align: left !important;">
                  
                  Rp <?= number_format($rowPagu->pagu, 0, ',', '.'); ?><br>
                  <?= $rowPagu->ket ?><br>
                  
                  <input type="hidden" value="<?= $sisa_pagu ?>" name="sisa_pagu" id="sisa_pagu">
                  <span class="text-red"> Rp <?= number_format($sisa_pagu, 0, ',', '.'); ?></span>
              </label>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Jumlah Realisasi SPJ</label>
              <div class="col-lg-6">
                  <input type="text" class="form-control" name="jml_rpagu" id="jml_rpagu" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Keterangan</label>
              <div class="col-lg-6">
                  <textarea id="ket_rpagu" class="form-control" name="ket_rpagu" cols="50"></textarea>
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= base_url('pengeluaran/realisasi') ?>" class="btn btn-primary">Batal</a>
                </div>
            </div>
          </form>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  <?php } ?>
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/pengeluaran.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
