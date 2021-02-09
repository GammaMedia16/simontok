<!DOCTYPE html>  
<html>
  <head>
    <meta charset="UTF-8">
    <title>SiMontok</title>

    <link rel="shorcut icon" href="<?=base_url('assets/dist/img/favicon.ico');?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Informasi Monitoring Keuangan POLTEKKES SEMARANG">
    <meta name="author" content="POLTEKKES SEMARANG">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?=base_url('assets/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?=base_url('assets/bootstrap/dist/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?=base_url('assets/dist/css/animate.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/dist/css/style.css');?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link rel="icon" href="<?=base_url('assets/dist/img/favicon.ico');?>">
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register" style="background:url(assets/dist/img/background-login.jpg) center center/cover no-repeat!important;height:100%;position:fixed">
  <div class="login-box login-sidebar" style="margin-top: 50px">
    <div class="white-box">
      <div class="text-center"><img style="max-width: 100%" src="<?=base_url('assets/dist/img/simontok.png');?>" alt="Home" />
        <br/>
      </div>  
        <?php if(isset($error)) : ?>
            <div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">×</button><?php echo $error; ?></div>
        <?php endif; ?>
        <?php 
            echo validation_errors('<div class="alert alert-danger"><button class="close" data-dismiss="alert" type="button">×</button>','</div>');
        ?>
        <form class="form-horizontal form-material" method="post" enctype="multipart/form-data" id="loginform" action="<?=base_url('access/validate');?>">
        <div class="form-group m-t-40">
          <div class="col-xs-12">
            <input type="text" name="username" 
                     class="form-control" placeholder="Username" autofocus="" value="<?php echo set_value('username'); ?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input type="password" name="userpass" 
                     class="form-control" placeholder="Password" value="<?php echo set_value('userpass'); ?>"/>
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
          </div>
          <div class="text-muted text-center">
            <p style="margin-top: 60px; font-size:9pt;">Copyright &copy; 2020 &nbsp;Politeknik Kesehatan Semarang</p>
          </div><!-- /.social-auth-links -->
        </div>
      </form>
    </div>
  </div>
</section>
<!-- jQuery -->
<!-- jQuery 2.1.3 -->
    <script src="<?=base_url('assets/plugins/jquery/dist/jquery.min.js');?>"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=base_url('assets/bootstrap/dist/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?=base_url('assets/plugins/iCheck/icheck.min.js');?>" type="text/javascript"></script>
    <script src="<?=base_url('assets/plugins/sidebar-nav/dist/sidebar-nav.min.js');?>" type="text/javascript"></script>
    <script src="<?=base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
    
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    <script src="<?=base_url('assets/dist/js/waves.js');?>"></script>
    <script src="<?=base_url('assets/dist/js/custom.min.js');?>"></script>
    <script src="<?=base_url('assets/plugins/styleswitcher/jQuery.style.switcher.js');?>" type="text/javascript"></script>

</body>
</html>
