<?php
  $title = "Unggah Data Pagu Anggaran";
  $icon = "fa fa-plus";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $viewbutton = false;
  //$this->load->view('design/header');
?>
<!-- Main content -->
<section class="content">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-header">
              <h3 class="panel-heading"><?= $title ?></h3>
            </div><!-- /.panel-header -->
            <div class="panel-body">
                <div class="col-lg-12"><br>
                <div class="alert alert-success" style="display: none;"></div>
                <form id="formImportView" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Tahun Anggaran</label>
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
                    <div class="form-group">
                        <label class="col-lg-2 control-label">File</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control" name="fileimport" id="fileimport"/>
                            <input type="hidden" class="form-control" name="namafile" id="namafile" value="<?= $nama_file ?>" />
                        </div>
                        <div class="col-xs-2">
                            <button type="submit" name="btnOKImport" id="btnOKImport" class="btn btn-primary"><i class="fa fa-search"></i> View Data</button>
                        </div>
                        <div class="col-xs-2">
                            <a href="<?=base_url('pengeluaran/import');?>" class="btn btn-warning">
                            <i class="fa fa-refresh"></i> Reset</a>
                        </div>
                    </div>
                </form><br><br>
                <?php  if ($view == true) { ?>
                <div class="alert alert-primary">
                  Data tampil dan akan diimport sebanyak  <?= $highestRow - 1 ?> baris
                </div>

                <?php } ?>
                </div>

                <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                <?php 
                
                $user_id = $this->session->user_id;
                $access = $this->session->roles_id;
                $sub_role = $this->session->sub_role;
                if (!$access) { $access = 0; }
                if ($access == 2) { ?>
                <?php } ?>
                
                <div class="table-responsive col-lg-12">
                     <form id="formImportData" method="post" enctype="multipart/form-data" class="form-horizontal" >
                      <table id="tableImportTallysheet" class="table table-striped table-bordered">
                        <thead><?php 
                          if ($view == true) { 
                            $countColPagu = count($dataColPagu);
                            echo "<tr>";
                            foreach ($dataColPagu as $rColPagu) {
                              echo "<th>".strtoupper($rColPagu->kolom)."</th>";
                            }
                            echo "</tr>";
                          } else {
                              echo "<tr><th>UNGGAH DATA</th></tr>";
                          }
                          ?>
                        </thead>
                        <tbody>
                        <?php if ($view == true) { ?>
                        <?php
                          $exist_no = 1;
                          for ($x=1; $x < $highestRow; $x++) { 
                            $exist_no = $x;
                            $viewbutton = true;
                            echo "<tr>";
                            foreach ($dataColPagu as $rColPagu) {
                              $colExcel = $rColPagu->id - 1;
                              echo "<td>".$record[$x][$colExcel];
                              echo "<input type=\"hidden\" value=\"".$record[$x][$colExcel]."\" name=\"".strtolower(str_replace(' ', '_', $rColPagu->kolom)).$x."\" id=\"".strtolower($rColPagu->kolom).$x."\"/>";
                              echo "</td>";
                            }
                            echo "</tr>";
                          }
                          $colspan = $countColPagu;
                        } 
                        ?>
                        
                        </tbody>
                        <?php if ($viewbutton == true) { ?>
                        <tfooter>
                            <tr>
                                <th colspan='<?= $colspan ?>'>
                                <button type="button" name="btnSaveImport" id="btnSaveImport" class="btn btn-lg btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
                                <input type="hidden" value="<?= $exist_no ?>" name="jmldata" id="jmldata"/>
                                </th>
                            </tr>
                        </tfooter>
                        <?php } ?>
                      </table>
                      </form>
                </div>
                </div>
                <div class="alert alert-success" style="display: none;"></div>
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