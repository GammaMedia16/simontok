<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  //$this->load->view('design/header');
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
                  <form id="updateKawasanForm" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                      <div class="form-group">
                      <label class="col-lg-3 control-label">Nama Kawasan</label>
                      <div class="col-lg-8">
                          <input type="hidden" readonly="" class="form-control" name="reg_kk_old" id="reg_kk_old" value="<?= $record->reg_kk ?>"/>
                          <input type="hidden" readonly="" class="form-control" name="created_old" id="created_old" value="<?= $record->created_at ?>"/>
                          <input type="hidden" readonly="" class="form-control" name="satker_kode" id="satker_kode" value="<?= $record->satker_kode ?>"/>
                          <input type="text" class="form-control" name="nama_kk" id="nama_kk" value="<?= $record->nama_kk ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Register Kawasan</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="reg_kk" id="reg_kk" value="<?= $record->reg_kk ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">ID WDPA</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="wdpa_id" id="wdpa_id" value="<?= $record->wdpa_id ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Provinsi</label>
                        <div class="col-lg-8 inputGroupContainer">
                            <select name="prov_id[]" id="prov_id" class="form-control select2" style="width: 100%;" multiple="multiple" data-placeholder="-- Pilih Provinsi --">
                                <?php foreach ($dataProv as $row) { ?>
                                <option value="<?= $row->id_prov ?>"><?= $row->nama_prov ?></option>
                                <?php } ?>                            
                            </select>
                        </div>
                      </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Fungsi Kawasan</label>
                      <div class="col-lg-4 inputGroupContainer">
                          <select name="fungsi_kk_id" id="fungsi_kk_id" class="form-control" style="width: 100%;" >
                            <?php foreach ($dataFungsiKK as $row1) { ?>
                              <?php if ($record->fungsi_kk_id == $row1->id_fungsi_kk) { ?>
                              <option selected value="<?= $row1->id_fungsi_kk ?>"><?= $row1->nama_fungsi ?></option>
                              <?php } else { ?>
                              <option value="<?= $row1->id_fungsi_kk ?>"><?= $row1->nama_fungsi ?></option>
                              <?php } ?>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Luas Kawasan</label>
                      <div class="col-lg-4">
                          <div class="input-group input-append">
                              <input type="text" class="form-control" id="luas_kk" value="<?= $record->luas_kk ?>" name="luas_kk" />
                              <span class="input-group-addon add-on">Ha</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Luas Zona/Blok Tradisional</label>
                      <div class="col-lg-4">
                          <div class="input-group input-append">
                              <input type="text" class="form-control" value="<?= $record->luas_zona ?>" id="luas_zona" name="luas_zona" />
                              <span class="input-group-addon add-on">Ha</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Luas Open Area</label>
                      <div class="col-lg-4">
                          <div class="input-group input-append">
                              <input type="text" class="form-control" value="<?= $record->luas_open_area ?>" id="luas_open_area" name="luas_open_area" />
                              <span class="input-group-addon add-on">Ha</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('referensi/kawasan') ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </div>
                    <div class="alert" style="display: block;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/kawasan.js')?>"></script> 
<script type="text/javascript">
    $(document).ready(function () {
      var valProvinsi = '<?= $record->prov_id ?>';
      var arrayProvinsi = valProvinsi.split(',');
      $('#prov_id').select2('val',arrayProvinsi);
    });

</script>
<?php
  load_controller('Commons', 'footer');
?>
