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
                  <form id="updateSatkerForm" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                      
                      
                      <div class="form-group">
                      <label class="col-lg-3 control-label">Nama Satuan Kerja</label>
                      <div class="col-lg-8">
                          <input type="text" readonly="" class="form-control" name="nama_satker" id="nama_satker" value="<?= $record->nama_satker ?>"/>
                          <input type="hidden" class="form-control" name="kode_satker_old" id="kode_satker_old" value="<?= $record->kode_satker ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Kode Satuan Kerja</label>
                      <div class="col-lg-6">
                          <input type="text" readonly="" class="form-control" name="kode_satker" id="kode_satker" value="<?= $record->kode_satker ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Alamat</label>
                        <div class="col-lg-8">
                            <textarea id="alamat" readonly="" class="form-control" name="alamat" cols="50"><?= $record->alamat ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Email</label>
                      <div class="col-lg-6">
                          <input type="text" readonly="" class="form-control" name="email" id="email" value="<?= $record->email ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">No Telepon</label>
                      <div class="col-lg-6">
                          <input type="text" readonly="" class="form-control" name="telp" id="telp" value="<?= $record->telp ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Kawasan Konservasi</label>
                      <div class="col-lg-8 inputGroupContainer">
                          <select disabled="" name="reg_kk[]" id="reg_kk" class="form-control select2" style="width: 100%;" multiple="multiple" data-placeholder="-- Pilih Kawasan Konservasi --">
                              <?php foreach ($dataKK as $row1) { ?>
                              <option value="<?= $row1->reg_kk ?>"><?= $row1->short_name.'. '.$row1->nama_kk ?></option>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Nama Provinsi</label>
                      <div class="col-lg-8 inputGroupContainer">
                          <select disabled="" name="prov_id[]" id="prov_id" class="form-control select2" style="width: 100%;" multiple="multiple" data-placeholder="-- Pilih Provinsi --">
                              <?php foreach ($dataProv as $row) { ?>
                              <option value="<?= $row->id_prov ?>"><?= $row->nama_prov ?></option>
                              <?php } ?>                            
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 pull-left col-lg-offset-3">Diperbarui oleh <?= $record->nama_user ?> pada <?php $waktu = date_create($record->last_update); echo date_format($waktu, 'd M Y H:i:s'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <a href="<?= base_url('referensi/satker') ?>" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/satker.js')?>"></script> 
<script type="text/javascript">
    $(document).ready(function () {
      var valProvinsi = '<?= $record->prov_id ?>';
      var arrayProvinsi = valProvinsi.split(',');
      $('#prov_id').select2('val',arrayProvinsi);
      var valKK = '<?= $record_kk ?>';
      var arrayKK = valKK.split(';');
      $('#reg_kk').select2('val',arrayKK);
    });
</script>
<?php
  load_controller('Commons', 'footer');
?>
