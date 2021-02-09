$(document).ready(function () {
    
    $('#createRealisasiPagu')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tgl_transaksi_rpagu: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal transaksi tidak boleh kosong.'
                    }
                }
            },
            jml_rpagu: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah realisasi tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah realisasi harus diisi angka'
                    },
                    between: {
                        min: 0,
                        max: $('#sisa_pagu').val(),
                        message: 'Maksimal realisasi pagu tidak boleh melebihi sisa pagu'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createRealisasiPagu")[0]);
        $.ajax({
              type: 'POST',
              url: '../createrealisasipagu',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        document.location.reload();
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#createRealisasiPagu").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#editRealisasiPagu')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tgl_transaksi_rpagu: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal transaksi tidak boleh kosong.'
                    }
                }
            },
            jml_rpagu: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah realisasi tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah realisasi harus diisi angka'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#editRealisasiPagu")[0]);
        $.ajax({
              type: 'POST',
              url: '../updaterealisasipagu',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                	var kdindex = JSON.parse(data).kdindex;
                    setTimeout(function() {
                        document.location.assign('../addrealisasipagu/' + kdindex);
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#editRealisasiPagu").data('formValidation').resetForm();
                }
              }
          });
    });
});

$('#btnSaveImport').on('click', function(e) {
	var dialog = confirm("Apakah Anda yakin akan Import Data Pagu Anggaran ini?");
	if (dialog == true) {
	    $.ajax({
	        type: 'POST',
	        url: 'importdata',
	        data: $("#formImportData").serialize() + '&' + $("#formImportView").serialize(),
	        success: function(data) {
	        	console.log(data);
	        	var status = JSON.parse(data).status;
	        	var message = JSON.parse(data).message;
	        	if (status == 'success')
	            {
	                $('.alert').removeClass('alert-warning');
	                $('.alert').removeClass('alert-danger');
	                $('.alert').addClass('alert-success');
	                $('.alert').html(message).show();
	                setTimeout(function() {
	                    document.location.assign('pagu');
	                }, 2000);
	            }
	            else if (status == 'error')
	            {
	                $('.alert').removeClass('alert-warning');
	                $('.alert').removeClass('alert-success');
	                $('.alert').addClass('alert-danger');
	                $('.alert').html(message).show();
	                setTimeout(function() {
	                   $('.alert').hide();
	                }, 3000);
	            }
	        }
	    });
	}
});

function submitSudah(id_rpagu, idrsah){
	var val_pending = $('#pending_rsah'+id_rpagu).val();
    var val_rsah = $('#real_sah'+id_rpagu).val();
    $.ajax({
          type: 'POST',
          url: '../sudahrealisasisah',
          data: {pending_rsah:val_pending,jml_rsah:val_rsah,id_rsah:idrsah},
          success: function(data) {
            var status = JSON.parse(data).status;
            var message = JSON.parse(data).message;
            if (status == 'success')
            {
                $('.alert').removeClass('alert-warning');
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-success');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                    document.location.reload();
                }, 2000);
            }
            else if (status == 'error')
            {
                $('.alert').removeClass('alert-warning');
                $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-danger');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                }, 2000);
            }
            else if (status == 'warning')
            {
                $('.alert').removeClass('alert-success');
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-warning');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                }, 2000);
            }
          }
    });        
}

function submitSimpan(id_rpagu, idrsah){
	var val_pending = $('#pending_rsah'+id_rpagu).val();
    var val_rsah = $('#real_sah'+id_rpagu).val();
    $.ajax({
          type: 'POST',
          url: '../simpanrealisasisah',
          data: {pending_rsah:val_pending,jml_rsah:val_rsah,id_rsah:idrsah},
          success: function(data) {
            var status = JSON.parse(data).status;
            var message = JSON.parse(data).message;
            if (status == 'success')
            {
                $('.alert').removeClass('alert-warning');
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-success');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                    document.location.reload();
                }, 2000);
            }
            else if (status == 'error')
            {
                $('.alert').removeClass('alert-warning');
                $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-danger');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                }, 2000);
            }
            else if (status == 'warning')
            {
                $('.alert').removeClass('alert-success');
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-warning');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                }, 2000);
            }
          }
    });        
}

function hapusRealisasiPagu(id_rpagu){
    var dialog = confirm("Anda yakin akan menghapus Data Realisasi ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../hapusrealisasi',
              data: {idrpagu:id_rpagu},
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                        document.location.reload();
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                    }, 2000);
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                    }, 2000);
                }
              }
        }); 
    }
               
}

/*$('#level1').on('change', function() {
    var sub = this.value;
    $.ajax({
          type: 'GET',
          url: 'cekkode',
          data: {id_sub:sub},
          success: function(data) {
            //console.log(data);
            var row = JSON.parse(data).row;
            var cbKodeArsip = "";
            $.each(row, function(i, r) {
                cbKodeArsip += "<option value=\"" + row[i]['kode_arsip'] + "\">" + row[i]['kode_arsip'] + " - " + row[i]['rincian_kode'] + "</option>";
            })
            $("#kode_arsip").show();
            $("#kode_arsip").html(cbKodeArsip);
          }
    });
})*/