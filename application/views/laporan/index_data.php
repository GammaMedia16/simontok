<?php
  $title = $judul;
  $icon = "fa fa-table";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);
  $access = $this->session->sub_role;
?>

  <!-- Small paneles (Stat panel) -->
  <div class="row">
    <div class="col-lg-12">

      <!-- Profile Image -->
      <div class="panel panel-default">
        <div class="panel-header with-border">
          <h3 class="panel-heading"><?= $judul.$jurusan_exist ?></h3>
        </div>
        <div class="panel-body">
          
          <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
          <div class="col-lg-12">
            <form method="post" role="form" class="form-horizontal">
                <div class="form-group">
                  <label class="col-lg-2 control-label">Tahun</label>
                  <div class="col-lg-2">
                  <select name="tahun" id="tahun" class="form-control" style="width: 100%;" onChange="this.form.submit()">
                    <?php 
                      $thn_min = date("Y",strtotime(" -3 year"));
                      $thn_max = date("Y");
                      $no = 1; ?>
                        <?php for ($i=$thn_min; $i <= $thn_max; $i++) { ?>
                          <?php if ($tahun_exist == $i) { ?>
                              <option selected value="<?= $i; ?>"><?= $i; ?></option>
                          <?php } else { ?>
                              <option value="<?= $i; ?>"><?= $i; ?></option>
                          <?php } ?>
                        <?php } ?>
                        <?php if ($tahun_exist == 1) { ?>
                            <option selected value="1">SEMUA DATA</option>
                        <?php } else { ?>
                            <option value="1">SEMUA DATA</option>
                        <?php } ?>
                        
                    </select>
                  </div>
                  <div class="col-lg-2">
                    <button onclick="location.href='<?=base_url('laporan/data');?>'" type="button" class="btn btn-xs btn-warning btn-circle"><i class="fa fa-refresh"></i></button>
                  </div>
                </div>
            </form>
          </div>
          <div class="">
            <div class="col-lg-4 col-md-4 file-directory pa-0">
              <div class="ibox float-e-margins">
                <div class="ibox-content">
                  <div class="file-manager">
                    <h5 class="mb-10 pl-15"><u>Folder</u></h5>
                    <ul class="folder-list mb-20">
                      <?php foreach ($datajur as $rowjur) { ?>
                        <li class="fkodejur"><a href="<?= base_url('laporan/data?jurusan='.$rowjur->kode_jur)?>"><i class="zmdi zmdi-folder"></i> <?= $rowjur->nama_jur ?></a></li>
                      <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 file-sec pt-15">
              <div class="row">
                <div class="col-lg-12">
                <div class="alert" style="display: none;"></div>

                  <div class="row">
                    <?php foreach ($record as $row) { ?>
                      <div class="col-lg-3 file-box">
                      <div class="file">
                        <a href="<?= base_url('assets/filelaporan/'.$row->file_laporan) ?>">
                            <?php 
                              $pi = pathinfo($row->file_laporan);
                              $ext = $pi['extension'];
                              if ($ext == "xls" || $ext == "xlsx") {
                                echo "<div class=\"icon\" style=\"height: 80px !important;\"><i class=\"fa fa-file-excel-o\"></i></div>";
                              } elseif ($ext == "doc" || $ext == "docx") {
                                echo "<div class=\"icon\" style=\"height: 80px !important;\"><i class=\"fa fa-file-word-o\"></i></div>";
                              } elseif ($ext == "ppt" || $ext == "pptc") {
                                echo "<div class=\"icon\" style=\"height: 80px !important;\"><i class=\"fa fa-file-powerpoint-o\"></i></div>";
                              } elseif ($ext == "pdf") {
                                echo "<div class=\"icon\" style=\"height: 80px !important;\"><i class=\"fa fa-file-pdf-o\"></i></div>";
                              }  elseif ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
                                echo "<div class=\"image\" style=\"background-image:url(../assets/filelaporan/$row->file_laporan);height: 80px !important;\"></div>";
                              } 
                            ?>
                          <div class="file-name" style="height: 80px !important;">
                            <?= $row->judul_file.'.'.$ext ?>
                            <br>
                            <span>Created: <?php $tgl = date_create($row->dibuat); echo date_format($tgl, 'd M Y H:i:s'); ?></span>
                            <br>
                            
                          </div>
                        </a>
                        <?php if ($access == 3) { ?>
                          <button style="z-index: -1;" onclick="deleteDataLaciFile(<?= $row->id_laporan ?>)">
                            <i class="fa fa-remove text-danger"></i>
                          </button>
                        <?php } ?>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if ($access == 3) { ?>
          <div class="col-lg-12" >
            <div class="panel-group accordion-struct" id="accordion_1" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading_1">
                  <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapse_1" aria-expanded="true">Form Upload File</a> 
                </div>
                <div id="collapse_1" class="panel-collapse collapse" role="tabpanel">
                  <div class="panel-body pa-15"> 
                    <form id="createLaporanForm" method="post" enctype="multipart/form-data" class="form-horizontal" >
                      <div class="alert alert-success" style="display: none;"></div>
                      <div class="form-group">
                          <label class="col-lg-3 control-label">Judul</label>
                          <div class="col-lg-8">
                              <input type="text" class="form-control" name="judul_file" id="judul_file" value=""/>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-lg-3 control-label">Jurusan</label>
                          <div class="col-lg-4 inputGroupContainer">
                              <select name="kode_jur" id="kode_jur" class="form-control" style="width: 100%;">
                                  <?php foreach ($datajur as $row) { ?>
                                  <option value="<?= $row->kode_jur ?>"><?= $row->nama_jur ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-lg-3 control-label">Tahun</label>
                          <div class="col-lg-4 inputGroupContainer">
                              <select name="tahun_file" id="tahun_file" class="form-control" style="width: 100%;">
                                  <?php 
                                    $thn_min = date("Y",strtotime(" -3 year"));
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
                      <div class="form-group">
                          <label class="col-lg-3 control-label">File</label>
                          <div class="col-lg-6">
                              <input type="file" class="form-control" id="filelaporan" name="filelaporan" />
                              <!-- <span class="help-block">Choose a pdf file with a size between 1M and 10M.</span> -->
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-lg-9 col-lg-offset-3">
                              <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                      </div>
                      <div class="alert alert-success" style="display: none;"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        </div><!-- /.panel-body -->
      </div><!-- /.panel -->

      
    </div><!-- /.col -->
  </div><!-- /.row -->
  
<!-- /.content --> 

<script src="<?=base_url('assets/dist/js/content/laporan.js')?>"></script> 

<?php
  load_controller('Commons', 'footer');
?>
