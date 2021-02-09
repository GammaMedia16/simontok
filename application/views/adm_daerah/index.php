<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  //$this->load->view('design/header');
?>
<!-- Main content -->

<!-- Info paneles -->
<!-- Main row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?></h3>
                </div><!-- /.panel-header -->
                <div class="panel-body"> 

                    <?php 
                      $access = $this->session->sub_role;
                      if (!$access) { $access = 0; }
                      if ($access == 3) { ?>
                          <?php if ($prov == NULL && $kab_kota == NULL && $kec == NULL) { ?>
                            <a style="margin-bottom: 30px" href="<?=base_url();?>referensi/administrasi/add/prov" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>TAMBAH DATA PROVINSI</strong></a>
                          <?php } else if ($prov != NULL && $kab_kota == NULL && $kec == NULL) { ?>
                            <a style="margin: 20px" href="<?=base_url();?>referensi/administrasi/add/kabkota/<?= $prov ?>" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>TAMBAH DATA KABUPATEN/KOTA</strong></a>
                            <a style="margin: 20px" href="<?=base_url();?>referensi/administrasi/data" type="button" class="btn btn-success"><i class="fa fa-refresh"></i> <strong>SEMUA PROVINSI</strong></a>
                            <a href="<?=base_url();?>referensi/administrasi/data/<?=$prov?>"><?= $record[0]->nama_prov ?></a>
                          <?php } else if ($prov != NULL && $kab_kota != NULL && $kec == NULL) { ?>
                            <a style="margin: 20px" href="<?=base_url();?>referensi/administrasi/add/kec/<?= $kab_kota ?>" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>TAMBAH DATA KECAMATAN</strong></a>
                            <a href="<?=base_url();?>referensi/administrasi/data/<?=$prov?>"><?= $record[0]->nama_prov ?></a> / <a href="<?=base_url();?>referensi/administrasi/data/<?=$prov?>/<?=$kab_kota?>"><?= $record[0]->nama_kab_kota ?></a>
                          <?php } else if ($prov != NULL && $kab_kota != NULL && $kec != NULL) { ?>
                            <a style="margin: 20px" href="<?=base_url();?>referensi/administrasi/add/desa/<?= $kec ?>" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>TAMBAH DATA DESA</strong></a>
                            <a href="<?=base_url();?>referensi/administrasi/data/<?=$prov?>"><?= $record[0]->nama_prov ?></a> / <a href="<?=base_url();?>referensi/administrasi/data/<?=$prov?>/<?=$kab_kota?>"><?= $record[0]->nama_kab_kota ?></a> / <a href="<?=base_url();?>referensi/administrasi/data/<?=$prov?>/<?=$kab_kota?>/<?=$kec?>"><?= $record[0]->nama_kec ?></a>
                          <?php } ?>
                          
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                          <table id="tableMDI" class="table table-striped table-bordered" style="text-transform: capitalize !important;">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <?php if ($prov == NULL && $kab_kota == NULL && $kec == NULL) { ?>
                                  <th>PROVINSI</th>
                                <?php } else if ($prov != NULL && $kab_kota == NULL && $kec == NULL) { ?>
                                  <th>KABUPATEN / KOTA DI <?= $record[0]->nama_prov ?></th>
                                <?php } else if ($prov != NULL && $kab_kota != NULL && $kec == NULL) { ?>
                                  <th>KECAMATAN DI <?= $record[0]->nama_kab_kota ?>, <?= $record[0]->nama_prov ?></th>
                                <?php } else if ($prov != NULL && $kab_kota != NULL && $kec != NULL) { ?>
                                  <th>DESA DI <?= $record[0]->nama_kec ?><br><?= $record[0]->nama_kab_kota ?>, <?= $record[0]->nama_prov ?></th>
                                <?php } ?>
                                <th>AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                              <tr>
                                <?php if ($prov == NULL && $kab_kota == NULL && $kec == NULL) { ?>
                                  <td><?= $no ?></td>
                                  <td><a href="<?=base_url();?>referensi/administrasi/data/<?=$row->id_prov?>"><?= $row->nama_prov ?></a></td>
                                <?php } else if ($prov != NULL && $row->id_kab_kota != 0 && $kab_kota == NULL && $kec == NULL) { ?>
                                  <td><?= $no ?></td>
                                  <td><a href="<?=base_url();?>referensi/administrasi/data/<?=$row->id_prov?>/<?=$row->id_kab_kota?>"><?= $row->nama_kab_kota ?></a></td>
                                <?php } else if ($prov != NULL && $kab_kota != NULL && $row->id_kec != 0 && $kec == NULL) { ?>
                                  <td><?= $no ?></td>
                                  <td><a href="<?=base_url();?>referensi/administrasi/data/<?=$row->id_prov?>/<?=$row->id_kab_kota?>/<?=$row->id_kec?>"><?= $row->nama_kec ?></a></td>
                                <?php } else if ($prov != NULL && $kab_kota != NULL && $kec != NULL && $row->id_desa != '') { ?>
                                  <td><?= $no ?></td>
                                  <td><?= $row->nama_desa ?></td>
                                <?php } ?>
                                  
                                <td>
                                  <?php if ($access == 3) { ?>
                                    <?php if ($prov == NULL && $kab_kota == NULL && $kec == NULL) { ?>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/edit/prov/'.$row->id_prov);?>'" type="button" class="btn btn-xs bg-warning "><i class="fa fa-pencil"></i>&nbsp;Ubah Provinsi</button>
                                    <?php } else if ($prov != NULL && $row->id_kab_kota != 0 && $kab_kota == NULL && $kec == NULL) { ?>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/edit/kabkota/'.$row->id_kab_kota);?>'" type="button" class="btn btn-xs bg-warning "><i class="fa fa-pencil"></i>&nbsp;Ubah Kab/Kota</button>
                                    <?php } else if ($prov != NULL && $kab_kota != NULL && $row->id_kec != 0 && $kec == NULL) { ?>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/edit/kec/'.$row->id_kec);?>'" type="button" class="btn btn-xs bg-warning "><i class="fa fa-pencil"></i>&nbsp;Ubah Kecamatan</button>
                                    <?php } else if ($prov != NULL && $kab_kota != NULL && $kec != NULL && $row->id_desa != '') { ?>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/edit/desa/'.$row->id_desa);?>'" type="button" class="btn btn-xs bg-warning "><i class="fa fa-pencil"></i>&nbsp;Ubah Desa</button>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/detail/'.$row->id_desa);?>'" type="button" class="btn btn-xs btn-info "><i class="fa fa-search"></i>&nbsp;Detail</button>
                                    <?php } ?>
                                  <?php } ?>
                                  <?php if ($access == 4) { ?>
                                    <?php if ($prov != NULL && $kab_kota != NULL && $kec != NULL && $row->id_desa != '') { ?>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/edit/desa/'.$row->id_desa);?>'" type="button" class="btn btn-xs bg-warning "><i class="fa fa-pencil"></i>&nbsp;Ubah Desa</button>
                                      <button onclick="location.href='<?=base_url('referensi/administrasi/detail/'.$row->id_desa);?>'" type="button" class="btn btn-xs btn-info "><i class="fa fa-search"></i>&nbsp;Detail</button>
                                    <?php } ?>
                                  <?php } ?>


                                </td>
                              </tr>
                            <?php $no++; } ?>
                            </tbody>
                          </table>
                    </div>
                    </div>
                </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?=base_url('assets/dist/js/content/website.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>