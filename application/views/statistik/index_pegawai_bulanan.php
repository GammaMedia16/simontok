<?php
  $title = "";
  $icon = "";
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
                  <h3 class="panel-heading">REKAP DATA KINERJA PEGAWAI TAHUN <?= $tahun_exist ?> - REALISASI PAGU</h3>
                  <div class="col-lg-12">
                    <form method="post" role="form" class="form-horizontal ml-2">
                      <div class="form-group row">
                        <label class="col-lg-4 control-label">Tahun</label>
                        <div class="col-lg-3">
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

              <div class="table-responsive col-lg-12">
                <table id="tableTallysheet" class="table table-striped table-bordered dt-responsive nowrap">
                  <thead>
                    <tr>
                      <th rowspan="2" width="5%">NO</th>
                      <th rowspan="2" width="20%">NAMA</th>
                      <th colspan="12" width="75%">BULAN</th>
                    </tr>
                    <tr>
                      <th>Jan</th>
                      <th>Feb</th>
                      <th>Mar</th>
                      <th>Apr</th>
                      <th>Mei</th>
                      <th>Juni</th>
                      <th>Juli</th>
                      <th>Agust</th>
                      <th>Sept</th>
                      <th>Okt</th>
                      <th>Nov</th>
                      <th>Des</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($dataPegawai as $rowPegawai) { ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $rowPegawai->nama_user ?></td>
                        <?php
                          $arrJumlah = load_controller('Statistik', 'countpegawaibulanan', $tahun_exist, $rowPegawai->id_user);
                          $dataJumlah = json_decode($arrJumlah, true);
                          $jmlBln = [0,0,0,0,0,0,0,0,0,0,0,0];
                          //print_r($dataJumlah);
                          foreach ($dataJumlah as $rJml) {
                            $y = $rJml['bln'] - 1;
                            $jmlBln[$y] = $rJml['jml'];
                          }

                          for ($i=1; $i <= count($jmlBln); $i++) {
                          $x = $i - 1; 
                          ?>
                            <td><?= $jmlBln[$x] ?></td>

                          <?php
                          }
                        ?>
                        
                      </tr>
                    <?php $no++; } ?>
                  </tbody>
                </table>
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
<?php
  load_controller('Commons', 'footer');
?>

