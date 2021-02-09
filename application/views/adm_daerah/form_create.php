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
                  <form id="<?= $nama_form ?>" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                    <?php if ($kategori == 'prov' && $id == NULL) { ?>
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Nama Provinsi</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="nama_prov" id="nama_prov" value=""/>
                        </div>
                      </div>
                    <?php } else if ($kategori == 'kabkota' && $id != NULL) { ?>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Provinsi</label>
                        <div class="col-lg-8">
                            <input type="hidden" class="form-control" readonly="" name="id_prov" id="id_prov" value="<?= $row_data->id_prov ?>"/>
                            <input type="text" class="form-control" readonly="" name="nama_prov" id="nama_prov" value="<?= $row_data->nama_prov ?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Kabupaten/Kota</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="nama_kab_kota" id="nama_kab_kota" value=""/>
                        </div>
                      </div>
                    <?php } else if ($kategori == 'kec' && $id != NULL) { ?>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Provinsi</label>
                        <div class="col-lg-8">
                            <input type="hidden" class="form-control" readonly="" name="id_prov" id="id_prov" value="<?= $row_data->id_prov ?>"/>
                            <input type="text" class="form-control" readonly="" name="nama_prov" id="nama_prov" value="<?= $row_data->nama_prov ?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Kabupaten/Kota</label>
                        <div class="col-lg-8">
                            <input type="hidden" class="form-control" readonly="" name="id_kab_kota" id="id_kab_kota" value="<?= $row_data->id_kab_kota ?>"/>
                            <input type="text" class="form-control" readonly="" name="nama_kab_kota" id="nama_kab_kota" value="<?= $row_data->nama_kab_kota ?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Kecamatan</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="nama_kec" id="nama_kec" value=""/>
                        </div>
                      </div>
                    <?php } else if ($kategori == 'desa' && $id != NULL) { ?>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Provinsi</label>
                        <div class="col-lg-8">
                            <input type="hidden" class="form-control" readonly="" name="id_prov" id="id_prov" value="<?= $row_data->id_prov ?>"/>
                            <input type="text" class="form-control" readonly="" name="nama_prov" id="nama_prov" value="<?= $row_data->nama_prov ?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Kabupaten/Kota</label>
                        <div class="col-lg-8">
                            <input type="hidden" class="form-control" readonly="" name="id_kab_kota" id="id_kab_kota" value="<?= $row_data->id_kab_kota ?>"/>
                            <input type="text" class="form-control" readonly="" name="nama_kab_kota" id="nama_kab_kota" value="<?= $row_data->nama_kab_kota ?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Kecamatan</label>
                        <div class="col-lg-8">
                            <input type="hidden" class="form-control" readonly="" name="id_kec" id="id_kec" value="<?= $row_data->id_kec ?>"/>
                            <input type="text" readonly="" class="form-control" name="nama_kec" id="nama_kec" value="<?= $row_data->nama_kec ?>"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Nama Desa</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="nama_desa" id="nama_desa" value=""/>
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="col-lg-3 control-label">Titik Koordinat</label>
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
                          <label class="col-lg-3 control-label">Sejarah</label>
                          <div class="col-lg-8">
                              <textarea id="sejarah" class="form-control" name="sejarah" cols="50"></textarea>
                          </div>
                      </div>
                    <?php } ?>
                    
                    
                    
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('referensi/administrasi/data') ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

 <script src="<?=base_url('assets/dist/js/content/adm_daerah.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
