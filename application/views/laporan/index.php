<?php
  $title = "Kumpulan Laporan";
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
                  <h3 class="panel-title"><?= $title ?></h3>
                  <div class="col-lg-8 pull-right">
                    <form method="post" role="form" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Tahun</label>
                          <div class="col-lg-3">
                          <select name="tahun" id="tahun" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                            <?php 
                              $thn_min = date("Y",strtotime(" -5 year"));
                              $thn_max = date("Y");
                              $no = 1; ?>
                                <?php for ($i=$thn_min; $i <= $thn_max; $i++) { ?>
                                  <?php if ($tahun_exist == $i) { ?>
                                      <option selected value="<?= $i; ?>"><?= $i; ?></option>
                                  <?php } else { ?>
                                      <option value="<?= $i; ?>"><?= $i; ?></option>
                                  <?php } ?>
                                <?php } ?>
                                <?php if ($tahun_exist == 1) { ?>
                                    <option selected value="1">SEMUA DATA</option>
                                <?php } else { ?>
                                    <option value="1">SEMUA DATA</option>
                                <?php } ?>
                                
                            </select>
                          </div>
                          <label class="col-lg-2 control-label">Kategori</label>
                          <div class="col-lg-3">
                          <select name="wil" id="wil" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                                <?php if ($wil_exist == 0) { ?>
                                    <option selected value="0">SEMUA DATA</option>
                                <?php } else { ?>
                                    <option value="0">SEMUA DATA</option>
                                <?php } ?>
                                <?php foreach ($dataJur as $row) { ?>
                                    <?php if ($jur_exist == $row->id_ref_laporan) { ?>
                                    <option selected value="<?= $row->id_ref_laporan ?>"><?= $row->nama_ref_laporan ?></option>
                                    <?php } else { ?>
                                    <option value="<?= $row->id_ref_laporan ?>"><?= $row->nama_ref_laporan ?></option>
                                    <?php } ?>
                                <?php } ?>
                                
                            </select>
                          </div>
                        </div>
                    </form>
                  </div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <?php 
                    $user_id = $this->session->user_id;
                    $access = $this->session->roles_id;
                    if (!$access) { $access = 0; }
                    if ($access == 2) { ?>
                        <div class="col-xs-4">
                            <a href="<?=base_url();?>laporan/add" type="button" class="btn btn-primary"><i class="fa fa-upload"></i> <strong>UPLOAD LAPORAN</strong></a>
                        </div><br><br><br><br><br>
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                          <table id="tableKu" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>JUDUL</th>
                                <th>ISI RINGKAS</th>
                                <th>KATEGORI</th>
                                <th>AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                              <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->judul_laporan ?></td>
                                <td><?= $row->isi_laporan ?></td>
                                <td><?= $row->nama_ref_laporan ?></td>
                                <td>
                                    <table width="100%">
                                        <tr>
                                          <td>
                                            <?php if ($access == 2 && $user_id == $row->user_input) { ?>
                                                <button onclick="location.href='<?=base_url('laporan/edit/'.$row->id_laporan);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                                            <?php } ?>
                                            <button id="" onclick="detailLaporan(<?= $row->id_laporan ?>)" type="button" class="btn btn-xs btn-info"><i class="fa fa-info"></i>&nbsp;Detail</button></td>
                                        </tr>
                                    </table>
                                    
                                    
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
</div>
<script src="<?=base_url('assets/dist/js/content/laporan.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>