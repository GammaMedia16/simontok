<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $total_realisasi_sah = 0;
  foreach ($recordRealPagu as $rowRP) {
    if ($rowRP->flag_aksi == 1) {
      $total_realisasi_sah += $rowRP->jml_rsah;
    }
    
  }
  $sisa_pagu = $rowPagu->pagu - $total_realisasi_sah;
?>

  <!-- Small paneles (Stat panel) -->
  <div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading" style="line-height: 20pt !important;"><u>Data Realisasi Pengesahan Pagu Anggaran </u><br>
            Pagu Anggaran : <?= number_format($rowPagu->pagu, 0, ',', '.'); ?><br>
            Detail : <?= $rowPagu->ket ?><br>
            Total Realisasi : <?= number_format($total_realisasi_sah, 0, ',', '.'); ?><br>
            <span class="text-red">Sisa Pagu : <?= number_format($sisa_pagu, 0, ',', '.'); ?></span>
          <button onclick="location.href='<?=base_url('pengeluaran/pengesahan');?>'" type="button" class="btn btn-sm btn-warning pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</button>
          </h3>

        </div>
        <div class="panel-body ">
          <div class="alert" style="display: none;"></div>
          <div class="table-responsive col-xs-12">
            <table id="tableKu" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="10%">TGL TRANSAKSI</th>
                  <th width="10%">BULAN</th>
                  <th width="10%">JUMLAH REALISASI SPJ</th>
                  <th width="15%">KETERANGAN</th>
                  <th width="10%">USER</th>
                  <th width="15%">PENDING</th>
                  <th width="15%">REALISASI PENGESAHAN</th>
                  <th width="15%">STATUS/AKSI</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($recordRealPagu as $rowRP) { ?>
                <tr>
                  <td><?php $waktu = date_create($rowRP->tgl_transaksi_rpagu); echo date_format($waktu, 'd-m-Y'); ?></td>
                  <td><?= $bulan[$rowRP->bulan-1] ?></td>
                  <td align="right"><?= number_format($rowRP->jml_rpagu, 0, ',', '.'); ?><input type="hidden" class="form-control" name="jml_rpagu<?= $rowRP->id_rpagu ?>" id="jml_rpagu<?= $rowRP->id_rpagu ?>" value="<?= $rowRP->jml_rpagu ?>"/></td>
                  <td><?= $rowRP->ket_rpagu ?></td>
                  <td><?= $rowRP->nama_user ?></td>

                  <td><input type="text" class="form-control pending_rsah" name="pending_rsah<?= $rowRP->id_rpagu ?>" data-id="<?= $rowRP->id_rpagu ?>" id="pending_rsah<?= $rowRP->id_rpagu ?>" value="<?= $rowRP->pending_rsah ?>" style="width: 120px !important"/></td>
                  <td align="right"><input type="text" class="form-control real_sah" name="real_sah<?= $rowRP->id_rpagu ?>" id="real_sah<?= $rowRP->id_rpagu ?>" value="<?= number_format($rowRP->jml_rsah, 0, ',', '.'); ?>" readonly style="width: 120px !important" /></td>
                  <td>
                    <?php if ($rowRP->flag_aksi == 0) { ?>
                      <div class="label bg-red" align="center"><i class="fa fa-close"></i></div>
                    <?php } else { ?>
                      <div class="label bg-green" align="center"><i class="fa fa-check"></i></div>
                    <?php } ?>
                    <?php if ($access == 5) { 
                      if ($rowRP->flag_aksi == 0) { ?>
                      &nbsp;<button onclick="submitSudah(<?= $rowRP->id_rpagu ?>,<?= $rowRP->id_rsah ?>)" type="button" class="btn btn-xs btn-success">Sudah</button>
                    <?php } else { ?>
                      &nbsp;<button onclick="submitSimpan(<?= $rowRP->id_rpagu ?>,<?= $rowRP->id_rsah ?>)" type="button" class="btn btn-xs btn-primary">Simpan</button>
                    <?php }  } ?>
                  </td>

                </tr>
              <?php $no++; } ?>
              </tbody>
            </table>
            <div class="alert" style="display: none;"></div>

            <input type="hidden" id="base_url" value="<?= base_url() ?>"/>
          </div>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/pengeluaran.js')?>"></script> 
<script type="text/javascript">
  $(document).ready(function () {
    var dataRP = <?php echo json_encode($recordRealPagu) ?>;
    /*$.each(dataRP, function(i, row) {
        var val_pending = $('#pending_rsah'+dataRP[i].id_rpagu).val();
        var vreal_sah = parseInt(dataRP[i].jml_rpagu) - parseInt(val_pending);
        $('#real_sah'+dataRP[i].id_rpagu).val(vreal_sah.toLocaleString('de-DE', {minimumFractionDigits: 0})); 
    })*/
    $('.pending_rsah').on('keyup', function() {
        var id = $(this).attr("data-id");
        var jml_pending = $(this).val();
        var jml_rpagu = $('#jml_rpagu'+id).val();
        var jml_real_sah = parseInt(jml_rpagu) - parseInt(jml_pending);
        $('#real_sah'+id).val(jml_real_sah.toLocaleString('de-DE', {minimumFractionDigits: 0}));
    });

  });
  
</script>

<?php
  load_controller('Commons', 'footer');
?>
