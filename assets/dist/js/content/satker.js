$(document).ready(function () {
	$('#createSatkerForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_satker: {
                validators: {
                    notEmpty: {
                        message: 'Nama Satker tidak boleh kosong.'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: 'Email belum valid.'
                    }
                }
            },
            kode_satker: {
                validators: {
                    notEmpty: {
                        message: 'Kode Satker tidak boleh kosong'
                    },
                    digits: {
                        message: 'Kode Satker harus diisi angka'
                    }
                }
            }
            
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createSatkerForm")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: 'insert',
	        data: data,
	        processData: false,
	        contentType: false,
	        success: function(data) {
	        	var title = JSON.parse(data).title;
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            document.location.assign('../satker');
                        }
                        else if (status == 'error')
                        {
                            $("#createSatkerForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });


	$('#updateSatkerForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kk: {
                validators: {
                    notEmpty: {
                        message: 'Nama Satker tidak boleh kosong.'
                    }
                }
            },
            reg_kk: {
                validators: {
                    notEmpty: {
                        message: 'Register Satker tidak boleh kosong.'
                    },
                    digits: {
                        message: 'Register Satker harus diisi angka'
                    }
                }
            },
            wdpa_id: {
                validators: {
                    digits: {
                        message: 'ID WDPA harus diisi angka'
                    }
                }
            },
            prov_id: {
                validators: {
                    notEmpty: {
                        message: 'Provinsi tidak boleh kosong.'
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
            luas_kk: {
                validators: {
                    digits: {
                        message: 'Luas KK harus diisi angka'
                    }
                }
            },
            luas_zona: {
                validators: {
                    digits: {
                        message: 'Luas Zona/Blok Tradisional harus diisi angka'
                    }
                }
            },
            luas_open_area: {
                validators: {
                    digits: {
                        message: 'Luas Open Area harus diisi angka'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updateSatkerForm")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: '../update',
	        data: data,
	        processData: false,
	        contentType: false,
	        success: function(data) {
	        	var title = JSON.parse(data).title;
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            document.location.assign('../../satker');
                        }
                        else if (status == 'error')
                        {
                            $("#updateSatkerForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	


});


