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
                  <form id="updateDPKKForm" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                      
                      
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Satker / Kawasan Konservasi</label>
                      <div class="col-lg-4 inputGroupContainer">
                          <input type="hidden" class="form-control" name="id_dpkk" id="id_dpkk" value="<?= $record->id_dpkk ?>"/>
                          <?php if ($access == 4) { ?>
                            <input type="hidden" class="form-control" name="satker_kode" id="satker_kode_hidden" value="<?= $this->session->satker_kode ?>"/>
                          <?php } ?>
                          <select <?= $disabled ?> name="satker_kode" id="satker_kode" class="form-control select2" style="width: 100%;" data-placeholder="-- Pilih Satuan Kerja --">
                              <?php foreach ($dataSatker as $row2) { ?>
                                <?php if ($record->satker_kode == $row2->kode_satker) { ?>
                                  <option selected value="<?= $row2->kode_satker ?>"><?= $row2->nama_satker ?></option>
                                <?php } else { ?>
                                  <option value="<?= $row2->kode_satker ?>"><?= $row2->nama_satker ?></option>
                                <?php } ?>
                              <?php } ?>                            
                          </select>
                      </div>
                      <div class="col-lg-4 inputGroupContainer">
                          <select name="kk_reg" id="kk_reg" class="form-control select2" style="width: 100%;display:none;" data-placeholder="-- Pilih Kawasan Koservasi --">
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Desa</label>
                      <div class="col-lg-8 inputGroupContainer">
                          <select name="desa_id[]" multiple="multiple" id="desa_id" class="form-control select2"  data-placeholder="-- Pilih Desa --" style="width: 100%;display:none;">
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Status Daerah Penyangga</label>
                      <div class="col-lg-8 inputGroupContainer">
                          <select name="status_kawasan[]" id="status_kawasan" class="form-control select2" style="width: 100%;" multiple="multiple" data-placeholder="-- Pilih Status Daerah Penyangga --">
                                                         
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">No SK Penetapan</label>
                      <div class="col-lg-6">
                          <input type="text" class="form-control" name="no_sk_dpkk" id="no_sk_dpkk" value="<?= $record->no_sk_dpkk ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File SK Penetapan</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="fileskpenetapan" name="fileskpenetapan" />
                            <span class="text-muted">Format file *.PDF dengan ukuran maksimal 2MB.</span>
                            <p class="text-muted">*) Apabila File tidak diubah, dikosongkan saja.</p>
                            <?php if ($record->file_sk_dpkk != '') { ?>
                            File SK Penetapan : <a target="_blank" href="<?= base_url('assets/filedaerahpenyangga/'.$record->file_sk_dpkk) ?>">
                            <?= $record->file_sk_dpkk ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File Peta</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" id="filepeta" name="filepeta" />
                            <span class="text-muted">Format file *.KML dengan ukuran maksimal 2MB.</span>
                            <p class="text-muted">*) Apabila File tidak diubah, dikosongkan saja.</p>
                            <?php if ($record->file_peta != '') { ?>
                            File Peta: <a target="_blank" href="<?= base_url('assets/filedaerahpenyangga/'.$record->file_peta) ?>">
                            <?= $record->file_peta ?></a>
                            <?php } else { ?>
                            File Kosong</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Luas Daerah Penyangga KK</label>
                      <div class="col-lg-4">
                          <div class="input-group input-append">
                              <input type="text" class="form-control" value="<?= $record->luas_dpkk ?>" id="luas_dpkk" name="luas_dpkk" />
                              <span class="input-group-addon add-on">Ha</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Keterangan</label>
                        <div class="col-lg-8">
                            <textarea id="keterangan" class="form-control" name="keterangan" cols="50"><?= $record->keterangan ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" onclick="deleteData(<?= $record->id_dpkk ?>)" class="btn btn-danger">Hapus Data</button>
                            <a href="<?= base_url('dpkk') ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/dpkk.js')?>"></script> 
<script type="text/javascript">
  var initialLoad = true;
  var dataStatusKawasan = <?= $dataRefStatusKawasan ?>;
  $(document).ready(function () {
    initialLoad = false;
    if (initialLoad == false) {
      var json_data_reff = <?= $recordSelectedReff ?>;
      for(var i in json_data_reff) {
          dataStatusKawasan = $.grep(dataStatusKawasan, function(e) { return e.id!=json_data_reff[i]['id'] });
          dataStatusKawasan.push(json_data_reff[i]);
      }
    }
    $("#status_kawasan").select2({
      data: dataStatusKawasan
    });
  });

  $('#satker_kode').select2().on('change', function() {
      var id_select = $(this).val();
      var dataKK = $.parseJSON($.ajax({
                  url:  '../getdatakk',
                  dataType: "json",
                  type: 'GET',
                  data: {id:id_select},
                  async: false
              }).responseText);
      $("#kk_reg").empty();
      if (initialLoad) {
        dataKK = $.grep(dataKK, function(e) { return e.id!=<?= $record->kk_reg ?> });
        dataKK.push(
            {id: <?= $record->kk_reg ?>, text: "<?= $record->short_name.'. '.$record->nama_kk ?>", selected: "true"}
        );
      }

      $("#kk_reg").select2({
        data: dataKK
      });
      var dataDesa = $.parseJSON($.ajax({
                  url:  '../getdatadesa',
                  dataType: "json",
                  type: 'GET',
                  data: {id:$("#kk_reg").val()},
                  async: false
              }).responseText);
      $("#desa_id").empty();
      if (initialLoad) {
          var my_json = <?= $recordSelectedDesa ?>;
          for(var i in my_json) {
              dataDesa = $.grep(dataDesa, function(e) { return e.id!=my_json[i]['id'] });
              dataDesa.push(my_json[i]);
          }
        }
      $("#desa_id").select2({
        data: dataDesa
      });
      //console.log(dataKK);
  }).trigger('change');

  $('#kk_reg').select2().on('change', function() {
      var id_select = $(this).val();
      var dataDesa = $.parseJSON($.ajax({
                  url:  '../getdatadesa',
                  dataType: "json",
                  type: 'GET',
                  data: {id:id_select},
                  async: false
              }).responseText);
      
      $("#desa_id").empty();
      if (initialLoad) {
        var my_json = <?= $recordSelectedDesa ?>;
        for(var i in my_json) {
            dataDesa = $.grep(dataDesa, function(e) { return e.id!=my_json[i]['id'] });
            dataDesa.push(my_json[i]);
        }
      }
      $("#desa_id").select2({
        data: dataDesa
      });
  }).trigger('change');

  
</script>
<?php
  load_controller('Commons', 'footer');
?>
