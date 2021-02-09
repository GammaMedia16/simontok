$(document).ready(function () {
	
	$("#time_tallysheet").inputmask("hh:mm:ss", {"placeholder": "hh:mm:ss"});
	$("#lat").inputmask({
		mask: "-[9].9999999",
		isNumeric: true,
	});
	$("#lon").inputmask({
		mask: "[999].9999999",
		isNumeric: true,
		digits: "10"
	});


	$('#formCreateTerumbuKarang')
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
            petugas_id: {
                validators: {
                    notEmpty: {
                        message: 'Nama Pegawai tidak boleh kosong.'
                    }
                }
            },
            lat: {
                validators: {
                    notEmpty: {
                        message: 'Latitude tidak boleh kosong.'
                    }
                }
            },
            lon: {
                validators: {
                    notEmpty: {
                        message: 'Longitude tidak boleh kosong.'
                    }
                }
            },
            kedalaman: {
                validators: {
                    notEmpty: {
                        message: 'Kedalaman tidak boleh kosong.'
                    }
                }
            },
            arah_arus: {
                validators: {
                    notEmpty: {
                        message: 'Arah Arus tidak boleh kosong.'
                    }
                }
            },
            salinitas: {
                validators: {
                    notEmpty: {
                        message: 'Salinitas tidak boleh kosong.'
                    }
                }
            },
            kec_arus: {
                validators: {
                    notEmpty: {
                        message: 'Kecepatan Arus tidak boleh kosong.'
                    }
                }
            },
            do: {
                validators: {
                    notEmpty: {
                        message: 'DO tidak boleh kosong.'
                    }
                }
            },
            suhu: {
                validators: {
                    notEmpty: {
                        message: 'Suhu tidak boleh kosong.'
                    }
                }
            },
            kecerahan: {
                validators: {
                    notEmpty: {
                        message: 'Kecerahan tidak boleh kosong.'
                    }
                }
            },
            kec_angin: {
                validators: {
                    notEmpty: {
                        message: 'Kecepatan Angin tidak boleh kosong.'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formCreateTerumbuKarang")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: 'create',
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
	                    document.location.assign('../karang');
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
	                $("#formCreateTerumbuKarang").data('formValidation').resetForm();
	            }
	        }
	    });
		});
    });

    $('#formEditKarang')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
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
            petugas_id: {
                validators: {
                    notEmpty: {
                        message: 'Nama Pegawai tidak boleh kosong.'
                    }
                }
            },
            lat: {
                validators: {
                    notEmpty: {
                        message: 'Latitude tidak boleh kosong.'
                    }
                }
            },
            lon: {
                validators: {
                    notEmpty: {
                        message: 'Longitude tidak boleh kosong.'
                    }
                }
            },
            kedalaman: {
                validators: {
                    notEmpty: {
                        message: 'Kedalaman tidak boleh kosong.'
                    }
                }
            },
            arah_arus: {
                validators: {
                    notEmpty: {
                        message: 'Arah Arus tidak boleh kosong.'
                    }
                }
            },
            salinitas: {
                validators: {
                    notEmpty: {
                        message: 'Salinitas tidak boleh kosong.'
                    }
                }
            },
            kec_arus: {
                validators: {
                    notEmpty: {
                        message: 'Kecepatan Arus tidak boleh kosong.'
                    }
                }
            },
            do: {
                validators: {
                    notEmpty: {
                        message: 'DO tidak boleh kosong.'
                    }
                }
            },
            suhu: {
                validators: {
                    notEmpty: {
                        message: 'Suhu tidak boleh kosong.'
                    }
                }
            },
            kecerahan: {
                validators: {
                    notEmpty: {
                        message: 'Kecerahan tidak boleh kosong.'
                    }
                }
            },
            kec_angin: {
                validators: {
                    notEmpty: {
                        message: 'Kecepatan Angin tidak boleh kosong.'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formEditKarang")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: '../update',
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
	                    document.location.assign('../../karang');
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
	                $("#createTallysheetForm").data('formValidation').resetForm();
	            }
	        }
	    });
		});
    });


});

function deleteMonitoringKarang(idmaster){
    var dialog = confirm("Anda yakin akan menghapus Data ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../delete',
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
                        document.location.assign('../../karang');
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

function petaKarang() {
    var lokasi = $('#lokasi').val();
    document.location.assign('./karang/peta?&lokasi='+ lokasi);
}