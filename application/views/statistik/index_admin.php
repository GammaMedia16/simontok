<?php
  $title = $judul;
  $icon = "fa fa-bar-chart";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<section class="content">
<?php 
$access = $this->session->sub_role;
$roles = $this->session->roles_id;
?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel" style="margin-bottom: 10px !important;">
      <div class="panel-body">
          <form method="post" role="form" class="form-horizontal" >
            <div class="form-group" style="margin-bottom: 0px !important;">
              <label class="col-lg-5 control-label">Filter Tahun</label>
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
    </div>
  </div>   
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> CAPAIAN PENERIMAAN TAHUN <?= $tahun_exist ?>
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-6">
            <h2>TOTAL TARGET PENERIMAAN:</h2>
            <h2><b> Rp <?= number_format($total_target_penerimaan, 0, ',', '.') ?></b></h2>
          </div>
          <div class="col-lg-6">
            <h2>TOTAL REALISASI PENERIMAAN:</h2>
            <h2><b> Rp <?= number_format($total_realisasi_penerimaan, 0, ',', '.') ?></b></h2>
          </div>
          <div class="col-lg-12">
            <?php 
              $p_terima = @($total_realisasi_penerimaan/$total_target_penerimaan)*100;
              $persen_total_penerimaan = number_format($p_terima, 2, '.', ',');
            ?>
            <div class="progress progress-lg">
                <div class="progress-bar progress-bar-success active progress-bar-striped" aria-valuenow="<?= $persen_total_penerimaan ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_total_penerimaan ?>%;" role="progressbar"><?= $persen_total_penerimaan ?>%</div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="table-responsive col-xs-12">
              <table id="tableKu" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="20%">KODE AKUN</th>
                    <th width="30%">JENIS PENDAPATAN</th>
                    <th width="20%">JUMLAH TARGET PENERIMAAN</th>
                    <th width="20%">JUMLAH REALISASI</th>
                    <th width="10%">%</th>
                  </tr>
                </thead>
                <tbody>
                <?php $no=1;
                $total_target=0; 
                $total_real_target=0; 
                foreach ($recordAkunTerima as $rowAT) { ?>
                  <tr>
                    <td>
                      <?= $rowAT->akun ?>
                    </td>
                    <td>
                      <?= $rowAT->jenis_penerimaan ?>
                    </td>
                    <td align="right"><?= number_format($rowAT->jml_target_penerimaan, 0, ',', '.'); ?></td>
                    
                    <td align="right"><?= number_format($rowAT->jml_realisasi_penerimaan, 0, ',', '.'); ?></td>
                      <?php
                        $target = $rowAT->jml_target_penerimaan;
                        $realtarget = $rowAT->jml_realisasi_penerimaan;
                        $persentarget = @($realtarget/$target)*100;
                      ?>
                    <td align="right">
                      <div class="label bg-green" align="center"><?= number_format($persentarget, 2, ',', '.'); ?>%</div>
                    </td>

                  </tr>
                <?php 
                $total_target+=$target; 
                $total_real_target+=$realtarget;
                $no++; } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" align="right">
                      <b>GRAND TOTAL</b>
                    </td>
                    <?php 
                      $persentotaltarget = @($total_real_target/$total_target)*100;
                    ?>
                    <td align="right">
                      <b><?= number_format($total_target, 0, ',', '.'); ?></b>
                    </td>
                    <td align="right">
                      <b><?= number_format($total_real_target, 0, ',', '.'); ?></b>
                    </td>
                    <td align="right">
                      <div class="label bg-green" align="center"><?= number_format($persentotaltarget, 2, ',', '.'); ?>%</div>
                    </td>

                  </tr>
                </tfoot>
              </table>
              <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>   
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> CAPAIAN PENGELUARAN TAHUN <?= $tahun_exist ?>
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12" align="center">
            <h2>TOTAL PAGU ANGGARAN:</h2>
            <h2><b> Rp <?= number_format($total_pagu, 0, ',', '.') ?></b></h2>
          </div>
          <div class="col-lg-6">
            <h2>TOTAL REALISASI PAGU/SPJ:</h2>
            <h2><b> Rp <?= number_format($rPengeluaran->total_realisasi_pagu, 0, ',', '.') ?></b></h2>
            <?php 
              $total_realisasi_pagu = $rPengeluaran->total_realisasi_pagu;
              $p_pagu = @($total_realisasi_pagu/$total_pagu)*100;
              $persen_pagu = number_format($p_pagu, 2, '.', ',');
            ?>
            <div class="progress progress-lg">
                <div class="progress-bar progress-bar-primary active progress-bar-striped" aria-valuenow="<?= $persen_pagu ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_pagu ?>%;" role="progressbar"><?= $persen_pagu ?>%</div>
            </div>
          </div>
          <div class="col-lg-6">
            <h2>TOTAL REALISASI PENGESAHAN:</h2>
            <h2><b> Rp <?= number_format($rPSah->total_realisasi_sah, 0, ',', '.') ?></b></h2>
            <?php 
              $total_realisasi_sah = $rPSah->total_realisasi_sah;
              $p_sah = @($total_realisasi_sah/$total_pagu)*100;
              $persen_sah = number_format($p_sah, 2, '.', ',');
            ?>
            <div class="progress progress-lg">
                <div class="progress-bar progress-bar-success active progress-bar-striped" aria-valuenow="<?= $persen_sah ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_sah ?>%;" role="progressbar"><?= $persen_sah ?>%</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>   
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel">
      <div class="panel-heading" style="font-size: 12pt !important;"> GRAFIK REALISASI TAHUN <?= $tahun_exist ?>
          <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
      </div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
          <div class="col-lg-12">
            <form method="post" role="form" class="form-horizontal">
              <div class="form-group">
                <label class="col-lg-2 control-label">Bulan</label>
                <div class="col-lg-3">
                  <select name="bulan" id="bulan" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                      <?php 
                      $bulan = array("SEMUA DATA", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                      $no = 1; 
                      for ($i=0;$i<=12;$i++) { ?>
                        <?php if ($bulan_exist == $i) { ?>
                            <option selected value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                        <?php } else { ?>
                            <option value="<?= $i; ?>"><?= $bulan[$i]; ?></option>
                        <?php } ?>
                      <?php } ?>
                  </select>
                </div>
              </div>
            </form>
            <div class="table-responsive col-xs-12">
              <table id="tableKu" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="35%">NAMA JURUSAN</th>
                    <th width="20%">PAGU ANGGARAN</th>
                    <th width="20%">REALISASI</th>
                    <th width="20%">SISA PAGU</th>
                    <th width="5%">%</th>
                  </tr>
                </thead>
                <tbody>
                <?php $no=1; 
                $total_pj=0; 
                $total_rj=0; 
                $total_sj=0; 
                foreach ($dataResultRSJurusan as $rowRSJ) { ?>
                  <tr>
                    <td>
                      <?= $rowRSJ['nama_jurusan'] ?>
                    </td>
                    <td align="right"><?= number_format($rowRSJ['pagu'], 0, ',', '.'); ?></td>
                    
                    <td align="right"><?= number_format($rowRSJ['realisasi'], 0, ',', '.'); ?></td>
                      <?php
                        $pagu = $rowRSJ['pagu'];
                        $real = $rowRSJ['realisasi'];
                        $sisa = $pagu - $real;
                        $persen = @($real/$pagu)*100;
                      ?>
                    <td align="right"><?= number_format($sisa, 0, ',', '.'); ?></td>
                    <td align="right">
                      <div class="label bg-green" align="center"><?= number_format($persen, 2, ',', '.'); ?>%</div>
                    </td>

                  </tr>
                <?php 
                $total_pj+=$pagu; 
                $total_rj+=$real;
                $total_sj+=$sisa;
                $no++; } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td align="right">
                      <b>TOTAL</b>
                    </td>
                    <?php 
                      $persentotaljurusan = @($total_rj/$total_pj)*100;
                    ?>
                    <td align="right">
                      <b><?= number_format($total_pj, 0, ',', '.'); ?></b>
                    </td>
                    <td align="right">
                      <b><?= number_format($total_rj, 0, ',', '.'); ?></b>
                    </td>
                    <td align="right">
                      <b><?= number_format($total_sj, 0, ',', '.'); ?></b>
                    </td>
                    <td align="right">
                      <div class="label bg-green" align="center"><?= number_format($persentotaljurusan, 2, ',', '.'); ?>%</div>
                    </td>

                  </tr>
                </tfoot>
              </table>
              <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
            </div>
          </div>
          <div class="col-lg-12 chartsistem">
            <div id="chartRealisasiSahJurusan" class="chartdiv" style="height: 60vh;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>   
</div>
</section>
<script src="<?=base_url('assets/dist/js/content/website.js')?>"></script> 
<script src="<?=base_url('assets/plugins/amcharts/core.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/charts.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/amcharts.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/animated.js')?>"></script>
<script src="<?=base_url('assets/plugins/amcharts/themes/material.js')?>"></script>
<script type="text/javascript">
  var dataRealisasiSahJurusan = JSON.parse('<?php echo $dataRealisasiSahJurusan; ?>');
</script>
<script src="<?=base_url('assets/dist/js/content/statistik-admin.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>