<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  
?>
<!-- Main content -->
<section class="content">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?></h3>
                  <div class="col-lg-12 pull-right">
                    <form method="post" role="form" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Fungsi KK</label>
                          <div class="col-lg-3">
                            <select onChange="this.form.submit()" name="fungsi_kk_id" id="fungsi_kk_id" class="form-control" style="width: 100%;" >
                                    <?php if ($fungsi_exist == 0) { ?>
                                        <option selected value="0">SEMUA DATA</option>
                                    <?php } else { ?>
                                        <option value="0">SEMUA DATA</option>
                                    <?php } ?>
                                    <?php foreach ($dataFungsiKK as $row2) { ?>
                                        <?php if ($fungsi_exist == $row2->id_fungsi_kk) { ?>
                                        <option selected value="<?= $row2->id_fungsi_kk ?>"><?= $row2->nama_fungsi ?></option>
                                        <?php } else { ?>
                                        <option value="<?= $row2->id_fungsi_kk ?>"><?= $row2->nama_fungsi ?></option>
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                          </div>
                          <?php if ($this->session->sub_role != 4 ) { ?>
                          <label class="col-lg-2 control-label">Satuan Kerja</label>
                          <div class="col-lg-4">
                            <select onChange="this.form.submit()" name="satker_kode" id="satker_kode" class="form-control select2" style="width: 100%;" >
                                    <?php if ($satker_exist == 0) { ?>
                                        <option selected value="0">SEMUA DATA</option>
                                    <?php } else { ?>
                                        <option value="0">SEMUA DATA</option>
                                    <?php } ?>
                                    <?php foreach ($dataSatker as $row) { ?>
                                        <?php if ($satker_exist == $row->kode_satker) { ?>
                                        <option selected value="<?= $row->kode_satker ?>"><?= $row->nama_satker ?></option>
                                        <?php } else { ?>
                                        <option value="<?= $row->kode_satker ?>"><?= $row->nama_satker ?></option>
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                          </div>
                          <?php } ?>
                        </div>
                        <?php if ($this->session->sub_role != 4 ) { ?>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Provinsi</label>
                          <div class="col-lg-4">
                            <select onChange="this.form.submit()" name="prov_id" id="prov_id" class="form-control select2" style="width: 100%;" >
                                    <?php if ($prov_exist == 0) { ?>
                                        <option selected value="0">SEMUA DATA</option>
                                    <?php } else { ?>
                                        <option value="0">SEMUA DATA</option>
                                    <?php } ?>
                                    <?php foreach ($dataProv as $row1) { ?>
                                        <?php if ($prov_exist == $row1->id_prov) { ?>
                                        <option selected value="<?= $row1->id_prov ?>"><?= $row1->nama_prov ?></option>
                                        <?php } else { ?>
                                        <option value="<?= $row1->id_prov ?>"><?= $row1->nama_prov ?></option>
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                          </div>
                        </div>
                        <?php } ?>
                    </form>
                  </div>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <?php 
                    $access = $this->session->sub_role;
                    if (!$access) { $access = 0; }
                    if ($access == 3) { ?>
                        <div class="col-lg-12">
                            <a href="<?=base_url();?>referensi/kawasan/add" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>TAMBAH DATA KAWASAN</strong></a>
                            <br><br><br>
                        </div>
                        
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                          <table id="tableMDI" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>REGISTER KAWASAN</th>
                                <th>NAMA KAWASAN</th>
                                <th>FUNGSI KAWASAN</th>
                                <th>AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                              <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->reg_kk ?></td>
                                <td><?= $row->nama_kk ?></td>
                                <td><?= $row->nama_fungsi ?></td>
                                <td>
                                    <?php if ($access == 3 || $this->session->satker_kode == $row->satker_kode) { ?>
                                        <button onclick="location.href='<?=base_url('referensi/kawasan/edit/'.$row->reg_kk);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                    <?php } ?>
                                        <button onclick="location.href='<?=base_url('referensi/kawasan/detail/'.$row->reg_kk);?>'" type="button" class="btn btn-xs btn-info"><i class="fa fa-search"></i>&nbsp;Detail</button>
                                </td>
                              </tr>
                            <?php $no++; } ?>
                            </tbody>
                          </table>
                          <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
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
</section>
<script src="<?=base_url('assets/dist/js/content/kawasan.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>