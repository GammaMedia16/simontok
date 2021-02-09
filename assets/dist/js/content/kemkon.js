$(document).ready(function () {
	
	$('#createKemkonForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            no_pks: {
                validators: {
                    notEmpty: {
                        message: 'Nomor PKS tidak boleh kosong.'
                    }
                }
            },
            no_spd: {
                validators: {
                    notEmpty: {
                        message: 'Nomor Surat Persetujuan Dirjen tidak boleh kosong.'
                    }
                }
            },
            zona_blok: {
                validators: {
                    notEmpty: {
                        message: 'Zona/Blok tidak boleh kosong.'
                    }
                }
            },
            luas: {
                validators: {
                    notEmpty: {
                        message: 'Luas tidak boleh kosong.'
                    },
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            nilai_ekonomi: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Nilai Ekonomi harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            jangka_waktu: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Jangka Waktu harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            filebaverifikasi: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2MB'
                    }
                }
            },
            filepks: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 5*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 5MB'
                    }
                }
            },
            filepeta: {
                validators: {
                    file: {
                        extension: 'kml',
                        type: 'application/vnd.google-earth.kml+xml',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat KML dengan ukuran maksimal 2MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKemkonForm")[0]);
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
                            $("#createKemkonForm").data('formValidation').resetForm();
                            document.location.assign('../kemkon');
                        }
                        else if (status == 'error')
                        {
                            $("#createPDSKKForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	$('#updateKemkonForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            no_pks: {
                validators: {
                    notEmpty: {
                        message: 'Nomor PKS tidak boleh kosong.'
                    }
                }
            },
            no_spd: {
                validators: {
                    notEmpty: {
                        message: 'Nomor Surat Persetujuan Dirjen tidak boleh kosong.'
                    }
                }
            },
            zona_blok: {
                validators: {
                    notEmpty: {
                        message: 'Zona/Blok tidak boleh kosong.'
                    }
                }
            },
            luas: {
                validators: {
                    notEmpty: {
                        message: 'Luas tidak boleh kosong.'
                    },
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            nilai_ekonomi: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Nilai Ekonomi harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            jangka_waktu: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Jangka Waktu harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            filebaverifikasi: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2MB'
                    }
                }
            },
            filepks: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 5*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 5MB'
                    }
                }
            },
            filepeta: {
                validators: {
                    file: {
                        extension: 'kml',
                        type: 'application/vnd.google-earth.kml+xml',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat KML dengan ukuran maksimal 2MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updateKemkonForm")[0]);
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
                            document.location.assign('../../kemkon');
                        }
                        else if (status == 'error')
                        {
                            $("#updateKemkonForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	


});

function deleteData(idkemitraan){
    var dialog = confirm("Anda yakin akan menghapus Data Kemitraan Konservasi ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../delete',
              data: {id:idkemitraan},
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
                            document.location.assign('../../kemkon');
                        }
                        else if (status == 'error')
                        {
                            document.location.reload();
                        }

                        
                      }
                })
                
              }
        });
    } else {
        return false;
    }  
}

