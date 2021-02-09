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
          <form id="editRealisasiPagu" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
            <div class="alert" style="display: none;"></div>
            <input type="hidden" class="form-control" name="id_rpagu" id="id_rpagu" value="<?= $rowRealPagu->id_rpagu ?>"/>
            <input type="hidden" class="form-control" name="kdindex" id="kdindex" value="<?= $rowRealPagu->kdindex ?>"/>
            <div class="form-group">
              <label class="col-lg-3 control-label">Tanggal Transaksi</label>
              <div class="col-lg-4 inputGroupContainer date">
                <div class="input-group input-append date">
                    <input type="text" class="form-control" id="inputTglIns1" name="tgl_transaksi_rpagu" style="cursor: pointer" value="<?= $rowRealPagu->tgl_transaksi_rpagu ?>" placeholder="YYYY-MM-DD"/>
                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Bulan</label>
              <div class="col-lg-4">
                  <select name="bulan" id="bulan" class="form-control">
                      <?php 
                      $no = 1; 
                      foreach ($bulan as $i => $v) {
                        $val = $i+1; 
                        $bulan_exist = intval($rowRealPagu->bulan) - 1; ?>
                        <?php if ($bulan_exist == $i) { ?>
                            <option selected value="<?= $val; ?>"><?= $bulan[$i]; ?></option>
                        <?php } else { ?>
                            <option value="<?= $val; ?>"><?= $bulan[$i]; ?></option>
                        <?php } ?>
                      <?php } ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Jumlah Realisasi SPJ</label>
              <div class="col-lg-6">
                  <input type="text" class="form-control" name="jml_rpagu" id="jml_rpagu" value="<?= $rowRealPagu->jml_rpagu ?>"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Keterangan</label>
              <div class="col-lg-6">
                  <textarea id="ket_rpagu" class="form-control" name="ket_rpagu" cols="50"><?= $rowRealPagu->ket_rpagu ?></textarea>
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-3">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?= base_url('pengeluaran/addrealisasipagu/'.$rowRealPagu->kdindex) ?>" class="btn btn-primary">Batal</a>
                </div>
            </div>
          </form>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/pengeluaran.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
