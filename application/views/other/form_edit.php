<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
  //$this->load->view('design/header');
?>

  <!-- Small paneles (Stat panel) -->
  <div class="row">
            <div class="col-md-12">

              <!-- Profile Image -->
              <div class="panel panel-default">
                <div class="panel-header with-border">
                  <h3 class="panel-heading"><?= $judul?></h3>
                </div>
                <div class="panel-body ">
                  <form id="updateOtherForm" action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                    <div class="alert" style="display: none;"></div>
                      
                      
                      <div class="form-group">
                      <label class="col-lg-3 control-label"><?= $judul_referensi ?></label>
                      <div class="col-lg-8">
                          <input type="hidden" class="form-control" name="id_reference" id="id_reference" value="<?= $record->id_reference?>"/>
                          <input type="text" class="form-control" name="detail_1" id="detail_1" value="<?= $record->detail_1?>"/>
                          <input type="hidden" class="form-control" name="get_referensi" id="get_referensi" value="<?= $get_referensi ?>"/>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('referensi/other/data/'.$get_referensi) ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </div>
                    <div class="alert" style="display: none;"></div>
                  </form>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->

              
            </div><!-- /.col -->
            </div><!-- /.row -->
  
<!-- /.content --> 

 <script src="<?=base_url('assets/dist/js/content/other.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
