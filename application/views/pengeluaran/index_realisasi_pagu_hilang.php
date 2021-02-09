<?php
  $title = "Data Pagu Anggaran";
  $icon = "fa fa-money";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<!-- Main content -->
<section class="content">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
                <div class="panel-header">
                  <h3 class="panel-heading">Data Realisasi Pagu Anggaran Tidak Terdeteksi Tahun <?= $tahun_exist ?></h3>
                  <div class="col-lg-12">

                  </div>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <?php 
                    $access = $this->session->sub_role;
                    if (!$access) { $access = 0; }
                    if ($access == 3) { ?>
                        
                        
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                          <table id="tableKu" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="30%">KDGIAT/OUTPUT/SUB OUTPUT/KOMPONEN/SUB KOMPONEN/KD BEBAN/AKUN</th>
                                <th width="35%">URAIAN</th>
                                <th width="15%">PAGU</th>
                                <th width="20%">REALISASI</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { 
                              //if ($row->level == 7) { ?>
                              <tr>
                                <td align="right">
                                  <?= $row->kdgiat.'.'.$row->kdoutput.'.'.$row->kdsoutput.'.'.$row->kdkmpnen.'.'.$row->kdskmpnen.'.'.$row->jnsbel.'.'.$row->kdbeban ?>
                                    
                                  </td>
                                <td>

                                  <?php 
                                  if (strstr($row->ket, '] ')) {
                                    $keterangan = str_replace('] ', '', strstr($row->ket, '] '));
                                  } else {
                                    $keterangan = $row->ket;
                                  }
                                  ?>
                                    <a href="<?=base_url();?>pengeluaran/addrealisasipaguhilang/<?= $row->kdindex ?>"><?= $keterangan ?></a>
                                    
                                </td>
                                <td align="right"><?= number_format($row->pagu, 0, ',', '.'); ?></td>
                                <td align="right"><?= number_format($row->jml_realisasi_pagu, 0, ',', '.'); ?></td>

                              </tr>
                            <?php //}
                            $no++; } ?>
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
<script src="<?=base_url('assets/dist/js/content/pengeluaran.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>


                    <!-- <form method="post" role="form" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Program</label>
                          <div class="col-lg-8">
                            <select  onChange="this.form.submit()" name="level1" id="level1" class="form-control select2" style="width: 100%;" >
                              <?php if ($level1_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php foreach ($dataL1 as $row1) { ?>
                                  <?php if ($level1_exist == $row1->kdprogram) { ?>
                                  <option selected value="<?= $row1->kdprogram ?>"><?= $row1->ket ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $row1->kdprogram ?>"><?= $row1->ket ?></option>
                                  <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Kegiatan</label>
                          <div class="col-lg-8">
                            <select onChange="this.form.submit()" name="level2" id="level2" class="form-control select2" style="width: 100%;" >
                              <?php if ($level2_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php foreach ($dataL2 as $row2) { ?>
                                  <?php if ($level2_exist == $row2->kdgiat) { ?>
                                  <option selected value="<?= $row2->kdgiat ?>"><?= $row2->ket ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $row2->kdgiat ?>"><?= $row2->ket ?></option>
                                  <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Output</label>
                          <div class="col-lg-8">
                            <select onChange="this.form.submit()" name="level3" id="level3" class="form-control select2" style="width: 100%;" >
                              <?php if ($level3_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php foreach ($dataL3 as $row3) { ?>
                                  <?php if ($level3_exist == $row3->kdoutput) { ?>
                                  <option selected value="<?= $row3->kdoutput ?>"><?= $row3->ket ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $row3->kdoutput ?>"><?= $row3->ket ?></option>
                                  <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Sub Output</label>
                          <div class="col-lg-8">
                            <select onChange="this.form.submit()" name="level4" id="level4" class="form-control select2" style="width: 100%;" >
                              <?php if ($level4_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php foreach ($dataL4 as $row4) { ?>
                                  <?php if ($level4_exist == $row4->kdprogram) { ?>
                                  <option selected value="<?= $row4->kdprogram ?>"><?= $row4->ket ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $row4->kdprogram ?>"><?= $row4->ket ?></option>
                                  <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Komponen</label>
                          <div class="col-lg-8">
                            <select onChange="this.form.submit()" name="level5" id="level5" class="form-control select2" style="width: 100%;" >
                              <?php if ($level5_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php foreach ($dataL5 as $row5) { ?>
                                  <?php if ($level5_exist == $row5->kdprogram) { ?>
                                  <option selected value="<?= $row5->kdprogram ?>"><?= $row5->ket ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $row5->kdprogram ?>"><?= $row5->ket ?></option>
                                  <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Sub Komponen</label>
                          <div class="col-lg-8">
                            <select onChange="this.form.submit()" name="level6" id="level6" class="form-control select2" style="width: 100%;" >
                              <?php if ($level6_exist == 0) { ?>
                                  <option selected value="0">SEMUA DATA</option>
                              <?php } else { ?>
                                  <option value="0">SEMUA DATA</option>
                              <?php } ?>
                              <?php foreach ($dataL6 as $row6) { ?>
                                  <?php if ($level6_exist == $row6->kdprogram) { ?>
                                  <option selected value="<?= $row6->kdprogram ?>"><?= $row6->ket ?></option>
                                  <?php } else { ?>
                                  <option value="<?= $row6->kdprogram ?>"><?= $row6->ket ?></option>
                                  <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-8 col-lg-offset-2">
                            <a href="<?=base_url();?>pengeluaran/realisasi" type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Ulangi Filter</a>
                          </div>
                        </div>
                    </form> -->