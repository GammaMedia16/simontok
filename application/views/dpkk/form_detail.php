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
                  <form id="" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                      
                      
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Satker / Kawasan Konservasi</label>
                      <div class="col-lg-4 inputGroupContainer">
                          <input readonly="" type="text" class="form-control" name="" id="" value="<?= $record->nama_satker ?>"/>
                          
                      </div>
                      <div class="col-lg-4 inputGroupContainer">
                          <input readonly="" type="text" class="form-control" name="" id="" value="<?= $record->short_name.' '.$record->nama_kk ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-10 col-lg-offset-1" style="text-align: left !important;">
                          <table id="" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="5%">NO</th>
                                <th width="20%">PROVINSI</th>
                                <th width="25%">KAB/KOTA</th>
                                <th width="20%">KECAMATAN</th>
                                <th width="30%">DESA</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                $no=1;
                                $arr_desa = load_controller('Dpkk', 'getdatadesaekspor', $record->desa_id);
                                foreach ($arr_desa as $key => $value) {
                              ?>
                                  <tr>
                                    <td><?= $no ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_prov']) ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_kab_kota']) ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_kec']) ?></td>
                                    <td><?= ucwords($arr_desa[$key]['nama_desa']) ?></td>
                                  </tr>
                              <?php $no++; } ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Status Daerah Penyangga</label>
                      <label class="col-lg-6 control-label" style="text-align: left !important;">
                          <?= load_controller('Dpkk', 'getdatastatuskwsview', $record->status_kawasan) ?>
                      </label>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">No SK Penetapan</label>
                      <div class="col-lg-6">
                          <input readonly="" type="text" class="form-control" name="no_sk_dpkk" id="no_sk_dpkk" value="<?= $record->no_sk_dpkk ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File SK Penetapan</label>
                        <div class="col-lg-6">
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
                              <input  readonly="" type="text" class="form-control" value="<?= $record->luas_dpkk ?>" id="luas_dpkk" name="luas_dpkk" />
                              <span class="input-group-addon add-on">Ha</span>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Keterangan</label>
                        <div class="col-lg-8">
                            <textarea  readonly="" id="keterangan" class="form-control" name="keterangan" cols="50"><?= $record->keterangan ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-8 pull-left col-lg-offset-3">Diperbarui oleh <?= $record->nama_user ?> pada <?php $waktu = date_create($record->last_update); echo date_format($waktu, 'd M Y H:i:s'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <a href="<?= base_url('dpkk') ?>" class="btn btn-primary">Kembali</a>
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

<?php
  load_controller('Commons', 'footer');
?>
