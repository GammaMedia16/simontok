<?php
  $title = "Input File Laporan";
  $icon = "fa fa-file-text-o";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<!-- Main content -->
<div class="page-wrapper">
  <div class="container pt-30">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Input File Laporan Tahun <?= $tahun_exist ?></h3>
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <form id="updateLaporanForm" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Judul Laporan</label>
                        <div class="col-lg-6">
                            <input type="hidden" class="form-control" name="id_laporan" id="id_laporan" value="<?= $record->id_laporan ?>"/>
                            <input type="hidden" class="form-control" name="file_old" id="file_old" value="<?= $record->file_laporan ?>"/>
                            <input type="text" class="form-control" name="judul_laporan" id="judul_laporan" value="<?= $record->judul_laporan ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Jurusan</label>
                        <div class="col-lg-4 inputGroupContainer">
                            <select name="jurusan" id="jurusan" class="form-control" style="width: 100%;">
                                <?php foreach ($dataJur as $row) { ?>
                                <?php if ($row->id_laporan == $record->jurusan_id) { ?>
                                    <option selected value="<?= $row->id_laporan ?>"><?= $row->nama_jur ?></option>
                                    <?php } else { ?>
                                    <option selected value="<?= $row->id_laporan ?>"><?= $row->nama_jur ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Tahun</label>
                        <div class="col-lg-4 inputGroupContainer">
                            <select name="tahun" id="tahun" class="form-control" style="width: 100%;">
                                <?php 
                                  $thn_min = date("Y",strtotime(" -5 year"));;
                                  $thn_max = date("Y");
                                  $no = 1; 
                                  for ($i=$thn_min; $i <= $thn_max; $i++) { ?>
                                    <?php if ($record->tahun == $i) { ?>
                                        <option selected value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">File Laporan</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filelaporan" name="filelaporan" />
                            <p class="text-muted">*) Apabila File Laporan tidak diubah, dikosongkan saja.</p>
                            <?php if ($record->file_laporan != '') { ?>
                            File Laporan : <a target="_blank" href="<?= base_url('assets/filelaporan/'.$record->file_laporan) ?>">
                            <?= $record->file_laporan ?></a>
                            <?php } else { ?>
                            File Laporan Kosong</p>
                            <?php } ?><!-- <span class="help-block">Choose a pdf file with a size between 1M and 10M.</span> -->
                        </div>
                    </div>
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" onclick="location.href='<?=base_url('laporan')?>'" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->
</div>
<script src="<?=base_url('assets/dist/js/content/laporan.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>