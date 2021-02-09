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
                  <h3 class="panel-heading">Data Pagu Anggaran Tahun <?= $tahun_exist ?></h3>
                  <div class="col-lg-12">
                    <form method="post" role="form" class="form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-2 control-label">Tahun</label>
                          <div class="col-lg-2">
                            <select name="tahun" id="tahun" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                                <?php 
                                $thn_min = 2020;
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
                          <label class="col-lg-2 control-label">Nama File</label>
                          <div class="col-lg-3">
                            <select onChange="this.form.submit()" name="filepagu" id="filepagu" class="form-control select2" style="width: 100%;" >
                                    <?php foreach ($dataFile as $rowFile) { ?>
                                        <?php if ($file_exist == $rowFile->id_file) { ?>
                                        <option selected value="<?= $rowFile->id_file ?>"><?= $rowFile->nama_file ?></option>
                                        <?php } else { ?>
                                        <option value="<?= $rowFile->id_file ?>"><?= $rowFile->nama_file ?></option>
                                        <?php } ?>
                                    <?php } ?>
                            </select>
                          </div>
                          <div class="col-lg-2">
                            <?php if ($flag_exist == 1) { ?>
                              <div class="label bg-green" align="center">AKTIF</div>
                            <?php } else { ?>
                              <div class="label bg-red" align="center">TIDAK AKTIF</div>
                            <?php } ?>
                          </div>
                        </div>
                    </form>
                  </div>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <?php 
                    $access = $this->session->sub_role;
                    if (!$access) { $access = 0; }
                    if ($access == 4 || $access == 5) { ?>
                        <div class="col-lg-12">
                            <a href="<?=base_url();?>pengeluaran/import" type="button" class="btn btn-primary"><i class="fa fa-upload"></i> <strong>Unggah Data Pagu</strong></a>
                            <br><br><br>
                        </div>
                        
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                          <table id="tableKu" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width="10%">KODE</th>
                                <th width="20%">KDGIAT/OUTPUT/SUB OUTPUT/KOMPONEN/SUB KOMPONEN/KD BEBAN/AKUN</th>
                                <th width="30%">URAIAN</th>
                                <th width="15%">PAGU AKHIR</th>
                                <th width="10%">BLOKIR</th>
                                <th width="15%">PAGU</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $no=1; foreach ($record as $row) { ?>
                              <tr>
                                <td align="right"><?php
                                if ($row->kode != 0) {
                                  echo $row->kode;
                                } else {
                                  echo $row->jnsbel;
                                } 
                                 
                                ?></td>
                                <td align="right">
                                  <?= $row->kdgiat.'.'.$row->kdoutput.'.'.$row->kdsoutput.'.'.$row->kdkmpnen.'.'.$row->kdskmpnen.'.'.$row->jnsbel.'.'.$row->kdbeban ?>
                                    
                                  </td>
                                <td><?php
                                if (strstr($row->ket, '] ')) {
                                  echo str_replace('] ', '', strstr($row->ket, '] '));
                                } else {
                                  echo $row->ket;
                                }
                                ?></td>
                                <td align="right"><?= number_format($row->paguakhir, 0, ',', '.'); ?></td>
                                <td align="right"><?= number_format($row->nilblokir, 0, ',', '.'); ?></td>
                                <td align="right"><?= number_format($row->pagu, 0, ',', '.'); ?></td>

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
<script src="<?=base_url('assets/dist/js/content/pengeluaran.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>