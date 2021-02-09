<?php
  $title = "Data Target Penerimaan";
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
                  <h3 class="panel-heading">Data Target Peneriman Tahun <?= $tahun_exist ?></h3>
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
                        </div>
                    </form>
                  </div>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <?php 
                    $access = $this->session->sub_role;
                    if (!$access) { $access = 0; }
                    if ($access == 6) { ?>
                        <div class="col-lg-12">
                            <a href="<?=base_url();?>penerimaan/addtarget" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> <strong>Input Data</strong></a>
                            <br><br><br>
                        </div>
                        
                    <?php } ?>
                    <div class="table-responsive col-xs-12">
                      <table id="tableKu" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th width="10%">NO</th>
                            <th width="15%">KODE AKUN</th>
                            <th width="30%">JENIS TARGET PENERIMAAN</th>
                            <th width="20%">JUMLAH TARGET PENERIMAAN</th>
                            <th width="10%">TAHUN</th>
                            <th width="15%">AKSI</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; $total_target=0; foreach ($record as $row) {  ?>
                          <tr>
                            <td><?= $no ?></td>
                            <td><?= $row->kode_akun_penerimaan ?></td>
                            <td><?= $row->jenis_penerimaan ?></td>
                            <td><?= number_format($row->jml_target_penerimaan, 0, ',', '.'); ?></td>
                            <td><?= $row->thn_target_penerimaan ?></td>
                            <td><?php if ($this->session->sub_role == 6) { ?>
                              <button onclick="location.href='<?=base_url('penerimaan/edittarget/'.$row->id_akun_penerimaan);?>'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>
                            <?php } ?></td>
                          </tr>
                        <?php $total_target+=$row->jml_target_penerimaan; $no++; } ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3" align="right"><b>TOTAL</b></td>
                            <td colspan="3"><b><?= number_format($total_target, 0, ',', '.'); ?></b></td>
                          </tr>
                        </tfoot>
                      </table>
                      <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
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
<script src="<?=base_url('assets/dist/js/content/penerimaan.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>