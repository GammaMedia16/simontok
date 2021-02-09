<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  if ($tahun_exist != 0) {
    $tahun_judul = 'Tahun '.$tahun_exist;
  } else {
    $tahun_judul = 'sampai dengan Tahun '.date('Y');
  }
?>
<!-- Main content -->
<section class="content">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?> <?= $tahun_judul ?></h3>
                  <div class="col-lg-12 pull-right">
                    <form method="post" id="filterFormBinaDesa" role="form" class="form-horizontal">
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
                          <label class="col-lg-2 control-label">Tahun</label>
                          <div class="col-lg-3">
                            <select name="tahun" id="tahun" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                              <?php if ($tahun_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php 
                              $thn_min = 2014;
                              $thn_max = date("Y");
                              $no = 1; 
                              for ($i=$thn_min; $i <= $thn_max; $i++) { ?>

                                <?php if ($tahun_exist == $i) { ?>
                                    <option selected value="<?= $i; ?>"><?= $i; ?></option>
                                <?php } else { ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
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
                          <label class="col-lg-2 control-label">Unit Kawasan</label>
                          <div class="col-lg-4">
                            <select onChange="this.form.submit()" name="kk_reg" id="kk_reg" class="form-control select2" style="width: 100%;" >
                                    <?php if ($satker_exist == 0) { ?>
                                        <option selected value="0">SEMUA DATA</option>
                                    <?php } else { ?>
                                        <option value="0">SEMUA DATA</option>
                                    <?php } ?>
                                    <?php foreach ($dataKK as $row) { ?>
                                        <?php if ($kk_exist == $row->reg_kk) { ?>
                                        <option selected value="<?= $row->reg_kk ?>"><?= $row->short_name.'. '.$row->nama_kk ?></option>
                                        <?php } else { ?>
                                        <option value="<?= $row->reg_kk ?>"><?= $row->short_name.'. '.$row->nama_kk ?></option>
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <?php if ($this->session->sub_role != 4 ) { ?>
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
                          <?php } ?>
                          <label class="col-lg-2 control-label">Jenis Usaha</label>
                          <div class="col-lg-4">
                            <select onChange="this.form.submit()" name="usaha_id" id="usaha_id" class="form-control" style="width: 100%;" >
                                    <?php if ($usaha_exist == 0) { ?>
                                        <option selected value="0">SEMUA DATA</option>
                                    <?php } else { ?>
                                        <option value="0">SEMUA DATA</option>
                                    <?php } ?>
                                    <?php foreach ($dataUsaha as $row2) { ?>
                                        <?php if ($usaha_exist == $row2->id_reference) { ?>
                                        <option selected value="<?= $row2->id_reference ?>"><?= $row2->detail_1 ?></option>
                                        <?php } else { ?>
                                        <option value="<?= $row2->id_reference ?>"><?= $row2->detail_1 ?></option>
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                          </div>
                        </div>
                    </form>
                  </div>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <?php 
                    $access = $this->session->roles_id;
                    if (!$access) { $access = 0; }
                    if ($access == 2) { ?>
                        <div class="col-lg-12">
                            <a href="<?=base_url();?>pemberdayaan/binadesa/add" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>TAMBAH DATA</strong></a>
                            <a id="btnUnduhBinaDesa" type="button" class="btn btn-warning"><i class="fa fa-download"></i> <strong>UNDUH DATA</strong></a>
                            <a href="<?=base_url();?>pemberdayaan/binadesa/resume" type="button" class="btn btn-success"><i class="fa fa-dashboard"></i> <strong>RESUME DATA</strong></a>
                            <br><br><br>
                        </div>
                        
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                          <table id="tableMDI" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="5%">NO</th>
                                <th width="15%">NAMA SATKER</th>
                                <th width="15%">UNIT KAWASAN</th>
                                <th width="18%">NAMA KELOMPOK</th>
                                <th width="15%">NAMA DESA</th>
                                <th width="10%">TAHUN</th>
                                <th width="12%">BIAYA (Rp)</th>
                                <th width="10%">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                              <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->nama_satker ?></td>
                                <td><?= $row->short_name.'. '.$row->nama_kk ?></td>
                                <td><?= $row->nama_kelompok ?></td>
                                <td><?= load_controller('Binadesa', 'getdatadesaview', $row->desa_id, NULL, 'pemberdayaan/') ?></td>
                                <td><?= $row->tahun_keg ?></td>
                                <td><?= number_format($row->total_biaya, 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($this->session->sub_role == 3 || $this->session->satker_kode == $row->satker_kode) { ?>
                                        <button style="margin-bottom: 5px !important;" onclick="location.href='<?=base_url('pemberdayaan/binadesa/edit/'.$row->id_pdskk);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                    <?php } ?>
                                        <button onclick="location.href='<?=base_url('pemberdayaan/binadesa/detail/'.$row->id_pdskk);?>'" type="button" class="btn btn-xs btn-info"><i class="fa fa-search"></i>&nbsp;Detail</button>
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
<script src="<?=base_url('assets/dist/js/content/binadesa.js')?>"></script>
<script type="text/javascript">
  $('#btnUnduhBinaDesa').click(function(){ 
      $('#filterFormBinaDesa').attr('action','<?= base_url('pemberdayaan/binadesa/ekspor') ?>');
      var form = document.getElementById("filterFormBinaDesa");
      form.submit(); 
      $('#filterFormBinaDesa').attr('action','');
  });
</script>
<?php
  load_controller('Commons', 'footer');
?>