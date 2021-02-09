<?php
  $title = "Halaman Beranda";
  $icon = "fa fa-dashboard";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>

<?php if ($roles_id == 2) { ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-header with-border">
            <h3 class="panel-heading">Beranda</h3>
          </div><!-- /.panel-header -->
        <div class="panel-body">
          <h5>Selamat datang <b><?= $nama ?></b> di Sistem Monitoring Keuangan POLTEKKES Semarang</h5>
        </div>
          
        </div><!-- /.panel -->
      </div><!-- /.col -->
    </div>
      
<?php } ?>
<script src="<?=base_url('assets/dist/js/content/dashboard.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>