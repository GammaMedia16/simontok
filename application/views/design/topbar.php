  <body class="fix-header">
    
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part" >
                    <!-- Logo -->
                    <a class="logo" href="<?=base_url();?>">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is light logo icon--><img src="<?=base_url('assets/dist/img/logo.png');?>" alt="home" class="dark-logo" />
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <b style="font-size:24px !important;">SiMontok</b>
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                    
                </ul>



                <ul class="nav navbar-top-links navbar-right pull-right">
                <?php if ($loggedin == 0) { ?>
                    <li style="font-size:12pt;font-weight:bold;">
                        <a href="<?= base_url().'login'; ?>">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <i class="fa fa-user"></i>
                          &nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    </li>
                <?php } elseif ($loggedin == 1) { ?>
                    <?php
                        if ($gender == "L") {
                          $iconUser = "user_m.png";
                        } elseif ($gender == "P") {
                          $iconUser = "user_f.png";
                        }
                    ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?=base_url('assets/dist/img/'.$iconUser);?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?= $nama ?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?=base_url('assets/dist/img/'.$iconUser);?>" alt="user" /></div>
                                    <div class="u-text">
                                        <h4><?= $nama ?></h4>
                                        <p class="text-muted" style="font-size: 10pt;"><?= $roles ?></p>
                                        <a href="<?= base_url().'admin/users/edit/'.$user_id; ?>" class="btn btn-rounded btn-danger btn-sm">Ubah Profil &amp; Password</a></div>
                                </div>
                            </li><li role="separator" class="divider"></li>
                            <li><a href="<?= base_url().'access/logout'; ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                <?php } ?>

                </ul>

            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
      
      