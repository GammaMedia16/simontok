<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">MENU</span></h3> </div>
        <ul class="nav" id="side-menu">
            
            <?php if ($this->session->loggedIn == 1 && $nama_satker != NULL) { ?>
            <li class="user-pro">
                <a href="#" class="waves-effect"> 
                  <span class="hide-menu"> <?= $nama_satker ?></span><br>
                  <span class="hide-menu" style="font-size: 12px; font-style: italic;"> <i class="fa fa-circle text-success"></i> Online</a></span>
                  
                </a>
            </li>
            <?php } ?>
            <li style="background: rgba(225, 225, 225, 0.3); padding: 15px 35px 15px 20px;">
                <b>MENU UTAMA</b>
            </li>
            <li>
                <a href="<?=base_url('dashboard');?>" class="waves-effect">
                    <i class="fa fa-dashboard fa-fw"></i>
                    <span class="hide-menu">Beranda</span>
                </a>
            </li>
            <?php if ($roles_id == 2) { ?>
              <?php if ($sub_role == 4 || $sub_role == 6 || $sub_role == 7) { ?>
                <!-- Penerimaan -->          
                <li><a href="<?=base_url('penerimaan');?>" class="waves-effect">
                    <i class="fa fa-money fa-fw"></i> <span class="hide-menu">Penerimaan<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=base_url('penerimaan/target');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Target Penerimaan</span></a>
                        </li>
                        <li><a href="<?=base_url('penerimaan/realisasi');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Realisasi Penerimaan</span></a>
                        </li>
                         <li><a href="<?=base_url('penerimaan/unduh');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Unduh Data</span></a>
                        </li>
                    </ul>
                </li>

              <?php } ?>

              <?php if ($sub_role == 3 || $sub_role == 4 || $sub_role == 5 || $sub_role == 7) { ?>
                <!-- Pengeluaran -->          
                <li><a href="<?=base_url('pengeluaran');?>" class="waves-effect">
                    <i class="fa fa fa-shopping-bag fa-fw"></i> <span class="hide-menu">Pengeluaran<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=base_url('pengeluaran/pagu');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Pagu</span></a>
                        </li>
                        <li><a href="<?=base_url('pengeluaran/realisasi');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Realisasi Pagu</span></a>
                        </li>
                        <li><a href="<?=base_url('pengeluaran/pengesahan');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Pengesahan Pagu</span></a>
                        </li>
                         <li><a href="<?=base_url('pengeluaran/unduh');?>" class="waves-effect">
                          <i class="fa fa-circle-o fa-fw"></i> <span class="hide-menu">Unduh Data</span></a>
                        </li>
                    </ul>
                </li>
              <?php } ?>
              <?php if ($sub_role == 3 || $sub_role == 4 || $sub_role == 5 || $sub_role == 7) { ?>
                <!-- Laci File -->          
                <li>
                  <a href="<?=base_url('laporan/data');?>" class="waves-effect">
                      <i class="fa fa-file-o fa-fw"></i>
                      <span class="hide-menu">Laci File</span>
                  </a>
                </li>
              <?php } ?>
              <?php if ($sub_role == 4) { ?>
                <!-- Laci File -->          
                <li>
                  <a href="<?=base_url('statistik/pegawai');?>" class="waves-effect">
                      <i class="fa fa-area-chart fa-fw"></i>
                      <span class="hide-menu">Kinerja Pegawai</span>
                  </a>
                </li>
              <?php } ?>
                <!-- Statistik -->
                <li>
                  <a href="<?=base_url('statistik/all');?>" class="waves-effect">
                      <i class="fa fa-bar-chart-o fa-fw"></i>
                      <span class="hide-menu">Statistik</span>
                  </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Left Sidebar -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 style="font-size:19pt !important; font-weight:400 !important;" class="page-title">
                  SISTEM MONITORING KEUANGAN
            <small style="font-size:15pt;font-weight:400;">Politeknik Kesehatan Kemenkes Semarang</small></h1> </div>
            <div class="col-lg-8 col-sm-12 col-md-12 col-xs-12 pull-right">
                <ol class="breadcrumb">
                    <li><i class="<?php echo $iconBreadcumb; ?>"></i>&nbsp;&nbsp;<?php echo $titleBreadcumb; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>