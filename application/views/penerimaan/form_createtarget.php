<?php
  $title = "Input Target Penerimaan";
  $icon = "fa fa-money";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<!-- Main content -->
<section class="content">
<!-- Info boxes -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading"><?= $judul?></h3>
        </div>
        <div class="panel-body ">
          <form id="createTargetPenerimaan" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Kode Akun</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="kode_akun_penerimaan" id="kode_akun_penerimaan" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Jenis Target Penerimaan</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="jenis_penerimaan" id="jenis_penerimaan" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Jumlah Target Penerimaan</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="jml_target_penerimaan" id="jml_target_penerimaan" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Tahun</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="thn_target_penerimaan" id="thn_target_penerimaan" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('penerimaan/target') ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->


 <script src="<?=base_url('assets/dist/js/content/penerimaan.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
?>