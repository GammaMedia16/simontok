<?php
  $title = "Analisis Hasil Data Patroli";
  $icon = "fa fa-bar-chart";
  load_controller('Commons', 'header');
  load_controller('Commons', 'topbar');
  load_controller('Commons', 'sidebar', $title, $icon);

  //$this->load->view('design/header');
?>
<section class="content">
<!-- Info paneles -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                <div class="panel-header">
                  <h3 class="panel-heading"><?= $title ?></h3>
                </div><!-- /.panel-header -->
                <div class="panel-body">
                    <input type="hidden" class="form-control" name="base_url" id="base_url" value="<?= base_url() ?>"/>
                    <div class="col-lg-12">
                    	<form id="" method="get" enctype="multipart/form-data" class="form-horizontal" >
                    	<div class="form-group">
	                    	<label class="col-lg-4 control-label">Jenis Kegiatan</label>
		                    <div class="col-lg-4">
			                    <select name="tallysheet_id" id="tallysheet_id" class="form-control select2" style="width: 100%;" >
			                            <?php if ($tall_exist == 0) { ?>
			                                <option selected value="0">SEMUA DATA</option>
			                            <?php } else { ?>
			                                <option value="0">SEMUA DATA</option>
			                            <?php } ?>
			                            <?php foreach ($dataTallysheet as $row1) { ?>
			                                <?php if ($tall_exist == $row1->id) { ?>
			                                <option selected value="<?= $row1->id ?>"><?= ucwords($row1->name) ?></option>
			                                <?php } else { ?>
			                                <option value="<?= $row1->id ?>"><?= ucwords($row1->name) ?></option>
			                                <?php } ?>
			                            <?php } ?>
			                            
			                    </select>
		                    </div>
	                    </div>
	                    <div class="form-group">
	                    	<label class="col-lg-4 control-label">Kawasan</label>
		                    <div class="col-lg-4">
			                    <select name="resort_id" id="resort_id" class="form-control select2" style="width: 100%;" >
			                            <?php if ($res_exist == 0) { ?>
			                                <option selected value="0">SEMUA DATA</option>
			                            <?php } else { ?>
			                                <option value="0">SEMUA DATA</option>
			                            <?php } ?>
			                            <?php foreach ($dataRes as $row) { ?>
			                                <?php if ($res_exist == $row->id) { ?>
			                                <option selected value="<?= $row->id ?>"><?= $row->nama_resort ?></option>
			                                <?php } else { ?>
			                                <option value="<?= $row->id ?>"><?= $row->nama_resort ?></option>
			                                <?php } ?>
			                            <?php } ?>
			                    </select>
		                    </div>
	                    </div>
	                    <div class="form-group">
                            <label class="col-lg-3 control-label">Tanggal</label>
                            <div class="col-lg-6 inputGroupContainer date">
                                <div class="input-group input-append date">
                                    <input type="text" class="form-control" id="inputTglIns0" name="dari" style="cursor: pointer" value="<?= date('Y').'-01-01' ?>" placeholder="YYYY-MM-DD"/>
                                    <span class="input-group-addon add-on">s.d.</span>
                                    <input type="text" class="form-control" id="inputTglIns1" name="sampai" style="cursor: pointer" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD"/>
                                </div>
                            </div>
                        </div>
	                    <div class="form-group">
	                    	<div class="col-lg-8 pull-right">
			                    <button type="submit" class="btn btn-primary">Lihat Hasil</button>
			                    <button type="button" onclick="location.href='<?=base_url('analisis')?>'" class="btn btn-warning">Reset</button>
		                    </div>
	                    </div>
	                	</form>
                	</div>
                    

                    </div>
                    </div>
                    </div>
                </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col -->
</div><!-- /.row -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</section>
<?php
  load_controller('Commons', 'footer');
?>