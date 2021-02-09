<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<!-- Main content -->
<section class="content">
<!-- Info boxes -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
          <div class="panel-header">
            <div class="panel-heading">Unduh Data Penerimaan Tahun <?= date('Y') ?></div>
          </div><!-- /.panel-header -->
          <div class="panel-body">
            <div class="alert" style="display: none;"></div>
            <div class="col-lg-12">
              <form id="eksporTP" method="post" action="<?=base_url('penerimaan/eksportarget');?>" enctype="multipart/form-data" class="form-horizontal" >
                <div class="alert alert-success" style="display: none;"></div>
                <div class="form-group">
                  <label class="col-lg-5 control-label">Rekap Target Penerimaan </label>
                    <div class="col-lg-7">
                        <button type="submit" class="btn btn-primary">Unduh Data</button>
                    </div>
                </div>
              </form>
            </div>
            <div class="col-lg-12">
              <form id="eksporTPA" method="post" action="<?=base_url('penerimaan/eksporrealisasiakun');?>" enctype="multipart/form-data" class="form-horizontal" >
                <div class="alert alert-success" style="display: none;"></div>
                <div class="form-group">
                  <label class="col-lg-5 control-label">Rekap Realisasi Penerimaan Per Akun</label>
                  <div class="col-lg-2">
                      <select name="bulan" id="bulan" class="form-control" style="width: 100%;"">
                          <?php 
                          $bulan = array("SEMUA DATA", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                          $no = 1; 
                          for ($i=0;$i<=12;$i++) { ?>
                            <?php if ($bulan_exist == $i) { ?>
                                <option selected value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                            <?php } else { ?>
                                <option value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                            <?php } ?>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-2">
                        
                        <button type="submit" class="btn btn-primary">Unduh Data</button>
                    </div>

                </div>
              </form>
            </div>
            <div class="col-lg-12">
              <form id="eksporTPD" method="post" action="<?=base_url('penerimaan/eksporrealisasidetail');?>" enctype="multipart/form-data" class="form-horizontal" >
                <div class="alert alert-success" style="display: none;"></div>
                <div class="form-group">
                  <label class="col-lg-5 control-label">Rekap Detail Realisasi Penerimaan</label>
                  <div class="col-lg-2">
                      <select name="bulan" id="bulan" class="form-control" style="width: 100%;"">
                          <?php 
                          $bulan = array("SEMUA DATA", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                          $no = 1; 
                          for ($i=0;$i<=12;$i++) { ?>
                            <?php if ($bulan_exist == $i) { ?>
                                <option selected value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                            <?php } else { ?>
                                <option value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                            <?php } ?>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-2">
                        
                        <button type="submit" class="btn btn-primary">Unduh Data</button>
                    </div>

                </div>
              </form>
            </div>
          </div><!-- /.panel-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
</section>
<script src="<?=base_url('assets/dist/js/content/ekspor.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>