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
            <div class="panel-heading">Unduh Data Pengeluaran Tahun <?= date('Y') ?></div>
          </div><!-- /.panel-header -->
          <div class="panel-body">
            <div class="alert" style="display: none;"></div>
            <div class="col-lg-12">
              <form id="" method="post" action="<?=base_url('pengeluaran/eksporrealisasipagu');?>" enctype="multipart/form-data" class="form-horizontal ml-4" >
                <div class="alert alert-success" style="display: none;"></div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><u>Rekap Realisasi Pagu per Hari</u></label>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 control-label">Tanggal</label>
                  <div class="col-lg-3 inputGroupContainer date">
                    <div class="input-group input-append date">
                        <input type="text" class="form-control" id="inputTglIns1" name="tanggal" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                  <div class="col-lg-2">
                      <button type="submit" class="btn btn-primary">Unduh Data</button>
                  </div>
                </div>
                
              </form>
            </div>
            <div class="col-lg-12">
              <form id="" method="post" action="<?=base_url('pengeluaran/eksporrealisasisah');?>" enctype="multipart/form-data" class="form-horizontal ml-4" >
                <div class="alert alert-success" style="display: none;"></div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><u>Rekap Realisasi Pengesahan per Hari</u></label>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 control-label">Tanggal</label>
                  <div class="col-lg-3 inputGroupContainer date">
                    <div class="input-group input-append date">
                        <input type="text" class="form-control" id="inputTglIns1" name="tanggal" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
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