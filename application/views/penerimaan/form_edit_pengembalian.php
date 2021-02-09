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
          <h3 class="panel-heading"><?= $judul?></h3>
        </div>
        <div class="panel-body ">
          <form id="editPengembalian" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
            <div class="alert" style="display: none;"></div>
            <input type="hidden" class="form-control" name="id_rterima" id="id_rterima" value="<?= $rowReal->id_rterima ?>"/>
            <input type="hidden" class="form-control" name="kode_akun_penerimaan" id="kode_akun_penerimaan" value="<?= $rowReal->kode_akun_penerimaan ?>"/>
            <div class="form-group">
              <label class="col-lg-3 control-label">Tanggal Transaksi</label>
              <div class="col-lg-4 inputGroupContainer date">
                <div class="input-group input-append date">
                  <?php 
                  if ($rowReal->tgl_transaksi_pengembalian == '0000-00-00') {
                    $d_pengembalian = date('Y-m-d');
                  } else {
                    $d_pengembalian = $rowReal->tgl_transaksi_pengembalian;
                  }
                  ?>
                    <input type="text" class="form-control" id="inputTglIns1" name="tgl_transaksi_pengembalian" style="cursor: pointer" value="<?= $d_pengembalian ?>" placeholder="YYYY-MM-DD"/>
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Jumlah Realisasi Penerimaan</label>
              <div class="col-lg-6">
                  <input type="text" class="form-control" name="jml_rterima" id="jml_rterima" readonly value="<?= $rowReal->jml_rterima ?>"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Jumlah Pengembalian Realisasi</label>
              <div class="col-lg-6">
                  <input type="text" class="form-control" name="jml_pengembalian" id="jml_pengembalian" value="<?= $rowReal->jml_pengembalian ?>"/>
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= base_url('penerimaan/addrealisasipenerimaan/'.$rowReal->kode_akun_penerimaan) ?>" class="btn btn-primary">Batal</a>
                </div>
            </div>
          </form>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/penerimaan.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
