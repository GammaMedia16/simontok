<?php
  $title = "Beranda";
  $icon = "fa fa-dashboard";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-header with-border">
        <h3 class="panel-heading">Sambutan Direktur Kawasan Konservasi</h3>
      </div><!-- /.panel-header -->
      <div class="panel-body">
          <p align="justify" style="padding:5px;">
            <img style="margin-right:25px;max-width: 35%" align="left" src="<?=base_url('assets/dist/img/simdpkk.png');?>" class="img-responsive" alt="Kepala Balai"  />
            <p align="justify" style="padding-top:20px;">Puji syukur kami panjatkan kepada Tuhan Yang Maha Kuasa karena berkat rahmat dan karunia-Nya, Sistem Informasi Manajemen Daerah Penyangga Kawasan Konservasi dan Kemitraan Konservasi akhirnya bisa terwujud. Dengan hadirnya sistem ini, Direktorat Kawasan Konservasi pada Ditjen KSDAE sedang berupaya untuk meningkatkan pengelolaan data dan informasi serta pelayanan publik di bidang pemberdayaan masyarakat dan kemitraan konservasi. 
            Akhirnya, selamat berkunjung ke sistem kami, semoga kita semua selalu dalam Lindungan Tuhan Yang Maha Kuasa.</p>
            <div style="padding:10px;" align="right">Jakarta, September 2019
            <br><br><b>Ir. Dyah Murtiningsih, M.Hum.</b>
            <br>Direktur Kawasan Konservasi</div>
          </p>
      </div><!-- /.panel-body -->
    </div><!-- /.panel -->
  </div><!-- /.col -->
</div>


<script src="<?=base_url('assets/dist/js/content/dashboard.js')?>"></script>
<?php
  load_controller('Commons', 'footer');
?>