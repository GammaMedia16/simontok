<?php
  $title = "Input Data Monitoring";
  $icon = "fa fa-plus";
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
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Form Input Data Monitoring</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="createTallysheetForm" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert alert-success" style="display: none;"></div>
                    
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Jenis Kegiatan</label>
                        <div class="col-lg-4 inputGroupContainer">
                            <select name="tallysheet_id" id="tallysheet_id" class="form-control select2" style="width: 100%;" >
                                <option value="0">-- Pilih Jenis Kegiatan --</option>
                                <?php foreach ($dataTallysheet as $row1) { ?>
                                <option value="<?= $row1->id ?>"><?= ucwords($row1->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Resort</label>
                        <div class="col-lg-4 inputGroupContainer">
                            <select name="resort_id" id="resort_id" class="form-control" style="width: 100%;">
                                <?php foreach ($dataRes as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->nama_resort ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Waktu</label>
                        <div class="col-lg-4 inputGroupContainer date">
                            <div class="input-group input-append date">
                                <input type="text" class="form-control" id="inputTglIns0" name="date_tallysheet" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-lg-4 inputGroupContainer date">
                            <div class="input-group input-append date">
                                <input type="text" id="time_tallysheet" name="time_tallysheet"  value="<?= date('H:i:s') ?>" class="form-control">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-time"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Titik Koordinat</label>
                        <div class="col-lg-4 inputGroupContainer">
                            <div class="input-group input-append">
                                <input type="text" class="form-control" id="lat" name="lat" />
                                <span class="input-group-addon add-on">LAT</span>
                            </div>
                        </div>
                        <div class="col-lg-4 inputGroupContainer">
                            <div class="input-group input-append">
                                <input type="text" id="lon" name="lon" class="form-control">
                                <span class="input-group-addon add-on">LON</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Petugas</label>
                        <div class="col-lg-8 inputGroupContainer">
                            <select name="petugas_id[]" id="petugas_id" class="form-control select2" style="width: 100%;" multiple="multiple" data-placeholder="-- Pilih Nama Pegawai --">
                                <?php foreach ($dataPetugas as $row2) { ?>
                                <option value="<?= $row2->id_user ?>"><?= $row2->nama_user ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="add_referensi">
                        
                    </div>
                    <div id="add_deskripsi">
                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">File Foto</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="file_foto" name="file_foto" />
                            <span class="help-block">Unggah gambar dengan format *.JPG | *.JPEG | *.PNG maksimal ukuran 500Kb</span>
                        </div>
                    </div>
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-4">
                            <button id="btnSimpan" type="submit" class="btn btn-primary" disabled>Simpan</button>
                            <button type="button" onclick="location.href='<?=base_url('tallysheet/baru')?>'" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
</section>
<script src="<?=base_url('assets/dist/js/content/tallysheet.js')?>"></script>
<script>
    window.paceOptions = {
        ajax: {
            trackMethods: ['GET', 'POST', 'PUT', 'DELETE', 'REMOVE']
        },
        restartOnRequestAfter: true
    };
</script>
<?php
  load_controller('Commons', 'footer');
?>