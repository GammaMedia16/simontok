$(document).ready(function () {
    $("#waktu").inputmask("hh:mm:ss", {"placeholder": "hh:mm:ss"});
	$('#formCreatePNBP')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tanggal_setor: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal setor tidak boleh kosong.'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formCreatePNBP")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: 'createpnbp',
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
	                    document.location.assign('pnbp');
	                }, 4000);
	            }
	            else if (status == 'error')
	            {
	                $('.alert').removeClass('alert-warning');
	                $('.alert').removeClass('alert-success');
	                $('.alert').addClass('alert-danger');
	                $form.find('.alert').html(message).show();
	                setTimeout(function() {
	                   $form.find('.alert').hide();
	                }, 3000);
	                $("#formCreatePNBP").data('formValidation').resetForm();
	            }
	        }
	    });
		});
    });

    $('#formEditPNBP')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tanggal_setor: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal setor tidak boleh kosong.'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formEditPNBP")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: '../updatepnbp',
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
	                    document.location.assign('../pnbp');
	                }, 4000);
	            }
	            else if (status == 'error')
	            {
	                $('.alert').removeClass('alert-warning');
	                $('.alert').removeClass('alert-success');
	                $('.alert').addClass('alert-danger');
	                $form.find('.alert').html(message).show();
	                setTimeout(function() {
	                   $form.find('.alert').hide();
	                }, 3000);
	                $("#formEditPNBP").data('formValidation').resetForm();
	            }
	        }
	    });
		});
    });

    $('#formCreatePengunjung')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            lokasi_id: {
                validators: {
                    notEmpty: {
                        message: 'Lokasi tidak boleh kosong.'
                    }
                }
            },
            tanggal: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal tidak boleh kosong.'
                    }
                }
            },
            waktu: {
                validators: {
                    notEmpty: {
                        message: 'Waktu tidak boleh kosong.'
                    }
                }
            },
            resort_id: {
                validators: {
                    notEmpty: {
                        message: 'Resort tidak boleh kosong.'
                    }
                }
            },
            tujuan: {
                validators: {
                    notEmpty: {
                        message: 'Tujuan Kunjungan tidak boleh kosong.'
                    }
                }
            },
            file_foto: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 500*1024,
                        message: 'File Foto harus berformat *.JPG | *.JPEG | *.PNG maksimal ukuran 500Kb'
                    }
                }
            },
            jml_pria: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah Pria tidak boleh kosong'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Jumlah Pria hanya bisa diisi dengan karakter angka'
                    }
                }
            },
            jml_wanita: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah Wanita tidak boleh kosong'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Jumlah Wanita hanya bisa diisi dengan karakter angka'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formCreatePengunjung")[0]);
        Pace.track(function(){
        $.ajax({
            type: 'POST',
            url: 'createpengunjung',
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
                        document.location.assign('pengunjung');
                    }, 4000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 3000);
                    $("#formCreatePengunjung").data('formValidation').resetForm();
                }
            }
        });
        });
    });

    $('#formEditPengunjung')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            lokasi_id: {
                validators: {
                    notEmpty: {
                        message: 'Lokasi tidak boleh kosong.'
                    }
                }
            },
            tanggal: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal tidak boleh kosong.'
                    }
                }
            },
            waktu: {
                validators: {
                    notEmpty: {
                        message: 'Waktu tidak boleh kosong.'
                    }
                }
            },
            resort_id: {
                validators: {
                    notEmpty: {
                        message: 'Resort tidak boleh kosong.'
                    }
                }
            },
            tujuan: {
                validators: {
                    notEmpty: {
                        message: 'Tujuan Kunjungan tidak boleh kosong.'
                    }
                }
            },
            file_foto: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 500*1024,
                        message: 'File Foto harus berformat *.JPG | *.JPEG | *.PNG maksimal ukuran 500Kb'
                    }
                }
            },
            jml_pria: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah Pria tidak boleh kosong'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Jumlah Pria hanya bisa diisi dengan karakter angka'
                    }
                }
            },
            jml_wanita: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah Wanita tidak boleh kosong'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Jumlah Wanita hanya bisa diisi dengan karakter angka'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formEditPengunjung")[0]);
        Pace.track(function(){
        $.ajax({
            type: 'POST',
            url: '../updatepengunjung',
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
                        document.location.assign('../pengunjung');
                    }, 4000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 3000);
                    $("#formEditPengunjung").data('formValidation').resetForm();
                }
            }
        });
        });
    });

});



function deletePNBP(idmaster){
    var dialog = confirm("Anda yakin akan menghapus Data ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../deletepnbp',
              data: {id:idmaster},
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                        document.location.assign('../pnbp');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                    }, 2000);
                }
                
              }
        });
    } else {
        return false;
    }  
}

function deletePengunjung(idmaster){
    var dialog = confirm("Anda yakin akan menghapus Data ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../deletepengunjung',
              data: {id:idmaster},
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                        document.location.assign('../pengunjung');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                    }, 2000);
                }
                
              }
        });
    } else {
        return false;
    }  
}